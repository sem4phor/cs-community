<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Chat Message'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="chatMessages index large-9 medium-8 columns content">
    <h3><?= __('Chat Messages') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('message_id') ?></th>
                <th><?= $this->Paginator->sort('sent_by') ?></th>
                <th><?= $this->Paginator->sort('message') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($chatMessages as $chatMessage): ?>
            <tr>
                <td><?= $this->Number->format($chatMessage->message_id) ?></td>
                <td><?= $this->Number->format($chatMessage->sent_by) ?></td>
                <td><?= h($chatMessage->message) ?></td>
                <td><?= h($chatMessage->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $chatMessage->message_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $chatMessage->message_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $chatMessage->message_id], ['confirm' => __('Are you sure you want to delete # {0}?', $chatMessage->message_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
