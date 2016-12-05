<?= $this->element('chat'); ?>
<div class="lobbies lobbies-index medium-7 columns content">

    <?php if (isset($your_lobby)): ?>
        <?= $this->element('your_lobby'); ?>
    <?php else: ?>
        <?= $this->element('new_lobby_form'); ?>
    <?php endif; ?>

    <div class='row' style="margin-top:20px;"><h3><?= __('Lobbies') ?></h3></div>

    <div id='lobbies-list'>
        <?php foreach ($lobbies as $lobby): ?>
            <div class='lobby-item row' id="<?= $lobby->lobby_id ?>">
                <div class="row">
                    <div class='column medium-1'>
                        <?= $this->Html->image('flags/' . $lobby->language . '.png', ["alt" => $lobby->language]); ?>
                    </div>
                    <div class='lobby-users-column column medium-2'>
                        <?php $lobby_steam_ids_of_lobby = []; ?>
                        <?php foreach ($lobby->users as $lobby_user): ?>
                            <div steam_id="<?php echo $lobby_user->steam_id ?>"                                 class="lobby-user-column column medium-2">
                                <div class="row">
                                    <?php array_push($lobby_steam_ids_of_lobby, $lobby_user->steam_id); ?>
                                    <?php if ($lobby_user->steam_id == $lobby->owner->steam_id): ?>
                                        <?= $this->Html->image($lobby->owner->avatar, ["alt" => 'steam avatar', "heigth" => '20', "width" => '20', 'url' => $lobby->owner->profileurl, 'class' => 'lobby_owner']); ?>
                                    <?php else: ?>
                                        <?= $this->Html->image($lobby_user->avatar, ["alt" => 'steam avatar', "heigth" => '20', "width" => '20', 'url' => $lobby_user->profileurl]); ?>
                                    <?php endif; ?>
                                </div>
                                <div class="row">
                                    <?= $this->Html->image('flags/' . $lobby_user->loccountrycode . '.png', ["alt" => $lobby_user->loccountrycode, "heigth" => '20', "width" => '20']); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class='column medium-4'>
                        <?= $this->Html->image('ranks/' . $lobby->RankFrom->name . '.png', ["alt" => $lobby->rank_to]); ?>
                        <?= $this->Html->image('ranks/' . $lobby->RankTo->name . '.png', ["alt" => $lobby->rank_to]); ?>
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
                        <div class="row">
                            <?= $this->Html->image('teamspeak.png', ["alt" => 'TS3', "heigth" => '20', "width" => '20']); ?>
                            <?= h($lobby->teamspeak_req) ? __('Yes') : __('No'); ?>
                        </div>
                    </div>
                    <div class='column medium-1'>
                        <?= $lobby->created->timeAgoInWords(); ?>
                    </div>
                    <div class='column medium-2'>
                        <?php if (($user['steam_id'] == $lobby->owner_id)): ?>
                            <?= $this->Form->postLink('Delete', ["action" => 'delete', $lobby->lobby_id], ['class' => 'button small radius']); ?>
                        <?php elseif (in_array($user['steam_id'], $lobby_steam_ids_of_lobby)): ?>
                            <?= $this->Html->link('Leave', ["action" => 'leave', $lobby->lobby_id], ['class' => 'button small radius']); ?>
                        <?php else: ?>
                            <?= $this->Html->link('Join', ["action" => 'join', $lobby->lobby_id], ['class' => 'button small radius']); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class='row'>
                    <div class='column medium-3'><?= __('Min. Playtime: ') . $lobby->min_playtime; ?></div>
                    <div class='column medium-3'><?= __('Min. Age: ') . $lobby->min_age; ?></div>
                    <div class='column medium-3'><?= __('Min. Upvotes: ') . $lobby->min_upvotes; ?></div>
                    <div class='column medium-3'><?= __('Max. Downvotes: ') . $lobby->max_downvotes; ?></div>
                </div>
            </div>
        <?php endforeach; ?>
        <?= $this->Paginator->next(__('next'), ['style' => 'margin:auto;', 'class' => 'next']) ?>
    </div>
</div>

<?= $this->element('filter_options'); ?>


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


