<?php

set_include_path('../library' . PATH_SEPARATOR . get_include_path());

// 環境変数
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));
defined('ROOT_PATH') || define('ROOT_PATH', realpath(dirname(__FILE__) . '/../'));
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : "development"));

require_once ROOT_PATH.'/library/composer/vendor/autoload.php';

use Zend\Application;
use Zend\Loader\Autoloader;

// autoloaderインスタンス化
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->unregisterNamespace(array('Zend_', 'ZendX_'))
           ->setFallbackAutoloader(true);



$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/core.ini'
);


try {

    $application->bootstrap();
    $front = $application->getBootstrap()->getResource('FrontController');
    $front->addControllerDirectory(APPLICATION_PATH.'/modules/core/controllers');
    $application->run();

} catch (Exception $e) {
    throw $e;
}

