<?php
/**
 * Created by JetBrains PhpStorm.
 * User: a.burkut Dem
 * Email : a.burkut90@gmail.com
 * Date: 23.05.13
 * Time: 17:01
 */

/**
 * @var $grid Grid
 * @var $this CrudController
 */

?>

<table class="table table-bordered table-striped">
  <?php Yii::app()->controller->renderPartial(Grid::HEAD_VIEW_PATH, array('grid' => $grid))?>
  <?php Yii::app()->controller->renderPartial(Grid::ITEMS_VIEW_PATH, array('grid' => $grid))?>
</table>

