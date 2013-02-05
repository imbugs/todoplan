<?php
Yii::import("ext.wbsdk.SaetV2Ex", true);

class OauthController extends Controller
{
	public function filters() {
		return array(
            'accessControl',
        );
	}
	
	public function accessRules() {
        return array(
			array('allow',
				'users'=>array('*')
			)
        );
    }
	
    public function doCreate() {
    	$model = new stdClass();
		$model->activeTabs = array('CreateForm' => 'active', 'BindForm' => '');
		$model->createForm = new CreateForm;
		$model->bindForm = new BindForm;
		
    	// collect user input data
		if(isset($_POST['CreateForm']) || isset($_POST['BindForm'])) {
			if(isset($_POST['CreateForm'])) {
				$model->createForm->attributes=$_POST['CreateForm'];
				// validate user input and redirect to the previous page if valid
				if($model->createForm->validate()) {
					if ($model->createForm->execute()) {
						$this->redirect(Yii::app()->homeUrl);
					}
				}
			}
			
			if(isset($_POST['BindForm'])) {
				$model->activeTabs['CreateForm'] = '';
				$model->activeTabs['BindForm'] = 'active';
				
				$model->bindForm->attributes=$_POST['BindForm'];
				// validate user input and redirect to the previous page if valid
				if($model->bindForm->validate()) {
					if ($model->bindForm->bind()) {
						$this->redirect(Yii::app()->homeUrl);
					}
				}
			}
			// 失败后重新尝试
			$this->render('create', array('model' => $model, 'token' => $_SESSION['token']));
			Yii::app()->end();
		}
		return $model;
    }
    
	public function actionWeibo() {
		$model = $this->doCreate();

		$code = Yii::app()->getRequest()->getParam("code", NULL);
		if (isset($code)) {
			$keys = array();
			$keys['code'] = $code;
			$keys['redirect_uri'] = WB_CALLBACK_URL;
			$oAuth = new SaeTOAuthV2( WB_AKEY , WB_SKEY );
			$token = null;
			try {
				$token = $oAuth->getAccessToken( 'code', $keys );
			} catch (OAuthException $e) {
				$token = isset($_SESSION['token']) ? $_SESSION['token'] : null; 
			}
			
			if (isset($token)) {
				// oauth sucess
				$_SESSION['token'] = $token;
				setcookie( 'weibojs_' . $oAuth->client_id, http_build_query($token) );
				
				// 检查Weibo用户是否已存在
				$userAction = new UserAction;
				$userInfo = $userAction->getUserByLoginType(UserConstant::TYPE_WEIBO, $token['uid']);
				if(isset($userInfo)){
					$identity = new UserIdentity($userInfo->username, '');
					$identity->oauthLogin();
					Yii::app()->user->login($identity, 0);
					// 直接登录
					$this->redirect(Yii::app()->homeUrl);
				} else {
					// 绑定/创建页面
					$this->render('create', array('model' => $model, 'token' => $token));
				}
			} else {
				echo "微薄验证失败";
			}
		}
	}
}