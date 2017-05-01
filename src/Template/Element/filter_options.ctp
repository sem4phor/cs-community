<!-- section for filtering lobbies -->
<div class="filter-options-border medium-2 columns">
    <div class="filter-options">
        <div class="row">
            <div class="columns medium-12"><h3><?= __('Filter') ?></h3></div>
        </div>
        <?= $this->Form->create('Filter'); ?>
        <div class="row filter-row-1">
            <div class="columns medium-6">
                <?= $this->Form->input('filter_user_rank', ['label' => __('Your Rank'), 'type' => 'select', 'options' => $ranks, 'onchange' => 'updateRankFromSelectBackground()']); ?>
            </div>
            <div class="columns medium-6">
                <?= $this->Form->input('filter_language', ['default' => 'en', 'label' => __('Language'), 'type' => 'select', 'options' => $languages]); ?>
            </div>
        </div>
        <div class="row">
            <div class="columns medium-9"> <?= $this->Form->input('filter_prime_req', ['type' => 'checkbox', 'label' => __('Prime Required')]); ?>
            </div>
            <div class="columns medium-3"><?= $this->Html->image('prime.png', ["alt" => __('Prime'), "heigth" => '20', "width" => '20']); ?>
            </div>
        </div>

        <div class="row">
            <div class="columns medium-9"> <?= $this->Form->input('filter_microphone_req', ['type' => 'checkbox', 'label' => __('Mic. Required')]); ?>
            </div>
            <div class="columns medium-3"> <?= $this->Html->image('microphone.png', ["alt" => __('Microphone'), "heigth" => '20', "width" => '20']); ?>
            </div>
        </div>

        <div class="row">
            <div class="columns medium-9">
                <?= $this->Form->input('filter_teamspeak_req', ['type' => 'checkbox', 'label' => __('Teamspeak Required')]); ?>
            </div>
            <div class="columns medium-3">
                <?= $this->Html->image('teamspeak.png', ["alt" => __('TS3'), "heigth" => '20', "width" => '20']); ?>
            </div>
        </div>
        <div class="row">
            <div class="columns medium-6">
                <?= $this->Form->input('filter_min_age', ['type' => 'select', 'options' => $ages, 'label' => __('Min. Age')]); ?>
            </div>
        </div>
        <div class="row">
            <div class="columns medium-12">
                <?= $this->Form->button(__('Apply'), ['type' => 'Submit', 'class' => 'tiny radius right', 'id' => 'filter-button-apply']); ?>
            </div>
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>

