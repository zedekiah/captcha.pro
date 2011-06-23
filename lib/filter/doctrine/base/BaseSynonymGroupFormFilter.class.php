<?php

/**
 * SynonymGroup filter form base class.
 *
 * @package    captcha
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseSynonymGroupFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'description'        => new sfWidgetFormFilterInput(),
      'word_list'          => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Word')),
      'possible_word_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'PossibleWord')),
    ));

    $this->setValidators(array(
      'description'        => new sfValidatorPass(array('required' => false)),
      'word_list'          => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Word', 'required' => false)),
      'possible_word_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'PossibleWord', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('synonym_group_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addWordListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.WordSynonymGroup WordSynonymGroup')
      ->andWhereIn('WordSynonymGroup.word_id', $values)
    ;
  }

  public function addPossibleWordListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('PossibleWordSynonymGroup.word_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'SynonymGroup';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'description'        => 'Text',
      'word_list'          => 'ManyKey',
      'possible_word_list' => 'ManyKey',
    );
  }
}
