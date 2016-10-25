<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $lobby->lobby_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $lobby->lobby_id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Lobbies'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Lobbies'), ['controller' => 'Lobbies', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Lobby'), ['controller' => 'Lobbies', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="lobbies form large-9 medium-8 columns content">
    <?= $this->Form->create($lobby) ?>
    <fieldset>
        <legend><?= __('Edit Lobby') ?></legend>
        <?php
            echo $this->Form->input('owned_by');
            echo $this->Form->input('free_slots');
            echo $this->Form->input('url');
            echo $this->Form->input('microphone_req');
            echo $this->Form->input('min_age');
            echo $this->Form->input('teamspeak_req');
            echo $this->Form->input('rank_to');
            echo $this->Form->input('rank_from');
            echo $this->Form->input('min_playtime');
            echo $this->Form->input('language');
            echo $this->Form->input('min_upvotes');
            echo $this->Form->input('max_downvotes');
            echo $this->Form->input('users._ids', ['options' => $users]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
