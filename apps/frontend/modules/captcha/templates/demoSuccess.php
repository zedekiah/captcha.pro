<form action="<?php echo $sf_request->getUri(); ?>" method="post">
    <?php echo $form ?>
    <div id="procaptcha_container"></div>
    <?php if($captchaError) echo '<p>Ошибка ProCaptcha</p>'; ?>
    <p><input type="submit"></p>
</form>
