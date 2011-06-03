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
    public function executeGet()
    {
        //TODO взять 5 случайных картинок из группы и склеить их в одну
        $groupCount = SynonymGroupTable::getInstance()->count();
        $randGroupNumber = rand(0, $groupCount);
        $newImage = imagecreatetruecolor(sfConfig::get('app_captcha_image_width', 100)*3, sfConfig::get('app_captcha_image_height', 100)*3);
        for($i = 0; $i < 3; $i++)
        {
            $src = imagecreatefrompng(sfConfig::get('sf_root_dir').'/web/images/cache/'.$randGroupNumber.'_'.rand(0, sfConfig::get('app_captcha_images_per_group', 50)).'.png');
            imagecopy($newImage, $src, $i*sfConfig::get('app_captcha_image_width', 100), 0, 0, 0, imagesx($src), imagesy($src));
            imagedestroy($src);
        }
        imagepng($newImage, sfConfig::get('sf_root_dir').'/web/images/captcha/1.png', 9);
        $this->image = sfConfig::get('sf_root_dir').'/web/images/captcha/1.png';
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
