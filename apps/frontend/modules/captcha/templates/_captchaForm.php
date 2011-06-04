<table cellspacing="0" cellpadding="0" class="procaptcha">
<tr>
    <td>
	<img src="<?php echo $image ?>" alt="captcha" />
    </td>
    <td>
	<a href="#" class="refresh"></a>
    </td>
</tr>
<tr>
    <td colspan="2">
	<input name="captcha_hash" type="text" value="<?php echo $hash ?>" readonly style="display: none;" />
	<span>Опишите одним словом то, что видите на этих картинках:</span>
	<input name="captcha_word" type="text" />
    </td>
</tr>
</table>
