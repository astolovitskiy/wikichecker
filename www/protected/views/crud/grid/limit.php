<?php
/**
 * Created by JetBrains PhpStorm.
 * User: astolovitsky
 * Date: 10/7/13
 * Time: 2:12 PM
 * To change this template use File | Settings | File Templates.
 */

/**
 * @var $this CrudController
 * @var $grid Grid
 */

?>

<div class="limitContainer">

  <label>
    <?php echo 'Show: '?>
    <?php foreach(array(10, 25, 50, 100, 250, 500, 1000) as $num) :?>
      <?php if($num == $grid->getLimit()): ?>
        <span><?php echo $num ?></span>
      <?php else: ?>
        <?php echo CHtml::link($num, $this->getLimitUrl($num), array('class' => 'hint')) ?>
      <?php endif?>
    <?php endforeach; ?>
  </label>

</div>