<script>
    $(function () {
        $.widget("custom.iconselectmenu", $.ui.selectmenu, {
            _renderItem: function (ul, item) {
                var li = $("<li>"),
                    wrapper = $("<div>", {text: item.label});
                if (item.disabled) {
                    li.addClass("ui-state-disabled");
                }
                $("<span>", {
                    style: item.element.attr("data-style"),
                    "class": "ui-icon " + item.element.attr("data-class")
                })
                    .appendTo(wrapper);

                return li.append(wrapper).appendTo(ul);
            }
        });
    });

    function updateSelectBackground(select_id, img_path, button_id) {
        var sel_item = $(select_id + ' option:selected').text();
        $(button_id).css('background-image', 'url(\'' + img_path + sel_item + '.png\')');
    }

    function initImageSelector(select_id, img_path) {
        $(select_id)
            .iconselectmenu()
            .iconselectmenu("menuWidget")
            .addClass("ui-menu-icons avatar");
        var options = $(select_id).children();

        for (var x = 0; x < options.length; x++) {
            options[x].setAttribute('data-class', 'avatar');
            options[x].setAttribute('data-style', "background-image: url(\'" + img_path + options[x].innerHTML + ".png');");
        }
    }

    $(document).ready(function () {
        $('#expand').hide();
        $('#expand_new_lobby').on('click', function () {
            if ($('#expand').is(':hidden')) {
                $('#expand').slideDown();
                $('#expand_new_lobby').text('less options');
            } else {
                $('#expand').slideUp();
                $('#expand_new_lobby').text('more options');
            }
        });

        // filter selectors
        initImageSelector('#filter-language', '/cs-community/webroot/img/flags/', '#filter-language-button');
        initImageSelector('#filter-user-rank', '/cs-community/webroot/img/ranks/', '#filter-user-rank-button');
        updateSelectBackground('#filter-language', '/cs-community/webroot/img/flags/', '#filter-language-button');
        updateSelectBackground('#filter-user-rank', '/cs-community/webroot/img/ranks/', '#filter-user-rank-button');
        $('#filter-language-menu').on('click', function () {
            updateSelectBackground('#filter-language', '/cs-community/webroot/img/flags/', '#filter-language-button');
        });
        $('#filter-user-rank-menu').on('click', function () {
            updateSelectBackground('#filter-user-rank', '/cs-community/webroot/img/ranks/', '#filter-user-rank-button');
        });
        // new lobby selectors
        initImageSelector('#language', '/cs-community/webroot/img/flags/', '#language-button');
        initImageSelector('#rank-from', '/cs-community/webroot/img/ranks/', '#rank-from-button');
        initImageSelector('#rank-to', '/cs-community/webroot/img/ranks/', '#rank-to-button');
        updateSelectBackground('#language', '/cs-community/webroot/img/flags/', '#language-button');
        updateSelectBackground('#rank-from', '/cs-community/webroot/img/ranks/', '#rank-from-button');
        updateSelectBackground('#rank-to', '/cs-community/webroot/img/ranks/', '#rank-to-button');
        $('#language-menu').on('click', function () {
            updateSelectBackground('#language', '/cs-community/webroot/img/flags/', '#language-button');
        });
        $('#rank-from-menu').on('click', function () {
            var e1 = $('#rank-to');
            var e2 = $('#rank-from');
            if (parseInt(e1.val()) < parseInt(e2.val())) {
                e1.val(e2.val());
                updateSelectBackground('#rank-to', '/cs-community/webroot/img/ranks/', '#rank-to-button');
            }
            updateSelectBackground('#rank-from', '/cs-community/webroot/img/ranks/', '#rank-from-button');
        });
        $('#rank-to-menu').on('click', function () {
            var e1 = $('#rank-from');
            var e2 = $('#rank-to');
            if (parseInt(e1.val()) > parseInt(e2.val())) {
                e1.val(e2.val());
                updateSelectBackground('#rank-from', '/cs-community/webroot/img/ranks/', '#rank-from-button');
            }
            updateSelectBackground('#rank-to', '/cs-community/webroot/img/ranks/', '#rank-to-button');
        });
    });
</script>