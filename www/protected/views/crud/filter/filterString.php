<?php
/**
 * Created by JetBrains PhpStorm.
 * User: UnderDark
 * Date: 29.07.13
 * Time: 15:36
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
		<?php echo CHtml::textField($attribute, $this->request->getParam($attribute)) ?>
	</div>
</div>
