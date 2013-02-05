<?php
class ChangeEmailAction extends CAction {
	public function run() {
		$result = new stdClass();
		$result->success = false;
		
		$userId = Session::userId();
		$email = Yii::app()->getRequest()->getParam("email", "");

		if (StringUtils::isEmpty($userId) ||StringUtils::isEmpty($email, true)) {
			$result->error_msg = "变更邮箱地址失败.";
			echo json_encode($result);
			Yii::app()->end();
		}
		if(filter_var($email,FILTER_VALIDATE_EMAIL) === false) {
			$result->error_msg = "电子邮件不合法";
			echo json_encode($result);
			Yii::app()->end();
		}
		$user = User::model()->findByAttributes(array('id' => $userId));
		if($user === null) {
			$result->error_msg = "用户不存在.";
        } else if($user->status === UserConstant::STATUS_ACTIVE) {
            $result->error_msg = "无法变更已激活的邮箱.";
        } else {
        	$userAction = new UserAction();
        	$check = $userAction->getUserByEmail($email);
			if ($check != null) {
				$result->error_msg = "该电子邮件地址不可用";
				echo json_encode($result);
				Yii::app()->end();
			}
        	$user->email = $email;
        	$user->status === UserConstant::STATUS_TOVALID;
        	$user->gmt_update = new CDbExpression('now()');
        	if ($user->save()) {
        		// 从数据库刷新Session中的UserInfo信息
        		Yii::app()->user->userinfo = null;
        		Session::userInfo();
	            $result->success = true;
    	        $result->error_msg = "邮箱地址更新成功.";
        	} else {
        		$result->error_msg = "更新邮箱时发生异常.";
        	}
        }
        if ($result->success) {
        	Yii::log("change email [{$user->username}]", CLogger::LEVEL_INFO);
        } else {
        	Yii::log("change email failed [{$user->username}]", CLogger::LEVEL_WARNING);
        }
		echo json_encode($result);
	}
}