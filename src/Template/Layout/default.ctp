<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CS-Community: Find the best teammates ever!';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    <?= $this->Html->script('https://code.jquery.com/jquery-3.1.1.min.js"
                             			  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
                             			  crossorigin="anonymous'); ?>
    <?= $this->Html->script('jquery.infinite-scroll.js'); ?>
</head>
<body>
    <nav class="top-bar expanded" data-topbar role="navigation">
        <ul class="title-area large-3 medium-4 colmuns">
            <li class="name">
                <h1><?= $this->Html->link(__('CS-Community'), ['controller' => 'lobbies', 'action' => 'home', 'class' => 'logo']) ?></a></h1>
            </li>
        </ul>
        <section class="top-bar-section">
            <ul class="right">
                <?php if (isset($user)): ?>
                    <li class='has-dropdown not-click'><a href='#'> <?= h($user->steam_personaname) ?></a>
                        <ul class="dropdown">
                            <li > <?= $this->Html->link(__('Settings'), ['controller' => 'users','action' => 'settings']) ?></li>
                            <li > <?= $this->Html->link(__('View Profile'), ['controller' => 'users','action' => 'view', $user['user_id']]) ?></li>
                            <li><?= $this->Html->link(__('Logout'), ['controller' => 'users', 'action' => 'logout']) ?></li>
                        </ul>
                    </li>
                    <li><?= $this->Html->image($user->steam_avatar, ['alt' => 'steam_avatar']); ?></li>
                <?php else: ?>
                   <li><?= $this->Html->image("http://cdn.steamcommunity.com/public/images/signinthroughsteam/sits_02.png", [
                               "alt" => "Steam Login",
                               'url' => ['controller' => 'Users', 'action' => 'login']]); ?>
                   </li>

                <?php endif; ?>
            </ul>

        </section>
    </nav>
    <?= $this->Flash->render() ?>
    <section class="container clearfix">
        <?= $this->fetch('content') ?>
    </section>
    <footer>
    </footer>
</body>
</html>
