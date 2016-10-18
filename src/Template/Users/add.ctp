<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Add User') ?></legend>
        <?php
            echo $this->Form->input('user_id');
            echo $this->Form->input('steam_id');
            echo $this->Form->input('username');
            echo $this->Form->input('password');
            echo $this->Form->input('age');
            echo $this->Form->input('role');
            echo $this->Form->input('rank');
            echo $this->Form->input('upvotes');
            echo $this->Form->input('downvotes');
            echo $this->Form->input('language_one');
            echo $this->Form->input('language_two');
            echo $this->Form->input('language_three');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
