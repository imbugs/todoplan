<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel {
	public $username;
	public $password;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules() {
		return array(
			// username is required
			array('username', 'required'),
			// 用户名必须在 3 到 12 个字符之间
			array('username', 'length', 'min'=>4, 'max'=>12),
			// password is required
			array('password', 'required'),
			// 在登录场景中，密码必须接受验证。
			array('password', 'authenticate'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels() {
		return array(
			'username'=>'用户名',
			'password'=>'密码',
			'rememberMe'=>'记住我'
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params) {
		if(!$this->hasErrors()) {
			$this->_identity=new UserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
			if ($this->_identity->errorCode == UserIdentity::ERROR_USERNAME_INVALID) {
				Yii::log("login failed [{$this->username}], errorCode [ERROR_USERNAME_INVALID]", CLogger::LEVEL_WARNING);
				$this->addError('errorMsg','用户名或密码错误');
			} else if ($this->_identity->errorCode == UserIdentity::ERROR_PASSWORD_INVALID) {
				Yii::log("login failed [{$this->username}], errorCode [ERROR_PASSWORD_INVALID]", CLogger::LEVEL_WARNING);
				$this->addError('errorMsg','用户名或密码错误.');
			}
		} else {
			$errors = $this->getErrors();
			$error = array_shift($errors);
			$this->addError('errorMsg',$error[0]);
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login() {
		if($this->_identity===null) {
			$this->_identity=new UserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE) {
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity, $duration);
			Yii::log("login success [{$this->username}]", CLogger::LEVEL_INFO);
			return true;
		} else {
			Yii::log("login failed [{$this->username}], errorCode [{$this->_identity->errorCode}]", CLogger::LEVEL_WARNING);
			return false;
		}
	}
}
