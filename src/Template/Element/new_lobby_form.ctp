<?= $this->Form->create($lobby) ?>
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
                <script>
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
            </div>
            <div class="medium-2 columns">
                <?= $this->Html->tag('div', null, ['class' => 'input select']); ?>
                <?= $this->Html->tag('select', null, ['id' => 'language', 'name' => 'language']); ?>
                <?php foreach ($languages as $language): ?>
                    <?php if ($language == 'en-GB'): ?>
                        <?= $this->Html->tag('option', $language, ['style' => 'background-image:url(webroot/img/flags/' . explode('_', $language)[0] . '.png)', 'value' => $language, 'selected' => 'true']); ?>
                    <?php endif; ?>
                    <?= $this->Html->tag('option', $language, ['style' => 'background-image:url(webroot/img/flags/' . explode('_', $language)[0] . '.png)', 'value' => $language]); ?>
                <?php endforeach; ?>
                <?= $this->Html->tag('/select'); ?>
                <?= $this->Html->tag('/div'); ?>
            </div>
        </div>
        <div class='row' ?>
            <div class="medium-2 columns">
                <?= $this->Html->tag('div', null, ['class' => 'input select']); ?>
                <?= $this->Html->tag('select', null, ['id' => 'rank_from', 'name' => 'rank_from']); ?>
                <?php foreach ($ranks as $rank): ?>
                    <?php if ($user['rank_id'] < 3 && $rank == 1): ?>
                        <?= $this->Html->tag('option', $rank, ['style' => 'background-image:url(webroot/img/ranks/' . $rank . '.png)', 'value' => $rank, 'selected' => 'true']); ?>
                    <?php elseif ($rank == $user['rank_id'] - 2): ?>
                        <?= $this->Html->tag('option', $rank, ['style' => 'background-image:url(webroot/img/ranks/' . $rank . '.png)', 'value' => $rank, 'selected' => 'true']); ?>
                    <?php else: ?>
                        <?= $this->Html->tag('option', $rank, ['style' => 'background-image:url(webroot/img/ranks/' . $rank . '.png)', 'value' => $rank]); ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?= $this->Html->tag('/select'); ?>
                <?= $this->Html->tag('/div'); ?>
            </div>
            <div class="medium-1 columns"><?= '-' ?></div>
            <div class="medium-2 columns">

                <?= $this->Html->tag('div', null, ['class' => 'input select']); ?>
                <?= $this->Html->tag('select', null, ['id' => 'rank_to', 'name' => 'rank_to']); ?>
                <?php foreach ($ranks as $rank): ?>
                    <?php if ($user['rank_id'] > 16 && $rank == 18): ?>
                        <?= $this->Html->tag('option', $rank, ['style' => 'background-image:url(webroot/img/ranks/' . $rank . '.png)', 'value' => $rank, 'selected' => 'true']); ?>
                    <?php elseif ($rank == $user['rank_id'] + 2): ?>
                        <?= $this->Html->tag('option', $rank, ['style' => 'background-image:url(webroot/img/ranks/' . $rank . '.png)', 'value' => $rank, 'selected' => 'true']); ?>
                    <?php else: ?>
                        <?= $this->Html->tag('option', $rank, ['style' => 'background-image:url(webroot/img/ranks/' . $rank . '.png)', 'value' => $rank]); ?>
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
        <script>
            function expandNewLobbyOptions() {
                if (document.getElementById("expand").style.display == "inline") {
                    document.getElementById("expand").style.display = "none";
                } else {
                    document.getElementById("expand").style.display = "inline"
                }
            }
        </script>

        <div id='expand'>
            <div class='row' style="margin-top:20px;">
                <div class="medium-3 columns">
                    <?= $this->Form->input('teamspeak_req', ['style' => 'margin-bottom:0;']); ?>
                    <?= $this->Form->input('teamspeak_ip', ['label' => false]); ?>
                </div>
                <div class="medium-2 columns">
                    <?= $this->Form->input('min_playtime'); ?>
                </div>
                <div class="medium-2 columns">
                    <?= $this->Form->input('min_age', ['type' => 'select', 'options' => $ages]); ?>
                </div>
                <div class="medium-2 columns">
                    <?= $this->Form->input('min_upvotes'); ?>
                </div>
                <div class="medium-2 columns left">
                    <?= $this->Form->input('max_downvotes'); ?>
                </div>
            </div>
        </div>
    </fieldset>

<?= $this->Form->end() ?>