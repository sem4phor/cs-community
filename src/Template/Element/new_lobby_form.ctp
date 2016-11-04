<div class="lobbies new large-9 medium-8 columns medium-centered content container">
    <?= $this->Form->create($lobby) ?>
        <fieldset>
            <div class='row' ?>
                <div class="large-4 columns">

                    <h2><?= __('Add your own Lobby') ?></h2>

                </div>
            </div>
            <div class='row' ?>
                <div class="large-8 columns">

                    <?= $this->Form->input('url', ['class' => 'url']); ?>

                </div>
                <div class="large-1 columns">

                    <?= $this->Form->input( __( 'help'), ['type'=>'text', 'value' => 'placeholder']);; ?>

                </div>
            </div>
            <div class='row' ?>
                <div class="large-2 columns">

                    <?= $this->Html->tag('div', null, ['class' => 'input select']); ?>
                        <?= $this->Html->tag('select', null, ['id' => 'rank_from', 'name' => 'rank_from']); ?>
                            <?php foreach ($ranks as $rank): ?>
                            <?php if ($user[ 'rank_id'] < 3 && $rank==1 ): ?>
                            <?= $this->Html->tag('option', $rank, ['style' => 'background-image:url(webroot/img/ranks/'.$rank.'.png)', 'value' => $rank, 'selected' => 'true']); ?>
                                <?php elseif($rank==$user[ 'rank_id']-2): ?>
                                <?= $this->Html->tag('option', $rank, ['style' => 'background-image:url(webroot/img/ranks/'.$rank.'.png)', 'value' => $rank, 'selected' => 'true']); ?>
                                    <?php else: ?>
                                    <?= $this->Html->tag('option', $rank, ['style' => 'background-image:url(webroot/img/ranks/'.$rank.'.png)', 'value' => $rank]); ?>
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                        <?= $this->Html->tag('/select'); ?>
                                            <?= $this->Html->tag('/div'); ?>

                </div>
                <div class="large-2 columns">

                    <?= $this->Html->tag('div', null, ['class' => 'input select']); ?>
                        <?= $this->Html->tag('select', null, ['id' => 'rank_to', 'name' => 'rank_to']); ?>
                            <?php foreach($ranks as $rank): ?>
                            <?php if ($user[ 'rank_id']> 16 && $rank == 18): ?>
                            <?= $this->Html->tag('option', $rank, ['style' => 'background-image:url(webroot/img/ranks/'.$rank.'.png)', 'value' => $rank, 'selected' => 'true']); ?>
                                <?php elseif($rank==$user[ 'rank_id']+2): ?>
                                <?= $this->Html->tag('option', $rank, ['style' => 'background-image:url(webroot/img/ranks/'.$rank.'.png)', 'value' => $rank, 'selected' => 'true']); ?>
                                    <?php else: ?>
                                    <?= $this->Html->tag('option', $rank, ['style' => 'background-image:url(webroot/img/ranks/'.$rank.'.png)', 'value' => $rank]); ?>
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                        <?= $this->Html->tag('/select'); ?>
                                            <?= $this->Html->tag('/div'); ?>

                </div>
                <div class="large-2 columns">
                    <?= $this->Form->input('prime_req'); ?>
                </div>
                <div class="large-2 columns">
                    <?= $this->Html->tag('div', null, ['class' => 'input select']); ?>
                        <?= $this->Html->tag('select', null, ['id' => 'language', 'name' => 'language']); ?>
                            <?php foreach($languages as $language): ?>
                            <?php if ($language=='en-GB' ): ?>
                            <?= $this->Html->tag('option', $language, ['style' => 'background-image:url(webroot/img/flags/'.explode('_',$language)[0].'.png)', 'value' => $language, 'selected' => 'true']); ?>
                                <?php endif; ?>
                                <?= $this->Html->tag('option', $language, ['style' => 'background-image:url(webroot/img/flags/'.explode('_',$language)[0].'.png)', 'value' => $language]); ?>
                                    <?php endforeach; ?>
                                    <?= $this->Html->tag('/select'); ?>
                                        <?= $this->Html->tag('/div'); ?>
                </div>
                <?= $this->Form->button(__('Advanced options'), ['id' => 'expand_new_lobby', 'class' => 'tiny right', 'onclick' => 'expandNewLobbyOptions()', 'type' => 'button']) ?>
                            <script>
                                function expandNewLobbyOptions() {
                                    if(document.getElementById("expand").style.display == "inline") {
                                        document.getElementById("expand").style.display = "none";
                                        } else {
                                        document.getElementById("expand").style.display = "inline"
                                        }
                                }
                            </script>
            </div>

            <div id='expand'>
            <div class='row'>
                <div class="small-2 large-4 columns">
                    <?= $this->Form->input('microphone_req'); ?>
                </div>
                <div class="small-2 large-4 columns">

                </div>
                <div class="small-2 large-4 columns">
                    <?= $this->Form->input('teamspeak_req'); ?>
                </div>
                <div class="small-2 large-4 columns">
                    <?= $this->Form->input('min_playtime'); ?>
                </div>
                <div class="small-2 large-4 columns">
                    <?= $this->Form->input('min_age', ['type'=>'select', 'options'=>$ages]); ?>
                </div>



                <div class="small-2 large-4 columns">
                    <?= $this->Form->input('min_upvotes'); ?> </div>


                <div class="small-2 large-4 columns">
                    <?= $this->Form->input('max_downvotes'); ?>
                </div>

            </div>
            </div>
        </fieldset>
        <?= $this->Form->button(__('Submit'), ['class' => 'small right']) ?>
            <?= $this->Form->end() ?>
</div>