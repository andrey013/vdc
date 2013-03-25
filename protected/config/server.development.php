<?php

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'modules'=>array(
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'123',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters'=>array('127.0.0.1','::1'),
            'generatorPaths'=>array(
                'ext.giix-core', // giix generators
            ),
        ),
    ),

    // application components
    'components'=>array(
        'urlManager' => array(
            'showScriptName'=>true,
        ),
        'mail' => array(
            'dryRun' => true,
        ),
        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=vdc',
            'username' => 'vdc',
            'password' => '123',
            'enableProfiling'=>true,
            'enableParamLogging'=>true,
            // Cache queries
            'schemaCachingDuration' => 180,
        ),
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning, info',
                ),
                /*array(
                    'class'=>'CFileLogRoute',
                    'categories'=>'system.db.*',
                    'logFile'=>'sql.log',
                ),*/
                // uncomment the following to show log messages on web pages
                /*
                array(
                    'class'=>'CWebLogRoute',
                ),
                
                array( // configuration for the toolbar
                    'class'=>'XWebDebugRouter',
                    'config'=>'alignLeft, opaque, runInDebug, fixedPos, collapsed, yamlStyle',
                    'levels'=>'error, warning, profile, info',
                    //'levels'=>'error, warning, trace, profile, info',
                    'allowedIPs'=>array('127.0.0.1','::1','192.168.1.54','192\.168\.1[0-5]\.[0-9]{3}'),
                ),
                */
            ),
        ),
    ),

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params'=>array(
        // this is used in contact page
        'adminEmail'=>'webmaster@example.com',
    ),
);
