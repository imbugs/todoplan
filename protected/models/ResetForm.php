<?php
class ResetForm extends CFormModel {
	public $username;
	public $newPasswd;
	public $verifyPasswd;
	public $resetKey;
	public $success;

	private $userInfo;

	/**
	 * Declares the validation rules.
	 * The rules state that username and newPasswd are required,
	 * and newPasswd needs to be authenticated.
	 */
	public function rules() {
		return array(
			// username required
			array('username, newPasswd, verifyPasswd, resetKey', 'required'),
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
			'username'=>'用户名',
			'resetKey'=>'resetKey',
			'newPasswd'=>'新密码',
			'verifyPasswd'=>'确认密码'
		);
	}

	public function check($attribute,$params) {
		if($this->hasErrors()) {
			$errors = $this->getErrors();
			$error = array_shift($errors);
			$this->addError('errorMsg',$error[0]);
		} else {
			if ($this->newPasswd !== $this->verifyPasswd) {
				$this->addError('errorMsg',"新密码不一致");
			}
			$userAction = new UserAction;
			$this->userInfo = $userAction->getUserByName($this->username);
			if ($this->userInfo == null) {
				$this->addError('errorMsg',"该用户名不存在");
			}
		}
	}

	public function resetPassword() {
		$userInfo = new stdClass();
		$userInfo->password = $this->newPasswd;
		$userAction = new UserAction();
		$result = $userAction->doResetPasswd($userInfo, $this->resetKey);
		if (!$result) {
			Yii::log("reset password failed [{$this->username}]", CLogger::LEVEL_WARNING);
			$this->addError('errorMsg',"密码修改失败");
		} else {
			Yii::log("reset password [{$this->username}]", CLogger::LEVEL_INFO);
		}

		return $result;
	}
}
