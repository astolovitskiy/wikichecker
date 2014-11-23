<?php
/**
 * Created by JetBrains PhpStorm.
 * User: a.burkut Dem
 * Email : a.burkut90@gmail.com
 * Date: 23.05.13
 * Time: 0:07
 */

/**
 * @var $this CrudController
 * @var $title string
 * @var $grid Grid
 */

$this->setPageTitle($title);

$baseUrl = Yii::app()->request->baseUrl;

$this->setJsFiles(array_merge(array('/js/bootstrap.modal.js', '/js/app/grid.js'), $this->getJsFiles()));

?>

<div class="table-responsive main-grid">

  <?php $this->renderPartial('//crud/filter/container')?>

  <div class="clearfix"></div>

  <?php echo CHtml::beginForm($this->getGroupUrl())?>

  <div class="message_container">
    <?php foreach($this->user->getFlashes() as $flash) :?>
      <?php echo $flash?>
    <?php endforeach?>
  </div>

  <div class="body">
    <?php echo $grid->render() ?>

    <div class="clearfix">

      <div class="pull-right">
        <?php if($this->allowCreate()) :?>
          <?php echo CHtml::link('Create', $this->getCreateUrl(), array('class' => 'btn btn-primary btn-sm', 'data-original-title' => 'Create'))?>
        <?php endif?>

        <?php foreach($this->getGroupActions() as $groupActionKey => $groupActionOptions) :?>
          <?php echo CHtml::submitButton(Arr::get($groupActionOptions, 'buttonValue'), array_merge(Arr::get($groupActionOptions, 'buttonOptions', array()), array('name' => 'groupButton')))?>
        <?php endforeach;?>

        <?php foreach($this->getButtons() as $button) :?>
          <?php echo CHtml::link($button['label'], $this->createUrl($button['route'], Arr::get($button, 'params', array())), Arr::get($button, 'htmlOptions', array()))?>
        <?php endforeach ?>
      </div>

      <?php Yii::app()->controller->renderPartial(Grid::PAGINATION_VIEW_PATH, array('grid' => $grid)) ?>

    </div>
  </div>

  <?php $this->renderPartial('//crud/grid/limit', array('grid' => $grid))?>


  <?php echo CHtml::endForm()?>

</div>

<?php $this->renderPartial('//crud/grid/modal')?>