<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Routing\Router;

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
            if ($user['role_id'] == 3 && $ban_user->role_id != 2 || $ban_user->role_id != 3)
                return true;
        }
        return parent::isAuthorized($user);
    }

    public function login()
    {
        $steamId = $this->SteamOpenId->validate();
        $this->request->data['Users']['steam_id'] = $steamId;

        $user = $this->Users->get($steamId);
        if ($user == null) {
            $this->Users->register($steamId);
        }
        $this->Users->updateSteamData($steamId);
        $user = $this->Users->get($steamId);
        if ($user['role_id'] == 4) {
            $this->Flash->error(__('You are currently banned from this site!'));
            return $this->redirect($this->Auth->logout());
        }
        Log::write('debug', $this->request->data);
        if ($this->Auth->identify()) {
            if ($user) {
                $this->Auth->setUser($user);
            }
            return $this->redirect(['controller' => 'Lobbies', 'action' => 'home']);
        } else {
            $this->Flash->error(__('Authentification Failed!'));
            return $this->redirect(['controller' => 'Lobbies', 'action' => 'home']);
        }
    }

    public
    function logout()
    {
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
