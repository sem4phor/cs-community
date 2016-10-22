<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Lobby'), ['action' => 'edit', $lobby->lobby_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Lobby'), ['action' => 'delete', $lobby->lobby_id], ['confirm' => __('Are you sure you want to delete # {0}?', $lobby->lobby_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Lobbys'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Lobby'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="lobbys view large-9 medium-8 columns content">
    <h3><?= h($lobby->lobby_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Url') ?></th>
            <td><?= h($lobby->url) ?></td>
        </tr>
        <tr>
            <th><?= __('Rank To') ?></th>
            <td><?= h($lobby->rank_to) ?></td>
        </tr>
        <tr>
            <th><?= __('Rank From') ?></th>
            <td><?= h($lobby->rank_from) ?></td>
        </tr>
        <tr>
            <th><?= __('Language') ?></th>
            <td><?= h($lobby->language) ?></td>
        </tr>
        <tr>
            <th><?= __('Lobby Id') ?></th>
            <td><?= $this->Number->format($lobby->lobby_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Owned By') ?></th>
            <td><?= $this->Number->format($lobby->owned_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Free Slots') ?></th>
            <td><?= $this->Number->format($lobby->free_slots) ?></td>
        </tr>
        <tr>
            <th><?= __('Min Age') ?></th>
            <td><?= $this->Number->format($lobby->min_age) ?></td>
        </tr>
        <tr>
            <th><?= __('Min Playtime') ?></th>
            <td><?= $this->Number->format($lobby->min_playtime) ?></td>
        </tr>
        <tr>
            <th><?= __('Min Upvotes') ?></th>
            <td><?= $this->Number->format($lobby->min_upvotes) ?></td>
        </tr>
        <tr>
            <th><?= __('Max Downvotes') ?></th>
            <td><?= $this->Number->format($lobby->max_downvotes) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($lobby->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($lobby->modified) ?></td>
        </tr>
        <tr>
            <th><?= __('Microphone Req') ?></th>
            <td><?= $lobby->microphone_req ? __('Yes') : __('No'); ?></td>
         </tr>
        <tr>
            <th><?= __('Teamspeak Req') ?></th>
            <td><?= $lobby->teamspeak_req ? __('Yes') : __('No'); ?></td>
         </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Users') ?></h4>
        <?php if (!empty($lobby->users)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('User Id') ?></th>
                <th><?= __('Steam Id') ?></th>
                <th><?= __('Country Code') ?></th>
                <th><?= __('Age Range') ?></th>
                <th><?= __('Role Id') ?></th>
                <th><?= __('Rank') ?></th>
                <th><?= __('Upvotes') ?></th>
                <th><?= __('Downvotes') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th><?= __('Username') ?></th>
                <th><?= __('Password') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($lobby->users as $users): ?>
            <tr>
                <td><?= h($users->user_id) ?></td>
                <td><?= h($users->steam_id) ?></td>
                <td><?= h($users->country_code) ?></td>
                <td><?= h($users->age_range) ?></td>
                <td><?= h($users->role_id) ?></td>
                <td><?= h($users->rank) ?></td>
                <td><?= h($users->upvotes) ?></td>
                <td><?= h($users->downvotes) ?></td>
                <td><?= h($users->created) ?></td>
                <td><?= h($users->modified) ?></td>
                <td><?= h($users->username) ?></td>
                <td><?= h($users->password) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Users', 'action' => 'view', $users->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'Users', 'action' => 'edit', $users->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Users', 'action' => 'delete', $users->id], ['confirm' => __('Are you sure you want to delete # {0}?', $users->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>
