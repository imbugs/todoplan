<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<!-- APP CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/dist/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/dist/bootstrap/css/bootstrap-responsive.min.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/dist/pnotify/css/jquery.pnotify.default.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/dist/app/css/wunderlist.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/dist/app/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/dist/app/css/print.css" media="print" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/dist/app/css/main.css"/>
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/dist/app/css/ie.css" media="screen, projection" />
	<![endif]-->

	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/dist/jquery/1.8.3/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/dist/jquery-ui/ui/jquery.ui.core.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/dist/jquery-ui/ui/jquery.ui.widget.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/dist/jquery-ui/ui/jquery.ui.mouse.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/dist/jquery-ui/ui/jquery.ui.sortable.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/dist/jquery-ui/ui/jquery.ui.draggable.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/dist/jquery-ui/ui/jquery.ui.droppable.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/dist/bootstrap/js/bootstrap.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/dist/keybind/jquery.keybind.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/dist/tmpl/jquery.tmpl.min.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/dist/expanding/expanding.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/dist/jquery.nicescroll/jquery.nicescroll.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/dist/pnotify/js/jquery.pnotify.js"></script>
	
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/dist/app/js/jquery.yiiactiveform.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/dist/app/js/tp.core.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/dist/app/js/tp.inputeditor.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/dist/app/js/tp.item.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/dist/app/js/tp.list.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/dist/app/js/tp.app.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/dist/app/js/tp.scroll.patch.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/dist/app/js/tp.init.js"></script>
	
	<script type="text/javascript">
	<!--
	//-->
	</script>
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
</body>
</html>
