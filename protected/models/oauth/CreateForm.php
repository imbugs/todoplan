<?php
class CreateForm extends CFormModel {
	public $username;
	public $email;
	public $token;
	
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
			// email
			array('email', 'required'),
			
			array('username', 'check'),
			
			array('token', 'required'),
		);
	}
	
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels() {
		return array(
			'username'=>'用户名',
			'email'=>'电子邮件'
		);
	}

	public function check($attribute,$params) {
		if($this->hasErrors()) {
			$errors = $this->getErrors();
			$error = array_shift($errors);
			$this->addError('errorMsg',$error[0]);
		} else {
			// 检查token
			if (!isset($_SESSION['token']['uid'])) {
				$this->addError('errorMsg','oauth uid错误.');
				return;
			}
			if ($this->token !== $_SESSION['token']['access_token']) {
				$this->addError('errorMsg','oauth token错误.');
				return;
			}
			
			if(filter_var($this->email,FILTER_VALIDATE_EMAIL) === false) {
				$this->addError('errorMsg',"电子邮件不合法");
				return;
			}
			
			// 删除没有认证的，以防乱注册
			User::deleteUnverify();
			$userAction = new UserAction;
			$result = $userAction->getUserByName($this->username);
			if ($result != null) {
				$this->addError('errorMsg',"该用户名不可用");
			}
			$result = $userAction->getUserByEmail($this->email);
			if ($result != null) {
				$this->addError('errorMsg',"该电子邮件地址不可用");
			}
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function execute() {
		$userAction = new UserAction;
		$result = $userAction->createOauthUser($this, UserConstant::TYPE_WEIBO, $_SESSION['token']['uid']);
		$autoLogin = false;
		if ($result->success) {
			if($this->_identity===null) {
				$this->_identity=new UserIdentity($this->username,'');
				$this->_identity->oauthLogin();
				if($this->_identity->errorCode===UserIdentity::ERROR_NONE) {
					// auto login after signup
					$autoLogin = Yii::app()->user->login($this->_identity, 0);
				}
			}
		}
		if (!$autoLogin) {
			// logout if already login not login auto
			Session::logout();
		}
		return $result->success;
	}
}
