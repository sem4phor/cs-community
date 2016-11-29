<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;

/**
 * ChatMessages Controller
 *
 * @property \App\Model\Table\ChatMessagesTable $ChatMessages
 */
class ChatMessagesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Messages']
        ];
        $chatMessages = $this->paginate($this->ChatMessages);

        $this->set(compact('chatMessages'));
        $this->set('_serialize', ['chatMessages']);
    }

    /**
     * New method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function new()
    {
        $chatMessage = $this->ChatMessages->newEntity();
        $this->request->data['sent_by'] = $this->Auth->user('steam_id');
        if ($this->request->is('post')) {
            $chatMessage = $this->ChatMessages->patchEntity($chatMessage, $this->request->data);
            if ($this->ChatMessages->save($chatMessage)) {
                $this->Flash->success(__('The chat message has been saved.'));
                // start websocket stuff make sure req. data contains info about the topic
                $context = new \ZMQContext();
                $socket = $context->getSocket(\ZMQ::SOCKET_PUSH, 'Pusher');
                $socket->connect("tcp://localhost:5555");
                $this->request->data['chat'] = 'new_chat_message';
                $socket->send(json_encode($this->request->data));
                // end websocket stuff
            } else {
                $this->Flash->error(__('The chat message could not be saved. Please, try again.'));
            }
        }
        return $this->redirect($this->referer());
    }

    /**
     * View method
     *
     * @param string|null $id Chat Message id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $chatMessage = $this->ChatMessages->get($id, [
            'contain' => ['Messages']
        ]);

        $this->set('chatMessage', $chatMessage);
        $this->set('_serialize', ['chatMessage']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $chatMessage = $this->ChatMessages->newEntity();
        if ($this->request->is('post')) {
            $chatMessage = $this->ChatMessages->patchEntity($chatMessage, $this->request->data);
            if ($this->ChatMessages->save($chatMessage)) {
                $this->Flash->success(__('The chat message has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The chat message could not be saved. Please, try again.'));
            }
        }
        $messages = $this->ChatMessages->Messages->find('list', ['limit' => 200]);
        $this->set(compact('chatMessage', 'messages'));
        $this->set('_serialize', ['chatMessage']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Chat Message id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $chatMessage = $this->ChatMessages->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $chatMessage = $this->ChatMessages->patchEntity($chatMessage, $this->request->data);
            if ($this->ChatMessages->save($chatMessage)) {
                $this->Flash->success(__('The chat message has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The chat message could not be saved. Please, try again.'));
            }
        }
        $messages = $this->ChatMessages->Messages->find('list', ['limit' => 200]);
        $this->set(compact('chatMessage', 'messages'));
        $this->set('_serialize', ['chatMessage']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Chat Message id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $chatMessage = $this->ChatMessages->get($id);
        if ($this->ChatMessages->delete($chatMessage)) {
            $this->Flash->success(__('The chat message has been deleted.'));
        } else {
            $this->Flash->error(__('The chat message could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
