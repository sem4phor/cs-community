<script src="http://autobahn.s3.amazonaws.com/js/autobahn.min.js"></script>
<script
    src="https://code.jquery.com/jquery-3.1.1.min.js"
    integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
    crossorigin="anonymous"></script>
<script src="http://localhost/cs-community/js/jquery.infinite-scroll.js"></script>

<script>
    var conn;
    conn = new ab.Session('ws://localhost:8080',
        function () {
            conn.subscribe('topicValue', function (topic, data) {
                // This is where you would add the new article to the DOM (beyond the scope of this tutorial)
                console.log("New article published to category " + topic + ' : ' + data.title);
                var user = <?php echo json_encode($user); ?>;

                // check if lobby should be displayed with user comparing lobby data

                var lobby_item = document.createElement("div");
                lobby_item.setAttribute("class", "lobby-item row");

                var lang_col = document.createElement("div");
                lang_col.setAttribute("class", "column medium-1");
                var lang_img = document.createElement("img");
                lang_img.setAttribute("src", "flags/" + data.language + ".png");
                lang_img.setAttribute("alt", data.language);
                lang_col.appendChild(lang_img);
                lobby_item.appendChild(lang_col);

                var user_col = document.createElement("div");
                user_col.setAttribute("class", "column medium-2");
                var user_avatar_row = document.createElement("div");
                user_avatar_row.setAttribute("class", "row");
                var user_avatar = document.createElement("img");
                user_avatar.setAttribute("src", data.owned_by.avatar);
                user_avatar.setAttribute("alt", "steam avatar");
                user_avatar.setAttribute("heigth", "20");
                user_avatar.setAttribute("width", "20");
                user_avatar.setAttribute("url", data.owned_by.profileurl);
                user_avatar.setAttribute("class", "lobby_owner");
                user_avatar_row.appendChild(user_avatar);
                user_col.appendChild(user_avatar_row);
                var user_flag_row = document.createElement("div");
                user_flag_row.setAttribute("class", "row");
                var user_flag = document.createElement("img");
                user_flag.setAttribute("src", "/cs-community/img/flags/" + data.owned_by.country_code + ".png");
                user_flag.setAttribute("alt", data.owned_by.country_code);
                user_flag.setAttribute("heigth", "20");
                user_flag.setAttribute("width", "20");
                user_flag_row.appendChild(user_flag);
                user_col.appendChild(user_flag_row);
                lobby_item.appendChild(user_col);

                var rank_col = document.createElement("div");
                rank_col.setAttribute("class", "column medium-4");
                var rank_from = document.createElement("img");
                rank_from.setAttribute("src", "/cs-community/img/ranks/" + data.rank_from + ".png");
                rank_from.setAttribute("alt", data.rank_from);
                var rank_to = document.createElement("img");
                rank_to.setAttribute("src", "/cs-community/img/ranks/" + data.rank_to + ".png");
                rank_to.setAttribute("alt", data.rank_to);
                rank_col.appendChild(rank_from);
                rank_col.appendChild(rank_to);
                lobby_item.appendChild(rank_col);


                var mic_prime_col = document.createElement("div");
                mic_prime_col.setAttribute("class", "column medium-1");
                var mic_row = document.createElement("div");
                mic_row.setAttribute("class", "row");
                var mic_icon = document.createElement("img");
                mic_icon.setAttribute("src", "/cs-community/img/microphone.png");
                mic_icon.setAttribute("alt", "microphone");
                mic_icon.setAttribute("heigth", "20");
                mic_icon.setAttribute("width", "20");
                if (data.microphone_req == 1) {
                    mic_icon.after(document.createTextNode("Yes"));
                } else {
                    mic_icon.after(document.createTextNode("No"));
                }
                mic_row.appendChild(mic_icon);
                mic_prime_col.appendChild(mic_row);
                var prime_row = document.createElement("div");
                prime_row.setAttribute("class", "row");
                var prime_icon = document.createElement("img");
                prime_icon.setAttribute("src", "/cs-community/img/prime.png");
                prime_icon.setAttribute("alt", "prime");
                prime_icon.setAttribute("heigth", "20");
                prime_icon.setAttribute("width", "20");
                if (data.prime_req == 1) {
                    prime_icon.after("__('Yes')");
                } else {
                    prime_icon.after("<?= __('No') ?>");
                }
                prime_row.appendChild(prime_icon);
                mic_prime_col.appendChild(prime_row);
                lobby_item.appendChild(mic_prime_col);

                var created_col = document.createElement("div");
                created_col.setAttribute("class", "column medium-1");
                created_col.innerHTML = "Just now";
                lobby_item.appendChild(created_col);

                var action_col = document.createElement("div");
                action_col.setAttribute("class", "column medium-2");
                var join_button = document.createElement("a");
                join_button.setAttribute("href", "/lobbies/join/" + data.lobby_id);
                join_button.setAttribute("class", "button");
                join_button.innerHTML = "<?= __('Join') ?>";
                action_col.appendChild(join_button);
                lobby_item.appendChild(action_col);

                document.getElementById('lobbies-list').prepend(lobby_item);


            });
        },
        function () {
            console.warn('WebSocket connection closed');
        },
        {'skipSubprotocolCheck': true}
    );
