<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
define('CONFIG_PATH', dirname(__FILE__));
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'商城系统',

	// preloading 'log' component
	'preload'=>array('log'),

//        'defaultController'=>'b2c/default/index',

	// autoloading model and component classes
	'import'=>array(
		'application.components.*',
	),

    'modules'=>array('b2c'),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
        'mailer' => array(
            'class' => 'application.extensions.mailer.EMailer',
            'pathViews' => 'application.views.email',
            'pathLayouts' => 'application.views.email.layouts'
        ),

//        'cache'=>array(
//            'class'=>'system.caching.CFileCache',
//        ),

        'cache'=>array(
            'class'=>'CMemCache',
            'servers'=>array(
                array(
                    'host'=>'127.0.0.1',
                    'port'=>11211,
                    'weight'=>120,
                ),
            ),
        ),
		// uncomment the following to enable URLs in path-format

		'urlManager'=>array(
			'urlFormat'=>'path',
            'showScriptName'=>false,
            'urlSuffix'=>'.html',//搭车加上.html后缀
            'showScriptName'=>false,
            'rules'=>array(
//				'<controller:\w+>/<id:\d+>'=>'<controller>',
//				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
//				'<controller:\w+>/<action:\w+>'=>'b2c/<controller>/<action>',
//				'category'=>'b2c/category/index',
//				'product'=>'b2c/product/index',
			),
		),


		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),

//		'errorHandler'=>array(
//			// use 'site/error' action to display errors
//			'errorAction'=>'site/error',
//		),

		'log' => require(CONFIG_PATH.'/log.php'),
                'session' => array(
                    'timeout'=>7200
                ),

	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
    'params'=>require(dirname(__FILE__).'/b2c_params.php'),
);
