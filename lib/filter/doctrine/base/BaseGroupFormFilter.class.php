<?php

/**
 * Group filter form base class.
 *
 * @package    captcha
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseGroupFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'description:{ type' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'description:{ type' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('group_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Group';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'description:{ type' => 'Text',
    );
  }
}
