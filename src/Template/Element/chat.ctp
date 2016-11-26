<div class="chat medium-3 columns">
    <div class="chat-container">
        <div class="row">
            <div class="columns medium-12"><h3 style="color:#fff"><?= __('Chat') ?></h3></div>
        </div>
        <div class="row chat-message-container">
            <?php $col_index = 0; ?>
            <?php $colors = ["#234567", "#CF142B", "#C5AC6A", "#5E9FB8"]; ?>
            <?php foreach ($chatMessages as $chatMessage): ?>
                <div class="row">
                    <div class="columns medium-12" style="color:<?php echo $colors[$col_index]; ?>">
                        <?php $col_index += 1;
                        if ($col_index >= count($colors)) $col_index = 0; ?>
                        <?= h($chatMessage->sender->personaname) . ':' ?>
                        <?= h($chatMessage->message) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="submit-message row">
            <div class="chat-message-input columns medium-8">
                <?= $this->Form->create('ChatMessage', ['url' => ['controller' => 'ChatMessages', 'action' => 'new']]); ?>
                <?= $this->Form->input('message', ['label' => false, 'width' => '10px']); ?>
            </div>
            <div class="chat-message-input columns medium-4">
                <?= $this->Form->button('Send', ['type' => 'submit', 'class' => 'tiny radius']); ?>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
