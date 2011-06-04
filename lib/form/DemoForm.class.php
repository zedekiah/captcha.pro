<?php

class DemoForm extends BaseForm
{
  public function setup()
  {
    $this->setWidgets(array(
        'name'          => new sfWidgetFormInput(),
    ));

//    $this->setLabels(array(
//        'name'          => 'Ваше имя'
//    ));

    $this->setValidators(array(
        'name'          => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('demo_form[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }
}
