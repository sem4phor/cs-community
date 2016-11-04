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

    <h3><?= __('Lobbies') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort(__('users')) ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('microphone_req') ?></th>
                <th scope="col"><?= $this->Paginator->sort('min_age') ?></th>
                <th scope="col"><?= $this->Paginator->sort('rank_from') ?></th>
                <th></th>
                 <th scope="col"><?= $this->Paginator->sort('rank_to') ?></th>
                <th scope="col"><?= $this->Paginator->sort('min_playtime') ?></th>
                <th scope="col"><?= $this->Paginator->sort('language') ?></th>
                <th scope="col"><?= __('Action') ?></th>
            </tr>
        </thead>
        <tbody id='lobbies-list'>
            <?php foreach ($lobbies as $lobby): ?>
            <tr class='lobby-item'>
                <td>
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
                </td>
                <td><?= h($lobby->created) ?></td>
                <td><?= h($lobby->modified) ?></td>
                <td>
                    <?= $this->Html->image('microphone.png', ["alt" => 'microphone', "heigth" => '20', "width" => '20']); ?>
                    <?= h($lobby->microphone_req) ? __('Yes') : __('No'); ?>
                </td>
                <td><?= $this->Number->format($lobby->min_age) ?></td>
                <td><?= $this->Html->image('ranks/'.$lobby->rank_from.'.png', ["alt" => $lobby->rank_to]); ?></td>
                <td><div class='until'>-</div></td>
                <td><?= $this->Html->image('ranks/'.$lobby->rank_to.'.png', ["alt" => $lobby->rank_to]); ?></td>
                <td><?= $this->Number->format($lobby->min_playtime) ?></td>
                 <td><?= $this->Html->image('flags/'.$lobby->language.'.png', ["alt" => $lobby->language.' flag']); ?></td>
                <?php if(in_array($user['user_id'], $user_ids_of_lobby)): ?>
                    <td><?= $this->Html->link('Leave', ["action" => 'leave', $lobby->lobby_id]); ?></td>
                 <?php else: ?>
                        <td><?= $this->Html->link('Join', ["action" => 'join', $lobby->lobby_id]); ?></td>
                 <?php endif; ?>
            </tr>
            <tr class='spacer'><td colspan='11'></td></tr>
            <?php endforeach; ?>
        </tbody>
    </table>
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
              img: 'webroot/img/spinner.gif'
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
