<?php  
/*$length = ob_get_length();
$filename = '/home/andrey/yii/vdc/protected/views/layouts/main.php';
$last_modified = date ("F d Y H:i:s", filemtime($filename));//, getlastmod());                                                                                    
header("Content-Length: $length");                                                                                                      
header("Last-Modified: $last_modified GMT time");*/      
?>
<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->

	
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css" rel="stylesheet"/>
	<!-- <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-responsive.css" rel="stylesheet"> -->
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" rel="stylesheet"/>

	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/editablegrid.min.js"></script>
	<!-- <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/live.js"></script>
 -->
	<title>ВДЦ<?php // echo CHtml::encode($this->pageTitle); ?></title>
</head>

<script>
$(function(){
	//$('.dropdown-toggle').dropdown();
	$('select').addClass('shadow_select');
	//$('select').wrap('<span class="select-wrapper" />');
	//$('.select-wrapper').width($(this).width());

	/*$('select').focusin(function() {
		$('.select-wrapper').addClass('webkit_specific');
	});

	$('select').focusout(function() {
		$('.select-wrapper').removeClass('webkit_specific');
	});*/
});
</script>

<body>

	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="brand" href="#">все для вас</a>
				<ul class="nav">
					<li class="active"><a href="<?php echo $this->createUrl('/order/list'); ?>">Заказы</a></li>
					<li><a href="#">Настройки</a></li>
					<li><a href="#">Дизайнеры</a></li>
					<li><a href="#">Пользователи</a></li>
					<li class="dropdown">
						<a class="dropdown-toggle" id="dLabel" role="button" data-toggle="dropdown" href="#">
							Скачать <b class="caret"></b>
						</a>
						<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
							<li><a href="#"><i class="icon-file"></i> Инструкция</a></li>
							<li><a href="#"><i class="icon-file"></i> Прайс</a></li>
							<li><a href="#"><i class="icon-file"></i> Описание принципа работы ЕДЦ</a></li>
							<li><a href="#"><i class="icon-plus"></i> Создать ссылку на документ</a></li>
						</ul>
					</li>
					<li><a href="<?php echo $this->createUrl('/site/page', array('view'=>'about')); ?>">Контакты ВДЦ</a></li>
				</ul>
				<ul id="logout" class="nav pull-right">
					<?php if(!Yii::app()->user->isGuest){ ?>
					<li class="dropdown">
						<div class="btn-group">
						<a class="btn dropdown-toggle" id="status" role="button" data-toggle="dropdown" href="#">
							<i class="icon-ok"></i> <?php echo User2::model()->with('profile')->findByPk(Yii::app()->user->id)->profile->lastname ?> <b class="caret"></b>
						</a>
						<ul class="dropdown-menu" role="menu" aria-labelledby="status">
							<li><a href="#"><i class="icon-ok"></i> Свободен</a></li>
							<li><a href="#"><i class="icon-off"></i> Занят</a></li>
						</ul>
						</div>
					</li>
					<li><a href="<?php echo $this->createUrl('/site/logout'); ?>">
						<!-- <?php echo 'Выход' /* ('.Yii::app()->user->name.')'*/ ?> -->
						Выход
						</a>
					</li>
					
					<?php }else{ ?>
					<li><a href="<?php echo $this->createUrl('/site/login'); ?>">Вход</a></li>
					<?php } ?>

				</ul>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>

	<div id="container" class="container">
		<?php echo $content; ?>
	</div><!-- container -->

	<div class="clearfix"></div>

	<!-- <div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> Всё для Вас<br/>
		All Rights Reserved.
	</div><!-- footer -->
</body>
</html>
