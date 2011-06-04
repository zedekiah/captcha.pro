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
	<label>Опишите одним словом то, что видите на этих картинках:</label>
	<input name="captcha_word" type="text" />
	<span>PROCaptcha 2011</span>
    </td>
</tr>
</table>
