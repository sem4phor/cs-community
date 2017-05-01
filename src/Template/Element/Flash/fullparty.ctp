<!-- element for displaying a dialog if a lobby gets full -->
<div class="dialog" title="<?= h($message) ?>">
    <?= $this->Html->link(
        __('Join Lobby'),
        $params['lobby_link'],
        ['class' => 'button radius small']
    ); ?>
    <?php if($params['ts3_ip'] !== '') : ?>
        <?= $this->Html->link(
            __('Join TS3'),
            'ts3server://'.$params['ts3_ip'],
            ['class' => 'button radius small']
        ); ?>
    <?php endif; ?>
</div>

<script>
    $(function () {
        $(".dialog").dialog();
    });
</script>