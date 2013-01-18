<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - 注册';
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
			<img src="<?php echo Config::getInstance()->biglogo;?>"/>
		</div>
		<h2>注册新用户</h2>
		<div class="warning">
			<?php echo $form->error($model,'errorMsg', array('class' => 'alert alert-error')); ?>
		</div>
		<div class="input-prepend">
			<span class="add-on"><i class="icon-user"></i></span>
			<input placeholder="用户名" name="SignupForm[username]" id="SignupForm_username" type="text" maxlength="12" required>
	    </div>
	    <div class="input-prepend">
			<span class="add-on"><i class="icon-envelope"></i></span>
			<input placeholder="电子邮件地址" name="SignupForm[email]" id="SignupForm_email" type="email" required>
	    </div>
	    <div class="input-prepend">
			<span class="add-on"><i class="icon-lock"></i></span>
			<input placeholder="密码" name="SignupForm[password]" id="SignupForm_password" type="password" required>
	    </div>
		<div class="submit" style="margin-top: 10px;">
			<?php echo CHtml::submitButton('立即注册', array("class"=>"btn btn-warning")); ?>
			<span style="margin-left: 20px;">
				已有帐号，<a href="<?php echo Config::getUrl('loginUrl');?>" class="default">直接登录</a>»
			</span>
		</div>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
