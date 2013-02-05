<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - 登录';
?>

<style>
</style>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
	<div class="login-form">
		<div class="logo">
			<a href="<?php echo Yii::app()->homeUrl;?>">
				<img src="<?php echo Config::getInstance()->biglogo;?>"/>
			</a>
		</div>
		<h2>登录</h2>
		<div class="warning">
			<?php echo $form->error($model,'errorMsg', array('class' => 'alert alert-error')); ?>
		</div>
		<div class="input-prepend">
			<span class="add-on"><i class="icon-user"></i></span>
			<input placeholder="用户名" name="LoginForm[username]" id="LoginForm_username" type="text" maxlength="12" value="" class="error" required>
	    </div>
	    <div class="input-prepend">
			<span class="add-on"><i class="icon-lock"></i></span>
			<input placeholder="密码" name="LoginForm[password]" id="LoginForm_password" type="password" value="" class="error" required>
	    </div>
	    <div class="rememberMe">
	    	<label class="checkbox">
	    		<?php echo $form->checkBox($model,'rememberMe'); ?>
	    		下次自动登录
	    		<span style="margin-left: 50px;">
					<a href="<?php echo Config::getUrl('forgetUrl');?>" class="default">忘记密码？</a>
				</span>
		    </label>
		</div>
		<div class="submit">
			<?php echo CHtml::submitButton('登录', array("class"=>"btn btn-info")); ?>
			<span style="margin-left: 20px;">
				还没有账号？<a href="<?php echo Config::getUrl('signupUrl');?>" class="default">立即注册</a>！
			</span>
		</div>
		<div class="third-login" style="margin-top: 20px;">
			<span>使用第三方账号登录:</span>
			
			<div>
				<a href="<?php echo $openApi->wbUrl;?>" class="default">新浪微博</a>
				QQ
			</div>
		</div>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
