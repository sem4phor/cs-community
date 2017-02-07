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
 * LobbiesController Controller
 *
 * Provides methods to handle lobby objects
 *
 * @author Valentin Rapp
 * @property \App\Model\Table\LobbiesTable $Lobbies
 */
class LobbiesController extends AppController
{

    /**
     * beforeFilter
     *
     * Grants access to the home-method for everyone
     *
     * @param \Cake\Event\Event $event An Event instance
     * @access public
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['home']);
        parent::beforeFilter($event);
    }

    /**
     * isAuthorized
     *
     * Check if the provided user is authorized for the request:
     * Banned users arent authorized for any action.
     * All registered users can create one lobby.
     * Only lobby-owners can kick users from their lobby.
     * You can only delete your own lobby.
     * You cant leave your own lobby.
     * You can join a lobby if you arent already part of a lobby and have the required playtime.
     *
     *
     * @param array|null $user The user to check the authorization of. If empty the user in the session will be used.
     * @access public
     * @return boolean True if $user is authorized, otherwise false
     */
    public function isAuthorized($user)
    {
        if (isset($user['role_id']) && $user['role_id'] === 4) {
            return false;
        }
        // All registered users can add lobbies
        if ($this->request->action === 'create' || $this->request->action === 'index') {
            return true;
        }
        // kick only users in own lobby and not self
        if ($this->request->action === 'kick') {
            $steam_id = $this->request->params['pass'][0];
            $lobby = $this->Lobbies->find()->where(['owner_id =' => $user['steam_id']])->contain(['Users'])->toArray()[0];
            foreach ($lobby->users as $lobby_user) {
                if ($steam_id == $user['steam_id']) {
                    return false;
                } elseif ($steam_id == $lobby_user->steam_id) {
                    return true;
                }
            }
        }
        // you can only delete your own lobby
        if ($this->request->action == 'delete') {
            $lobby_id = (int)$this->request->params['pass'][0];
            if ($this->Lobbies->isOwnedBy($lobby_id, $user['steam_id'])) {
                return true;
            }
        }
        // you can only leave if you are in the lobby but not own
        if ($this->request->action == 'leave') {
            $lobby_id = (int)$this->request->params['pass'][0];
            $user_lobby_id = $this->Lobbies->Users->get($user['steam_id'])->lobby_id;
            if ($this->Lobbies->isOwnedBy($lobby_id, $user['steam_id'])) {
                return false;
            } elseif ($lobby_id === $user_lobby_id) {
                return true;
            } else {
                return false;
            }
        }
        // you are allowed to join if you arent already part of a lobby
        if ($this->request->action == 'join') {
            if ($this->Lobbies->Users->get($user['steam_id'])->lobby_id == null) {
                return true;
            } else {
                return false;
            }
        }
        return parent::isAuthorized($user);
    }

    /**
     * create
     *
     * Method to create new lobbies. A new lobby is sent to the WebsocketServer.
     *
     * @access public
     * @return \Cake\Network\Response|void Redirects on successful create.
     *
     */
    public function create()
    {
        $lobby = $this->Lobbies->newEntity();
        $lobby = $this->Lobbies->patchEntity($lobby, $this->request->data);
        $lobby->owner_id = $this->Auth->user('steam_id');
        $lobby->free_slots = 5;
        if (!$lobby->teamspeak_req) {
            $lobby->teamspeak_ip = null;
        }
        $lobby->region = $this->Lobbies->Users->getRegionCode($this->Auth->user('steam_id'));
        if ($this->Lobbies->save($lobby)) {
            $this->join($lobby->lobby_id);
            $this->request->data['topic'] = 'lobby_new';
            $this->request->data['lobby'] = $this->Lobbies->get($lobby->lobby_id, ['contain' => ['RankFrom', 'RankTo', 'Owner']]);
            $this->websocketSend($this->request->data);
        } else {
            $this->Flash->error(__('The lobby could not be saved. Please, try again.'));
        }
        $this->redirect(['action' => 'home']);
    }

