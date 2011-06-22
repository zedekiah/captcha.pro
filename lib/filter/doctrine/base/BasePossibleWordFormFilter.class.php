<?php

/**
 * PossibleWord filter form base class.
 *
 * @package    captcha
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasePossibleWordFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'synonym_group_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('SynonymGroup'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'synonym_group_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('SynonymGroup'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('possible_word_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PossibleWord';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'synonym_group_id' => 'ForeignKey',
      'new_word'         => 'Text',
    );
  }
}
