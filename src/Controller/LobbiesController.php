<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;


class LobbiesController extends AppController
{

    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['home']);
        parent::beforeFilter($event);
    }

    public function isAuthorized($user)
    {
        // banned user cant access anything but home
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
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
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
     * Index method
     *
     * @return \Cake\Network\Response|null
     *
     * Shows all the lobbies matching with the users characteristics ()
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

            // load last 15 chat messages
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

    public
    function join($lobby_id)
    {
        $user = $this->Lobbies->Users->get($this->Auth->user('steam_id'));
        $lobby = $this->Lobbies->get($lobby_id, [
            'contain' => ['Users']
        ]);
        if ($lobby->free_slots == 0) {
            $this->Flash->error(__('The lobby is full.'));
            return $this->redirect($this->referer());
        }
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
                return $this->redirect($this->referer());
            } else {
                $this->Flash->error(__('The lobby could not be joined. Please, try again.'));
            }
        }
        return $this->redirect($this->referer());
    }

    public
    function leave($lobby_id)
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

    public
    function kick($steam_id)
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

    public
    function delete($id = null)
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
