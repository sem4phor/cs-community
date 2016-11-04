<script src="http://autobahn.s3.amazonaws.com/js/autobahn.min.js"></script>
<script>
    var conn = new ab.Session('ws://localhost:8080',
        function() {
            conn.subscribe('language', function(topic, data) {
                // This is where you would add the new article to the DOM (beyond the scope of this tutorial)
                console.log('New article published to category "' + topic + '" : ' + data.title);
                location.reload(); // append neues db obj. wie? reload einen bestimmten div mit ajax,
                // bei lobbys: neue immer oben
            });
        },
        function() {
            console.warn('WebSocket connection closed');
        },
        {'skipSubprotocolCheck': true}
    );
</script>



<div class="lobbies index large-9 medium-8 columns medium-centered content">
<div class='row'>
<?= $this->element('new_lobby_form'); ?>
<div>
    <h3><?= __('Lobbies') ?></h3>

               <!-- <th scope="col"><?= $this->Paginator->sort(__('users')) ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('microphone_req') ?></th>
                <th scope="col"><?= $this->Paginator->sort('min_age') ?></th>
                <th scope="col"><?= $this->Paginator->sort('rank_from') ?></th>
                <th></th>
                 <th scope="col"><?= $this->Paginator->sort('rank_to') ?></th>
                <th scope="col"><?= $this->Paginator->sort('min_playtime') ?></th>
                <th scope="col"><?= $this->Paginator->sort('language') ?></th>
                <th scope="col"><?= __('Action') ?></th>-->

        <div id='lobbies-list'>
            <?php foreach ($lobbies as $lobby): ?>
            <div class='lobby-item row'>
                <div class='column large-2'>
                    <?php $user_ids_of_lobby = []; ?>
                    <?php foreach($lobby->users as $user): ?>
                        <?php array_push($user_ids_of_lobby, $user->user_id); ?>
                        <?php if ($user->user_id == $lobby->owned_by): ?>
                            <?= $this->Html->image($user->avatar, ["alt" => 'steam avatar', "heigth" => '20', "width" => '20', 'url' => $user->profileurl, 'class' => 'lobby_owner']); ?>
                        <?php else: ?>
                            <?= $this->Html->image($user->avatar, ["alt" => 'steam avatar', "heigth" => '20', "width" => '20', 'url' => $user->profileurl]); ?>
                        <?php endif; ?>
                        <?= $this->Html->image('flags/'.$user->country_code.'.png', ["alt" => $user->country_code, "heigth" => '20', "width" => '20']); ?>
                    <?php endforeach; ?>
                </div>
                <div class='column large-1'><?= h($lobby->created) ?></div>
                <div class='column large-1'><?= h($lobby->modified) ?></div>
                <div class='column large-1'>
                    <?= $this->Html->image('microphone.png', ["alt" => 'microphone', "heigth" => '20', "width" => '20']); ?>
                    <?= h($lobby->microphone_req) ? __('Yes') : __('No'); ?>
                </div>
                <div class='column large-1'><?= $this->Number->format($lobby->min_age) ?></div>
                <div class='column large-1'><?= $this->Html->image('ranks/'.$lobby->rank_from.'.png', ["alt" => $lobby->rank_to]); ?></div>
                <div class='until column large-11'>-</div>
                <div class='column large-1'><?= $this->Html->image('ranks/'.$lobby->rank_to.'.png', ["alt" => $lobby->rank_to]); ?></div>
                <div class='column large-1'><?= $this->Number->format($lobby->min_playtime) ?></div>
                 <div class='column large-1'><?= $this->Html->image('flags/'.$lobby->language.'.png', ["alt" => $lobby->language]); ?></div>
                <?php if(in_array($user['user_id'], $user_ids_of_lobby)): ?>
                    <div class='column large-1'><?= $this->Html->link('Leave', ["action" => 'leave', $lobby->lobby_id]); ?></div>
                 <?php else: ?>
                        <div class='column large-1'><?= $this->Html->link('Join', ["action" => 'join', $lobby->lobby_id]); ?></div>
                 <?php endif; ?>
            </div>
            <?php endforeach; ?>

    <script>
      $(function(){
        var $container = $('#lobbies-list');
        $container.infinitescroll({
          navSelector  : '.next',    // selector for the paged navigation
          nextSelector : '.next a',  // selector for the NEXT link (to page 2)
          itemSelector : '.lobby-item',     // selector for all items you'll retrieve
          debug         : true,
          dataType      : 'html',
          loading: {
              finishedMsg: 'No more lobbies to load!',
            }
          }
        );
      });
    </script>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
    </div>
</div>
