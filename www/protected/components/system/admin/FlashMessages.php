<?php
/**
 * Created by JetBrains PhpStorm.
 * User: UnderDark
 * Date: 29.07.13
 * Time: 12:31
 * To change this template use File | Settings | File Templates.
 */

class FlashMessages {

	/**
	 * var string
	 */
	const TYPE_SUCCESS = 'alert-success';

	/**
	 * var string
	 */
	const TYPE_ERROR = 'alert-danger';

	/**
	 * var string
	 */
	const TYPE_WARNING = 'alert-warning';

	/**
	 * @param $message string
	 * @param $type string
	 * @return string
	 */
	public static function getMessageView($message, $type) {
		return Yii::app()->controller->renderPartial('//crud/grid/flashMessage', array('class' => $type, 'message' => $message), TRUE);
	}
}