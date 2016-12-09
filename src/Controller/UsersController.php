<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Mailer\Email;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['logout', 'register', 'view']);
    }

    public function isAuthorized($user)
    {
        // banned user cant access anything but home
        if (isset($user['role_id']) && $user['role_id'] === 4) {
            return false;
        }
        // allow mods to ban users but not other mods or admins
        if ($this->request->action == 'ban' || $this->request->action == 'unban') {
            $ban_user = $this->Users->get($this->request->params['pass'][0]);
            if($user['role_id'] == 3 && $ban_user->role_id != 2 || $ban_user->role_id != 3)
                return true;
        }
        return parent::isAuthorized($user);
    }



    public function login()
    {
        $user = $this->Auth->identify();
        if ($user) {
            $query = $this->Users->find()->where(['steam_id =' => $user['steam_id']]);
            if ($query->isEmpty()) {
                return $this->redirect(['action' => 'register', $user['steam_id']]);
            }
            $user = $this->getUserData($user);
            if ($user['role_id'] == 4) {
                $this->Flash->error(__('You are currently banned from this site!'));
                return $this->redirect($this->Auth->logout());
            }
            $this->Auth->setUser($user);
            return $this->redirect($this->Auth->redirectUrl());
        }
        $this->Flash->error(__('Authentification Error!'));
    }

    public function getUserData($user)
    {
        $query = $this->Users->find()->where(['steam_id =' => $user['steam_id']]);
        $user = $query->first();

        $user = $this->fetchSteamDataFromUser($user);
        if ($user['steam_communityvisibilitystate'] != 3 || $user['steam_profilestate'] != 1) {
            $this->Flash->error(__('Make profile public!'));
            return $this->redirect($this->Auth->logout());
        }
        if ($user['loccountrycode'] == false) {
            $this->Flash->error(__('Set up your country!'));
            return $this->redirect($this->Auth->logout());
        }
        // update DB
        $update_user = $this->Users->get($user['steam_id']);
        $update_user->loccountrycode = $user['loccountrycode'];
        $update_user->avatar = $user['steam_avatar'];
        $update_user->avatarmedium = $user['steam_avatarmedium'];
        $update_user->avatarfull = $user['steam_avatarfull'];
        $update_user->profileurl = $user['steam_profileurl'];
        $update_user->personaname = $user['steam_personaname'];
        $update_user->playtime = $user['steam_csgo_total_time_played'];
        if ($this->Users->save($update_user)) {

        } else {
            $this->Flash->error(__('Could not get UserData, please try again.'));
            return $this->redirect($this->logout());
        }
        return $user;
    }

    public function register($steam_id = null)
    {
        $reg_user = $this->Users->newEntity();
        $reg_user->steam_id = $steam_id;
        if ($this->Users->save($reg_user)) {
            $user = $this->getUserData($reg_user);
            $this->Auth->setUser($reg_user);
            return $this->redirect($this->Auth->redirectUrl());
        } else {
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
    }

// adds steamdata to user
// loccountrycode is set to false if not set
    public
    function fetchSteamDataFromUser($user)
    {
        $url = file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=" . Configure::read('APIkey') . "&steamids=" . $user['steam_id']);
        $content = json_decode($url, true);
        $user['steam_communityvisibilitystate'] = $content['response']['players'][0]['communityvisibilitystate'];
        $user['steam_profilestate'] = $content['response']['players'][0]['profilestate'];
        $user['steam_lastlogoff'] = $content['response']['players'][0]['lastlogoff'];
        $user['steam_profileurl'] = $content['response']['players'][0]['profileurl'];
        $user['steam_avatar'] = $content['response']['players'][0]['avatar'];
        $user['steam_avatarmedium'] = $content['response']['players'][0]['avatarmedium'];
        $user['steam_avatarfull'] = $content['response']['players'][0]['avatarfull'];
        $user['steam_personastate'] = $content['response']['players'][0]['personastate'];
        $user['steam_timecreated'] = $content['response']['players'][0]['timecreated'];
        $user['steam_personaname'] = $content['response']['players'][0]['personaname'];
        isset($content['response']['players'][0]['loccountrycode']) ? $user['loccountrycode'] = $content['response']['players'][0]['loccountrycode'] : $user['loccountrycode'] = false;
        $url = file_get_contents("http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=" . Configure::read('APIkey') . "&steamid=" . $user['steam_id'] . "&format=json");
        $content = json_decode($url, true);
        foreach ($content['response']['games'] as $key => $value) {
            if ($value['appid'] == 730) {
                $user['steam_csgo_total_time_played'] = $value['playtime_forever'] / 60;
                break;
            };
        }
        return $user;
    }

    public
    function logout()
    {
        //session_unset();
        //session_destroy();
        return $this->redirect($this->Auth->logout());
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public
    function view($id = null)
    {
        $roles = $this->Users->Roles->find('list');
        $view_user = $this->Users->get($id, [
            'contain' => ['Roles']
        ]);

        $this->set('view_user', $view_user);
        $this->set('roles', $roles);
    }

    /**
     * Ban method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function ban($id = null)
    {
        $user = $this->Users->get($id);
        $user->role_id = 4;// banned
        if ($this->Users->save($user)) {
            $this->Flash->success(__('The user has been banned.'));
            return $this->redirect(['controller' => 'lobbies', 'action' => 'home']);
        } else {
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
    }

    public function makeMod($id = null)
    {
        $user = $this->Users->get($id);
        $user->role_id = 3;// banned
        if ($this->Users->save($user)) {
            $this->Flash->success(__('The user has been banned.'));
            return $this->redirect(['controller' => 'lobbies', 'action' => 'home']);
        } else {
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
    }

    /**
     * Ban method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function unban($id = null)
    {
        $user = $this->Users->get($id);
        $user->role_id = 1;// default
        if ($this->Users->save($user)) {
            $this->Flash->success(__('The user has been unbanned.'));
            return $this->redirect(['controller' => 'lobbies', 'action' => 'home']);
        } else {
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
    }
}
