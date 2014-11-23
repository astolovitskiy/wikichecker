<?php
/**
 * Created by JetBrains PhpStorm.
 * User: a.burkut Dem
 * Email : a.burkut90@gmail.com
 * Date: 23.05.13
 * Time: 17:26
 */

/**
 * @var $grid Grid
 * @var $item ActiveRecord
 * @var $this CrudController
 */

?>

<tbody>

  <?php foreach($grid->getItems()->findAll() as $item) :?>

    <tr item_id="<?php echo $item->id?>">

      <?php if($this->allowCheckboxes()) :?>
        <td class="center">
          <?php echo CHtml::checkBox('item_'.$item->id, false, array('value' => $item->id, 'class' => 'check-one'))?>
          <span class="lbl"></span>
        </td>
      <?php endif; ?>

      <?php foreach($grid->getColumns() as $column => $type) :?>

        <td class="<?php echo Arr::get($type, 'class')?>">
          <?php echo GridColumn::factory($item, $column, $type)->render() ?>
        </td>

      <?php endforeach ?>

      <?php if($this->allowActions()) :?>

        <td>

          <?php if($item->allowUpdate()) :?>

            <a href="<?php echo $this->getUpdateUrl($item->id)?>" class="btn btn-mini btn-info" title="<?php echo 'Edit'?>">
              <i class="glyphicon glyphicon-pencil bigger-120"></i>
            </a>

          <?php endif ?>

          <?php foreach($this->getAdditionalActions() as $action) :?>

            <a href="<?php echo $this->createUrl(Arr::get($action, 'action'), array('id' => $item->id)).Arr::get($action, 'actionAdds')?>" class="btn btn-mini <?php echo Arr::get($action, 'type')?>"  title="<?php echo Arr::get($action, 'title')?>">
              <i class="<?php echo Arr::get($action, 'icon')?> bigger-120"></i>
            </a>

          <?php endforeach;?>

          <?php if($item->allowDelete()) :?>

            <a href="<?php echo $this->getDeleteUrl($item->id)?>" class="btn btn-mini btn-danger hint delete-record" title="<?php echo 'Delete'?>">
              <i class="glyphicon glyphicon-trash bigger-120"></i>
            </a>

          <?php endif ?>

        </td>

      <?php endif ?>

    </tr>

  <?php endforeach; ?>

</tbody>

