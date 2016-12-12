<div class="users view large-9 medium-8 columns content">
    <h3><?= h($view_user->name) ?></h3>
    <?= $this->Html->image($view_user->avatarfull, ["alt" => 'steam avatar full', 'url' => $view_user->profileurl]); ?>
    <table>
        <tr>
            <th scope="row"><?= __('Country Code') ?></th>
            <td><?= h($view_user->loccountrycode) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Username') ?></th>
            <td><?= h($view_user->personaname) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Role') ?></th>
            <td><?= h($view_user->role->name) ?></td>
        </tr>

        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($view_user->created->timeAgoInWords()) ?></td>
        </tr>
    </table>
    <?php if ($user->role_id == 2): ?>
        <?= $this->Html->link(
            'Give Moderator Rights',
            ['controller' => 'Users', 'action' => 'makeMod', $view_user->steam_id], ['class' => 'button']
        ); ?>
    <?php endif; ?>
    <?php if ($user->role_id == 3 || $user->role_id == 2): ?>
        <?php if ($view_user->role_id == 4): ?>
            <?= $this->Html->link(
                'Unban',
                ['controller' => 'Users', 'action' => 'unban', $view_user->steam_id], ['class' => 'button']
            ); ?>
        <?php else: ?>
            <?= $this->Html->link(
                'Ban',
                ['controller' => 'Users', 'action' => 'ban', $view_user->steam_id], ['class' => 'button']
            ); ?>
        <?php endif; ?>
    <?php endif; ?>
</div>
