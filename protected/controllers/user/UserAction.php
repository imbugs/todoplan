<?php
class UserAction {
	/** 
	 * 根据id获取User信息 
	 */
	public function getUserById($id) {
		$user = null;
		$record = User::model()->findByPk($id);
		if ($record != null) {
			$user = $record->copy();
		}
        return $user;
	}
	/**
	 * 根据username获取User信息 
	 * @param string $username
	 */
	public function getUserByName($username) {
		$user = $this->getUserByAttributes(array('username' => $username));
        return $user;
	}
	
	/**
	 * 根据email获取User信息 
	 * @param string $email
	 */
	public function getUserByEmail($email) {
		$user = $this->getUserByAttributes(array('email' => $email));
        return $user;
	}

	/**
	 * 根据attributes获取User信息 
	 * @param array $array
	 */
	public function getUserByAttributes($array) {
		$user = null;
		$record = User::model()->findByAttributes($array);
		if ($record != null) {
			$user = $record->copy();
		}
        return $user;
	}
	
	/**
	 * 创建User
	 * @param mixed $userInfo
	 * $userInfo->username
	 * $userInfo->email
	 * $userInfo->password
	 */
	public function createUser($userInfo)
	{
		$user = new User;
		$result = new stdClass();
		$result->success = false;
		
		if (isset($userInfo) 
			&& isset($userInfo->username) 
			&& isset($userInfo->email) 
			&& isset($userInfo->password) ) {
			$user->username = $userInfo->username;
			$user->email = $userInfo->email;
			// md5加密
			$user->password = md5($userInfo->password);
		} else {
			$result->error_msg = "invalid user infomation.";
			return $result;
		}
		$user->status = UserConstant::STATUS_INIT; // 初始用户状态
		$user->login_type = UserConstant::TYPE_LOCAL; // 本地注册
		$user->gmt_update = new CDbExpression('now()');
		$user->gmt_create = new CDbExpression('now()');
		
		if ($user->save()) {
			$result->success = true;
			$result->error_msg = "";
			if ($user->status == UserConstant::STATUS_TOVALID) {
				$this->sendVerifyMail($user);
			}
		} else {
			$result->error_msg = $taskList->error_msg;
		}
		return $result;
	}
	
	// 发送验证Email
	public function sendVerifyMail($user) {
		$mail = VerifyMail::newRecord($user, UserConstant::VERIFY_VALID);
		if (!isset($mail)) {
			return false;
		}
		$subject = "TodoPlan账号激活";
		$url = Yii::app()->createAbsoluteUrl('user/verify',array('emailActivationKey'=>$mail->code));
		
		$body = "感谢您注册TodoPlan网!<br/>
		请马上打开以下链接，激活您的账号！<br/>
		$url <br/>
		请将该网址复制并粘贴至新的浏览器窗口中。<br/>
		本邮件为系统自动发送，不需要回复";
		
		$result = EmailUtils::sendYiiMail($mail->email, $subject, $body);
		return $result;
	}
	
	// 发送重置密码Email
	public function sendResetMail($user) {
		$mail = VerifyMail::newRecord($user, UserConstant::VERIFY_RESET);
		$subject = "TodoPlan账号密码找回";
		$body = "http://xxxtest, 自动找回"; 
		EmailUtils::sendYiiMail($to, $subject, $body);
	}
	
	public function doVerifyMail($user, $code) {
		// 删除过期数据
		VerifyMail::deleteExpired();
		$attributes  =array('username' => $user->username, 'email' => $user->email, 'code' => $code);
		$count = VerifyMail::model()->deleteAllByAttributes($attributes);
		if ($count > 0) {
			// 更新用户状态
			$record = User::model()->findByAttributes(array('username' => $user->username, 'email' => $user->email));
			if ($record != null) {
				$record->status = UserConstant::STATUS_ACTIVE;
				if ($record->save()) {
					return true;
				}
			}
			return false;
		} else {
			return false;
		}
	} 
}
