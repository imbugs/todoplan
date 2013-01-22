<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="imagetoolbar" content="no" />
	<link rel="icon" type="image/x-icon" href="<?php echo Yii::app()->request->baseUrl; ?>/dist/app/images/logo/todoplan.ico" />
	<link rel="shortcut icon" type="image/x-icon"
		href="<?php echo Yii::app()->request->baseUrl; ?>/dist/app/images/logo/todoplan.ico" />
	<meta name="robots" content="noindex,nofollow" />
	<title>错误 404</title>
	<style>
	body {
		background: #f9fee8;
		margin: 0;
		padding: 20px;
		text-align: center;
		font-family: Arial, Helvetica, sans-serif;
		font-size: 14px;
		color: #666666;
	}
	
	.error_page {
		width: 600px;
		padding: 50px;
		margin: auto;
	}
	
	.error_page h1 {
		margin: 20px 0 0;
	}
	
	.error_page p {
		margin: 10px 0;
		padding: 0;
	}
	
	a {
		color: #9caa6d;
		text-decoration: none;
	}
	
	a:hover {
		color: #9caa6d;
		text-decoration: underline;
	}
	</style>
</head>

<body class="login">
	<div class="error_page">
		<img alt="todoplan-logo"
			src="<?php echo Yii::app()->request->baseUrl; ?>/dist/app/images/logo/todoplan-logo.png" />
		<h1>We're sorry...</h1>
		<p>您访问的页面没有找到.</p>
		<p>
			<a href="<?php echo Yii::app()->homeUrl;?>">返回主页</a>
		</p>
	</div>
</body>
</html>

