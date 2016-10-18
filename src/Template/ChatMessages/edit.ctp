<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $chatMessage->message_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $chatMessage->message_id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Chat Messages'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="chatMessages form large-9 medium-8 columns content">
    <?= $this->Form->create($chatMessage) ?>
    <fieldset>
        <legend><?= __('Edit Chat Message') ?></legend>
        <?php
            echo $this->Form->input('sent_by');
            echo $this->Form->input('message');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
