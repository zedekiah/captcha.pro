<?php

/**
 * WordGroup form base class.
 *
 * @method WordGroup getObject() Returns the current form's model object
 *
 * @package    captcha
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseWordGroupForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'word_id'  => new sfWidgetFormInputHidden(),
      'group_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'word_id'  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('word_id')), 'empty_value' => $this->getObject()->get('word_id'), 'required' => false)),
      'group_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('group_id')), 'empty_value' => $this->getObject()->get('group_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('word_group[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WordGroup';
  }

}
