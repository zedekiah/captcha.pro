<form action="<?php echo url_for('captcha/validation', true); ?>" method="post">
    <img src="<?php echo $image ?>">
    <p><input name="captcha_hash" type="text" value="<?php echo $hash ?>" readonly></p>
    <p>Word</p>
    <input name="captcha_word" type="text">
    <p><input type="submit"></p>
</form>
