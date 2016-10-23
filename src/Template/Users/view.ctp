<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->user_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->user_id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->user_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Lobbys'), ['controller' => 'Lobbys', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Lobby'), ['controller' => 'Lobbys', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $user->has('user') ? $this->Html->link($user->user->name, ['controller' => 'Users', 'action' => 'view', $user->user->user_id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Steam Id') ?></th>
            <td><?= h($user->steam_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Country Code') ?></th>
            <td><?= h($user->country_code) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Age Range') ?></th>
            <td><?= h($user->age_range) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Role') ?></th>
            <td><?= $user->has('role') ? $this->Html->link($user->role->name, ['controller' => 'Roles', 'action' => 'view', $user->role->role_id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rank') ?></th>
            <td><?= h($user->rank) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Username') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Password') ?></th>
            <td><?= h($user->password) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Upvotes') ?></th>
            <td><?= $this->Number->format($user->upvotes) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Downvotes') ?></th>
            <td><?= $this->Number->format($user->downvotes) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($user->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($user->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Lobbys') ?></h4>
        <?php if (!empty($user->lobbys)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Lobby Id') ?></th>
                <th scope="col"><?= __('Owned By') ?></th>
                <th scope="col"><?= __('Free Slots') ?></th>
                <th scope="col"><?= __('Url') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Microphone Req') ?></th>
                <th scope="col"><?= __('Min Age') ?></th>
                <th scope="col"><?= __('Teamspeak Req') ?></th>
                <th scope="col"><?= __('Rank To') ?></th>
                <th scope="col"><?= __('Rank From') ?></th>
                <th scope="col"><?= __('Min Playtime') ?></th>
                <th scope="col"><?= __('Language') ?></th>
                <th scope="col"><?= __('Min Upvotes') ?></th>
                <th scope="col"><?= __('Max Downvotes') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->lobbys as $lobbys): ?>
            <tr>
                <td><?= h($lobbys->lobby_id) ?></td>
                <td><?= h($lobbys->owned_by) ?></td>
                <td><?= h($lobbys->free_slots) ?></td>
                <td><?= h($lobbys->url) ?></td>
                <td><?= h($lobbys->created) ?></td>
                <td><?= h($lobbys->modified) ?></td>
                <td><?= h($lobbys->microphone_req) ?></td>
                <td><?= h($lobbys->min_age) ?></td>
                <td><?= h($lobbys->teamspeak_req) ?></td>
                <td><?= h($lobbys->rank_to) ?></td>
                <td><?= h($lobbys->rank_from) ?></td>
                <td><?= h($lobbys->min_playtime) ?></td>
                <td><?= h($lobbys->language) ?></td>
                <td><?= h($lobbys->min_upvotes) ?></td>
                <td><?= h($lobbys->max_downvotes) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Lobbys', 'action' => 'view', $lobbys->lobby_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Lobbys', 'action' => 'edit', $lobbys->lobby_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Lobbys', 'action' => 'delete', $lobbys->lobby_id], ['confirm' => __('Are you sure you want to delete # {0}?', $lobbys->lobby_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
