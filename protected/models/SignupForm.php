<?php
require_once(Yii::app()->basePath . "/controllers/user/UserAction.php");
/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class SignupForm extends CFormModel {
	public $username;
	public $email;
	public $password;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules() {
		return array(
			// username required
			array('username', 'required'),
			// 用户名必须在 3 到 12 个字符之间
			array('username', 'length', 'min'=>4, 'max'=>12),
			// email, password, password2 required
			array('email, password', 'required'),
			array('password', 'check'),
		);
	}
	
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels() {
		return array(
			'username'=>'用户名',
			'password'=>'密码',
			'email'=>'电子邮件'
		);
	}

	public function check($attribute,$params) {
		if($this->hasErrors()) {
			$errors = $this->getErrors();
			$error = array_shift($errors);
			$this->addError('errorMsg',$error[0]);
		} else {
			$userAction = new UserAction;
			$result = $userAction->getUser($this->username);
			if ($result != null) {
				$this->addError('errorMsg',"该用户名不可用");
			}
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function signup() {
		$userAction = new UserAction;
		$result = $userAction->createUser($this);
		return $result->success;
	}
}