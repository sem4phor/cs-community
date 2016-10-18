<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Username') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <tr>
            <th><?= __('Password') ?></th>
            <td><?= h($user->password) ?></td>
        </tr>
        <tr>
            <th><?= __('Age') ?></th>
            <td><?= h($user->age) ?></td>
        </tr>
        <tr>
            <th><?= __('Role') ?></th>
            <td><?= h($user->role) ?></td>
        </tr>
        <tr>
            <th><?= __('Rank') ?></th>
            <td><?= h($user->rank) ?></td>
        </tr>
        <tr>
            <th><?= __('Language One') ?></th>
            <td><?= h($user->language_one) ?></td>
        </tr>
        <tr>
            <th><?= __('Language Two') ?></th>
            <td><?= h($user->language_two) ?></td>
        </tr>
        <tr>
            <th><?= __('Language Three') ?></th>
            <td><?= h($user->language_three) ?></td>
        </tr>
        <tr>
            <th><?= __('User Id') ?></th>
            <td><?= $this->Number->format($user->user_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Steam Id') ?></th>
            <td><?= $this->Number->format($user->steam_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Upvotes') ?></th>
            <td><?= $this->Number->format($user->upvotes) ?></td>
        </tr>
        <tr>
            <th><?= __('Downvotes') ?></th>
            <td><?= $this->Number->format($user->downvotes) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($user->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($user->modified) ?></td>
        </tr>
    </table>
</div>
