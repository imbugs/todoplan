<?php
class SiteController extends Controller {
	/**
	 * Declares class-based actions.
	 */
	public function actions() {
		return array();
	}

	public function filters() {
		return array(
            'accessControl',
        );
	}
	
	public function accessRules() {
        return array(
            array('deny',  // deny all guests
            	'actions'=>array('index'),
				'users'=>array('?')
			),
			array('allow',
				'users'=>array('*')
			)
        );
    }
    
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex() {
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$userId = Session::userId();
		$userAction = new UserAction;
		$userInfo = $userAction->getUserById($userId);

		$oauthUid = Session::oauthUId();
		if (isset($userInfo->status) && $userInfo->status == UserConstant::STATUS_TOVALID && empty($oauthUid)) {
			// 末验证，非oauth登录
			$this->redirect(Config::getUrl('verifyUrl'));
		}
		if (isset($userInfo->status)) {
			$this->render('index', array("userInfo" => $userInfo));
		} else {
			$this->redirect(Config::getUrl('logoutUrl'));
		}
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError() {
		if($error=Yii::app()->errorHandler->error) {
			Session::logout();
			if(Yii::app()->request->isAjaxRequest) {
				echo $error['message'];
			} else {
				if ($error['code'] == '404') {
					$this->renderPartial('404');
				} else {
					$this->render('error', $error);
				}
			}
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact() {
		$model=new ContactForm;
		if(isset($_POST['ContactForm'])) {
			$model->attributes=$_POST['ContactForm'];
			if($model->validate()) {
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}
}