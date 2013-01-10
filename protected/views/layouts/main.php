<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/dist/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/dist/bootstrap/css/bootstrap-responsive.min.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/dist/jquery/1.8.3/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/dist/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/dist/keybind/jquery.keybind.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/dist/tmpl/jquery.tmpl.min.js"></script>
	<script type="text/javascript" src="http://lab.cubiq.org/iscroll/src/iscroll.js"></script>

	<script type="text/javascript">
	<!--
	$(function() {
		// init method 
	});
	//-->
	</script>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	
	<style type="text/css">
	/* Sticky footer styles
	-------------------------------------------------- */
	html,body {
		height: 100%;
		/* The html and body elements cannot have any padding or margin. */
		background-color: #f5f5f5;
		overflow: hidden;
	}
	
	/* Wrapper for page content to push down footer */
	div#wrapper {
		min-height: 100%;
		height: 100%;
		margin: 0 auto -60px;
		background-color: white;
	}
	
	/* Set the fixed height of the footer here */
	#footer {
		position: absolute;
		height: 30px;
		line-height: 30px;
		bottom: 0;
		left:0;
		right:0;
		background-color: #f5f5f5;
	}
	
	/* Custom page CSS
	      -------------------------------------------------- */
	/* Not required for template or sticky footer method. */
	.container {
		margin: 20px 0;
	}
	
	.height100 {
		position: relative;
		min-height: 100%;
		max-height: 100%;
		height: 100%;
	}
	
	* html .height100 {
		height: 100%;
	}
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
</body>
</html>
