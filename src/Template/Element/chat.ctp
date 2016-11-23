<div class="chat medium-2 columns right" style="color:#fff">
    <div class="row">
        <h3 style="color:#fff"><?= __('Chat') ?></h3>
        <?php foreach ($chatMessages as $chatMessage): ?>
            <div class="row">
                <div class="columns medium-10"><?= h($chatMessage->sender->personaname) ?>
                    <?= h($chatMessage->message) ?></div>
                <div class="columns medium-2"><?= h($chatMessage->created) ?></div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="row">
        <?= $this->Form->create('ChatMessage', ['url' => ['controller' => 'ChatMessages', 'action' => 'new']]); ?>
        <?= $this->Form->input('message'); ?>
        <?= $this->Form->button('send', ['type' => 'submit']); ?>
        <?= $this->Form->end(); ?>
    </div>
    <div class="row">
    </div>
</div>
