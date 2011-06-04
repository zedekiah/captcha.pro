<?php

/**
 * captcha actions.
 *
 * @package    captcha
 * @subpackage captcha
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class captchaActions extends sfActions
{
    public function executeGetImage()
    {
        $groupCount = SynonymGroupTable::getInstance()->count();
        $randGroupNumber = rand(1, $groupCount);
        $wordCount = Doctrine_Query::create()
            ->select('word_id')
            ->from('WordSynonymGroup')
            ->where("synonym_group_id=$randGroupNumber")
            ->count();
        $newImage = imagecreatetruecolor(sfConfig::get('app_images_width')*5, sfConfig::get('app_images_height'));
        $alreadyUsed = array();
        for($i = 0; $i < 5; $i++)
        {
            $randImageNumber = rand(1, sfConfig::get('app_images_perWord')*$wordCount);
            while(in_array($randImageNumber, $alreadyUsed)) {
                $randImageNumber = rand(1, sfConfig::get('app_images_perWord')*$wordCount);
            }
            $src = imagecreatefrompng(sfConfig::get('sf_root_dir').'/web/images/cache/'.$randGroupNumber.'_'.$randImageNumber.'.'.sfConfig::get('app_images_filetype'));
            imagecopy($newImage, $src, $i*sfConfig::get('app_images_width'), 0, 0, 0, imagesx($src), imagesy($src));
            imagedestroy($src);
            $alreadyUsed[] = $randImageNumber;
        }
        $hash = md5(date('dmYhis'));
        imagepng($newImage, sfConfig::get('sf_root_dir').'/web/images/captcha/'.$hash.'.png', 9);
        $this->image = 'images/captcha/'.$hash.'.png';
        $validation = new Validation();
        $validation->setHash($hash);
        $validation->setSynonymGroupId($randGroupNumber);
        $validation->save();
        $this->val = $wordCount;
    }

    public function executeGetCaptcha()
    {
        //TODO Сделать форму, ее пока нет
        $this->form = new CaptchaForm();
    }

    public function executeValidation(sfWebRequest $request)
    {
        //TODO Валидация не доделана. нужно выяснять принадлежит ли введенное слово к группе и зкоторой сделана картинка
        $hash = $request->getparameter('hash');
        $word = $request->getParameter('word');
        $validation = Doctrine_Core::getTable('Validation')->findOneByHash($hash);
        if($validation) 
        {
            $wordObject = Doctrine_Core::getTable('Word')->findOneByName($word);
            die($wordObject->getSynonymGroupId());
        }
    }

  public function executeIndex(sfWebRequest $request)
  {
    $this->synonym_groups = Doctrine_Core::getTable('SynonymGroup')
      ->createQuery('a')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new SynonymGroupForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new SynonymGroupForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($synonym_group = Doctrine_Core::getTable('SynonymGroup')->find(array($request->getParameter('id'))), sprintf('Object synonym_group does not exist (%s).', $request->getParameter('id')));
    $this->form = new SynonymGroupForm($synonym_group);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($synonym_group = Doctrine_Core::getTable('SynonymGroup')->find(array($request->getParameter('id'))), sprintf('Object synonym_group does not exist (%s).', $request->getParameter('id')));
    $this->form = new SynonymGroupForm($synonym_group);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($synonym_group = Doctrine_Core::getTable('SynonymGroup')->find(array($request->getParameter('id'))), sprintf('Object synonym_group does not exist (%s).', $request->getParameter('id')));
    $synonym_group->delete();

    $this->redirect('captcha/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $synonym_group = $form->save();

      $this->redirect('captcha/edit?id='.$synonym_group->getId());
    }
  }
}
