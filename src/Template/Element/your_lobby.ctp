<div class="row">
    <h3><?= __('Your Lobby') ?></h3>
</div>
<div class='lobby-item row'>

    <div
        class='column medium-1'><?= $this->Html->image('flags/' . $your_lobby->language . '.png', ["alt" => $your_lobby->language]); ?></div>
    <div class='column medium-2'>
        <?php $user_ids_of_lobby = []; ?>
        <div class='row'>
            <?php foreach ($your_lobby->users as $user): ?>
                <?php array_push($user_ids_of_lobby, $user->user_id); ?>
                <?php if ($user->user_id == $your_lobby->owned_by): ?>
                    <?= $this->Html->image($user->avatar, ["alt" => 'steam avatar', "heigth" => '20', "width" => '20', 'url' => $user->profileurl, 'class' => 'lobby_owner']); ?>
                <?php else: ?>
                    <?= $this->Html->image($user->avatar, ["alt" => 'steam avatar', "heigth" => '20', "width" => '20', 'url' => $user->profileurl]); ?>
                    <?= $this->Html->link('Kick', ["action" => 'kick', $user->user_id], ['class' => 'button tiny round']); ?>
                <?php endif; ?>

            <?php endforeach; ?>
        </div>
        <div class='row'>
            <?php foreach ($your_lobby->users as $user): ?>
                <?= $this->Html->image('flags/' . $user->country_code . '.png', ["alt" => $user->country_code, "heigth" => '20', "width" => '20']); ?>
            <?php endforeach; ?>
        </div>
    </div>
    <div class='column medium-4'>
        <?= $this->Html->image('ranks/' . $your_lobby->rank_from . '.png', ["alt" => $your_lobby->rank_to]); ?>
        <?= $this->Html->image('ranks/' . $your_lobby->rank_to . '.png', ["alt" => $your_lobby->rank_to]); ?>
    </div>
    <div class='column medium-1'>
        <div class="row">
            <?= $this->Html->image('microphone.png', ["alt" => 'microphone', "heigth" => '20', "width" => '20']); ?>
            <?= h($your_lobby->microphone_req) ? __('Yes') : __('No'); ?>
        </div>
        <div class="row">
            <?= $this->Html->image('prime.png', ["alt" => 'prime', "heigth" => '20', "width" => '20']); ?>
            <?= h($your_lobby->prime_req) ? __('Yes') : __('No'); ?>
        </div>
    </div>
    <div class='column medium-1'>
        <?= $your_lobby->created; ?>
    </div>
    <div class='column medium-2'>
        <?php if ($is_own_lobby): ?>
            <?= $this->Html->link('Delete', ["action" => 'delete', $your_lobby->lobby_id], ['class' => 'button']); ?>
        <?php else: ?>
            <?= $this->Html->link('Leave', ["action" => 'leave', $your_lobby->lobby_id], ['class' => 'button']); ?>
        <?php endif; ?>
    </div>
</div>
