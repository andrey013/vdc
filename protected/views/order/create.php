<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/pageOrderCreate.js"></script>

<script>
	$(function(){
		'use strict';

		var status = $("#Order_orderStatusHist")
		$(".statusRadio").removeClass("active");
		$(".statusRadio[value="+status.val()+"]").addClass("active");
		var status = $("#Order_orderStatusHist")
		$(".statusRadio").bind('click', function(){
				status.val(this.value);
			});

	});
</script>

<?php
$this->renderPartial('_form', array(
		'model' => $model,
		'buttons' => 'create'));
?>