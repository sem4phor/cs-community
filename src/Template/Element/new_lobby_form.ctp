<!-- section for creating new lobbies -->
<div class="lobbies new row">
    <div class='row'>
        <div class="medium-11 columns">
            <?= $this->Form->create(null, ['url' => ['action' => 'create']]) ?>
            <h2 id="new-lobby-title"><?= __('Add your own Lobby') ?></h2>
        </div>
        <div class="medium-1 columns">
            <div data-tooltip aria-haspopup="true" class="icon-help"
                 title="To get the Lobby Link create a Lobby go to your steamprofile, rightclick on the Join Game Button, copy and paste it here"></div>
        </div>
    </div>
    <div class='row'>
        <div class="medium-10 columns">
            <?= $this->Form->input('url', ['label' => false, 'style' => 'color:#888', 'type' => 'text', 'value' => __('Paste your lobby link here...'), 'onfocus' => 'inputFocus(this)', 'onblur' => 'inputBlur(this)', 'pattern' => '(steam:\/\/joinlobby\/[0-9]*\/[0-9]*\/[0-9]*)', 'title' => 'Enter a valid lobby url']); ?>
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
                <div class="medium-8 columns"><?= $this->Form->input('prime_req', ['label' => 'Prime Required', 'type' => 'checkbox']); ?>
                </div>
                <div class="medium-4 columns">
                    <?= $this->Html->image('prime.png', ["alt" => __('Prime'), "heigth" => '20', "width" => '20']); ?>
                </div>
            </div>
            <div class="row">
                <div class="medium-8 columns">
                    <?= $this->Form->input('microphone_req', ['label' => __('Mic. Required'), 'type' => 'checkbox']); ?> </div>
                <div class="medium-4 columns">
                    <?= $this->Html->image('microphone.png', ["alt" => __('microphone'), "heigth" => '20', "width" => '20']); ?>
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
    <!-- more options -->
    <div id='expand-content' class='row'>
        <div class="medium-10 columns medium-centered">
            <div class="medium-4 columns">
                <div class='row'>
                    <div class="medium-8 columns"> <?= $this->Form->input('teamspeak_req', ['label' => __('Teamspeak'), 'style' => 'margin-bottom:0;', 'checked' => false, 'onchange' => 'toggleReadOnly()']); ?>
                    </div>
                    <div class="medium-4 columns"> <?= $this->Html->image('teamspeak.png', ["alt" => __('TS3'), "heigth" => '20', "width" => '20']); ?>
                    </div>
                </div>
                <?= $this->Form->input('teamspeak_ip', ['label' => false, 'readOnly' => true, 'value' => 'TS3 IP', 'style' => 'color:#888', 'onfocus' => 'inputFocus(this)', 'onblur' => 'inputBlur(this)', 'pattern' => '([0-9]+(?:\.[0-9]+){3}(:[0-9]+)*|([a-zA-Z0-9]+\.)+[a-zA-Z0-9]+(:[0-9]+)*)', 'title' => 'Enter a valid Teamspeak3 ip or hostname']); ?>
            </div>
            <div class="medium-4 columns">
                <?= $this->Form->input('min_playtime', ['label' => __('Min. Playtime'), 'default' => '0']); ?>
            </div>
            <div class="medium-4 columns left">
                <?= $this->Form->input('min_age', ['label' => __('Min. Age'), 'type' => 'select', 'options' => $ages, 'default' => '12']); ?>
            </div>

        </div>
    </div>
    <?= $this->Form->end() ?>
</div>

<script>
    // input for a teamspeak ip should only be available when TS is checked
    function toggleReadOnly() {
        $('#teamspeak-ip').prop('readonly', !$('#teamspeak-ip').is('[readonly]'));
    }
</script>