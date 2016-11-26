<div class="filter-options medium-2 columns">
    <div class="filter-options-container">
        <?= $this->Form->create('Filter'); ?>
        <div class="row">
            <div class="columns medium-6">
                <?= $this->Form->input('filter_user_rank', ['label' => 'Your Rank', 'type' => 'select', 'options' => $ranks, 'onchange' => 'updateRankFromSelectBackground()']); ?>
            </div>
            <div class="columns medium-6">
                <?= $this->Form->input('filter_min_playtime', ['label' => 'Min. Playtime', 'value' => $filter['filter_min_playtime']]); ?>
            </div>
        </div>
        <div class="row">
            <div class="columns medium-6">
                <?= $this->Form->input('filter_min_age', ['type' => 'select', 'options' => $ages, 'default' => $filter['filter_min_age'], 'label' => 'Min. Age']); ?>
            </div>
            <div class="columns medium-6">
                <?= $this->Form->input('filter_language', ['default' => 'en', 'label' => 'Language', 'type' => 'select', 'options' => $languages]); ?>
            </div>
        </div>
        <div class="row">
            <div class="columns medium-6">
                <?= $this->Form->input('filter_min_upvotes', ['label' => 'Min. Upvotes', 'value' => $filter['filter_min_upvotes']]); ?>
            </div>
            <div class="columns medium-6">
                <?= $this->Form->input('filter_max_downvotes', ['label' => 'Max. Downvotes', 'value' => $filter['filter_max_downvotes']]); ?>
            </div>
        </div>
        <div class="row">
            <div class="columns medium-12">
                <?= $this->Form->input('filter_prime_req', ['type' => 'checkbox', 'label' => 'Only Prime Lobbies']); ?>
            </div>
        </div>
        <div class="row">
            <div class="columns medium-12">
                <?= $this->Form->input('filter_teamspeak_req', ['type' => 'checkbox', 'label' => 'Teamspeak']); ?>
            </div>
        </div>
        <div class="row">
            <div class="columns medium-12">
                <?= $this->Form->input('filter_microphone_req', ['type' => 'checkbox', 'label' => 'Mic Required']); ?>
            </div>
        </div>
        <div class="row">
            <div class="columns medium-12">
                <?= $this->Form->button('Apply', ['type' => 'Submit', 'class' => 'tiny radius']); ?>
            </div>
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>

