<?php
/**
 * Created by JetBrains PhpStorm.
 * User: UnderDark
 * Date: 10.09.13
 * Time: 16:19
 * To change this template use File | Settings | File Templates.
 */

/**
 * @var $this CrudController
 * @var $formPath string
 * @var $title string
 * @var $model ActiveRecord
 */

$baseUrl = Yii::app()->request->baseUrl;

$this->setJsFiles(array('/js/app/form.js'), array_merge($this->getJsFiles()));
?>

<?php $this->renderPartial($formPath, array('title' => $title, 'model' => $model))?>

<script>
  var errors = <?php echo CJSON::encode($model->getErrors())?>;
  var formName = '<?php echo get_class($model)?>';
</script>