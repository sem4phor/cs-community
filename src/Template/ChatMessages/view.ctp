<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Chat Message'), ['action' => 'edit', $chatMessage->message_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Chat Message'), ['action' => 'delete', $chatMessage->message_id], ['confirm' => __('Are you sure you want to delete # {0}?', $chatMessage->message_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Chat Messages'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Chat Message'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="chatMessages view large-9 medium-8 columns content">
    <h3><?= h($chatMessage->message_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Message') ?></th>
            <td><?= h($chatMessage->message) ?></td>
        </tr>
        <tr>
            <th><?= __('Message Id') ?></th>
            <td><?= $this->Number->format($chatMessage->message_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Sent By') ?></th>
            <td><?= $this->Number->format($chatMessage->sent_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($chatMessage->created) ?></td>
        </tr>
    </table>
</div>
