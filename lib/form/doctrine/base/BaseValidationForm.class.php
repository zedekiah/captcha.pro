<?php

/**
 * Validation form base class.
 *
 * @method Validation getObject() Returns the current form's model object
 *
 * @package    captcha
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseValidationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'hash'             => new sfWidgetFormInputHidden(),
      'synonym_group_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('SynonymGroup'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'hash'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('hash')), 'empty_value' => $this->getObject()->get('hash'), 'required' => false)),
      'synonym_group_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('SynonymGroup'))),
    ));

    $this->widgetSchema->setNameFormat('validation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Validation';
  }

}
