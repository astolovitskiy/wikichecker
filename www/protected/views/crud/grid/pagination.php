<?php
/**
 * Created by JetBrains PhpStorm.
 * User: a.burkut Dem
 * Email : a.burkut90@gmail.com
 * Date: 23.05.13
 * Time: 17:28
 */

/**
 * @var $this Controller
 * @var $grid Grid
 */

?>

<?php $this->widget('CLinkPager', array(
	'pages' => $grid->getPages(),
	'maxButtonCount' => 10,
	'header' => '',
	'selectedPageCssClass' => 'active',
	'nextPageLabel' => 'Next',
	'prevPageLabel' => 'Previous',
	'firstPageLabel' => 'First',
	'lastPageLabel' => 'Last',
	'htmlOptions' => array('class'=>'pagination no-margin')
))?>