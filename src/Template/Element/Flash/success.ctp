<div class="message success"><?= h($message) ?><a href='#' class='close' onclick="closeMessage()">&times;</a></div>

<script>
    function closeMessage() {
        $('.message').slideUp();
    }
</script>

