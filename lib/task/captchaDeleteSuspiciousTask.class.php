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

    $groups_qty = Doctrine_Core::getTable('SynonymGroup')->count();

    $words = Doctrine_Core::getTable('FailWord')->findAll();

    Doctrine::getTable('Validation')->findAll()->delete();
  }
}
