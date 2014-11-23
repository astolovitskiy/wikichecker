<?php
/**
 * Created by JetBrains PhpStorm.
 * User: UnderDark
 * Date: 29.07.13
 * Time: 17:30
 * To change this template use File | Settings | File Templates.
 */

/**
 * @var $this Controller
 * @var $attribute string
 * @var $options array
 * @var $model ActiveRecord
 */

?>

<div class="filter-container">
	<?php $this->renderPartial('//crud/filter/label', array('attribute' => $attribute, 'model' => $model, 'label' => Arr::get($options, 'label')))?>

	<div class="filter-inputs">
		<span>по</span> <?php echo CHtml::textField('to_'.$attribute, $this->request->getParam('to_'.$attribute), array('class' => 'input-xlarge datepicker')) ?>
	</div>
	<div class="filter-inputs">
		<span>с</span> <?php echo CHtml::textField('from_'.$attribute, $this->request->getParam('from_'.$attribute), array('class' => 'input-xlarge datepicker')) ?>
	</div>
</div>