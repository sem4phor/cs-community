<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Cache\Cache;
use Cake\Log\Log;
use React\ZMQ;
use Cake\I18n\Time;

/**
 * Lobbies Controller
 *
 * @property \App\Model\Table\LobbiesTable $Lobbies
 */
class LobbiesController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
    }


    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     *
     * TODO make sure you can only add one at a  time
     */
    public function new($lobby)
    {
        $lobby = $this->Lobbies->patchEntity($lobby, $this->request->data);
        $lobby->owner_id = $this->Auth->user('user_id');
        $lobby->free_slots = 4;
        if ($this->Lobbies->save($lobby)) {
            $this->join($lobby->lobby_id);
            $this->Flash->success(__('The lobby has been saved.'));

            // start websocket stuff make sure req. data contains info about the topic
            $context = new \ZMQContext();
            $socket = $context->getSocket(\ZMQ::SOCKET_PUSH, 'Pusher');
            $socket->connect("tcp://localhost:5555");
            $this->request->data['newLobby'] = 'topicValue';
            $this->request->data['lobby_id'] = $this->Lobbies->Users->get($this->Auth->user('user_id'), ['contain' => 'Lobby'])->lobby_id;// test this
            $this->request->data['owner_id'] = $this->Lobbies->Users->get($this->Auth->user('user_id'));

            Log::write('debug', $this->request->data);
            $socket->send(json_encode($this->request->data));
            // end websocket stuff

            // deny new as long as user has own lobby?
            return $this->redirect($this->referer());
        } else {
            $this->Flash->error(__('The lobby could not be saved. Please, try again.'));
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     *
     * Shows all the lobbies matching with the users characteristics ()
     */
    public function index()
    {
        $user_region = $this->Lobbies->Users->getRegionCode($this->Auth->user('user_id'));
        $user_min_age = explode('-', $this->Auth->user('age_range'))[0];

        // stuff for new lobby
        $new_lobby = $this->Lobbies->newEntity();
        if ($this->request->is('post')) {
            $this->new($new_lobby);
        }

        $ranks = $this->Lobbies->Users->Rank->find('list');
        $ages = [12, 14, 16, 18, 20];
        $languages = $this->Lobbies->Users->Countries->getLocalesOfContinent($user_region);

        $rank_from = $this->Auth->user('rank_id');
        $this->Auth->user('rank_id') - 2 >= 1 ?  $rank_from = $this->Auth->user('rank_id') - 2 : 1;

        $rank_to = $this->Auth->user('rank_id');
        $this->Auth->user('rank_id') + 2 <= 18 ?  $rank_to = $this->Auth->user('rank_id') + 2 : 18;

        $this->set(compact('ages', 'ranks', 'new_lobby', 'languages', 'rank_to', 'rank_from'));

        // stuff for own lobby
        if ($this->Lobbies->Users->get($this->Auth->user('user_id'), ['contain' => 'Lobby'])->lobby != null) {
            $your_lobby = $this->Lobbies->Users->get($this->Auth->user('user_id'), ['contain' => 'Lobby.Users'])->lobby;
            $is_own_lobby = $your_lobby->owner_id == $this->Auth->user('user_id');
            $this->set(compact('your_lobby', 'is_own_lobby'));
        }

        // stuff for index
        // TODO uncomment later on
        $lobbies = $this->Lobbies->find()->where([
            //'min_upvotes <=' => $this->Auth->user('upvotes'),
            //'max_downvotes >=' => $this->Auth->user('downvotes'),
            //'min_playtime <=' => $this->Auth->user('playtime'),
            //'rank_from <=' => $this->Auth->user('rank'),
            //'rank_to >=' => $this->Auth->user('rank'),
            //'min_age <=' => $user_min_age,
            //'region =' => $user_region,
            //'owner_id !=' => $this->Auth->user('user_id')
        ])->contain(['Users', 'Owner']);

        $lobbies = $this->paginate($lobbies);
        $this->set(compact('lobbies'));
        $this->set('_serialize', ['lobbies']);


    }

    /**
     * Display method
     *
     * @return \Cake\Network\Response|null
     */
    public function home()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $lobbies = $this->paginate($this->Lobbies);

        $this->set(compact('lobbies'));
        $this->set('_serialize', ['lobbies']);
    }

    /**
     * View method
     *
     * @param string|null $id Lobby id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $lobby = $this->Lobbies->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('lobby', $lobby);
        $this->set('_serialize', ['lobby']);
    }

    public function join($lobby_id)
    {
        $lobby = $this->Lobbies->get($lobby_id);
        if ($lobby->free_slots == 0) {
            $this->Flash->error(__('The lobby is full.'));
            return $this->redirect($this->referer());
        }
        $user = $this->Lobbies->Users->get($this->Auth->user('user_id'));
        $user->lobby = $lobby;
        if ($this->Lobbies->Users->save($user)) {
            $lobby->free_slots = $lobby->free_slots - 1;
            if ($this->Lobbies->save($lobby)) {
                $this->Flash->success(__('The lobby has been saved.'));
                // TODO spread mssg an alle lobbyguys und lösche aus indexliste aller
                return $this->redirect($this->referer());
            } else {
                $this->Flash->error(__('The lobby could not be saved. Please, try again.'));
                return $this->redirect($this->referer());
            }

        }
    }

    public function leave($lobby_id)
    {
        $lobby = $this->Lobbies->get($lobby_id);
        $user = $this->Lobbies->Users->find()->where(['user_id' => $this->Auth->user('user_id')])->toArray();

        if ($this->Lobbies->association('Users')->unlink($lobby, $user)) {
            $lobby->free_slots = $lobby->free_slots + 1;
            $this->Flash->success(__('The lobby has been saved.'));
            return $this->redirect($this->referer());

        } else {
            $this->Flash->error(__('The lobby could not be saved. Please, try again.'));
            return $this->redirect($this->referer());
        }
    }

    public function kick($user_id)
    {
        $lobby = $this->Lobbies->find()->where(['owner_id =' => $this->Auth->user('user_id')])->toArray()[0];
        $user = $this->Lobbies->Users->find()->where(['user_id' => $user_id])->toArray();

        if ($this->Lobbies->association('Users')->unlink($lobby, $user)) {
            $lobby->free_slots = $lobby->free_slots + 1;
            $this->Flash->success(__('The lobby has been saved.'));
            return $this->redirect($this->referer());

        } else {
            $this->Flash->error(__('The lobby could not be saved. Please, try again.'));
            return $this->redirect($this->referer());
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Lobby id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public
    function edit($id = null)
    {
        $lobby = $this->Lobbies->get($id, [
            'contain' => ['Users']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $lobby = $this->Lobbies->patchEntity($lobby, $this->request->data);
            if ($this->Lobbies->save($lobby)) {
                $this->Flash->success(__('The lobby has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The lobby could not be saved. Please, try again.'));
            }
        }
        $lobbies = $this->Lobbies->Lobbies->find('list', ['limit' => 200]);
        $users = $this->Lobbies->Users->find('list', ['limit' => 200]);
        $this->set(compact('lobby', 'lobbies', 'users'));
        $this->set('_serialize', ['lobby']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Lobby id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public
    function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $lobby = $this->Lobbies->get($id);
        if ($this->Lobbies->delete($lobby)) {
            $this->Flash->success(__('The lobby has been deleted.'));
        } else {
            $this->Flash->error(__('The lobby could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
