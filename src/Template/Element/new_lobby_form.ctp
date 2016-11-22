<div class="row lobbies new medium-centered">
    <?= $this->Form->create($new_lobby) ?>
    <fieldset>
        <div class='row' ?>
            <div class="medium-11 columns">
                <h2><?= __('Add your own Lobby') ?></h2>
            </div>
            <div class="medium-1 columns left">
                <?= $this->Html->image('help.png', ["alt" => 'help button', "heigth" => '15', "width" => '15', 'url' => '']); ?>
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
                <?= $this->Form->input('rank_from', ['default' => $rank_from, 'type' => 'select', 'options' => $ranks, 'onchange' => 'updateRankFromSelectBackground()']); ?>
            </div>
            <div class="medium-1 columns"><?= '-' ?></div>
            <div class="medium-2 columns">
                <?= $this->Form->input('rank_to', ['default' => $rank_to, 'type' => 'select', 'options' => $ranks, 'onchange' => 'updateRankToSelectBackground()']); ?>
            </div>
            <div class="medium-4 columns">
                <?= $this->Form->input('prime_req'); ?>
                <?= $this->Form->input('microphone_req'); ?>
            </div>
            <div class='medium-2 columns' ?>
                <?= $this->Form->button(__('Submit'), ['class' => 'small right']) ?>
            </div>
        </div>
        <div class='row'>
            <div class="medium-3 columns right" onclick="expandNewLobbyOptions()" id="expand_new_lobby">
                <?= __('advanced options') ?>
                <?= $this->Html->image('expand.png', ["heigth" => '30', "width" => '30']) ?>
            </div>
        </div>


        <div id='expand'>
            <div class='row' style="margin-top:20px;">
                <div class="medium-3 columns">
                    <?= $this->Form->input('teamspeak_req', ['style' => 'margin-bottom:0;', 'id' => 'teamspeak_req', 'checked' => false, 'onchange' => 'toggleReadOnly()']); ?>
                    <script>
                        function toggleReadOnly() {
                            document.getElementById('teamspeak_ip').readOnly = !document.getElementById('teamspeak_ip').readOnly;
                        }
                    </script>
                    <?= $this->Form->input('teamspeak_ip', ['label' => false, 'id' => 'teamspeak_ip', 'readOnly' => true]); ?>
                </div>
                <div class="medium-2 columns">
                    <?= $this->Form->input('min_playtime', ['value' => '0']); ?>
                </div>
                <div class="medium-2 columns">
                    <?= $this->Form->input('min_age', ['type' => 'select', 'options' => $ages, 'value' => '12']); ?>
                </div>
                <div class="medium-2 columns">
                    <?= $this->Form->input('min_upvotes', ['value' => '0']); ?>
                </div>
                <div class="medium-2 columns left">
                    <?= $this->Form->input('max_downvotes', ['value' => '5']); ?>
                </div>
            </div>
        </div>
    </fieldset>

    <?= $this->Form->end() ?>
</div>

<script>
    $(document).ready(function () {
        updateLangSelectBackground('language', '/cs-community/webroot/img/flags/');
        updateSelectBackground('rank-from', '/cs-community/webroot/img/ranks/');
        updateSelectBackground('rank-to', '/cs-community/webroot/img/ranks/');
    });
    function updateSelectBackground(elem_id, url) {
        var e = document.getElementById(elem_id);
        var selected_val = e.options[ e.selectedIndex ].value;
        console.log('url("'+url+selected_val+'.png")');
        e.style.backgroundImage = 'url("'+url+selected_val+'.png")';
        e.style.backgroundPosition = '50% center';
        e.style.backgroundSize = '112px 37px';
    }
    function updateLangSelectBackground(elem_id, url) {
        var e = document.getElementById(elem_id);
        var selected_val = e.options[ e.selectedIndex ].innerHTML;
        console.log('url("'+url+selected_val+'.png")');
        e.style.backgroundImage = 'url("'+url+selected_val+'.png")';
        e.style.backgroundPosition = '50% center';
        e.style.backgroundSize = '112px 37px';
    }
    function updateRankFromSelectBackground() {
        var e1 = document.getElementById('rank-to');
        var e2 = document.getElementById('rank-from');
        if (parseInt(e1.value) < parseInt(e2.value)) {
            e1.value = e2.value;
            updateSelectBackground('rank-to', '/cs-community/webroot/img/ranks/');
        }
        updateSelectBackground('rank-from', '/cs-community/webroot/img/ranks/');
    }
    function updateRankToSelectBackground() {
        var e1 = document.getElementById('rank-from');
        var e2 = document.getElementById('rank-to');
        if (parseInt(e1.value) > parseInt(e2.value)) {
            e1.value = e2.value;
            updateSelectBackground('rank-from', '/cs-community/webroot/img/ranks/');
        }
        updateSelectBackground('rank-to', '/cs-community/webroot/img/ranks/');
    }
    function expandNewLobbyOptions() {
        if (document.getElementById("expand").style.display == "inline") {
            document.getElementById("expand").style.display = "none";
        } else {
            document.getElementById("expand").style.display = "inline"
        }
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