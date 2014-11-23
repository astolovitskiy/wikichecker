<?php
/**
 * Created by JetBrains PhpStorm.
 * User: UnderDark
 * Date: 29.07.13
 * Time: 17:11
 * To change this template use File | Settings | File Templates.
 */

/**
 * @var $this CrudController
 */

$filters = $this->getFilters();

?>

<?php if(count($filters)) :?>

	<?php echo CHtml::form(null, 'GET', array('class' => 'filter-form', 'debili' => 'oni'))?>
		<div class="filter">

			<div class="dataTables_filter" id="DataTables_Table_0_filter">
				<?php foreach($filters as $attribute => $filterOption) : ?>
					<?php $filter = $this->getFilter($attribute, $filterOption); ?>
					<?php $filter->render() ?>
				<?php endforeach ?>
			</div>

			<div class="clearfix"></div>

			<div class="filter-buttons">
				<?php echo CHtml::submitButton('Search', array('class' => 'btn btn-primary', 'name' => 'search'))?>

				<?php echo CHtml::link('Clear', $this->createUrl($this->getIndexRoute()), array('class' => 'btn btn-primary', 'name' => 'clear'))?>
			</div>
		</div>
	<?php echo CHtml::endForm()?>

<?php endif ?>