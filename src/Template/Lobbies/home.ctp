<?php if (!isset($user)): ?>
    <div class="lobbies home medium-7 medium-centered columns content">
        <div id='lobbies-list'>
            <?php if ($lobbies->isEmpty()): ?>
                <div class="row no-lobbies">
                    <p><?= __('There is currently no party available.') ?></p>
                </div>
            <?php endif; ?>
            <?php foreach ($lobbies as $lobby): ?>
                <div class='lobby-item row' id="<?= $lobby->lobby_id ?>">
                    <div class="row">
                        <div class='column medium-1'>
                            <?= $this->Html->image('flags/' . $lobby->language . '.png', ["alt" => $lobby->language]); ?>
                        </div>
                        <div class='lobby-users-column column medium-2'>
                            <div steam_id="<?php echo $lobby->owner->steam_id ?>"
                                 class="lobby-user-column column medium-2">
                                <div class="row">
                                    <?= $this->Html->image($lobby->owner->avatar, ["alt" => 'steam avatar', 'url' => $lobby->owner->profileurl, 'class' => 'lobby_owner']); ?>
                                </div>
                                <div class="row">
                                    <?= $this->Html->image('flags/' . $lobby->owner->loccountrycode . '.png', ["alt" => $lobby->owner->loccountrycode, "class" => "flag"]); ?>
                                </div>
                            </div>
                            <?php foreach ($lobby->users as $lobby_user): ?>
                                <?php if ($lobby_user->steam_id !== $lobby->owner->steam_id): ?>
                                    <div steam_id="<?php echo $lobby_user->steam_id ?>"
                                         class="lobby-user-column column medium-2">
                                        <div class="row">
                                            <?= $this->Html->image($lobby_user->avatar, ["alt" => 'steam avatar', 'url' => $lobby_user->profileurl]); ?>
                                        </div>
                                        <div class="row">
                                            <?= $this->Html->image('flags/' . $lobby_user->loccountrycode . '.png', ["alt" => $lobby_user->loccountrycode, "class" => "flag"]); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <div class='column medium-4'>
                            <div class="row">
                                <div class="medium-5 columns">
                                    <?= $this->Html->image('ranks/' . $lobby->RankFrom->name . '.png', ["alt" => $lobby->RankFrom, "class" => 'rank-icon']); ?>
                                </div>
                                <div class="medium-2 columns"><span class="stretch">-</span></div>

                                <div class="medium-5 columns">
                                    <?= $this->Html->image('ranks/' . $lobby->RankTo->name . '.png', ["alt" => $lobby->RankTo, "class" => 'rank-icon']); ?>
                                </div>
                            </div>
                        </div>

                        <div class='column medium-2'>
                            <?= $lobby->created->timeAgoInWords(); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class='column medium-1'><?= $this->Html->image('prime.png', ["alt" => 'prime', "heigth" => '20', "width" => '20']); ?>
                            <?= h($lobby->prime_req) ? __('Yes') : __('No'); ?>
                        </div>
                        <div class='column medium-1'> <?= $this->Html->image('microphone.png', ["alt" => 'microphone', "heigth" => '20', "width" => '20']); ?>
                            <?= h($lobby->microphone_req) ? __('Yes') : __('No'); ?>
                        </div>
                        <div class='column medium-1'> <?= $this->Html->image('teamspeak.png', ["alt" => 'TS3', "heigth" => '20', "width" => '20']); ?>
                            <?= h($lobby->teamspeak_req) ? __('Yes') : __('No'); ?>
                        </div>
                        <div class='column medium-2'><?= __('Min. Playtime: ') . h($lobby->min_playtime); ?></div>
                        <div class='column medium-2 left'><?= __('Min. Age: ') . h($lobby->min_age); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
            <ul style="display:none;">
                <?= $this->Paginator->next(__('next'), ['style' => 'margin:auto;', 'class' => 'next']) ?>
            </ul>
        </div>
    </div>
