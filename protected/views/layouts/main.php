<?php  
/*$length = ob_get_length();
$filename = '/home/andrey/yii/vdc/protected/views/layouts/main.php';
$last_modified = date ("F d Y H:i:s", filemtime($filename));//, getlastmod());                                                                                    
header("Content-Length: $length");                                                                                                      
header("Last-Modified: $last_modified GMT time");*/   

$upload_handler = new UploadHandler(array(
				'script_url' => $this->createUrl('/document/json').'/',
           		        'upload_dir' => dirname($_SERVER['SCRIPT_FILENAME']).'/files/documents/',
            	                'upload_url' => Yii::app()->request->baseUrl.'/files/documents/',
            	                'id' => 't',
            	                'stage' => 't'
			), false);
$res = $upload_handler->get_file_objects();

$files = array();
foreach ($res as $key => $value) {
	$ts = Document::model()->findAll('filename = :filename and disabled = 0', array(':filename' => $value->filename));
	
	if(!isset($ts[0])){
		$t = new Document;
		$t->name = ' ';
		$t->filename = $value->filename;
		$t->url = $value->url;
		$t->admin = 0;
		$t->designer = 0;
		$t->manager = 0;
		$t->disabled = 0;
		$files[] = $t;
	}else{
		$ts[0]->url = $value->url;
		$files[] = $ts[0];
	}
}

$role_id = User2::model()->with('profile')->findByPk(Yii::app()->user->id)->role_id;

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
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/daterangepicker.css" rel="stylesheet"/>
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

	$("#buttonfree").on("click", function(){
		$.ajax({
			type: "POST",
			url: "<?php echo $this->createUrl('/vdcuser/statusChange'); ?>",
			data: { status: "free"}
		}).done(function( msg ) {
			$("#userstatus").removeClass("btn-danger").addClass("btn-success")
			.find("i").removeClass("icon-off").addClass("icon-ok");
		});
	});
	$("#buttonbusy").on("click", function(){
		$.ajax({
			type: "POST",
			url: "<?php echo $this->createUrl('/vdcuser/statusChange'); ?>",
			data: { status: "busy"}
		}).done(function( msg ) {
			$("#userstatus").removeClass("btn-success").addClass("btn-danger")
			.find("i").removeClass("icon-ok").addClass("icon-off");
		});
	});

	<?php if(User2::model()->with('profile')->findByPk(Yii::app()->user->id)->profile->user_status_id==0){ ?>
		$("#userstatus").removeClass("btn-success").addClass("btn-danger")
		.find("i").removeClass("icon-ok").addClass("icon-off");
	<?php } ?>

	//$('.dropdown-toggle').dropdown();
	//$('select').addClass('shadow_select');
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
	<?php if(!Yii::app()->user->isGuest){ ?>
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="brand" href="<?php echo $this->createUrl('/order/list'); ?>">все для вас</a>
				<ul class="nav">
					<li <?php if($this->getRoute()=='order/list'){ ?>class="active"<? } ?>><a href="<?php echo $this->createUrl('/order/list'); ?>">Заказы</a></li>
					<?php if($role_id=='Admin'){ ?>
					<li <?php if($this->getRoute()=='designer/list'){ ?>class="active"<? } ?>><a href="<?php echo $this->createUrl('/designer/list'); ?>">Дизайнеры</a></li>
					<?php } ?>
					<!-- <li><a href="#">Пользователи</a></li> -->
					<li class="dropdown">
						<a class="dropdown-toggle" id="dLabel" role="button" data-toggle="dropdown" href="#">
							Скачать <b class="caret"></b>
						</a>
						<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
							<?php foreach ($files as $key => $value) {
								if($role_id=='Admin'&&$value->admin
								|| $role_id=='Designer'&&$value->designer
								|| $role_id=='Manager'&&$value->manager){ ?>
									<li><a href="<?php echo $value->url; ?>"><i class="icon-file"></i> <?php echo $value->name; ?></a></li>
							<?php }} ?>
						</ul>
					</li>
					<li <?php if($this->getRoute()=='site/page'){ ?>class="active"<? } ?>><a href="<?php echo $this->createUrl('/site/page', array('view'=>'about')); ?>">Контакты ВДЦ</a></li>
				</ul>
				<ul id="logout" class="nav pull-right">
					<?php if($role_id=='Designer'){ ?>
					<li class="dropdown">
						<div class="btn-group">
						<a class="btn btn-success dropdown-toggle" id="userstatus" role="button" data-toggle="dropdown" href="#">
							<i class="icon-ok"></i> <?php echo User2::model()->with('profile')->findByPk(Yii::app()->user->id)->profile->lastname ?> <b class="caret"></b>
						</a>
						<ul class="dropdown-menu" role="menu" aria-labelledby="userstatus">
							<li><a id='buttonfree' href="#"><i class="icon-ok"></i> Свободен</a></li>
							<li><a id='buttonbusy' href="#"><i class="icon-off"></i> Занят</a></li>
						</ul>
						</div>
					</li>
					<?php } ?>
					<li class="divider-vertical"></li>
					<?php if($role_id=='Admin'){ ?>
					<li <?php if(in_array($this->getRoute(),
										  array('vdcuser/list',
										  		'client/list',
										  		'difficulty/list',
										  		'orderType/list',
										  		'priority/list',
										  		'measureUnit/list',
										  		'price/list',
										  		'vdcinfo/update',
										  		'document/list',
										  		'mailer/list',
										  		'orderStatus/list'
										  		)))
								{ ?>class="active"<? } ?>>
						<a href="<?php echo $this->createUrl('/client/list'); ?>">Настройки</a>
					</li>
					<?php } ?>
					<li><a href="<?php echo $this->createUrl('/site/logout'); ?>">
						<!-- <?php echo 'Выход' /* ('.Yii::app()->user->name.')'*/ ?> -->
						Выход
						</a>
					</li>
					
					<!-- <li <?php if($this->getRoute()=='site/login'){ ?>class="active"<? } ?>><a href="<?php echo $this->createUrl('/site/login'); ?>">Вход</a></li> -->
					

				</ul>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	<?php } ?>
	<div id="container" class="container">
		<?php echo $content; ?>
	</div><!-- container -->

	<div class="clearfix"></div>
	<?php //echo $this->getRoute(); ?>
	<!-- <div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> Всё для Вас<br/>
		All Rights Reserved.
	</div><!-- footer -->
</body>
</html>
