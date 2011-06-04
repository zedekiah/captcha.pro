<?php

class captchaComponents extends sfComponents
{
    public function executeCaptchaForm()
    {
        $this->hash = Captcha::generateImage();
        $this->image = '/images/captcha/'.$this->hash.'.png';
    }
}
