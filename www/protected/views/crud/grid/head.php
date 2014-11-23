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
 */
?>



<thead>
	<tr>
		<?php if($this->allowCheckboxes()) :?>
			<th  class="center group-checkboxes">
				<?php echo CHtml::checkBox('', false, array('id' => 'check_all'))?>
				<span class="lbl"></span>
			</th>
		<?php endif; ?>

		<?php foreach($grid->getHeader() as $item) : ?>
			<th class="<?php echo $grid->getHeaderClass($item)?>">
				<?php echo $item ?>
			</th>
		<?php endforeach ?>

		<?php if($this->allowActions()) :?>
			<th></th>
		<?php endif; ?>
	</tr>
</thead>
