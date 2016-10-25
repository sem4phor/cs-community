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


<div class="lobbies index large-9 medium-8 columns small-centered content">
    <h3><?= __('Lobbies') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('owned_by') ?></th><!-- delete this but highlight in usder list the leader -->
                <th scope="col"><?= $this->Paginator->sort(__('users')) ?></th><!-- replace with avatars -->
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('microphone_req') ?></th>
                <th scope="col"><?= $this->Paginator->sort('min_age') ?></th>
                <th scope="col"><?= $this->Paginator->sort('rank_from') ?></th>
                <th></th>
                 <th scope="col"><?= $this->Paginator->sort('rank_to') ?></th>
                <th scope="col"><?= $this->Paginator->sort('min_playtime') ?></th>
                <th scope="col"><?= $this->Paginator->sort('language') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lobbies as $lobby): ?>
            <tr>
                <td><?= $this->Number->format($lobby->owned_by) ?></td>
                <td>
                    <?php foreach($lobby->users as $user): ?>
                        <?= $this->Html->image($user->avatar, ["alt" => 'steam avatar', "heigth" => '20', "width" => '20']); ?>
                        <?= $this->Html->image('flags/'.$user->country_code.'.png', ["alt" => 'steam avatar', "heigth" => '20', "width" => '20']); ?>
                    <?php endforeach; ?>
                </td>
                <td><?= h($lobby->created) ?></td>
                <td><?= h($lobby->modified) ?></td>
                <td>
                    <?= $this->Html->image('microphone.png', ["alt" => 'microphone', "heigth" => '20', "width" => '20']); ?>
                    <?= h($lobby->microphone_req) ?>
                </td>
                <td><?= $this->Number->format($lobby->min_age) ?></td>
                <td><?= $this->Html->image($lobby->rank_from.'.png', ["alt" => $lobby->rank_to]); ?></td>
                <td><div class='until'>-</div></td>
                <td><?= $this->Html->image($lobby->rank_to.'.png', ["alt" => $lobby->rank_to]); ?></td>
                <td><?= $this->Number->format($lobby->min_playtime) ?></td>
                 <td><?= $this->Html->image('flags/'.$lobby->language.'.png', ["alt" => $lobby->language.' flag']); ?></td>
            </tr>
            <tr class='spacer'><td colspan='11'></td></tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
