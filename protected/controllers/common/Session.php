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
	
	/**
	 * get session oauthid
	 */
	public static function oauthUId () {
		$useId = null;
		if (isset($_SESSION['token']) && isset($_SESSION['token']['uid'])) {
			$useId = $_SESSION['token']['uid'];
		}
		return $useId;
	}
	
	public static function logout() {
		Yii::app()->user->logout();
		unset($_SESSION['token']);
	}
	
	/**
	 * get session userinfo
	 */
	public static function userInfo() {
		if (!isset(Yii::app()->user->userinfo)) {
			$useId = Yii::app()->user->getId();
			if (!empty($useId)) {
				$userAction = new UserAction;
				$userInfo = $userAction->getUserById($useId);
				Yii::app()->user->setState('userinfo', $userInfo);
			}
		}
		return Yii::app()->user->userinfo;
	}
}
