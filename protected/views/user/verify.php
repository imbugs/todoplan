<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - 邮箱验证';
?>

<style>
</style>
<div class="form">
	<div class="login-form">
		<div class="logo">
			<img src="<?php echo Config::getInstance()->biglogo;?>"/>
		</div>
		<h2>邮箱验证</h2>
		<p>
		已向 xxx#xx 发送验证邮件，
		打开邮件中的验证连接即可完成注册。
		</p>
	</div>
</div><!-- form -->
