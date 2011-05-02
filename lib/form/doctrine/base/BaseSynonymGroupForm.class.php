<?php

/**
 * SynonymGroup form base class.
 *
 * @method SynonymGroup getObject() Returns the current form's model object
 *
 * @package    captcha
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSynonymGroupForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'description' => new sfWidgetFormInputText(),
      'word_list'   => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Word')),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'description' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'word_list'   => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Word', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('synonym_group[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'SynonymGroup';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['word_list']))
    {
      $this->setDefault('word_list', $this->object->Word->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveWordList($con);

    parent::doSave($con);
  }

  public function saveWordList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['word_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Word->getPrimaryKeys();
    $values = $this->getValue('word_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Word', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Word', array_values($link));
    }
  }

}
