<?php

class updateImagesTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'captcha';
    $this->name             = 'updateImages';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [updateImages|INFO] task does things.
Call it with:

  [php symfony updateImages|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    // add your code here
    
    $groups = Doctrine_Core::getTable('SynonymGroup')->createQuery()->execute();


    foreach ($groups as $group) {

	/* START: For each group */
	$group_id = $group->getId();
	$words = Doctrine_Core::getTable('WordSynonymGroup')->findOneBySynonymGroupId($group_id);
	$i = 0;

	foreach ($g_words as $g_word) {

	    /* START: For each word in word group */

	    $word = Doctrine_Core::getTable('Word')->findOneById($g_word->getId());
	    echo $word."\n";

	    $search = $word;
	    $json = file_get_contents('http://ajax.googleapis.com/ajax/services/search/images?v=1.0&rsz=8&q='.urlencode($search).'&start=0');
	    $data = json_decode($json);

	    foreach ($data->responseData->results as $v){

		$data->responseData->cursor->estimatedResultCount;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $v->unescapedUrl);
		$filetype = substr(strrchr($v->unescapedUrl,'.'),1);
		echo sfConfig::get('sf_root_dir').'/web/images/cache/' . $group_id. '_' .$i . '.'.$filetype."\n";
		$fp = fopen(sfConfig::get('sf_root_dir').'/web/images/cache/' . $group_id. '_' .$i . '.'.$filetype, 'w');
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_exec ($ch);
		curl_close ($ch);
		fclose($fp);

		echo 'Imagick -> start'."\n";

		$picture_file = sfConfig::get('sf_root_dir').'/web/images/cache/' . $group_id. '_' .$i . '.'.$filetype;

		$picture = new Imagick($picture_file);
		$width = $picture->getImageWidth();
		$height = $picture->getImageHeight();

		if ($width <= $height) {
		    $size = $width;
		}
		else {
		    $size = $height;
		}

		echo 'Imagick -> cropping'."\n";

		$picture->cropImage($size, $size, 0, 0);

		echo 'Imagick -> scaling'."\n";

		$picture->scaleImage(sfConfig::get('app_captcha_image_width'), sfConfig::get('app_captcha_image_height'));

		echo 'Imagick -> saving'."\n";

		$picture->writeImage($picture_file);
		$i++;
	    }

	    /* END: For each word in word group */
	}

	/* END: For each group */
    }
  }
}
