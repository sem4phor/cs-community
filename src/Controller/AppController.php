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

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Routing\Router;
use React\ZMQContext;

/**
 * Application Controller
 *
 * Contains application wide methods which other controllers inherit. Initializes Components.
 *
 * @author Valentin Rapp
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization of the controller
     *
     * Initializes and configures Components needed in the application.
     *
     * @access public
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('SteamOpenId');
        $this->loadComponent('Auth', [
            'loginRedirect' => [
                'controller' => 'Lobbies',
                'action' => 'home'
            ],
            'logoutRedirect' => [
                'controller' => 'Lobbies',
                'action' => 'home'
            ],
            'authorize' => 'controller',
            'authError' => 'You are not allowed to do this.'
        ]);
    }

    /**
     * WebsocketSend
     *
     * Sends JSON encoded data from the Webserver to the WebsocketServer
     *
     * @param array $data the data that will be sent
     * @access public
     * @return void
     */
    public function websocketSend($data)
    {
        $context = new \ZMQContext();
        $socket = $context->getSocket(\ZMQ::SOCKET_PUSH, 'Pusher');
        $socket->connect("tcp://localhost:5555");
        $socket->send(json_encode($data));
    }

    /**
     * beforeFilter
     *
     * Perform logic that needs to happen before each controller action
     *
     * @param \Cake\Event\Event $event An Event instance
     * @access public
     * @return void
     */
    public function beforeFilter(Event $event)
    {
    }

    /**
     * isAuthorized
     *
     * Check if the provided user is authorized for the request. If the user is an admin with the roleid 2 he automatically is authorized
     *
     * @param array|null $user The user to check the authorization of. If empty the user in the session will be used.
     * @access public
     * @return boolean True if $user is authorized, otherwise false
     */
    public function isAuthorized($user)
    {
        // Admin can access every action
        if (isset($user['role_id']) && $user['role_id'] === 2) {
            return true;
        }
        // Default deny
        return false;
    }

    /**
     * Before render callback.
     *
     * If the user is logged in he is set as a view variable for accessing userdata in views just like his region code. If the user is not logged in, the openid login url is set.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event)
    {
        $this->loadModel('Users');
        if ($this->Auth->user() !== null) $this->set('user_region', $this->Users->getRegionCode($this->Auth->user('steam_id')));
        if ($this->Auth->user() === null) $this->set('loginUrl', $this->SteamOpenId->genUrl(Router::url(['controller' => 'users', 'action' => 'login'], true), false));
        if ($this->Auth->user() !== null) $this->set('user', $this->Auth->user());

        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }
}
