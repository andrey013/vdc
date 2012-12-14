<?php

// Set framework path
$yii = dirname( __FILE__ ) . '/protected/yii-1.1.12/framework/yii.php';

// Set configurations based on environment
if( isset( $_SERVER['APPLICATION_ENV'] ) )
{
  // Enable debug mode for development environment
  defined( 'YII_DEBUG' ) or define( 'YII_DEBUG', true );
 
  // Specify how many levels of call stack should be shown in each log message
  defined( 'YII_TRACE_LEVEL' ) or define( 'YII_TRACE_LEVEL', 3 );
 
  // Set environment variable
  $environment = 'development';
  // $environment = $_SERVER['APPLICATION_ENV']; // Uncomment for dynamic config files
}
else
{
  // Set environment variable
  $environment = 'production';
}
 
// Include config files
$configMain = require_once( dirname( __FILE__ ) . '/protected/config/main.php' );
$configServer = require_once( dirname( __FILE__ ) . '/protected/config/server.'
  . $environment . '.php' );
 
// Include Yii framework
require_once( $yii );
 
// Run application
$config = CMap::mergeArray( $configMain, $configServer );

$app = Yii::createWebApplication($config);

Yii::app()->setTimeZone("Europe/Moscow");

$app->run();
