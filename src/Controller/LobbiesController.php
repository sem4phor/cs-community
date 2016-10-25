<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

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
        $this->Auth->allow();
    }

    /**
 * Index method
 *
 * @return \Cake\Network\Response|null
 */
    public function index()
    {
        $this->paginate = [

        ];
        $lobbies = $this->paginate($this->Lobbies);

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
            'contain' => ['Lobbies', 'Users']
        ]);

        $this->set('lobby', $lobby);
        $this->set('_serialize', ['lobby']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $lobby = $this->Lobbies->newEntity();
        if ($this->request->is('post')) {
            $lobby = $this->Lobbies->patchEntity($lobby, $this->request->data);
            if ($this->Lobbies->save($lobby)) {
                $this->Flash->success(__('The lobby has been saved.'));

                // start websocket stuff make sure req. data contains info about the topic
                $context = new \ZMQContext();
                $socket = $context->getSocket(\ZMQ::SOCKET_PUSH, 'PusherComponent');
                $socket->connect("tcp://localhost:5555");
                $socket->send(json_encode($this->request->data));
                // end websocket stuff

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

    public function join() {

    }

    /**
     * Edit method
     *
     * @param string|null $id Lobby id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
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
    public function delete($id = null)
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
