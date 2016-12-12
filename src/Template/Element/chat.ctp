<div class="chat medium-3 columns">
    <div class="chat-container">
        <div class="row">
            <div class="columns medium-12"><h3 style="color:#fff"><?= __('Chat') ?></h3></div>
        </div>
        <div id="chat-message-container" class="row chat-message-container">
            <?= __('Welcome '.$user->personaname.'!') ?>
        </div>
        <div class="submit-message row">
            <div class="chat-message-input columns medium-8">
                <?= $this->Form->create('ChatMessage', ['type' => 'post', 'onsubmit' => 'return performPostRequest(this)', 'url' => ['controller' => 'ChatMessages', 'action' => 'new']]); ?>
                <?= $this->Form->input('message', ['label' => false, 'width' => '10px']); ?>
            </div>
            <div class="chat-message-input columns medium-4">
                <?= $this->Form->button('Send', ['type' => 'submit', 'class' => 'tiny radius']); ?>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function performPostRequest(form) {
        parameters="";
        for(var i=0;i<form.elements.length;i++) {
            if(parameters!="")
                parameters+="&";
            if(form.elements[i].checked==true || !(form.elements[i].type=="radio" || form.elements[i].type=="checkbox"))
                parameters+=form.elements[i].name+"="+encodeURIComponent(form.elements[i].value);
        }

        $.ajax({
            url: form.action,
            data: parameters,
            type : 'POST'
        });
        return false;
    }
</script>