    /**
     * index
     *
     * Method to paginate all lobbies
     *
     * @access public
     * @return void
     *
     */
    public function index()
    {
        $lobbies = $this->Lobbies->find('all', [
            'order' => ['Lobbies.created' => 'ASC'],
            'limit' => 30
        ])->contain(['Users', 'Owner', 'RankFrom', 'RankTo']);

        $this->set(compact('lobbies'));
        $this->set('_serialize', ['lobbies']);
    }

    /**
     * home
     *
     * calls index when the user is not logged in. Otherwise it shows the chat, a form to create a lobby/see the joined lobby, a form to filter the lobbies and the lobbies matching the filter.
     *
     * @access public
     * @return void
     *
     */
    public function home()
    {
        if ($this->Auth->user() === null) {
            $this->index();
        } else {
            $user_region = $this->Lobbies->Users->getRegionCode($this->Auth->user('steam_id'));

            // set variables for new lobby
            $this->loadModel('Ranks');
            $ranks = $this->Ranks->find('list');
            $ages = [12, 14, 16, 18, 20];
            $languages = $this->Lobbies->Users->Countries->getLocalesOfContinent($user_region);
            $this->set(compact('ages', 'ranks', 'new_lobby', 'languages'));

            // load newest 15 chat messages
            $this->loadModel('ChatMessages');
            $chatMessages = $this->ChatMessages->find('all', [
                'order' => ['ChatMessages.created' => 'DESC'],
                'limit' => 15
            ])->contain(['Sender']);
            $this->set(compact('chatMessages'));

            // load the lobby the user is currently part of
            $your_lobby_id = $this->Lobbies->Users->get($this->Auth->user('steam_id'))->lobby_id;
            if ($your_lobby_id != null) {
                $your_lobby = $this->Lobbies->get($your_lobby_id, ['contain' => ['Users', 'RankFrom', 'RankTo', 'Owner']]);
                $is_own_lobby = $your_lobby->owner_id == $this->Auth->user('steam_id');
                $this->set(compact('your_lobby', 'is_own_lobby'));
            }

            // load the list of lobbies based on the filter
            $filter = [];
            if ($this->request->is('post')) {
                foreach ($this->request->data as $key => $value) {
                    if ($value != '') {
                        $filter[$key] = $value;
                    }
                }
            }
            if (!empty($filter)) {
                $lobbies = $this->Lobbies->find('all', [
                    'order' => ['Lobbies.created' => 'ASC'],
                    'limit' => 30
                ])->where([
                    'min_playtime <=' => $this->Auth->user('playtime'),
                    'prime_req =' => $filter['filter_prime_req'],
                    'language =' => $filter['filter_language'],
                    'teamspeak_req =' => $filter['filter_teamspeak_req'],
                    'microphone_req =' => $filter['filter_microphone_req'],
                    'rank_from <=' => $filter['filter_user_rank'],
                    'rank_to >=' => $filter['filter_user_rank'],
                    'min_age <=' => $filter['filter_min_age'],
                    'region =' => $user_region
                ])->contain(['Users', 'Owner', 'RankFrom', 'RankTo']);
            } else {
                $lobbies = $this->Lobbies->find()->where([
                    'region =' => $user_region,
                    'min_playtime <=' => $this->Auth->user('playtime')
                ])->contain(['Users', 'Owner', 'RankFrom', 'RankTo']);
            }
            $this->set(compact('lobbies', 'filter'));
            $this->set('_serialize', ['lobbies']);
        }
    }

