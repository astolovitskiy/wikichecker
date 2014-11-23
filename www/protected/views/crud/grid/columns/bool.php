<?php
/**
 * Created by JetBrains PhpStorm.
 * User: a.burkut Dem
 * Email : a.burkut90@gmail.com
 * Date: 23.05.13
 * Time: 18:38
 */

/**
 * @var $gridColumn GridColumnBool
 */
?>

<?php if($gridColumn->getItem()->{$gridColumn->getColumn()}) :?>
	<span class="label label-success"><?php echo 'Yes'?></span>
<?php else :?>
	<span class="label label-important"><?php echo 'No'?></span>
<?php endif ?>


