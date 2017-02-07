<!-- section for displaying the joined lobby. The owner is able to kick other users from this section. -->

<div class="row your-lobby">
    <div class='row' id="<?= $your_lobby->lobby_id ?>">
        <div class="row">
            <h2><?= __('Your Lobby') ?></h2>
        </div>
        <div class="row">
            <div class='column medium-1'>
                <?= $this->Html->image('flags/' . $your_lobby->language . '.png', ["alt" => $your_lobby->language]); ?>
            </div>
            <div class='lobby-users-column column medium-3'>
                <div steam_id="<?php echo $your_lobby->owner->steam_id ?>" class="lobby-user-column column medium-2">
                    <div class="row">
                        <?= $this->Html->image($your_lobby->owner->avatar, ["alt" => 'steam avatar', 'url' => $your_lobby->owner->profileurl, 'class' => 'lobby_owner']); ?>
                    </div>
                    <div class="row">
                        <?= $this->Html->image('flags/' . $your_lobby->owner->loccountrycode . '.png', ["alt" => $your_lobby->owner->loccountrycode, "class" => "flag"]); ?>
                    </div>
                </div>
                <?php foreach ($your_lobby->users as $lobby_user): ?>
                    <?php if ($lobby_user->steam_id !== $your_lobby->owner->steam_id): ?>
                        <div steam_id="<?php echo $lobby_user->steam_id ?>" class="lobby-user-column column medium-2">
                            <div class="row">
                                <?= $this->Html->image($lobby_user->avatar, ["alt" => 'steam avatar', 'url' => $lobby_user->profileurl]); ?>
                            </div>
                            <div class="row">
                                <?= $this->Html->image('flags/' . $lobby_user->loccountrycode . '.png', ["alt" => $lobby_user->loccountrycode, "class" => "flag"]); ?>
                            </div>
                            <?php if ($is_own_lobby): ?>
                                <div class="kick-row row">
                                    <a href="lobbies/kick/<?= $lobby_user->steam_id ?>">
                                        <span class="ui-icon-close ui-icon"></span>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class='column medium-4'>
                <div class="row">
                    <div class="medium-5 columns">
                        <?= $this->Html->image('ranks/' . $your_lobby->RankFrom->name . '.png', ["alt" => $your_lobby->RankFrom, "class" => 'rank-icon']); ?>
                    </div>
                    <div class="medium-2 columns"><span class="stretch">-</span></div>
                    <div class="medium-5 columns">
                        <?= $this->Html->image('ranks/' . $your_lobby->RankTo->name . '.png', ["alt" => $your_lobby->RankTo, "class" => 'rank-icon']); ?>
                    </div>
                </div>
            </div>
            <div class='column medium-2'>
                <?php if ($is_own_lobby): ?>
                    <?= $this->Form->postLink(__('Delete'), ["action" => 'delete', $your_lobby->lobby_id], ['class' => 'radius button']); ?>
                <?php else: ?>
                    <?= $this->Html->link(__('Leave'), ["action" => 'leave', $your_lobby->lobby_id], ['class' => 'radius button']); ?>
                <?php endif; ?>
            </div>
            <div class='column medium-2'>
                <?= $your_lobby->created->timeAgoInWords(); ?>
            </div>
        </div>
        <div class="row">
            <div class='column medium-1'><?= $this->Html->image('prime.png', ["alt" => __('Prime'), "heigth" => '20', "width" => '20']); ?>
                <?= h($your_lobby->prime_req) ? __('Yes') : __('No'); ?>
            </div>
            <div class='column medium-1'> <?= $this->Html->image('microphone.png', ["alt" => __('microphone'), "heigth" => '20', "width" => '20']); ?>
                <?= h($your_lobby->microphone_req) ? __('Yes') : __('No'); ?>
            </div>
            <div class='column medium-1'> <?= $this->Html->image('teamspeak.png', ["alt" => __('TS3'), "heigth" => '20', "width" => '20']); ?>
                <?= h($your_lobby->teamspeak_req) ? __('Yes') : __('No'); ?>
            </div>
            <div class='column medium-2'><?= __('Min. Playtime: ') . h($your_lobby->min_playtime); ?></div>
            <div class='column medium-2 left'><?= __('Min. Age: ') . h($your_lobby->min_age); ?></div>
        </div>
    </div>
</div>