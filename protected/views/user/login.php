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
		<h4>登录</h4>
		<div>
			<?php echo $form->error($model,'errorMsg', array('class' => 'alert alert-error')); ?>
		</div>
		<div class="input-prepend">
			<span class="add-on"><i class="icon-user"></i></span>
			<?php echo $form->textField($model,'username', array('placeholder' => '用户名')); ?>
	    </div>
	    <div class="input-prepend">
			<span class="add-on"><i class="icon-lock"></i></span>
			<?php echo $form->passwordField($model,'password', array('placeholder' => '密码')); ?>
	    </div>
	    <div class="rememberMe">
	    	<label class="checkbox">
	    		<?php echo $form->checkBox($model,'rememberMe'); ?>
	    		下次自动登录
		    </label>
		</div>
		<div class="submit">
			<?php echo CHtml::submitButton('登录', array("class"=>"btn btn-info")); ?>
			<span style="margin-left: 20px;">
				还没有账号？<a href="<?php echo Config::getUrl('signupUrl');?>" class="default">立即注册</a>！
			</span>
		</div>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
