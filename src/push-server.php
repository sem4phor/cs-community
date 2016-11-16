<?php
/**
 * Created by PhpStorm.
 * User: Valentin
 * Date: 10.10.2016
 * Time: 15:17
 */
require dirname(__DIR__) . '/vendor/autoload.php';
use Ratchet\ConnectionInterface;
use Ratchet\Wamp\WampServerInterface;
use React\ZMQ\Context;

$loop   = React\EventLoop\Factory::create();
$pusher = new App\Pusher();

// Listen for the web server to make a ZeroMQ push after an ajax request
$context = new Context($loop);
$pull = $context->getSocket(ZMQ::SOCKET_PULL);
$pull->bind('tcp://127.0.0.1:5555'); // Binding to 127.0.0.1 means the only client that can connect is itself
$pull->on('message', array($pusher, 'onLobbyEntry'));

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