<?php
/**
 * Based on the Ratchet Push Integration Tutorial on http://socketo.me/docs/push
 */
require dirname(__DIR__) . '/vendor/autoload.php';
use React\ZMQ\Context;
use App\Controller\Component\PusherComponent;

// create the Eventloop and an instance of the WAMPServerInterface
$loop   = React\EventLoop\Factory::create();
$pusher = new PusherComponent();

// Listen for the web server to make a ZeroMQ push after a client submitted data
$context = new Context($loop);
$pull = $context->getSocket(ZMQ::SOCKET_PULL);
$pull->bind('tcp://127.0.0.1:5555'); // Binding to 127.0.0.1 means the only client that can connect is itself
$pull->on('message', [$pusher, 'onSubmit']); // the message received from the webserver calls WAMPinterface

// Set up our WebSocket server for clients wanting real-time updates
$webSock = new React\Socket\Server($loop);
$webSock->listen(8080, '0.0.0.0'); // Binding to 0.0.0.0 means remotes can connect
$webServer = new Ratchet\Server\IoServer(
    new Ratchet\Http\HttpServer(
        new Ratchet\WebSocket\WsServer(
            new Ratchet\Wamp\WampServer(
                $pusher
            )
        )
    ),
    $webSock
);

$loop->run();