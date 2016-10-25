<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;
use Cake\Core\Configure;
use Cake\Event\Event;

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
        $this->Auth->allow();
    }

    // TODO set steam variables
    /*public function loginTest()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }

    public function logoutTest()
    {
        return $this->redirect($this->Auth->logout());
    }*/


    // TODO register (for help see urlaubsplaner)

    public function login()
    {
            $user = $this->Auth->identify();
            if ($user) {
                // if user not exists register him
                $query = $this->Users->find()->where(['steam_id =' => $user['steam_id']]);
               if($query->isEmpty()) {
                   return $this->redirect(['action' => 'register', $user['steam_id']]);
               }
                $user = $this->getUserData($user);
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Authentification Error!'));
    }

    public function getUserData($user) {
        $query = $this->Users->find()->where(['steam_id =' => $user['steam_id']]);
        $user = $query->first();

        // fetch steam info and check if all req. things are given if false logout if true set authuser and redirect to regiuster formn
        $user = $this->fetchSteamDataFromUser($user);
        if ($user['steam_communityvisibilitystate'] != 3 || $user['steam_profilestate'] != 1) {
            $this->Flash->error(__('Make profile public!'));
            //return $this->redirect(['action' => 'logout']);
            return $this->redirect($this->Auth->logout());
        }
        if ($user['loccountrycode'] == false) {
            $this->Flash->error(__('Set up your country!'));
            return $this->redirect($this->Auth->logout());
        }
        // update DB
            $update_user = $this->Users->get($user['user_id']);
            $update_user->country_code = $user['loccountrycode'];
            $update_user->avatar = $user['steam_avatar'];
            $update_user->avatarmedium = $user['steam_avatarmedium'];
            $update_user->avatarfull = $user['steam_avatarfull'];
            $update_user->profileurl = $user['steam_profileurl'];
            $update_user->personaname = $user['steam_personaname'];
            $update_user->playtime = $user['steam_csgo_total_time_played'];
            if ($this->Users->save($update_user)) {
                $this->Flash->success(__('The User has been saved.'));
            } else {
                $this->Flash->error(__('The absence could not be saved. Please, try again.'));
                return $this->redirect($this->Auth->logout());
            }
        return $user;
    }

    public function register($steam_id = null) {
        // if not in DB register by creating newUser(steamid)
        // ask all the req. things
        // if ready call login and redirect to auth->login redirect ELSE redirect to logout
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            $user->steam_id = $steam_id;
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                $user = $this->getUserData($user);
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    // adds steamdata to user
    // loccountrycode is set to false if not set
    public function fetchSteamDataFromUser($user) {
        $url = file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".Configure::read('APIkey')."&steamids=".$user['steam_id']);
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
        $url = file_get_contents("http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=".Configure::read('APIkey')."&steamid=".$user['steam_id']."&format=json");
        $content = json_decode($url, true);
        foreach($content['response']['games'] as $key => $value) {
            if ($value['appid'] == 730)  {
                $user['steam_csgo_total_time_played'] = $value['playtime_forever'] / 60;
                break;
            };
        }
        return $user;
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        return $this->redirect($this->Auth->logout());
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