    /**
     * join
     *
     * Lets a user join a lobby if he has enough playtimehours and the lobby is not full. The action is sent to the WebsocketServer
     *
     * @access public
     * @param int $lobby_id The id of the lobby which the users wants to join
     * @return \Cake\Network\Response|void Redirects on successful join.
     *
     */
    public function join($lobby_id)
    {
        $user = $this->Lobbies->Users->get($this->Auth->user('steam_id'));
        $lobby = $this->Lobbies->get($lobby_id, [
            'contain' => ['Users']
        ]);
        // flash a notice when the lobby is already full
        if ($lobby->free_slots == 0) {
            $this->Flash->error(__('The lobby is full.'));
            return $this->redirect($this->referer());
        }
        // flash a notice when the user doesnt have enough playtime
        if ($user->playtime < $lobby->min_playtime) {
            $this->Flash->error('You don\'t have enough playtime to join this lobby.');
            return $this->redirect($this->referer());
        }
        $user->lobby_id = $lobby->lobby_id;
        if ($this->Lobbies->Users->save($user)) {
            $lobby->free_slots = $lobby->free_slots - 1;
            if ($this->Lobbies->save($lobby)) {
                $this->request->data['topic'] = 'lobby_join';
                $this->request->data['lobby'] = $lobby;
                $this->request->data['joined_user'] = $user;
                $this->websocketSend($this->request->data);
                if ($lobby->free_slots == 0) {
                    $this->request->data['topic'] = 'lobby_full';
                    $this->websocketSend($this->request->data);
                    $this->Flash->set(__('Your party is complete!'), [
                        'element' => 'fullparty',
                        'params' => [
                            'lobby_link' => $lobby->url,
                            'ts3_ip' => $lobby->teamspeak_ip
                        ]
                    ]);
                    return $this->redirect($this->referer());
                }
                $this->Flash->success(__('Joined lobby.'));
            } else {
                $this->Flash->error(__('The lobby could not be joined. Please, try again.'));
            }
        }
        return $this->redirect($this->referer());
    }

    /**
     * leave
     *
     * Lets a user leave a lobby. The action is sent to the WebsocketServer
     *
     * @access public
     * @param int $lobby_id The id of the lobby which the users wants to leave
     * @return \Cake\Network\Response|void Redirects on successful leave.
     *
     */
    public function leave($lobby_id)
    {
        $lobby = $this->Lobbies->get($lobby_id, [
            'contain' => ['Users']
        ]);
        $user = $this->Lobbies->Users->get($this->Auth->user('steam_id'));
        $user->lobby_id = null;
        if ($this->Lobbies->Users->save($user)) {
            $lobby->free_slots = $lobby->free_slots + 1;
            if ($this->Lobbies->save($lobby)) {
                $this->Flash->success(__('Left lobby.'));
                $this->request->data['topic'] = 'lobby_leave';
                $this->request->data['lobby'] = $lobby;
                $this->request->data['user_left'] = $user;
                $this->websocketSend($this->request->data);
            } else {
                $this->Flash->error(__('The lobby could not be saved. Please, try again.'));
            }
        }
        return $this->redirect($this->referer());
    }

    /**
     * kick
     *
     * Lets a user kick a user from his lobby. The action is sent to the WebsocketServer
     *
     * @access public
     * @param int $steam_id The id of the user which the lobby-owner wants to kick
     * @return \Cake\Network\Response|void Redirects on successful kick.
     *
     */
    public function kick($steam_id)
    {
        $lobby = $this->Lobbies->find()->where(['owner_id =' => $this->Auth->user('steam_id')])->contain(['Users'])->toArray()[0];
        $user = $this->Lobbies->Users->get($steam_id);
        $user->lobby_id = null;
        if ($this->Lobbies->Users->save($user)) {
            $lobby->free_slots = $lobby->free_slots + 1;
            if ($this->Lobbies->save($lobby)) {
                $this->Flash->success(__('User successfully kicked.'));
                $this->request->data['topic'] = 'lobby_leave';
                $this->request->data['lobby'] = $lobby;
                $this->request->data['user_left'] = $user;
                $this->websocketSend($this->request->data);
            }
        } else {
            $this->Flash->error(__('Oops something went wrong while kicking user.'));
        }
        return $this->redirect($this->referer());
    }

    /**
     * delete
     *
     * Lets a user delete his lobby. The action is sent to the WebsocketServer
     *
     * @access public
     * @param int $id The id of the lobby which a user wants to delete.
     * @return \Cake\Network\Response|void Redirects on successful deletion.
     *
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $lobby = $this->Lobbies->get($id, ['contain' => 'Users']);
        if ($this->Lobbies->delete($lobby)) {
            $this->request->data['topic'] = 'lobby_delete';
            $this->request->data['lobby'] = $lobby;
            $this->websocketSend($this->request->data);
            $this->Flash->success(__('The lobby has been deleted.'));
        } else {
            $this->Flash->error(__('The lobby could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'home']);
    }

}
