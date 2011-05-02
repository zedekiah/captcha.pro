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
    $search = 'Сиськи Семенович';
    $json = file_get_contents('http://ajax.googleapis.com/ajax/services/search/images?v=1.0&as_filetype=jpg&rsz=8&q='.urlencode($search).'&start=0');
    $data = json_decode($json);

    $data->responseData->cursor->estimatedResultCount;
    $i = 0;
    foreach ($data->responseData->results as $v):
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $v->unescapedUrl);
      echo sfConfig::get('sf_root_dir').'/web/images/' . $i . '_image.jpg';
      $fp = fopen(sfConfig::get('sf_root_dir').'/web/images/' . $i . '_image.jpg', 'w');
      curl_setopt($ch, CURLOPT_FILE, $fp);
      curl_exec ($ch);
      curl_close ($ch);
      fclose($fp);
      $i++;
      /* it works, mutherfucker */
    endforeach;
    //How about that
  }
}
