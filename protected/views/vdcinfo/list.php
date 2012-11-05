<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/commonDatabaseGrid.js"></script>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/tinymce/jscripts/tiny_mce/tiny_mce.js" ></script>

<script>
	$(function(){
		tinyMCE.init({
		        mode : "textareas",
		        language : "ru",
		        body_class : "span10",
		        theme : "advanced",
		        theme_advanced_resizing : true,
		        onchange_callback : "myCustomOnChangeHandler",


		        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,sub,sup,fontsizeselect,|,forecolor,backcolor,|,justifyleft,justifycenter,justifyright,justifyfull",
		        theme_advanced_toolbar_location : "bottom",
		        setup : function(ed)
		        {
		            ed.onInit.add(function(ed)
		            {
		                ed.getDoc().body.style.fontSize = 14;
		            });
		        }
		});
	});
</script>

<!-- <h1>О ВДЦ</h1> -->

	<?php 
	$form = $this->beginWidget('GxActiveForm', array(
		'id' => 'vdcinfo-form',
		'htmlOptions'=>array(
			//'class'=>'form-horizontal',
			//'style'=>'margin-bottom: 0px',
		),
	));
	?>

		<button class="btn btn-large btn-magenta pull-right">Сохранить</button>
		<div class="clearfix"></div>
		<br>
		<!-- <input type="text" id="email" placeholder="Email"> -->
		<?php echo $form->textArea($model, 'vdc_info', array('class' => 'span10', 'style' => 'height: 500px')); ?>

		

		<!-- </form> -->
	<?php
		$this->endWidget();
	?>
</div>