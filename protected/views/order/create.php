<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/pageOrderCreate.js"></script>

<script>
	$(function(){
		var status = $("#Order_orderStatus")
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