<?php

date_default_timezone_set('US/Eastern');

return array(
  'basePath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
  'name' => 'My Console Application',

  'preload' => array('log'),

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
    'ext.phpmailer.*',
  ),

  'components' => array(
    'db' => require(dirname(__FILE__).'/database.php'),

    'log' => array(
      'class' => 'CLogRouter',
      'routes' => array(
        array(
          'class'=>'CFileLogRoute',
          'levels'=>'error, warning',
        ),
      ),
    ),

    'urlManager' => array(
      'urlFormat' => 'path',
      'showScriptName' => false,
      'rules' => require(dirname(__FILE__).'/routes.php'),
    ),

  ),
);
