<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - 重置密码';
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
		<h2>重置密码</h2>
		<div class="warning">
			<?php echo $form->error($model,'errorMsg', array('class' => 'alert alert-error')); ?>
		</div>
		<input name="ResetForm[username]" id="ResetForm_username" type="hidden" value="<?php echo $model->username;?>" >
		<input name="ResetForm[resetKey]" id="ResetForm_resetKey" type="hidden" value="<?php echo $model->resetKey;?>" >
	    <div class="input-prepend">
			<span class="add-on"><i class="icon-lock"></i></span>
			<input placeholder="新密码" name="ResetForm[newPasswd]" id="ResetForm_newPasswd" type="password" required>
	    </div>
	    <div class="input-prepend">
			<span class="add-on"><i class="icon-lock"></i></span>
			<input placeholder="确认密码" name="ResetForm[verifyPasswd]" id="ResetForm_verifyPasswd" type="password" required>
	    </div>
		<div class="submit" style="margin-top: 10px;">
			<?php echo CHtml::submitButton('重置密码', array("class"=>"btn btn-warning")); ?>
			<span style="margin-left: 20px;">
				我有密码，<a href="<?php echo Config::getUrl('loginUrl');?>" class="default">直接登录</a>»
			</span>
		</div>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
