<?php

class CaptchaForm extends BaseForm
{
  public function setup()
  {
    $this->setWidgets(array(
      'word'             => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'word'             => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('captcha[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Validation';
  }
}
