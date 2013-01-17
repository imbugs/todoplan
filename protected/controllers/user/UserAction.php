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
		} else {
			$result->error_msg = $taskList->error_msg;
		}
		return $result;
	}
}
