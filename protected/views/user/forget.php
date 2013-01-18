<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - 找回密码';
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
		<h2>找回密码</h2>
			<?php if (!$model->success) {?>
			<div class="warning">
				<?php echo $form->error($model,'errorMsg', array('class' => 'alert alert-error')); ?>
			</div>
	    	<span>输入你的用户名：</span>
		    <div class="input-prepend">
				<span class="add-on"><i class="icon-user"></i></span>
				<input placeholder="用户名" name="ForgetForm[username]" id="ForgetForm_username" type="text" maxlength="12" required>
		    </div>
		    <div class="submit">
		    	<input type="submit" class="btn btn-info" value="找回密码">
				<span style="margin-left: 20px;">
					我有密码，<a href="<?php echo Config::getUrl('loginUrl');?>" class="default" >直接登录</a>»
				</span>
			</div>
			<?php } else { ?>
			<p>
			已向 <?php echo $model->email; ?> 发送邮件<br>请打开邮件中的连接重置密码。
			</p>
			<?php }?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
