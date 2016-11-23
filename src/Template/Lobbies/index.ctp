<script src="http://autobahn.s3.amazonaws.com/js/autobahn.min.js"></script>
<script
    src="https://code.jquery.com/jquery-3.1.1.min.js"
    integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
    crossorigin="anonymous"></script>
<script src="http://localhost/cs-community/js/jquery.infinite-scroll.js"></script>
<script src="http://localhost/cs-community/js/update-index.js"></script>


<div class="lobbies index medium-8 columns medium-centered content">
    <?php if (isset($your_lobby)): ?>
        <?= $this->element('your_lobby'); ?>
    <?php else: ?>
        <?= $this->element('new_lobby_form'); ?>
    <?php endif; ?>

    <div class='row' style="margin-top:20px;"><h3><?= __('Lobbies') ?></h3></div>

    <div class="row">
        <?= $this->Form->create('Filter'); ?>
        <div class="columns medium-1"> <?= $this->Form->input('filter_prime_req', ['type' => 'checkbox']); ?></div>
        <div class="columns medium-1"><?= $this->Form->input('filter_teamspeak_req', ['type' => 'checkbox']); ?></div>
        <div class="columns medium-1"> <?= $this->Form->input('filter_microphone_req', ['type' => 'checkbox']); ?></div>
        <div
            class="columns medium-1"> <?= $this->Form->input('filter_min_age', ['type' => 'number', 'value' => $filter['filter_min_age']]); ?></div>
        <div class="columns medium-2"> <?= $this->Form->input('filter_rank_from'); ?></div>
        <div class="columns medium-2"> <?= $this->Form->input('filter_rank_to'); ?></div>
        <div class="columns medium-1"> <?= $this->Form->input('filter_language'); ?></div>
        <div
            class="columns medium-1"> <?= $this->Form->input('filter_min_playtime', ['type' => 'number', 'value' => $filter['filter_min_playtime']]); ?></div>
        <div
            class="columns medium-1"> <?= $this->Form->input('filter_min_upvotes', ['type' => 'number', 'value' => $filter['filter_min_upvotes']]); ?></div>
        <div
            class="columns medium-1"> <?= $this->Form->input('filter_max_downvotes', ['type' => 'number', 'value' => $filter['filter_max_downvotes']]); ?></div>
    </div><div class="row">
        <?= $this->Form->button('submit'); ?>
        <?= $this->Form->end(); ?>
    </div>
    <div id='lobbies-list'>
        <?php foreach ($lobbies as $lobby): ?>
            <div class='lobby-item row'>
                <div
                    class='column medium-1'><?= $this->Html->image('flags/' . $lobby->language . '.png', ["alt" => $lobby->language]); ?></div>
                <div class='column medium-2'>
                    <?php $lobby_user_ids_of_lobby = []; ?>
                    <div class='row'>
                        <?= $this->Html->image($lobby->owner->avatar, ["alt" => 'steam avatar', "heigth" => '20', "width" => '20', 'url' => $lobby->owner->profileurl, 'class' => 'lobby_owner']); ?>
                        <?php foreach ($lobby->users as $lobby_user): ?>
                            <?php if ($lobby_user->user_id != $lobby->owner->user_id): ?>
                                <?php array_push($lobby_user_ids_of_lobby, $lobby_user->user_id); ?>
                                <?= $this->Html->image($lobby_user->avatar, ["alt" => 'steam avatar', "heigth" => '20', "width" => '20', 'url' => $lobby_user->profileurl]); ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class='row'>
                        <?php foreach ($lobby->users as $lobby_user): ?>
                            <?= $this->Html->image('flags/' . $lobby_user->country_code . '.png', ["alt" => $lobby_user->country_code, "heigth" => '20', "width" => '20']); ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class='column medium-4'>
                    <?= $this->Html->image('ranks/' . $lobby->rank_from . '.png', ["alt" => $lobby->rank_to]); ?>
                    <?= $this->Html->image('ranks/' . $lobby->rank_to . '.png', ["alt" => $lobby->rank_to]); ?>
                </div>
                <div class='column medium-1'>
                    <div class="row">
                        <?= $this->Html->image('microphone.png', ["alt" => 'microphone', "heigth" => '20', "width" => '20']); ?>
                        <?= h($lobby->microphone_req) ? __('Yes') : __('No'); ?>
                    </div>
                    <div class="row">
                        <?= $this->Html->image('prime.png', ["alt" => 'prime', "heigth" => '20', "width" => '20']); ?>
                        <?= h($lobby->prime_req) ? __('Yes') : __('No'); ?>
                    </div>
                </div>
                <div class='column medium-1'>
                    <?= $lobby->min_age; ?>
                    <?= $lobby->teamspeak_req; ?>
                    <?= $lobby->min_playtime; ?>
                    <?= $lobby->min_upvotes; ?>
                    <?= $lobby->max_downvotes; ?>
                </div>
                <div class='column medium-1'>
                    <?= $lobby->created->timeAgoInWords(); ?>
                </div>
                <div class='column medium-2'>
                    <?php if (($user['user_id'] == $lobby->owner_id)): ?>
                        <?= $this->Form->postLink('Delete', ["action" => 'delete', $lobby->lobby_id], ['class' => 'button']); ?>
                    <?php elseif (in_array($user['user_id'], $lobby_user_ids_of_lobby)): ?>
                        <?= $this->Html->link('Leave', ["action" => 'leave', $lobby->lobby_id], ['class' => 'button']); ?>
                    <?php else: ?>
                        <?= $this->Html->link('Join', ["action" => 'join', $lobby->lobby_id], ['class' => 'button']); ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
        <?= $this->Paginator->next(__('next'), ['style' => 'margin:auto;', 'class' => 'next']) ?>
    </div>
</div>

<script>
    $(function () {
        var $container = $('#lobbies-list');
        $container.infinitescroll({
                navSelector: '.next',    // selector for the paged navigation
                nextSelector: '.next a',  // selector for the NEXT link (to page 2)
                itemSelector: '.lobby-item',     // selector for all items you'll retrieve
                debug: true,
                dataType: 'html',
                loading: {
                    finishedMsg: 'No more lobbies to load!'
                }
            }
        );
    });
</script>