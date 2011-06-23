<?php

/**
 * FailWord form base class.
 *
 * @method FailWord getObject() Returns the current form's model object
 *
 * @package    captcha
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseFailWordForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'synonym_group_id' => new sfWidgetFormInputHidden(),
      'new_word'         => new sfWidgetFormInputHidden(),
      'count'            => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'synonym_group_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('synonym_group_id')), 'empty_value' => $this->getObject()->get('synonym_group_id'), 'required' => false)),
      'new_word'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('new_word')), 'empty_value' => $this->getObject()->get('new_word'), 'required' => false)),
      'count'            => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('fail_word[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'FailWord';
  }

}
