<?php
/**
 * Created by JetBrains PhpStorm.
 * User: astolovitsky
 * Date: 4/4/14
 * Time: 3:15 PM
 * To change this template use File | Settings | File Templates.
 */

/**
 * @var $this Controller
 * @var $label null|string
 * @var $model ActiveRecord
 * @var $attribute string
 */

?>

<div class="filter-label">
	<?php echo ($label) ? $label : $model->getAttributeLabel($attribute)?> :
</div>