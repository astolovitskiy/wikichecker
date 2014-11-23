<?php
/**
 * Created by JetBrains PhpStorm.
 * User: UnderDark
 * Date: 30.07.13
 * Time: 11:26
 * To change this template use File | Settings | File Templates.
 */

/**
 * @var $this Controller
 * @var $attribute string
 * @var $options array
 * @var $model ActiveRecord
 */

?>


<?php $this->renderPartial('//crud/filter/filterString', array('attribute' => $attribute, 'options' => $options, 'model' => $model))?>

<script>
	$(document).ready(function() {
		$('#<?php echo $attribute?>').on('keydown', function() {
			return validateNumKey(event);
		});
	});
</script>