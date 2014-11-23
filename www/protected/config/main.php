<?php

date_default_timezone_set('US/Eastern');

return array(
  'basePath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
  'name' => 'Wikichecker',

  'preload'=>array('log'),

  'import' => array(
    'application.components.*',
    'application.components.helpers.*',
    'application.components.system.*',
    'application.components.system.admin.*',
    'application.components.system.admin.filter.*',
    'application.components.system.admin.grid.*',
    'application.components.user.*',
    'application.controllers.*',
    'application.models.*',
    'application.models.forms.*',
    'ext.diff.*',
  ),

  'components' => array(

    'coreMessages'=>array(
      'basePath'=>'protected/messages'
    ),

    'db' => require(dirname(__FILE__).'/database.php'),

    'request' => array(
      'class' => 'application.components.system.HttpRequest',
      'enableCookieValidation'=> true,
    ),

    'urlManager' => array(
      'urlFormat' => 'path',
      'showScriptName' => false,
      'rules' => require(dirname(__FILE__).'/routes.php'),
    ),

    'errorHandler' => array(
      'errorAction' => 'site/error',
    ),

    'authManager' => array(
      'class' => 'PhpAuthManager',
      'defaultRoles' => array('guest'),
    ),

    'log' => array(
      'class' => 'CLogRouter',
      'routes' => array(
        array(
          'class' => 'CWebLogRoute',
          'categories' => 'application',
          'levels' => 'error, warning, trace, profile, info',
        ),
      ),
    ),

    'user' => array(
      'class' => 'WebUser',
      'allowAutoLogin' => true,
      'loginUrl' => null,
    ),
  ),

  'params'=>array(
    'messages' => require(dirname(__FILE__).'/messages.php'),
  ),
);
