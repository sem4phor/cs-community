<!-- The home view. Here are all elements tied together. If the user is not logged in he wont see the chat and the lobby filter. -->

<?php if (isset($user)): ?>
<?= $this->element('chat'); ?>
<div class="lobbies lobbies-index medium-7 columns content">
    <?php if (isset($your_lobby)): ?>
        <?= $this->element('your_lobby'); ?>
    <?php else: ?>
        <?= $this->element('new_lobby_form'); ?>
    <?php endif ?>
    <?php else: ?>
    <div class="lobbies lobbies-index medium-7 medium-centered columns content">
        <?php endif; ?>
        <?php if (isset($user)): ?>
        <div id='lobbies-list' filter-active="<?= $filter_active ?>">
            <?php else: ?>
            <div id='lobbies-list'>
            <?php endif ?>

            <?php if ($lobbies->isEmpty()): ?>
                <div class="row no-lobbies">
                    <p><?= __("There is currently no lobby available. Why don't you create one?") ?></p>
                </div>
            <?php endif; ?>

            <?php foreach ($lobbies as $lobby): ?>
                <div class='lobby-item row' id="<?= $lobby->lobby_id ?>">
                    <div class="row">
                        <div class='column medium-1'>
                            <?= $this->Html->image('flags/' . $lobby->language . '.png', ["alt" => $lobby->language]); ?>
                        </div>
                        <div class='lobby-users-column column medium-3'>
                            <div steam_id="<?php echo $lobby->owner->steam_id ?>"
                                 class="lobby-user-column column medium-2">
                                <div class="row">
                                    <?= $this->Html->image($lobby->owner->avatar, ["alt" => __('Steam Avatar'), 'url' => $lobby->owner->profileurl, 'class' => 'lobby_owner']); ?>
                                </div>
                                <div class="row">
                                    <?= $this->Html->image('flags/' . $lobby->owner->loccountrycode . '.png', ["alt" => $lobby->owner->loccountrycode, "class" => "flag"]); ?>
                                </div>
                            </div>
                            <?php $is_in_lobby = false; ?>
                            <?php foreach ($lobby->users as $lobby_user): ?>
                                <?php if ($lobby_user->steam_id !== $lobby->owner->steam_id): ?>
                                    <div steam_id="<?php echo $lobby_user->steam_id ?>"
                                         class="lobby-user-column column medium-2">
                                        <div class="row">
                                            <?= $this->Html->image($lobby_user->avatar, ["alt" => __('Steam Avatar'), 'url' => $lobby_user->profileurl]); ?>
                                        </div>
                                        <div class="row">
                                            <?= $this->Html->image('flags/' . $lobby_user->loccountrycode . '.png', ["alt" => $lobby_user->loccountrycode, "class" => "flag"]); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if (isset($user)): ?>
                                    <?php $lobby_user->steam_id === $user->steam_id ? $is_in_lobby = true : ''; ?>
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
                        <?php if (isset($user)): ?>
                            <div class='column medium-2'>
                                <?php if ($lobby->owner->steam_id === $user->steam_id): ?>
                                    <?= $this->Form->postLink(__('Delete'), ["action" => 'delete', $lobby->lobby_id], ['class' => 'radius button small']); ?>
                                <?php elseif (!$is_in_lobby): ?>
                                    <?= $this->Html->link(__('Join'), ["action" => 'join', $lobby->lobby_id], ['id' => 'join-trigger', 'class' => 'radius button small', 'lobby-url' => $lobby->url]); ?>
                                <?php else: ?>
                                    <?= $this->Html->link(__('Leave'), ["action" => 'leave', $lobby->lobby_id], ['class' => 'radius button small']); ?>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <div class='column medium-2'>
                            <?= $lobby->created->timeAgoInWords(); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class='column medium-1'><?= $this->Html->image('prime.png', ["alt" => __('Prime'), "heigth" => '20', "width" => '20']); ?>
                            <?= h($lobby->prime_req) ? __('Yes') : __('No'); ?>
                        </div>
                        <div class='column medium-1'> <?= $this->Html->image('microphone.png', ["alt" => __('Microphone'), "heigth" => '20', "width" => '20']); ?>
                            <?= h($lobby->microphone_req) ? __('Yes') : __('No'); ?>
                        </div>
                        <div class='column medium-1'> <?= $this->Html->image('teamspeak.png', ["alt" => __('TS3'), "heigth" => '20', "width" => '20']); ?>
                            <?= h($lobby->teamspeak_req) ? __('Yes') : __('No'); ?>
                        </div>
                        <div class='column medium-2'><?= __('Min. Playtime: ') . h($lobby->min_playtime); ?></div>
                        <div class='column medium-2 left'><?= __('Min. Age: ') . h($lobby->min_age); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php if (isset($user)): ?>
        <?= $this->element('filter_options'); ?>
    <?php endif; ?>

    <script>
        // if a user sets his cursor to a provided input field textcolor will be black
        function inputFocus(i) {
            if (i.value == i.defaultValue) {
                i.value = "";
                i.style.color = "#000";
            }
        }
        // sets the textcolor of a provided input field to grey  if it isnt focused on.
        function inputBlur(i) {
            if (i.value == "") {
                i.value = i.defaultValue;
                i.style.color = "#888";
            }
        }
        // method for creating custom selectmenus with pictures as options.
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
        // updates the background of a select input field, to the backgrouind of the option which was selected
        function updateSelectBackground(select_id, img_path, button_id) {
            var sel_item = $(select_id + ' option:selected').text();
            $(button_id).css('background-image', 'url(\'' + img_path + sel_item + '.png\')');
        }
        // method to initialize the custom iconselectmenus
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
            // handle the more options of the new lobby section
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
            // initialize icon selectors
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
            initImageSelector('#language', '/cs-community/webroot/img/flags/', '#language-button');
            initImageSelector('#rank-from', '/cs-community/webroot/img/ranks/', '#rank-from-button');
            initImageSelector('#rank-to', '/cs-community/webroot/img/ranks/', '#rank-to-button');
           // update the backgrounds and values of the select inputs
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
            // trigger for starting the game if not started already and join the lobby ingame
            $('#join-trigger').on('click', function (e) {
                e.preventDefault();
                window.location = $(this).attr('lobby-url');
                window.location = this.href;
            });
            // add a scrollbar for the iconselect-menus
            $('.ui-menu').addClass('scrollbar-inner');
            $('.scrollbar-inner').scrollbar();
        });
    </script>
