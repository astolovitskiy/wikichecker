<?php
/**
 * Author: s.chudievich
 * Email: kuuu1010100@gmail.com
 * 05.08.13
 * 11:46
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
		<span>по</span> <?php echo CHtml::textField('to_'.$attribute, $this->request->getParam('to_'.$attribute)) ?>
	</div>
	<div class="filter-inputs">
		<span>с</span> <?php echo CHtml::textField('from_'.$attribute, $this->request->getParam('from_'.$attribute)) ?>
	</div>
</div>