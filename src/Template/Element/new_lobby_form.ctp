<div class="row lobbies new medium-centered">
    <div class='row' ?>
        <div class="medium-11 columns">
            <?= $this->Form->create($new_lobby, ['url' => ['action' => 'new']]) ?>
            <h2><?= __('Add your own Lobby') ?></h2>
        </div>
        <div class="medium-1 columns">
            <?= $this->Html->image('help.png', ['data-tooltip', 'aria-haspopup' => 'true', 'class' => 'has-tip', "alt" => 'help button', 'title' => 'To get the Lobby Link create a Lobby go to your steamprofile, rightclick on the Join Game Button, copy and paste it here.', "heigth" => '15', "width" => '15', 'url' => '']); ?>
        </div>
    </div>
    <div class='row' ?>
        <div class="medium-10 columns">
            <?= $this->Form->input('url', ['label' => false, 'style' => 'color:#888', 'type' => 'url', 'value' => 'Paste your lobby link here...', 'onfocus' => 'inputFocus(this)', 'onblur' => 'inputBlur(this)']); ?>
        </div>
        <div class="medium-2 columns">
            <?= $this->Form->input('language', ['default' => 'en', 'label' => false, 'type' => 'select', 'options' => $languages, 'onchange' => 'updateLangSelectBackground(\'language\', \'/cs-community/webroot/img/flags/\')']); ?>
        </div>
    </div>
    <div class='row' ?>
        <div class="medium-2 columns">
            <?= $this->Form->input('rank_from', ['label' => false, 'default' => $filter['filter_user_rank'], 'type' => 'select', 'options' => $ranks]); ?>
        </div>
        <div class="medium-1 columns"><?= '-' ?></div>
        <div class="medium-2 columns">
            <?= $this->Form->input('rank_to', ['label' => false, 'default' => $filter['filter_user_rank'], 'type' => 'select', 'options' => $ranks]); ?>
        </div>
        <div class="medium-4 columns">
            <?= $this->Form->input('prime_req', ['label' => 'Prime Only']); ?>
            <?= $this->Form->input('microphone_req', ['label' => 'Mic. Required']); ?>
        </div>
        <div class='medium-2 columns' ?>
            <?= $this->Form->button(__('Submit'), ['class' => 'small right radius']) ?>
        </div>
    </div>
    <div class='row'>
        <div class="medium-3 columns right" id="expand_new_lobby">
            <?= __('more options') ?>
            <?= $this->Html->image('expand.png', ["heigth" => '30', "width" => '30']) ?>
        </div>
    </div>

    <div id='expand'>
        <div class='row'>
            <div class="medium-3 columns">
                <?= $this->Form->input('teamspeak_req', ['label' => 'Teamspeak', 'style' => 'margin-bottom:0;', 'checked' => false, 'onchange' => 'toggleReadOnly()']); ?>
                <?= $this->Form->input('teamspeak_ip', ['label' => false, 'readOnly' => true]); ?>
            </div>
            <div class="medium-6 columns">
                <?= $this->Form->input('min_playtime', ['label' => 'Min. Playtime', 'default' => '0']); ?>
            </div>
            <div class="medium-6 columns">
                <?= $this->Form->input('min_age', ['label' => 'Min. Age', 'type' => 'select', 'options' => $ages, 'default' => '12']); ?>
            </div>
            <!--div class="medium-2 columns">
                <!--?= $this->Form->input('min_upvotes', ['label' => 'Min. Upvotes', 'default' => '0']); ?>
            </div>
            <div class="medium-3 columns">
                <!--?= $this->Form->input('max_downvotes', ['label' => 'Max. Downvotes', 'default' => '5']); ?>
            </div-->
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>

<script>
    function toggleReadOnly() {
        $('#teamspeak-ip').prop('readonly', !$('#teamspeak-ip').is('[readonly]'));
    }
    function inputFocus(i) {
        if (i.value == i.defaultValue) {
            i.value = "";
            i.style.color = "#000";
        }
    }
    function inputBlur(i) {
        if (i.value == "") {
            i.value = i.defaultValue;
            i.style.color = "#888";
        }
    }
</script>