<!-- shows detailed information about a user. This view allows moderators and admins to ban/unban users -->

<div class="users medium-centered medium-8 columns content">
    <div class="row">
        <div class="columns medium-3">
            <?= $this->Html->image($view_user->avatarfull, ["alt" => __('steam avatar full'), 'url' => $view_user->profileurl, "class" => "topbar-avatar"]); ?>
        </div>
        <div class="columns medium-9">
            <h3><?= h($view_user->personaname) ?></h3>
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
        </div>
    </div>
    <div class="row">
        <div class="medium-3 columns">&nbsp;</div>
        <div class="columns medium-7 left">
        <?php if ($user->role_id == 2 && $user->steam_id != $view_user->steam_id): ?>
            <?= $this->Html->link(
                __('Give Moderator Rights'),
                ['controller' => 'Users', 'action' => 'makeMod', $view_user->steam_id], ['class' => 'button']
            ); ?>
        <?php endif; ?>
        <?php if ($user->role_id == 3 || $user->role_id == 2  && $user->steam_id != $view_user->steam_id): ?>
            <?php if ($view_user->role_id == 4): ?>
                <?= $this->Html->link(
                    __('Unban'),
                    ['controller' => 'Users', 'action' => 'unban', $view_user->steam_id], ['class' => 'button']
                ); ?>
            <?php else: ?>
                <?= $this->Html->link(
                    __('Ban'),
                    ['controller' => 'Users', 'action' => 'ban', $view_user->steam_id], ['class' => 'button']
                ); ?>
            <?php endif; ?>
        <?php endif; ?>
        </div>
    </div>
</div>
