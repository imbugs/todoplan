<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - 找回密码';
?>

<style>
</style>
<div class="form">
	<div class="login-form">
		<div class="logo">
			<img src="<?php echo Config::getInstance()->biglogo;?>"/>
		</div>
		<h2>找回密码</h2>
		<form action="">
	    	<span>输入你的用户名：</span>
		    <div class="input-prepend">
				<span class="add-on"><i class="icon-user"></i></span>
				<input placeholder="用户名" type="text" required>
		    </div>
		    <div class="submit">
		    	<input type="submit" class="btn btn-info" value="找回密码">
				<span style="margin-left: 20px;">
					我有密码，<a href="<?php echo Config::getUrl('loginUrl');?>" class="default" >直接登录</a>»
				</span>
			</div>
		</form>
	</div>
</div><!-- form -->
