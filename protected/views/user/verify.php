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
			<a href="<?php echo Yii::app()->homeUrl;?>">
				<img src="<?php echo Config::getInstance()->biglogo;?>"/>
			</a>
		</div>
		<h2>邮箱验证</h2>
		<?php if($model->redirect) { ?>
		<p id="show-div"></p>
		<script language="javascript">
		(function($, win) {
			win.autoJump = {
				secs : 5, //倒计时的秒数 
				loadUrl : function (url) {
					for(var i=this.secs;i>=0;i--) {
						var cmd = 'autoJump.doUpdate(' + i + ', "' + url + '")';
						window.setTimeout(cmd, (this.secs-i) * 1000); 
					}
				},
				doUpdate: function (num, url) {
					var text = '已完成邮箱校验<br/>将在' + num + '秒后自动跳转到 <a href="' + url + '" class="default">首页</a>';
					$('p#show-div').html(text); 
					if(num <= 0) { window.location.href=url;} 
				}
			};
			autoJump.loadUrl("<?php echo Yii::app()->homeUrl; ?>");
		})(jQuery, window);
		</script>
		<p>
		<?php } else { 
			if (isset($model->sendFail) && $model->sendFail) {
				echo "邮件发送失败，请稍后重试。";
			} else {
				echo "已向 {$model->email} 发送验证邮件<br>打开邮件中的验证连接即可完成注册。";
			}
		?>
		</p>
		<a href="<?php echo Config::getUrl('verifyUrl');?>&send=true" class="default">重新发送验证邮件</a>
		<?php }?>
	</div>
</div><!-- form -->
