<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Country Code') ?></th>
            <td><?= h($user->country_code) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Age Range') ?></th>
            <td><?= h($user->age_range) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rank') ?></th>
            <td><?= h($user->rank) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Username') ?></th>
            <td><?= h($user->personaname) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Upvotes') ?></th>
            <td><?= $this->Number->format($user->upvotes) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Downvotes') ?></th>
            <td><?= $this->Number->format($user->downvotes) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($user->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Last Updated') ?></th>
            <td><?= h($user->modified) ?></td>
        </tr>
    </table>
</div>
