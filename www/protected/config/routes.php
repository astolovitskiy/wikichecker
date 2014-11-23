<?php

return array(
  '' => 'page/index',
  '<controller:\w+>' => '<controller>/index',
  '<controller:\w+>/<id:\d+>' => '<controller>/index',
  '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
);