<?php
Yii::import("ext.wbsdk.SaetV2Ex", true);

class UserController extends Controller
{
	public function filters() {
		return array(
            'accessControl',
        );
	}
	
	public function accessRules() {
        return array(
            array('deny',  // deny all guests
				'actions'=>array('changepasswd', 'verify', 'changemail'),
				'users'=>array('?')
			),
			array('allow',
				'users'=>array('*')
			)
        );
    }
    
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			'changepasswd'=>array(
				'class'=>'application.controllers.user.ChangePasswordAction',
			),
			'changemail'=>array(
				'class'=>'application.controllers.user.ChangeEmailAction',
			),
		);
	}
	
	public function actionForget() {
		
		$model = new ForgetForm;
		// collect user input data
		if(isset($_POST['ForgetForm'])) {
			$model->attributes=$_POST['ForgetForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate()) {
				$model->sendResetEmail();
			}
		}
		$this->render('forget',array('model'=>$model));
	}
	/**
	 * Displays the login page
	 */
	public function actionLogin() {
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm'])) {
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()) {
				$this->redirect(Yii::app()->homeUrl);
			}
		}
		
		$openApi = new stdClass();
		
		$oAuth = new SaeTOAuthV2( WB_AKEY , WB_SKEY );
		$openApi->wbUrl = $oAuth->getAuthorizeURL( WB_CALLBACK_URL );
		
		// display the login form
		$this->render('login',array('model'=>$model, 'openApi' => $openApi));
	}

	public function actionSignup() {
		$model = new SignupForm;
		// collect user input data
		if(isset($_POST['SignupForm'])) {
			$model->attributes=$_POST['SignupForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->signup()) {
				$this->redirect(Yii::app()->homeUrl);
			}
		}
		// display the login form
		$this->render('signup',array('model'=>$model));
	}
	
	public function actionVerify() {
		$model = new stdClass();
		$userInfo = Session::userInfo();
		$model->redirect = false;
		$model->email = StringUtils::maskEmail($userInfo->email, '*');
		
		$emailActivationKey = Yii::app()->getRequest()->getParam("emailActivationKey", "");
		if (empty($emailActivationKey)) {
			$send = Yii::app()->getRequest()->getParam("send", "false");
			if ($send == "true") {
				$userAction = new UserAction();
				$result = $userAction->sendVerifyMail($userInfo);
				if (!$result) {
					$model->sendFail = true;
				}
			}
		} else {
			$userAction = new UserAction();
			$result = $userAction->doVerifyMail($userInfo, $emailActivationKey);
			if ($result) {
				$model->redirect = true;
			}
		}
		$this->render('verify',array('model'=>$model));
	}
	
	public function actionReset() {
		$model = new ResetForm;
		$model->resetKey = Yii::app()->getRequest()->getParam("resetKey", "");
		$model->username = Yii::app()->getRequest()->getParam("username", "");
		$model->username = StringUtils::decode($model->username);

		if(isset($_POST['ResetForm'])) {
			$model->attributes=$_POST['ResetForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->resetPassword()) {
				$this->redirect(Yii::app()->user->loginUrl);
			}
		}
		
		$this->render('reset',array('model'=>$model));
	}
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout() {
		Session::logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}