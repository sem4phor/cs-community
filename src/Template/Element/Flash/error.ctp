<div class="message error"><?= h($message) ?><a href='#' class='close' onclick="closeMessage()">&times;</a></div>

<script>
    function closeMessage() {
        $('.message').slideUp();
    }
</script>
