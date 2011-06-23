<?php

/**
 * PossibleWordSynonymGroup form base class.
 *
 * @method PossibleWordSynonymGroup getObject() Returns the current form's model object
 *
 * @package    captcha
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePossibleWordSynonymGroupForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'word_id'          => new sfWidgetFormInputHidden(),
      'synonym_group_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'word_id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('word_id')), 'empty_value' => $this->getObject()->get('word_id'), 'required' => false)),
      'synonym_group_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('synonym_group_id')), 'empty_value' => $this->getObject()->get('synonym_group_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('possible_word_synonym_group[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PossibleWordSynonymGroup';
  }

}
