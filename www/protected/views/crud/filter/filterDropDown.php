<?php
/**
 * Created by JetBrains PhpStorm.
 * User: astolovitsky
 * Date: 10/25/13
 * Time: 4:51 PM
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
		<?php echo CHtml::dropDownList($attribute, $this->request->getParam($attribute), $options['options'], array('class' => 'chzn-select select-block-level')) ?>
	</div>
</div>