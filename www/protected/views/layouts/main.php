<?php
/**
 * @var Controller $this
 * @var string $content
 */
?>
<!DOCTYPE html>
<html lang="en">
  <?php echo $this->renderPartial('//layouts/head')?>
  <body>
    <?php echo $this->renderPartial('//layouts/header')?>
    <?php echo $this->renderPartial('//layouts/pageDescription')?>
    <div class="content">
      <?php echo $content?>
    </div>
    <?php echo $this->renderPartial('//layouts/footer')?>
    <?php echo $this->renderPartial('//layouts/scripts')?>
  </body>
</html>