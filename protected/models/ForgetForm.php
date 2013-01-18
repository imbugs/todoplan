<?php
class ForgetForm extends CFormModel {
	public $username;
	public $email;
	public $success;

	private $userInfo;
	
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
			// 检查用户名
			array('username', 'check'),
		);
	}
	
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels() {
		return array(
			'username'=>'用户名'
		);
	}

	public function check($attribute,$params) {
		if($this->hasErrors()) {
			$errors = $this->getErrors();
			$error = array_shift($errors);
			$this->addError('errorMsg',$error[0]);
		} else {
			$userAction = new UserAction;
			$this->userInfo = $userAction->getUserByName($this->username);
			if ($this->userInfo == null) {
				$this->addError('errorMsg',"该用户名不存在");
			}
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function sendResetEmail() {
		$userAction = new UserAction();
		$result = $userAction->sendResetMail($this->userInfo);
		$this->email = StringUtils::maskEmail($this->userInfo->email, '*');
		$this->success = $result;
	}
}
