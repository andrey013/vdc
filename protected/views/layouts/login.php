
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->

	
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css" rel="stylesheet"/>
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" rel="stylesheet"/>

	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js"></script>
	<title>Вход в систему</title>
</head>
<body>
	<div id="loginForm" class="loginForm">
		<?php echo $content; ?>
	</div><!-- loginForm -->
</body>
</html>
