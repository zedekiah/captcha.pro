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

  public function scaleImage($file_path) {
    echo 'Imagick -> start'."\n";

    $picture = new Imagick($file_path);
    $width = $picture->getImageWidth();
    $height = $picture->getImageHeight();
    $size = ($width <= $height) ? $width : $height;

    echo 'Imagick -> cropping'."\n";

    $picture->cropImage($size, $size, 0, 0);

    echo 'Imagick -> scaling'."\n";

    $picture->scaleImage(sfConfig::get('app_images_width'), sfConfig::get('app_images_height'));

    echo 'Imagick -> saving'."\n";

    $picture->writeImage($file_path);
  }

  public function getImagesJson($images_per_page, $images_cursor, $filetype, $search) {
    $json = file_get_contents('http://ajax.googleapis.com/ajax/services/search/images?v=1.0&safe=off&rsz='.$images_per_page.'&start='.$images_cursor.'&'.$filetype.'&q='.urlencode($search));
    return json_decode($json);
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    // add your code here

    $configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'prod', true);    
    $groups = Doctrine_Core::getTable('SynonymGroup')->createQuery()->execute();

    foreach ($groups as $group) {

	/* START: For each group */
	$group_id = $group->getId();
	
	$g_words = Doctrine_Core::getTable('WordSynonymGroup')->findBySynonymGroupId($group_id);
	$i = 1;

	foreach ($g_words as $g_word) {

	    /* START: For each word in word group */

	    $word = Doctrine_Core::getTable('Word')->findOneById($g_word->getWordId());
	    echo $word."\n";

	    $images_qty = sfConfig::get('app_images_perWord');
	    $images_cursor = 0;

	    while ($images_qty != 0) {

		/* START: Pages */

		if ($images_qty > 7) {
		    $images_per_page = 8;
		    $images_qty = $images_qty - 8;		    
		} else {
		    $images_per_page = $images_qty;
		    $images_qty = 0;
		}

		if (sfConfig::get('app_images_filetype') == 'all') {
		    $filetype = '';
		} else {
		    $filetype = 'as_filetype='.sfConfig::get('app_images_filetype');
		}

		$data = $this->getImagesJson($images_per_page, $images_cursor, $filetype, $word);

		foreach ($data->responseData->results as $v){

		    $data->responseData->cursor->estimatedResultCount;
		    $ch = curl_init();
		    curl_setopt($ch, CURLOPT_URL, $v->unescapedUrl);
		    $filetype = strtolower(substr(strrchr($v->unescapedUrl,'.'),1));

		    $file_path = sfConfig::get('sf_root_dir').'/web/images/cache/' . $group_id. '_' .$i . '.'.$filetype;

		    echo $file_path."\n";
		    $fp = fopen($file_path, 'w');
		    curl_setopt($ch, CURLOPT_FILE, $fp);
		    curl_exec ($ch);
		    curl_close ($ch);
		    fclose($fp);

		    $mime = mime_content_type($file_path);

		    echo $mime."\n";

		    /* Filetype check */

		    $filetype_check = ($filetype == 'jpg') ? 'jpeg' : $filetype;
		    
		    if ('image/'.$filetype_check == $mime ) {					    
			$this->scaleImage($file_path);
			$i++;		    
		    } else {
			echo 'WRONG FILETYPE!'."\n";
			$images_qty++;
		    }
		    
		    /* END: For each word in word group */
		}

		$images_cursor = $images_cursor + $images_per_page;

		/* END: Pages */
	    }
	    
	    /* END: For each group */
	}
    }
  }
}
