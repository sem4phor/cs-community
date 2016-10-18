<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Lobbys Controller
 *
 * @property \App\Model\Table\LobbysTable $Lobbys
 */
class LobbysController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Lobbies']
        ];
        $lobbys = $this->paginate($this->Lobbys);

        $this->set(compact('lobbys'));
        $this->set('_serialize', ['lobbys']);
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
        $lobby = $this->Lobbys->get($id, [
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
        $lobby = $this->Lobbys->newEntity();
        if ($this->request->is('post')) {
            $lobby = $this->Lobbys->patchEntity($lobby, $this->request->data);
            if ($this->Lobbys->save($lobby)) {
                $this->Flash->success(__('The lobby has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The lobby could not be saved. Please, try again.'));
            }
        }
        $lobbies = $this->Lobbys->Lobbies->find('list', ['limit' => 200]);
        $users = $this->Lobbys->Users->find('list', ['limit' => 200]);
        $this->set(compact('lobby', 'lobbies', 'users'));
        $this->set('_serialize', ['lobby']);
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
        $lobby = $this->Lobbys->get($id, [
            'contain' => ['Users']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $lobby = $this->Lobbys->patchEntity($lobby, $this->request->data);
            if ($this->Lobbys->save($lobby)) {
                $this->Flash->success(__('The lobby has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The lobby could not be saved. Please, try again.'));
            }
        }
        $lobbies = $this->Lobbys->Lobbies->find('list', ['limit' => 200]);
        $users = $this->Lobbys->Users->find('list', ['limit' => 200]);
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
        $lobby = $this->Lobbys->get($id);
        if ($this->Lobbys->delete($lobby)) {
            $this->Flash->success(__('The lobby has been deleted.'));
        } else {
            $this->Flash->error(__('The lobby could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
