<?php
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
				'actions'=>array('changepasswd'),
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
			)
		);
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
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	public function actionSignup() {
		$model = new SignupForm;
		// collect user input data
		if(isset($_POST['SignupForm'])) {
			$model->attributes=$_POST['SignupForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->signup()) {
				$this->redirect(Yii::app()->user->returnUrl);
			}
		}
		// display the login form
		$this->render('signup',array('model'=>$model));
	}
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout() {
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}