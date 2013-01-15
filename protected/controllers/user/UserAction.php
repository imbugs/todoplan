<?php
class UserAction {
	/**
	 * 根据username获取User信息 
	 * @param string $username
	 */
	public function getUser($username) {
		$record = User::model()->findByAttributes(array('username' => $username));
        return $record;
	}
	/**
	 * 创建User
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
			$result->error_msg = "no user infomation.";
			return $result;
		}
		$user->status = "tovalid"; // 等待email验证
		$user->login_type = 'local'; // 本地注册
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
