<?php
/**
 * Created by JetBrains PhpStorm.
 * User: astolovitsky
 * Date: 9/2/14
 * Time: 5:05 PM
 * To change this template use File | Settings | File Templates.
 */

/**
 * @var $model Page
 * @var $this Controller
 * @var $form CActiveForm
 */
?>

<?php
  $form = $this->beginWidget('CActiveForm',
    array(
      'id' => 'link_form',
      'clientOptions' => array(
        'validateOnSubmit' => true,
      ),
      'htmlOptions' => array(
        'class' => '',
        'novalidate' => 'novalidate'
      )
  ));
?>
  <div class="form-group">
    <label for="name"><?php  echo $model->getAttributeLabel('name')?></label>
    <?php echo $form->textField($model, 'name', array('class' => 'form-control'))?>
  </div>
  <div class="form-group">
    <label for="url"><?php  echo $model->getAttributeLabel('url')?></label>
    <?php echo $form->textField($model, 'url', array('class' => 'form-control'))?>
  </div>
  <div class="form-group">
    <label for="name"><?php  echo $model->getAttributeLabel('email')?></label>
    <?php echo $form->textField($model, 'email', array('class' => 'form-control'))?>
  </div>
  <div class="form-group">
    <label for="description"><?php  echo $model->getAttributeLabel('description')?></label>
    <?php echo $form->textArea($model, 'description', array('class' => 'form-control'))?>
  </div>
  <?php $this->renderPartial('//crud/form/buttonSave')?>
  <?php $this->renderPartial('//crud/form/buttonCancel')?>
<?php $this->endWidget() ?>

