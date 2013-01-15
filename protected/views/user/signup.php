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
		<h4>注册新用户</h4>
		<div>
			<?php echo $form->error($model,'errorMsg', array('class' => 'alert alert-error')); ?>
		</div>
		<div class="input-prepend">
			<span class="add-on"><i class="icon-user"></i></span>
			<?php echo $form->textField($model,'username', array('placeholder' => '用户名')); ?>
	    </div>
	    <div class="input-prepend">
			<span class="add-on"><i class="icon-envelope"></i></span>
			<?php echo $form->textField($model,'email', array('placeholder' => '电子邮件地址')); ?>
	    </div>
	    <div class="input-prepend">
			<span class="add-on"><i class="icon-lock"></i></span>
			<?php echo $form->passwordField($model,'password', array('placeholder' => '密码')); ?>
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
