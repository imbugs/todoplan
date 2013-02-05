<?php
$this->pageTitle=Yii::app()->name . ' - 创建(绑定)用户';
?>

<style>
.login-form li.active {
	font-weight: bold;
}
</style>
<div class="form">
	<div class="login-form">
		<div class="logo">
			<a href="<?php echo Yii::app()->homeUrl;?>">
				<img src="<?php echo Config::getInstance()->biglogo;?>"/>
			</a>
		</div>
		<div class="tabable">
			<ul class="nav nav-tabs">
				<li class="<?php echo $model->activeTabs['CreateForm'];?>"><a href="#create-user" data-toggle="tab">创建新用户</a></li>
				<li class="<?php echo $model->activeTabs['BindForm'];?>"><a href="#bind-user" data-toggle="tab">绑定已有用户</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane <?php echo $model->activeTabs['CreateForm'];?>" id="create-user">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'oauth-create-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
					<div class="warning">
						<?php echo $form->error($model->createForm,'errorMsg', array('class' => 'alert alert-error')); ?>
					</div>
					<div class="input-prepend">
						<span class="add-on"><i class="icon-user"></i></span>
						<input placeholder="用户名" name="CreateForm[username]" id="CreateForm_username" type="text" maxlength="12" required>
				    </div>
				    <div class="input-prepend">
						<span class="add-on"><i class="icon-envelope"></i></span>
						<input placeholder="电子邮件地址" name="CreateForm[email]" id="CreateForm_email" type="email" required>
				    </div>
					<div class="submit" style="margin-top: 10px;">
						<input name="CreateForm[token]" id="CreateForm_token" type="hidden" value="<?php echo $token['access_token']?>">
						<?php echo CHtml::submitButton('立即创建', array("class"=>"btn btn-warning")); ?>
					</div>
<?php $this->endWidget(); ?>
				</div>
				<div class="tab-pane <?php echo $model->activeTabs['BindForm'];?>" id="bind-user">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'oauth-bind-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
					<div class="warning">
						<?php echo $form->error($model->bindForm,'errorMsg', array('class' => 'alert alert-error')); ?>
					</div>
					<div class="input-prepend">
						<span class="add-on"><i class="icon-user"></i></span>
						<input placeholder="用户名" name="BindForm[username]" id="BindForm_username" type="text" maxlength="12" required>
				    </div>
				    <div class="input-prepend">
						<span class="add-on"><i class="icon-lock"></i></span>
						<input placeholder="密码" name="BindForm[password]" id="BindForm_password" type="password" value="" class="error" required>
				    </div>
					<div class="submit" style="margin-top: 10px;">
						<input name="BindForm[token]" id="BindForm_token" type="hidden" value="<?php echo $token['access_token']?>">
						<?php echo CHtml::submitButton('立即绑定', array("class"=>"btn btn-info")); ?>
					</div>
<?php $this->endWidget(); ?>
				</div>
			</div>
		</div>
	</div>
</div><!-- form -->
