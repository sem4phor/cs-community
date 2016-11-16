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
                <?= $this->Html->tag('div', null, ['class' => 'input select']); ?>
                <!-- background-position: 100% center;
                // background-repeat: no-repeat; -->
                <?= $this->Html->tag('select', null, ['id' => 'language', 'name' => 'language', 'onchange' => 'updateSelectBackground(language)']); ?>
                <?php foreach ($languages as $language): ?>
                    <?php if ($language == 'en_IE'): ?>
                        <?= $this->Html->tag('option', null, ['style' => 'background-image:url(webroot/img/flags/' . explode('_', $language)[0] . '.png)', 'value' => $language, 'selected' => 'selected']); ?>
                    <?php endif; ?>
                    <?= $this->Html->tag('option', null, ['style' => 'background-image:url(webroot/img/flags/' . explode('_', $language)[0] . '.png)', 'value' => $language]); ?>
                <?php endforeach; ?>
                <?= $this->Html->tag('/select'); ?>
                <?= $this->Html->tag('/div'); ?>
            </div>
        </div>
        <div class='row' ?>
            <div class="medium-2 columns">
                <?= $this->Html->tag('div', null, ['class' => 'input select']); ?>
                <?= $this->Html->tag('select', null, ['id' => 'rank_from', 'name' => 'rank_from', 'onchange' => 'updateRankToSelectBackground()']); ?>
                <?php foreach ($ranks as $rank): ?>
                    <?php if ($user['rank_id'] < 3 && $rank == 1): ?>
                        <?= $this->Html->tag('option', null, ['style' => 'background-image:url(webroot/img/ranks/' . $rank . '.png)', 'value' => $rank, 'selected' => 'selected']); ?>
                    <?php elseif ($rank == $user['rank_id'] - 2): ?>
                        <?= $this->Html->tag('option', null, ['style' => 'background-image:url(webroot/img/ranks/' . $rank . '.png)', 'value' => $rank, 'selected' => 'selected']); ?>
                    <?php else: ?>
                        <?= $this->Html->tag('option', null, ['style' => 'background-image:url(webroot/img/ranks/' . $rank . '.png)', 'value' => $rank]); ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?= $this->Html->tag('/select'); ?>
                <?= $this->Html->tag('/div'); ?>
            </div>
            <div class="medium-1 columns"><?= '-' ?></div>
            <div class="medium-2 columns">

                <?= $this->Html->tag('div', null, ['class' => 'input select']); ?>
                <?= $this->Html->tag('select', null, ['id' => 'rank_to', 'name' => 'rank_to', 'onchange' => 'updateRankFromSelectBackground()']); ?>
                <?php foreach ($ranks as $rank): ?>
                    <?php if ($user['rank_id'] > 16 && $rank == 18): ?>
                        <?= $this->Html->tag('option', null, ['style' => 'background-image:url(webroot/img/ranks/' . $rank . '.png)', 'value' => $rank, 'selected' => 'true']); ?>
                    <?php elseif ($rank == $user['rank_id'] + 2): ?>
                        <?= $this->Html->tag('option', null, ['style' => 'background-image:url(webroot/img/ranks/' . $rank . '.png)', 'value' => $rank, 'selected' => 'true']); ?>
                    <?php else: ?>
                        <?= $this->Html->tag('option', null, ['style' => 'background-image:url(webroot/img/ranks/' . $rank . '.png)', 'value' => $rank]); ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?= $this->Html->tag('/select'); ?>
                <?= $this->Html->tag('/div'); ?>
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
        updateSelectBackground(document.getElementById('language'));
        updateSelectBackground(document.getElementById('rank_from'));
        updateSelectBackground(document.getElementById('rank_to'));
    });
    function updateSelectBackground(element) {
        var e = document.getElementById(element.id);
        e.style.backgroundImage = e.options[e.selectedIndex].style.backgroundImage;
        e.style.backgroundPosition = '50% center';
        e.style.backgroundSize = '112px 37px';
    }
    function updateRankFromSelectBackground() {
        var e1 = document.getElementById('rank_to');
        var e2 = document.getElementById('rank_from');
        if (parseInt(e1.value) < parseInt(e2.value)) {
            e2.value = e1.value;
            updateSelectBackground(e2);
        }
        updateSelectBackground(e1);
    }
    function updateRankToSelectBackground() {
        var e1 = document.getElementById('rank_from');
        var e2 = document.getElementById('rank_to');
        if (parseInt(e1.value) > parseInt(e2.value)) {
            e2.value = e1.value;
            updateSelectBackground(e2);
        }
        updateSelectBackground(e1);
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