<?php
/**
 * @var PageVersionController $this
 * @var PageVersion $model
 */
?>

<?php echo ($content = $model->getDiffContent()) ? $content : 'Previous version does not exist'?>