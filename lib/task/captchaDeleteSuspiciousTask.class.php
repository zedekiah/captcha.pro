<?php

class captchaDeleteSuspiciousTask extends sfBaseTask
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
    $this->name             = 'deleteSuspicious';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [captcha:deleteSuspicious|INFO] task does things.
Call it with:

  [php symfony captcha:deleteSuspicious|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    $configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'prod', true);

    $groups_qty = Doctrine_Core::getTable('SynonymGroup')->count();
    $words = Doctrine_Query::create()->select('new_word')->from('FailWord')->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY)->execute();

    foreach ($words as $word) {
	
	$word = $word['new_word'];
	echo 'Word: '.$word_in_groups."\n";

	$word_in_groups = Doctrine_Query::create()->select('count(0)')->from('FailWord a')->where('count>'.($groups_qty*sfConfig::get('app_suspicious_percentagepergroup')/100))->andWhere('new_word', $word)->setHydrationMode(Doctrine_Core::HYDRATE_SINGLE_SCALAR)->execute();
	$word_in_groups = count($word_in_groups);

	echo 'Word in groups: '.$word_in_groups."\n";
	echo 'Groups qty:'.$groups_qty."\n";
	echo 'Suspicious: '.($groups_qty*sfConfig::get('app_suspicious_percentageingroups')/100)."\n";
	if ($word_in_groups > ($groups_qty*sfConfig::get('app_suspicious_percentageingroups')/100)) {
	    echo 'DELETE!'."\n";
	    Doctrine_Core::getTable('FailWord')->findBy('new_word', $word)->delete();
	}
    }
    echo "\n\n";
  }
}
