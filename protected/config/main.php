<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'VDC',
    //'sourceLanguage'=>'en_US',
    //'language'=>'ru',

    // preloading 'log' component
    'preload'=>array(
        'log',
    ),

    // autoloading model and component classes
    'import'=>array(
        'application.models.*',
        'application.components.*',
        'ext.giix-components.*', // giix components
        'application.extensions.yiidebugtb.*', //our extension
        'application.modules.user.*',
        'application.modules.user.models.*',
        'application.modules.user.components.*',
        'application.modules.rights.*',
        'application.modules.rights.components.*',
        'ext.yii-mail.YiiMailMessage',
    ),

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
        'user'=>array(
            'hash' => 'md5',
            'sendActivationMail' => false,
            'loginNotActiv' => false,
            'activeAfterRegister' => true,
            'autoLogin' => true,
            'registrationUrl' => array('/user/registration'),
            'recoveryUrl' => array('/user/recovery'),
            'loginUrl' => array('/user/login'),
            'returnUrl' => array('/user/profile'),
            'returnLogoutUrl' => array('/user/login'),
            'tableUsers' => 'vdc_user',
            'tableProfiles' => 'vdc_profile',
            'tableProfileFields' => 'vdc_profiles_field',
        ),
        'rights'=>array(
            //'install'=>true,
        ),
    ),

    // application components
    'components'=>array(
        'user'=>array(
            'class' => 'RWebUser',
            // enable cookie-based authentication
            'allowAutoLogin'=>true,
            'loginUrl' => array('/site/login'),
        ),
        'authManager'=>array(
            'class'=>'RDbAuthManager',
            'itemTable' => 'vdc_AuthItem',
            'itemChildTable' => 'vdc_AuthItemChild',
            'assignmentTable' => 'vdc_AuthAssignment',
            'rightsTable'   => 'vdc_Rights',
        ),
        'urlManager' => array(
            'urlFormat'=>'path',
            'rules' => array(
                '' => 'order/list',
            ),
        ),
        'mail' => array(
            'class' => 'ext.yii-mail.YiiMail',
            'transportType' => 'smtp',
            'viewPath' => 'application.views.mail',
            'logging' => true,
            'dryRun' => true,
            'transportOptions' => array(
                'host' => '',
                'username' => '',
                'password' => '',
                'port' => 465,
                'encryption' => 'ssl'
            )
        ),
        // uncomment the following to enable URLs in path-format
        /*
        'urlManager'=>array(
            'urlFormat'=>'path',
            'rules'=>array(
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ),
        ),
        */
        //'db'=>array(
            //'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
        //),
        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=vdc',
            'emulatePrepare' => true,
            'username' => 'vdc',
            'password' => '123',
            'charset' => 'utf8',
            'enableProfiling'=>true,
            'enableParamLogging'=>true,
        ),
        'errorHandler'=>array(
            // use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning, info',
                ),
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
