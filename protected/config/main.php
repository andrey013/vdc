<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'VDC',
    // preloading 'log' component
    'preload'=>array(
        'log',
    ),
    // autoloading model and component classes
    'import'=>array(
        'application.models.*',
        'application.components.*',
        'ext.giix-components.*', // giix components
        'application.modules.user.*',
        'application.modules.user.models.*',
        'application.modules.user.components.*',
        'application.modules.rights.*',
        'application.modules.rights.components.*',
        'ext.yii-mail.YiiMailMessage',
    ),
    'modules'=>array(
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
            'showScriptName'=>false,
            'rules' => array(
                '' => 'order/list',
            ),
        ),
        'mail' => array(
            'class' => 'ext.yii-mail.YiiMail',
            'transportType' => 'smtp',
            'viewPath' => 'application.views.mail',
            'logging' => true,
            'dryRun' => false,
            'transportOptions' => array(
                'host' => '',
                'username' => '',
                'password' => '',
                'port' => 465,
                'encryption' => 'ssl'
            )
        ),
        'db'=>array(
            'emulatePrepare' => true,
            'charset' => 'utf8',
        ),
        'errorHandler'=>array(
            // use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
        'cache'=>array(
            'class'=>'system.caching.CMemCache',
            'servers'=>array(
                array('host'=>'localhost', 'port'=>11211)
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
