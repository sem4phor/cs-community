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
 * ChatMessages Controller
 *
 * Provides methods to handle ChatMessages
 *
 * @author Valentin Rapp
 * @property \App\Model\Table\ChatMessagesTable $ChatMessages
 */
class ChatMessagesController extends AppController
{

    /**
     * beforeFilter
     *
     * Grants access to the send-method for everyone
     *
     * @param \Cake\Event\Event $event An Event instance
     * @access public
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        $this->Auth->allow('send');
        parent::beforeFilter($event);
    }

    /**
     * Send
     *
     * Creates a new ChatMessage, saves it and send it to the WebsocketServer.
     *
     * @access public
     * @return void
     */
    public function send()
    {
        $chatMessage = $this->ChatMessages->newEntity();
        $this->request->data['sent_by'] = $this->Auth->user('steam_id');
        $this->request->data['personaname'] = $this->Auth->user('personaname');
        if ($this->request->is('post')) {
            $chatMessage = $this->ChatMessages->patchEntity($chatMessage, $this->request->data);
            if ($this->ChatMessages->save($chatMessage)) {
                $this->request->data['topic'] = 'new_chat_message';
                $this->websocketSend($this->request->data);
                return;
            } else {
                $this->Flash->error(__('The chat message could not be saved. Please, try again.'));
            }
        }
    }
}
