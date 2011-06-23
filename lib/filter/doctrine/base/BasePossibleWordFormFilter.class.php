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
      'new_word'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'groups_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'SynonymGroup')),
    ));

    $this->setValidators(array(
      'new_word'    => new sfValidatorPass(array('required' => false)),
      'groups_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'SynonymGroup', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('possible_word_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addGroupsListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.PossibleWordSynonymGroup PossibleWordSynonymGroup')
      ->andWhereIn('PossibleWordSynonymGroup.synonym_group_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'PossibleWord';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'new_word'    => 'Text',
      'groups_list' => 'ManyKey',
    );
  }
}
