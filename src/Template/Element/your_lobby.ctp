<div class="row lobbies your-lobby medium-centered">

    <div class="row">
        <h3><?= __('Your Lobby') ?></h3>
    </div>
    <div class='lobby-item row'>
        <div class="row">
            <div class='column medium-1'>
                <?= $this->Html->image('flags/' . $your_lobby->language . '.png', ["alt" => $your_lobby->language]); ?>
            </div>
            <div class='column medium-2'>
                <?php $steam_ids_of_lobby = []; ?>
                <div class='row'>
                    <?php foreach ($your_lobby->users as $lobby_user): ?>
                        <?php if ($lobby_user->steam_id != $user->steam_id): ?>
                            <?= $this->Html->image('kick.png', ["alt" => 'help button', "heigth" => '20', "width" => '20', "url" => '/users/kick/' . $lobby_user->steam_id]); ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <div class='row'>
                    <?php foreach ($your_lobby->users as $lobby_user): ?>
                        <?php array_push($steam_ids_of_lobby, $lobby_user->steam_id); ?>
                        <?php if ($lobby_user->steam_id == $your_lobby->owner_id): ?>
                            <?= $this->Html->image($lobby_user->avatar, ["alt" => 'steam avatar', "heigth" => '20', "width" => '20', 'url' => $lobby_user->profileurl, 'class' => 'lobby_owner']); ?>
                        <?php else: ?>
                            <?= $this->Html->image($lobby_user->avatar, ["alt" => 'steam avatar', "heigth" => '20', "width" => '20', 'url' => $lobby_user->profileurl]); ?>
                        <?php endif; ?>

                    <?php endforeach; ?>
                </div>
                <div class='row'>
                    <?php foreach ($your_lobby->users as $lobby_user): ?>
                        <?= $this->Html->image('flags/' . $lobby_user->loccountrycode . '.png', ["alt" => $lobby_user->loccountrycode, "heigth" => '20px', "width" => '20px']); ?>
                    <?php endforeach; ?>
                </div>

            </div>
            <div class='column medium-4'>
                <?= $this->Html->image('ranks/' . $your_lobby->RankFrom->name . '.png', ["alt" => $your_lobby->RankFrom, "heigth" => '37px', "width" => '100px']); ?>
                <?= $this->Html->image('ranks/' . $your_lobby->RankTo->name . '.png', ["alt" => $your_lobby->RankTo, "heigth" => '37px', "width" => '100px']); ?>
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
                <div class="row">
                    <?= $this->Html->image('teamspeak.png', ["alt" => 'TS3', "heigth" => '20', "width" => '20']); ?>
                    <?= h($your_lobby->teamspeak_req) ? __('Yes') : __('No'); ?>
                </div>
            </div>


            <div class='column medium-2'>
                <?= $your_lobby->created->timeAgoInWords(); ?>
            </div>
            <div class='column medium-2'>
                <?php if ($is_own_lobby): ?>
                    <?= $this->Form->postLink('Delete', ["action" => 'delete', $your_lobby->lobby_id], ['class' => 'radius button small']); ?>
                <?php else: ?>
                    <?= $this->Html->link('Leave', ["action" => 'leave', $your_lobby->lobby_id], ['class' => 'button']); ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class='column medium-3'><?= __('Min. Playtime: ') . h($your_lobby->min_playtime); ?></div>
            <div class='column medium-3'><?= __('Min. Age: ') . h($your_lobby->min_age); ?></div>
            <div class='column medium-3'><?= __('Min. Upvotes: ') . h($your_lobby->min_upvotes); ?></div>
            <div class='column medium-3'><?= __('Max. Downvotes: ') . h($your_lobby->max_downvotes); ?></div>

        </div>
    </div>


</div>