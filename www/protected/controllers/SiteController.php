<?php

class SiteController extends Controller {

  /**
   * void
   */
  public function actionError() {
    if($error = Yii::app()->errorHandler->error) {
      if(Yii::app()->request->isAjaxRequest)
        echo $error['message'];
      else {
        $this->pageTitle = Yii::app()->name.' - Error';
        $this->render('error', $error);
      }
    }
  }

}