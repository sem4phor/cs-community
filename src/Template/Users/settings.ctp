<div class="users form medium-8 columns content centered">
    <?= $this->Form->create($set_user) ?>
    <fieldset>
        <legend><?= __('Settings') ?></legend>
        <?= $this->Html->image($user->avatarfull, ["alt" => 'steam avatar full', 'url' => $user->profileurl]); ?>
        <?= h($set_user->personaname); ?>
        <?= h($set_user->country_code); ?>
        <?= h($set_user->role_id); ?>
        <?= h($set_user->upvotes); ?>
        <?= h($set_user->downvotes); ?>
        <?= $this->Html->link('Edit country (relog after changing)', 'http://steamcommunity.com/profiles/' . $set_user->steam_id . '/edit', ['class' => 'button']); ?>
        <?= $this->Form->input('age_range', ['type' => 'select', 'options' => $ages, 'value' => '12-16']); ?>
        <?= $this->Form->input('rank_id', ['type' => 'select', 'options' => $ranks, 'onchange' => 'updateSelectBackground("rank-id", "/cs-community/webroot/img/ranks/")', 'value' => $set_user->rank_id]); ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

<script>
    $(document).ready(function () {
        updateSelectBackground("rank-id", "/cs-community/webroot/img/ranks/");
    });
    function updateSelectBackground(elem_id, url) {
        var e = document.getElementById(elem_id);
        var selected_val = e.options[ e.selectedIndex ].value;
        e.style.backgroundImage = 'url("'+url+selected_val+'.png")';
        e.style.backgroundPosition = '50% center';
        e.style.backgroundSize = '112px 37px';
    }
</script>