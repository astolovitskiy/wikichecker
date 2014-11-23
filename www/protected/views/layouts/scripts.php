<?php
/**
 * Created by JetBrains PhpStorm.
 * User: astolovitsky
 * Date: 9/2/14
 * Time: 5:20 PM
 * To change this template use File | Settings | File Templates.
 */

/**
 * @var Controller $this
 */
?>

<?php echo CHtml::scriptFile('/js/jquery.min.js')?>
<?php echo CHtml::scriptFile('/js/bootstrap.min.js')?>
<?php foreach($this->getJsFiles() as $file):?>
  <?php echo CHtml::scriptFile($file)?>
<?php endforeach?>