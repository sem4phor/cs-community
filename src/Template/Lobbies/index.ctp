<div class="lobbies index large-9 medium-8 columns content">
    <h3><?= __('Lobbies') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('lobby_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('owned_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('free_slots') ?></th>
                <th scope="col"><?= $this->Paginator->sort('url') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('microphone_req') ?></th>
                <th scope="col"><?= $this->Paginator->sort('min_age') ?></th>
                <th scope="col"><?= $this->Paginator->sort('teamspeak_req') ?></th>
                <th scope="col"><?= $this->Paginator->sort('rank_to') ?></th>
                <th scope="col"><?= $this->Paginator->sort('rank_from') ?></th>
                <th scope="col"><?= $this->Paginator->sort('min_playtime') ?></th>
                <th scope="col"><?= $this->Paginator->sort('language') ?></th>
                <th scope="col"><?= $this->Paginator->sort('min_upvotes') ?></th>
                <th scope="col"><?= $this->Paginator->sort('max_downvotes') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lobbies as $lobby): ?>
            <tr>
                <td><?= $lobby->has('lobby') ? $this->Html->link($lobby->lobby->lobby_id, ['controller' => 'Lobbies', 'action' => 'view', $lobby->lobby->lobby_id]) : '' ?></td>
                <td><?= $this->Number->format($lobby->owned_by) ?></td>
                <td><?= $this->Number->format($lobby->free_slots) ?></td>
                <td><?= h($lobby->url) ?></td>
                <td><?= h($lobby->created) ?></td>
                <td><?= h($lobby->modified) ?></td>
                <td><?= h($lobby->microphone_req) ?></td>
                <td><?= $this->Number->format($lobby->min_age) ?></td>
                <td><?= h($lobby->teamspeak_req) ?></td>
                <td><?= h($lobby->rank_to) ?></td>
                <td><?= h($lobby->rank_from) ?></td>
                <td><?= $this->Number->format($lobby->min_playtime) ?></td>
                <td><?= h($lobby->language) ?></td>
                <td><?= $this->Number->format($lobby->min_upvotes) ?></td>
                <td><?= $this->Number->format($lobby->max_downvotes) ?></td>
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
