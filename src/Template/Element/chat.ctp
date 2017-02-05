<div class="chat-border medium-3 columns ">
    <div class="chat">
        <div class="row">
            <div class="columns medium-12"><h3><?= __('Chat') ?></h3></div>
        </div>
        <div id="chat-message-container" class="row chat-message-container scrollbar-inner">
            <?= __('Welcome') . $user->personaname . ' !' ?>
            <?php $colors = ["#234567", "#CF142B", "#C5AC6A", "#5E9FB8", "#4CAF50", "#234567", "#CF142B", "#C5AC6A", "#5E9FB8", "#4CAF50"]; ?>
            <?php foreach ($chatMessages as $message): ?>
                <div class="row">
                    <div style='color:<?= $colors[rand(0,9)]; ?>' class="columns medium-12">
                        <?= h($message->sender->personaname) . ': ' . h($message->message) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="submit-message row">
            <div class="chat-message-input columns medium-8">
                <?= $this->Form->create('ChatMessage', ['type' => 'post', 'onsubmit' => 'return performPostRequest(this)', 'url' => ['controller' => 'ChatMessages', 'action' => 'send']]); ?>
                <?= $this->Form->input('message', ['label' => false, 'width' => '10px', 'autocomplete' => 'off', 'onfocus' => 'inputFocus(this)', 'onblur' => 'inputBlur(this)', 'value' => 'Say something', 'style' => 'color:#888']); ?>
            </div>
            <div class="chat-message-input columns medium-4">
                <?= $this->Form->button(__('Send'), ['type' => 'submit', 'class' => 'tiny radius']); ?>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function performPostRequest(form) {
        parameters = "";
        for (var i = 0; i < form.elements.length; i++) {
            if (parameters != "")
                parameters += "&";
            if (form.elements[i].checked == true || !(form.elements[i].type == "radio" || form.elements[i].type == "checkbox"))
                parameters += form.elements[i].name + "=" + encodeURIComponent(form.elements[i].value);
        }

        $.ajax({
            url: form.action,
            data: parameters,
            type: 'POST'
        });
        // delete value of input field after submitting
        $('#message').val('');
        // auto scroll down
        $('#chat-message-container').stop().animate({
            scrollTop: $('#chat-message-container')[0].scrollHeight
        }, 800);
        return false;
    }
</script>