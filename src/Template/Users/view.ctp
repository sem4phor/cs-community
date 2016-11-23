<div class="users view large-9 medium-8 columns content">
    <h3><?= h($view_user->name) ?></h3>
    <?= $this->Html->image($view_user->avatarfull, ["alt" => 'steam avatar full', 'url' => $view_user->profileurl]); ?>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Country Code') ?></th>
            <td><?= h($view_user->loccountrycode) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Username') ?></th>
            <td><?= h($view_user->personaname) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Upvotes') ?></th>
            <td><?= $this->Number->format($view_user->upvotes) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Downvotes') ?></th>
            <td><?= $this->Number->format($view_user->downvotes) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($view_user->created->timeAgoInWords()) ?></td>
        </tr>
    </table>
</div>
