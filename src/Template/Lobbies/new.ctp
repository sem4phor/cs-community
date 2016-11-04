<div class="lobbies form large-9 medium-8 columns content">
    <?= $this->Form->create($lobby) ?>
    <fieldset>
        <legend><?= __('Add Lobby') ?></legend>
        <?php
            echo $this->Form->input('owned_by');
            echo $this->Form->input('url');
            echo $this->Form->input('microphone_req');
            echo $this->Form->input('min_age');
            echo $this->Form->input('teamspeak_req');
            echo $this->Form->input('rank_to');
            echo $this->Form->input('rank_from');
            echo $this->Form->input('min_playtime');
            echo $this->Form->input('language');
            echo $this->Form->input('min_upvotes');
            echo $this->Form->input('max_downvotes');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
