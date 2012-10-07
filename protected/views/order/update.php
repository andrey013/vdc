<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/pageOrderUpdate.js"></script>

<script>
	$(function(){
		var status = $("#Order_orderStatus")
		$(".statusRadio").removeClass("active");
		$(".statusRadio[value="+status.val()+"]").addClass("active");
		datagrid = new DatabaseGrid("<?php echo $this->createUrl('/payment/jsonlist').'?id='.$model->id; ?>");
	});
</script>

<?php
$this->renderPartial('_form', array(
		'model' => $model));
?>