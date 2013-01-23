<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<meta name="application-name" content="TodoPlan">
	<meta name="description" content="在线任务管理">
	<meta name="keywords" content="任务管理,task,manager,todo,plan,list">
	<link rel="canonical" href="http://<?php echo Yii::app()->request->getServerName();?>">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/dist/app/tp-main.css"/>
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/dist/app/css/ie.css" media="screen, projection" />
	<![endif]-->
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/dist/app/tp-all.js"></script>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
	<div class="container" id="wrapper">
		<?php echo $content; ?>
	</div>
	<!-- page -->
	<div id="footer">
		<p class="muted pagination-centered">
			Copyright &copy;
			<?php echo date('Y'); ?>
			by <a href="mailto:<?php echo Yii::app()->params->adminEmail;?>" target="_blank">TodoPlan</a>, All Rights Reserved. <br />
		</p>
	</div>
	<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-37882850-1']);
	_gaq.push(['_trackPageview']);
	
	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
	</script>
</body>
</html>
