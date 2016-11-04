<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Edit User') ?></legend>
        <?php
            echo $this->Form->input('country_code');// link to steam settings
            echo $this->Form->input('age_range');
            echo $this->Form->input('rank');
            echo $this->Form->input('microphone');
            echo $this->Form->input('teamspeak');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
