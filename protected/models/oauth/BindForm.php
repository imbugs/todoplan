<?php
// 绑定用户需要用户密码
class BindForm extends CFormModel {
	public $username;
	public $password;
	public $token;

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
			
			array('token', 'required'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels() {
		return array(
			'username'=>'用户名',
			'password'=>'密码',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params) {
		if(!$this->hasErrors()) {
			// 检查token
			if (!isset($_SESSION['token']['uid'])) {
				$this->addError('errorMsg','oauth uid错误.');
				return;
			}
			if ($this->token !== $_SESSION['token']['access_token']) {
				$this->addError('errorMsg','oauth token错误.');
				return;
			}
			// 检查用户名密码
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
	public function bind() {
		if($this->_identity===null) {
			$this->_identity=new UserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE) {
			// 先登录，否则无权限变更记录
			Yii::app()->user->login($this->_identity, 0);

			$userAction = new UserAction;
			$result = $userAction->bindOAuthInfo($this->username, UserConstant::TYPE_WEIBO, $_SESSION['token']['uid']);
			if ($result) {
				Yii::log("bind oauth success [{$this->username}]", CLogger::LEVEL_INFO);
			} else {
				Yii::log("bind oauth failed [{$this->username}], uid [{$_SESSION['token']['uid']}]", CLogger::LEVEL_WARNING);
				$this->addError('errorMsg', "绑定用户失败.");
			}
			return $result;
		} else {
			Yii::log("login failed [{$this->username}], errorCode [{$this->_identity->errorCode}]", CLogger::LEVEL_WARNING);
			return false;
		}
	}
}