<?php else: ?>
    <?= $this->element('chat'); ?>
    <div class="lobbies lobbies-index medium-7 columns content">
        <?php if (isset($your_lobby)): ?>
            <?= $this->element('your_lobby'); ?>
        <?php else: ?>
            <?= $this->element('new_lobby_form'); ?>
        <?php endif; ?>
        <div id='lobbies-list'>
            <?php if ($lobbies->isEmpty()): ?>
                <div class="row no-lobbies">
                    <p><?= __('There is currently no party available.') ?></p>
                </div>
            <?php endif; ?>
            <?php foreach ($lobbies as $lobby): ?>
                <div class='lobby-item row' id="<?= $lobby->lobby_id ?>">
                    <div class="row">
                        <div class='column medium-1'>
                            <?= $this->Html->image('flags/' . $lobby->language . '.png', ["alt" => $lobby->language]); ?>
                        </div>
                        <div class='lobby-users-column column medium-3'>
                            <div steam_id="<?php echo $lobby->owner->steam_id ?>" class="lobby-user-column column medium-2">
                                <div class="row">
                                    <?= $this->Html->image($lobby->owner->avatar, ["alt" => 'steam avatar', 'url' => $lobby->owner->profileurl, 'class' => 'lobby_owner']); ?>
                                </div>
                                <div class="row">
                                    <?= $this->Html->image('flags/' . $lobby->owner->loccountrycode . '.png', ["alt" => $lobby->owner->loccountrycode, "class" => "flag"]); ?>
                                </div>
                            </div>
                            <?php $is_in_lobby = false; ?>
                            <?php foreach ($lobby->users as $lobby_user): ?>
                                <?php if ($lobby_user->steam_id !== $lobby->owner->steam_id): ?>
                                    <div steam_id="<?php echo $lobby_user->steam_id ?>" class="lobby-user-column column medium-2">
                                        <div class="row">
                                            <?= $this->Html->image($lobby_user->avatar, ["alt" => 'steam avatar', 'url' => $lobby_user->profileurl]); ?>
                                        </div>
                                        <div class="row">
                                            <?= $this->Html->image('flags/' . $lobby_user->loccountrycode . '.png', ["alt" => $lobby_user->loccountrycode, "class" => "flag"]); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php $lobby_user->steam_id === $user->steam_id ? $is_in_lobby = true : ''; ?>
                            <?php endforeach; ?>
                        </div>
                        <div class='column medium-4'>
                            <div class="row">
                                <div class="medium-5 columns">
                                    <?= $this->Html->image('ranks/' . $lobby->RankFrom->name . '.png', ["alt" => $lobby->RankFrom, "class" => 'rank-icon']); ?>
                                </div>
                                <div class="medium-2 columns"><span class="stretch">-</span></div>

                                <div class="medium-5 columns">
                                    <?= $this->Html->image('ranks/' . $lobby->RankTo->name . '.png', ["alt" => $lobby->RankTo, "class" => 'rank-icon']); ?>
                                </div>
                            </div>
                        </div>

                        <div class='column medium-2'>
                            <?php if ($lobby->owner->steam_id === $user->steam_id): ?>
                                <?= $this->Form->postLink('Delete', ["action" => 'delete', $lobby->lobby_id], ['class' => 'radius button small']); ?>
                            <?php elseif(!$is_in_lobby): ?>
                                <?= $this->Html->link('Join', ["action" => 'join', $lobby->lobby_id], ['id' => 'join-trigger', 'class' => 'radius button small', 'lobby-url' => $lobby->url]); ?>
                            <?php else: ?>
                                <?= $this->Html->link('Leave', ["action" => 'leave', $lobby->lobby_id], ['class' => 'radius button small']); ?>
                            <?php endif; ?>
                        </div>
                        <div class='column medium-2'>
                            <?= $lobby->created->timeAgoInWords(); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class='column medium-1'><?= $this->Html->image('prime.png', ["alt" => 'prime', "heigth" => '20', "width" => '20']); ?>
                            <?= h($lobby->prime_req) ? __('Yes') : __('No'); ?>
                        </div>
                        <div class='column medium-1'> <?= $this->Html->image('microphone.png', ["alt" => 'microphone', "heigth" => '20', "width" => '20']); ?>
                            <?= h($lobby->microphone_req) ? __('Yes') : __('No'); ?>
                        </div>
                        <div class='column medium-1'> <?= $this->Html->image('teamspeak.png', ["alt" => 'TS3', "heigth" => '20', "width" => '20']); ?>
                            <?= h($lobby->teamspeak_req) ? __('Yes') : __('No'); ?>
                        </div>
                        <div class='column medium-2'><?= __('Min. Playtime: ') . h($lobby->min_playtime); ?></div>
                        <div class='column medium-2 left'><?= __('Min. Age: ') . h($lobby->min_age); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>

            <ul style="display:none;">
                <?= $this->Paginator->next(__('next'), ['style' => 'margin:auto;', 'class' => 'next']) ?>
            </ul>
        </div>
    </div>
    <?= $this->element('filter_options'); ?>
<?php endif; ?>

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

    $(function () {
        $.widget("custom.iconselectmenu", $.ui.selectmenu, {
            _renderItem: function (ul, item) {
                var li = $("<li>"),
                    wrapper = $("<div>", {
                        /*text: item.label,*/
                        style: item.element.attr("data-style"),
                        "class": "ui-icon " + item.element.attr("data-class")
                    });
                if (item.disabled) {
                    li.addClass("ui-state-disabled");
                }
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
        $('#expand-content').hide();
        $('#expand-new-lobby').on('click', function () {
            var gear = $("<span>", {
                "class": "ui-icon ui-icon-gear"
            });
            if ($('#expand-content').is(':hidden')) {
                $('#expand-content').slideDown();
                $('#expand-new-lobby').text('less options');
            } else {
                $('#expand-content').slideUp();
                $('#expand-new-lobby').text('more options');
            }
            $('#expand-new-lobby').prepend(gear);
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

        $('#join-trigger').on('click', function (e) {
            e.preventDefault();
            window.location = $(this).attr('lobby-url');
            window.location = this.href;
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

        //$('.ui-selectmenu-menu').addClass('scrollbar-inner');
        $('.ui-menu').addClass('scrollbar-inner');
        $('.scrollbar-inner').scrollbar();
    });
</script>
