<?php
namespace App\Controller\Component;


use Ratchet\ConnectionInterface;
use Ratchet\Wamp\WampServerInterface;

/**
 * Based on the Ratchet Push Integration Tutorial on http://socketo.me/docs/push
 */
class PusherComponent implements WampServerInterface
{

    /**
     * A lookup of all the topics clients have subscribed to
     */
    protected $subscribedTopics = array();

    public function onSubscribe(ConnectionInterface $conn, $topic)
    {
        $this->subscribedTopics[$topic->getId()] = $topic;
    }

    public function onSubmit($msg)
    {
        $entryData = json_decode($msg, true);
        if (array_key_exists($entryData['topic'], $this->subscribedTopics)) {
            $topic = $this->subscribedTopics[$entryData['topic']];
            $topic->broadcast($entryData);
      } else {
            return;
        }
    }

    public function onUnSubscribe(ConnectionInterface $conn, $topic)
    {
    }

    public function onOpen(ConnectionInterface $conn)
    {
    }

    public function onClose(ConnectionInterface $conn)
    {
    }

    public function onCall(ConnectionInterface $conn, $id, $topic, array $params)
    {
        // In this application if clients send data it's because the user hacked around in console
        $conn->callError($id, $topic, 'You are not allowed to make calls')->close();
    }

    public function onPublish(ConnectionInterface $conn, $topic, $event, array $exclude, array $eligible)
    {
        // In this application if clients send data it's because the user hacked around in console
        $conn->close();
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
    }

}