</script>


<div class="lobbies index medium-8 columns medium-centered content">
    <?php if(isset($your_lobby)): ?>
            <?= $this->element('your_lobby'); ?>
    <?php else: ?>
            <?= $this->element('new_lobby_form'); ?>
    <?php endif; ?>

    <div class='row' style="margin-top:20px;"><h3><?= __('Lobbies') ?></h3></div>
    <!-- div class='row'>
        <div class="column medium-1"><?= $this->Paginator->sort('language') ?></div>
        <div class="column medium-2"><?= $this->Paginator->sort(__('users')) ?></div>
        <div class="column medium-2"><?= $this->Paginator->sort('rank_from') ?></div>
        <div class="column medium-2"><?= $this->Paginator->sort('rank_to') ?></div>
        <div class="column medium-1 right"><?= __('Action') ?></div>
        <div class="column medium-1 right"><?= $this->Paginator->sort('created') ?></div>
    </div -->
    <div id='lobbies-list'>
        <?php foreach ($lobbies as $lobby): ?>
            <div class='lobby-item row'>
                <div
                    class='column medium-1'><?= $this->Html->image('flags/' . $lobby->language . '.png', ["alt" => $lobby->language]); ?></div>
                <div class='column medium-2'>
                    <?php $user_ids_of_lobby = []; ?>
                    <div class='row'>
                        <?php foreach ($lobby->users as $user): ?>
                            <?php array_push($user_ids_of_lobby, $user->user_id); ?>
                            <?php if ($user->user_id == $lobby->owned_by): ?>
                                <?= $this->Html->image($user->avatar, ["alt" => 'steam avatar', "heigth" => '20', "width" => '20', 'url' => $user->profileurl, 'class' => 'lobby_owner']); ?>
                            <?php else: ?>
                                <?= $this->Html->image($user->avatar, ["alt" => 'steam avatar', "heigth" => '20', "width" => '20', 'url' => $user->profileurl]); ?>
                            <?php endif; ?>

                        <?php endforeach; ?>
                    </div>
                    <div class='row'>
                        <?php foreach ($lobby->users as $user): ?>
                            <?= $this->Html->image('flags/' . $user->country_code . '.png', ["alt" => $user->country_code, "heigth" => '20', "width" => '20']); ?>
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
                    <?= $lobby->created->timeAgoInWords(); ?>
                </div>
                <div class='column medium-2'>
                    <?php if (in_array($user['user_id'], $user_ids_of_lobby)): ?>
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
                    finishedMsg: 'No more lobbies to load!',
                }
            }
        );
    });
</script>