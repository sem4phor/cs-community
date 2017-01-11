<div class="lobbies new row">
    <div class='row'>
        <div class="medium-11 columns">
            <?= $this->Form->create($new_lobby, ['url' => ['action' => 'new']]) ?>
            <h2 id="new-lobby-title"><?= __('Add your own Lobby') ?></h2>
        </div>
        <div class="medium-1 columns">
            <div data-tooltip aria-haspopup="true" class="icon-help"
                 title="To get the Lobby Link create a Lobby go to your steamprofile, rightclick on the Join Game Button, copy and paste it here"></div>
        </div>
    </div>
    <div class='row'>
        <div class="medium-10 columns">
            <?= $this->Form->input('url', ['label' => false, 'style' => 'color:#888', 'type' => 'text', 'value' => 'Paste your lobby link here...', 'onfocus' => 'inputFocus(this)', 'onblur' => 'inputBlur(this)', 'pattern' => '(steam:\/\/joinlobby\/[0-9]*\/[0-9]*\/[0-9]*)', 'title' => 'Enter a valid lobby url']); ?>
        </div>
        <div class="medium-2 columns">
            <?= $this->Form->input('language', ['default' => 'en', 'label' => false, 'type' => 'select', 'options' => $languages, 'onchange' => 'updateLangSelectBackground(\'language\', \'/cs-community/webroot/img/flags/\')']); ?>
        </div>
    </div>
    <div class='row'>
        <div class="medium-2 columns">
            <?= $this->Form->input('rank_from', ['label' => false, 'type' => 'select', 'options' => $ranks]); ?>
        </div>
        <div class="medium-1 columns"><span class="stretch">-</span></div>
        <div class="medium-2 columns">
            <?= $this->Form->input('rank_to', ['label' => false, 'type' => 'select', 'options' => $ranks]); ?>
        </div>
        <div class="medium-5 columns left">
            <div class="row">
                <div class="medium-8 columns"><?= $this->Form->input('prime_req', ['label' => 'Prime Required']); ?>
                </div>
                <div class="medium-4 columns">
                    <?= $this->Html->image('prime.png', ["alt" => 'prime', "heigth" => '20', "width" => '20']); ?>
                </div>
            </div>
            <div class="row">
                <div class="medium-8 columns">
                    <?= $this->Form->input('microphone_req', ['label' => 'Mic. Required']); ?> </div>
                <div class="medium-4 columns">
                    <?= $this->Html->image('microphone.png', ["alt" => 'microphone', "heigth" => '20', "width" => '20']); ?>
                </div>
            </div>
        </div>
        <div class="medium-2 columns">
            <?= $this->Form->button(__('Create'), ['class' => 'smaller radius', 'style' => 'margin-top:3vh;']) ?>
        </div>
    </div>

    <div class='row'>
        <div class="columns medium-2" id="expand-new-lobby">
            <span class="ui-icon ui-icon-gear"></span>more options
        </div>
    </div>

    <div id='expand-content' class='row'>

        <div class="medium-10 columns medium-centered">
        <div class="medium-4 columns">
            <div class='row'>
                <div class="medium-8 columns"> <?= $this->Form->input('teamspeak_req', ['label' => 'Teamspeak', 'style' => 'margin-bottom:0;', 'checked' => false, 'onchange' => 'toggleReadOnly()']); ?>
                </div>
                <div class="medium-4 columns"> <?= $this->Html->image('teamspeak.png', ["alt" => 'TS3', "heigth" => '20', "width" => '20']); ?>
                </div>
            </div>
            <?= $this->Form->input('teamspeak_ip', ['label' => false, 'readOnly' => true, 'value' => 'TS3 IP', 'style' => 'color:#888', 'onfocus' => 'inputFocus(this)', 'onblur' => 'inputBlur(this)', 'pattern' => '([0-9]+(?:\.[0-9]+){3}(:[0-9]+)*|([a-zA-Z0-9]+\.)+[a-zA-Z0-9]+(:[0-9]+)*)', 'title' => 'Enter a valid Teamspeak3 ip or hostname']); ?>
        </div>
        <div class="medium-4 columns">
            <?= $this->Form->input('min_playtime', ['label' => 'Min. Playtime', 'default' => '0']); ?>
        </div>
        <div class="medium-4 columns left">
            <?= $this->Form->input('min_age', ['label' => 'Min. Age', 'type' => 'select', 'options' => $ages, 'default' => '12']); ?>
        </div>

        </div>
        <!--div class="medium-2 columns">
            <!--?= $this->Form->input('min_upvotes', ['label' => 'Min. Upvotes', 'default' => '0']); ?>
        </div>
        <div class="medium-3 columns">
            <!--?= $this->Form->input('max_downvotes', ['label' => 'Max. Downvotes', 'default' => '5']); ?>
        </div-->
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