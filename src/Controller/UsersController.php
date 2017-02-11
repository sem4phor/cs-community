<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Event\Event;

/**
 * Users Controller
 *
 * Provides methods to handle user objects
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

    /**
     * beforeFilter
     *
     * Grants access to the logout register and view-method for logged in users.
     *
     * @param \Cake\Event\Event $event An Event instance
     * @access public
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['logout', 'register', 'view']);
    }

    /**
     * isAuthorized
     *
     * Check if the provided user is authorized for the request.
     * If the user is banned (role_id = 4) he is not authorized for anything.
     * Moderators are allowed to ban and unban users, if they arent mods or admin.
     *
     * @param array|null $user The user to check the authorization of. If empty the user in the session will be used.
     * @access public
     * @return boolean True if $user is authorized, otherwise false
     */
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

    /**
     * login
     *
     * Authorizes the user, updates his steam data and logs him in.
     *
     * @access public
     * @return \Cake\Network\Response|void Redirects on successful login.
     */
    public function login()
    {
        $steamId = $this->SteamOpenId->validate();
        if ($this->Users->find()->where(['steam_id' => $steamId])->isEmpty()) {
            $this->Users->register($steamId);
        }
        $user = $this->Users->find()->where(['steam_id' => $steamId])->first();
        $updated = intval($this->Users->updateSteamData($steamId));
        if ($updated == 2) {
            $this->Flash->error(__('Please make your profile public to login!'));
            return $this->redirect($this->Auth->logout());
        } else if ($updated == 3) {
            $this->Flash->error(__('Please set up your country on your steamprofile to log in!'));
            return $this->redirect($this->Auth->logout());
        } else if ($updated == false) {
            $this->Flash->error(__('Error while updating steamdata. Please contact support!'));
            return $this->redirect($this->Auth->logout());
        };
        $user = $this->Users->get($steamId);
        if ($user['role_id'] == 4) {
            $this->Flash->error(__('You are currently banned from this site!'));
            return $this->redirect($this->Auth->logout());
        }
        $this->Auth->setUser($user);
        return $this->redirect(['controller' => 'Lobbies', 'action' => 'home']);

    }

    /**
     * logout
     *
     * Logs the user out
     *
     * @access public
     * @return \Cake\Network\Response|void Redirects on successful logout.
     */
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    /**
     * View
     *
     * shows detailed information about a user
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $roles = $this->Users->Roles->find('list');
        $view_user = $this->Users->get($id, [
            'contain' => ['Roles']
        ]);

        $this->set('view_user', $view_user);
        $this->set('roles', $roles);
    }

    /**
     * Ban
     *
     * Bans a user from accessing the application
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
        } else {
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        return $this->redirect(['controller' => 'lobbies', 'action' => 'home']);
    }

    /**
     * makeMod
     *
     * gives a user the role moderator
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function makeMod($id = null)
    {
        $user = $this->Users->get($id);
        $user->role_id = 3;// banned
        if ($this->Users->save($user)) {
            $this->Flash->success(__('Success!'));
        } else {
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        return $this->redirect(['controller' => 'lobbies', 'action' => 'home']);
    }

    /**
     * Unban
     *
     * Unbans a user to grant him access to the application
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     */
    public function unban($id = null)
    {
        $user = $this->Users->get($id);
        $user->role_id = 1;// default
        if ($this->Users->save($user)) {
            $this->Flash->success(__('The user has been unbanned.'));
        } else {
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        return $this->redirect(['controller' => 'lobbies', 'action' => 'home']);
    }

}
