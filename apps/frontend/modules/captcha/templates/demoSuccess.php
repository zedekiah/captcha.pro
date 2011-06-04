<div class="standart form">
    <form action="<?php echo $sf_request->getUri(); ?>" method="post">
	<?php echo $form ?>
	<div id="procaptcha_container"></div>
	<?php if($captchaError): ?>
	<ul class="error_list">
	    <li>Ошибка ProCaptcha.</li>
	</ul>
	<?php endif; ?>
	<input type="submit">
    </form>
</div>
