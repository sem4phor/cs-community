<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Lobby'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="lobbys index large-9 medium-8 columns content">
    <h3><?= __('Lobbys') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('lobby_id') ?></th>
                <th><?= $this->Paginator->sort('owned_by') ?></th>
                <th><?= $this->Paginator->sort('free_slots') ?></th>
                <th><?= $this->Paginator->sort('url') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lobbys as $lobby): ?>
            <tr>
                <td><?= $this->Number->format($lobby->lobby_id) ?></td>
                <td><?= $this->Number->format($lobby->owned_by) ?></td>
                <td><?= $this->Number->format($lobby->free_slots) ?></td>
                <td><?= h($lobby->url) ?></td>
                <td><?= h($lobby->created) ?></td>
                <td><?= h($lobby->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $lobby->lobby_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $lobby->lobby_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $lobby->lobby_id], ['confirm' => __('Are you sure you want to delete # {0}?', $lobby->lobby_id)]) ?>
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
