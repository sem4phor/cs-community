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
    public function new()
    {
        $lobby = $this->Lobbies->newEntity();
        $lobby = $this->Lobbies->patchEntity($lobby, $this->request->data);
        $lobby->owner_id = $this->Auth->user('steam_id');
        $lobby->free_slots = 4;
        if ($this->Lobbies->save($lobby)) {
            $this->join($lobby->lobby_id);
            $this->Flash->success(__('The lobby has been saved.'));

            // start websocket stuff make sure req. data contains info about the topic
            $context = new \ZMQContext();
            $socket = $context->getSocket(\ZMQ::SOCKET_PUSH, 'Pusher');
            $socket->connect("tcp://localhost:5555");
            $this->request->data['newLobby'] = 'topicValue';
            $this->request->data['lobby_id'] = $this->Lobbies->Users->get($this->Auth->user('steam_id'), ['contain' => 'Lobby'])->lobby_id;// test this
            $this->request->data['owner_id'] = $this->Lobbies->Users->get($this->Auth->user('steam_id'));

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
        $user_region = $this->Lobbies->Users->getRegionCode($this->Auth->user('steam_id'));
        $user_min_age = explode('-', $this->Auth->user('age_range'))[0];

        // chat stuff
        $this->loadModel('ChatMessages');
        $chatMessages = $this->ChatMessages->find()->contain(['Sender']);
        $this->set(compact('chatMessages'));

        // stuff for new lobby
        $new_lobby = $this->Lobbies->newEntity();

        $this->loadModel('Ranks');
        $ranks = $this->Ranks->find('list');
        $ages = [12, 14, 16, 18, 20];
        $languages = $this->Lobbies->Users->Countries->getLocalesOfContinent($user_region);

        $this->set(compact('ages', 'ranks', 'new_lobby', 'languages', 'rank_to', 'rank_from'));

        // stuff for own lobby
        if ($this->Lobbies->Users->get($this->Auth->user('steam_id'), ['contain' => 'Lobby'])->lobby != null) {
            $your_lobby = $this->Lobbies->Users->get($this->Auth->user('steam_id'), ['contain' => 'Lobby.Users'])->lobby;
            $is_own_lobby = $your_lobby->owner_id == $this->Auth->user('steam_id');
            $this->set(compact('your_lobby', 'is_own_lobby'));
        }

        // stuff for index
        $filter = ['filter_prime_req' => 0,'filter_teamspeak_req' => 0, 'filter_microphone_req' => 0, 'filter_min_age' => 12, 'filter_rank_from' => 1, 'filter_rank_to' => 18, 'filter_language' => 'en', 'filter_min_playtime' => 0, 'filter_min_upvotes' => 0, 'filter_max_downvotes' => 50];
        if ($this->request->is('post')) {
            foreach ($this->request->data as $key => $value) {
                if ($value!='') {
                    $filter[$key] = $value;
                }
            }
        }
        // TODO uncomment later on, finde nur lobbies deren user so undsoviel srtunden/votes haben: andWhere( minupv =< userupv. ) oder nur in join abfragen?
        $lobbies = $this->Lobbies->find()->where([
            'min_upvotes <=' => $filter['filter_min_upvotes'],
            'max_downvotes >=' => $filter['filter_max_downvotes'],
            'min_playtime <=' => $filter['filter_min_playtime'],
            'prime_req =' => $filter['filter_prime_req'],
            'teamspeak_req =' => $filter['filter_teamspeak_req'],
            'microphone_req =' => $filter['filter_microphone_req'],
            'rank_from <=' => $filter['filter_rank_from'],
            'rank_to >=' => $filter['filter_rank_to'],
            'min_age <=' => $filter['filter_min_age'],
            //'region =' => $user_region,
            //'owner_id !=' => $this->Auth->user('steam_id')
        ])->contain(['Users', 'Owner']);

        $lobbies = $this->paginate($lobbies);
        $this->set(compact('lobbies', 'filter'));
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
        $user = $this->Lobbies->Users->get($this->Auth->user('steam_id'));
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
        $user = $this->Lobbies->Users->find()->where(['steam_id' => $this->Auth->user('steam_id')])->toArray();

        if ($this->Lobbies->association('Users')->unlink($lobby, $user)) {
            $lobby->free_slots = $lobby->free_slots + 1;
            $this->Flash->success(__('The lobby has been saved.'));
            return $this->redirect($this->referer());

        } else {
            $this->Flash->error(__('The lobby could not be saved. Please, try again.'));
            return $this->redirect($this->referer());
        }
    }

    public function kick($steam_id)
    {
        $lobby = $this->Lobbies->find()->where(['owner_id =' => $this->Auth->user('steam_id')])->toArray()[0];
        $user = $this->Lobbies->Users->find()->where(['steam_id' => $steam_id])->toArray();

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
