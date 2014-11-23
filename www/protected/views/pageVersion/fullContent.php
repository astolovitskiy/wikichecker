<?php
/**
 * @var PageVersionController $this
 * @var PageVersion $model
 */


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $this->getPageTitle()?></title>
    <?php echo CHtml::cssFile('/css/wiki-css-1.css');?>
    <?php echo CHtml::cssFile('/css/wiki-css-2.css');?>
  </head>
  <body>
    <?php echo $model->getContent()?>
  </body>
</html>