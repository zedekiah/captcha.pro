<?php

class captchaAddFromUsersTask extends sfBaseTask
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
    $this->name             = 'addFromUsers';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [captcha:addFromUsers|INFO] task does things.
Call it with:

  [php symfony captcha:addFromUsers|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    $configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'prod', true);

    $words = Doctrine_Query::create()->select('*')->from('FailWord')->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY)->execute();

    foreach ($words as $word) {	

	$group_count = Doctrine_Query::create()->select('SUM(FailWord.count)')->from('FailWord')->where('synonym_group_id = '.$word['synonym_group_id'])->setHydrationMode(Doctrine_Core::HYDRATE_SINGLE_SCALAR)->execute();
	// сколько раз не проходили капчу для данной группы

	echo 'Word: '.$word['new_word']."\n";
	echo 'Total fails in group: '.$group_count."\n";
	echo 'Trusted minimum: '.sfConfig::get('app_trusted_min')."\n";
	echo 'Possible minimum: '.sfConfig::get('app_possible_min')."\n";
	echo 'Word fails counter: '.$word['count']."\n";
	echo 'Value to pass (trusted): '.($group_count*sfConfig::get('app_trusted_percentage')/100)."\n";
	echo 'Value to pass (possible): '.($group_count*sfConfig::get('app_possible_percentage')/100)."\n";

	if ($group_count > sfConfig::get('app_trusted_min') && $word['count'] > ($group_count*sfConfig::get('app_trusted_percentage')/100)) {
	// если общая сумма непрохождения больше минимального порога и количество упоминаний слова больше n% от этого порога, то

	   echo 'Adding as trusted word.'."\n";
	   
	   if (!Doctrine_Core::getTable('Word')->findBy('name', $word['new_word'])->count()) {

	   $addTrusted = new Word();
	   $addTrusted->setname($word['new_word']);
	   $addTrusted->link('Groups', $word['synonym_group_id']);
	   $addTrusted->save();

	   } else {

	   $word_id = Doctrine_Core::getTable('Word')->findOneBy('name', $word['new_word']);
	   // поиск id слова

	   $addRelation = new WordSynonymGroup();
	   $addRelation->setSynonymGroupId($word['synonym_group_id']);
	   $addRelation->setWordId($word_id['id']);
	   $addRelation->save();
	   // добавление связи
	   
	   }


	} elseif ($group_count > sfConfig::get('app_possible_min') && $word['count'] > ($group_count*sfConfig::get('app_possible_percentage')/100)) {
	   
	    echo 'Adding as possible word.'."\n";    
	    
	    $addPossible = new PossibleWord();
	    $addPossible->setNewWord($word['new_word']);
	    $addPossible->link('Groups', $word['synonym_group_id']);
	    $addPossible->save();

	}
	else {
	   echo 'Just an error. Delete.'."\n";
	}
	echo "\n";
    }
    //Doctrine_Core::getTable('FailWord')->findAll()->delete();
  }
}
