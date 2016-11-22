<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($reg_user) ?>
    <fieldset>
        <legend><?= __('Register User') ?></legend>
        <?= $this->Html->link('Make sure you set up your country properly', 'http://steamcommunity.com/profiles/' . $user['steam_id'] . '/edit', ['class' => 'button']); ?>
        <?= $this->Form->input('age_range', ['type' => 'select', 'options' => $ages, 'value' => '12-16']); ?>
        <?= $this->Form->input('rank_id', ['type' => 'select', 'options' => $ranks, 'onchange' => 'updateSelectBackground("rank-id", "/cs-community/webroot/img/ranks/")', 'value' => $user['rank_id']]); ?>
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
        var selected_val = e.options[e.selectedIndex].value;
        e.style.backgroundImage = 'url("' + url + selected_val + '.png")';
        e.style.backgroundPosition = '50% center';
        e.style.backgroundSize = '112px 37px';
    }
</script>