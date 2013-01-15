<?php
class ChangePasswordAction extends CAction {
	public function run() {
		$result = new stdClass();
		$result->success = false;
		
		$username = Yii::app()->getRequest()->getParam("username", "");
		$currentPasswd = Yii::app()->getRequest()->getParam("currentPasswd", "");
		$newPasswd = Yii::app()->getRequest()->getParam("newPasswd", "");
		$veryfyPasswd = Yii::app()->getRequest()->getParam("verifyPasswd", "");
		if (StringUtils::isEmpty($username, true)) {
			$result->error_msg = "变更密码失败.";
			echo json_encode($result);
			Yii::app()->end();
		}
		
		if (StringUtils::isEmpty($currentPasswd, true) 
			|| StringUtils::isEmpty($newPasswd, true) 
			|| StringUtils::isEmpty($veryfyPasswd, true)) {
			$result->error_msg = "密码不可为空.";
			echo json_encode($result);
			Yii::app()->end();
		}
		
		if ($newPasswd !== $veryfyPasswd) {
			$result->error_msg = "新密码不一致.";
			echo json_encode($result);
			Yii::app()->end();
		}
		
		$user = User::model()->findByAttributes(array('username' => $username));
		if($user === null) {
			$result->error_msg = "用户不存在.{$username}";
        } else if($user->password !== md5($currentPasswd)) {
            $result->error_msg = "密码错误.";
        } else {
        	$user->password = md5($newPasswd);
        	if ($user->save()) {
	            $result->success = true;
    	        $result->error_msg = "密码更新成功.";
        	} else {
        		$result->error_msg = "更新密码时发生异常.";
        	}
        }
		echo json_encode($result);
	}
}