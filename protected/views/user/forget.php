<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - 忘记密码';
?>

<style>
</style>
<div class="form">
	<div class="login-form">
		<div class="logo">
			<img src="<?php echo Config::getInstance()->biglogo;?>"/>
		</div>
		<h2>忘记密码</h2>
	    <div class="input-prepend">
			<span class="add-on"><i class="icon-envelope"></i></span>
			<input placeholder="电子邮件地址" type="email" required>
	    </div>
	    <div class="submit">
			<?php echo CHtml::submitButton('找回密码', array("class"=>"btn btn-info")); ?>
			<span style="margin-left: 20px;">
				我有密码，<a href="<?php echo Config::getUrl('loginUrl');?>" class="default" >直接登录</a>»
			</span>
		</div>
	</div>
</div><!-- form -->
