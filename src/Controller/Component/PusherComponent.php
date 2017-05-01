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
namespace App\Controller\Component;

use Ratchet\ConnectionInterface;
use Ratchet\Wamp\WampServerInterface;

/**
 * Implementation of the WampServerInterface. Handles Websocket Connections and provides the Pub/Sub Pattern for spreading messages.
 *
 * @author Valentin Rapp (Based on the Ratchet Push Integration Tutorial on http://socketo.me/docs/push)
 */
class PusherComponent implements WampServerInterface
{

    /**
     * A lookup of all the topics clients have subscribed to
     */
    protected $subscribedTopics = array();

    /**
     * onSubscribe
     *
     * Called when client subscribes a topic. Adds topic to topic array
     *
     * @param ConnectionInterface $conn
     * @param \Ratchet\Wamp\Topic|string $topic
     */
    public function onSubscribe(ConnectionInterface $conn, $topic)
    {
        $this->subscribedTopics[$topic->getId()] = $topic;
    }

    /**
     * onSubmit
     *
     * Called when data is submitted to the WebsocketServer. Broadcasts the data top all clients who subscribed
     *
     * @param array $msg The message submitted to the WebsocketServer
     */
    public function onSubmit($msg)
    {
        $entryData = json_decode($msg, true);
        // look up if client subscribed to this topic
        if (array_key_exists($entryData['topic'], $this->subscribedTopics)) {
            // broadcast to the topic channel
            $topic = $this->subscribedTopics[$entryData['topic']];
            $topic->broadcast($entryData);
      } else {
            return;
        }
    }

    /**
     * onUnSubscribe
     *
     * Called when client unsubscribes a topic
     *
     * @param ConnectionInterface $conn
     * @param \Ratchet\Wamp\Topic|string $topic
     */
    public function onUnSubscribe(ConnectionInterface $conn, $topic)
    {
    }

    /**
     * onOpen
     *
     * Called when connection is opened
     *
     * @param ConnectionInterface $conn
     */
    public function onOpen(ConnectionInterface $conn)
    {
    }

    /**
     * onClose
     *
     * Called when connection is closed
     *
     * @param ConnectionInterface $conn
     */
    public function onClose(ConnectionInterface $conn)
    {
    }

    /**
     * onCall
     *
     * In this application if clients send data it's because the user hacked around in console
     *
     * @param ConnectionInterface $conn
     * @param string $id
     * @param \Ratchet\Wamp\Topic|string $topic
     * @param array $params
     */
    public function onCall(ConnectionInterface $conn, $id, $topic, array $params)
    {
        $conn->callError($id, $topic, 'You are not allowed to make calls')->close();
    }

    /**
     * onPublish
     *
     * Called when client sends data. In this application if clients send data it's because the user hacked around in console.
     *
     * @param ConnectionInterface $conn
     * @param \Ratchet\Wamp\Topic|string $topic
     * @param string $event
     * @param array $exclude
     * @param array $eligible
     */
    public function onPublish(ConnectionInterface $conn, $topic, $event, array $exclude, array $eligible)
    {
        $conn->close();
    }

    /**
     * onSubscribe
     *
     * Called when client subscribes a topic
     *
     * @param ConnectionInterface $conn
     * @param \Exception $e
     * @internal param \Ratchet\Wamp\Topic|string $topic
     */
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
    }

}