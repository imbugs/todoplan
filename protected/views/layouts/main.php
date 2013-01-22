<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/dist/app/tp-main.css"/>
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/dist/app/css/ie.css" media="screen, projection" />
	<![endif]-->
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	
	<style type="text/css">
	</style>
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
			by TodoPlan, All Rights Reserved.<br />
		</p>
	</div>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/dist/app/tp-all.js"></script>
	<script type="text/javascript">
	<!--
	//-->
	</script>
</body>
</html>
