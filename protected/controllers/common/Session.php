<?php
class Session {
	/**
	 * get session userid
	 * @param Controller $controller
	 */
	public static function userId ($controller = null) {
		$useId = Yii::app()->user->getId();
		if (empty($useId)) {
			if ($controller != null) {
				$controller->redirect(Config::getUrl('loginUrl'));
			}
		}
		return $useId;
	}	
}
