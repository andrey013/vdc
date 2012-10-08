<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/pageOrderUpdate.js"></script>

<script>
	$(function(){
		var status = $("#Order_orderStatus")
		$(".statusRadio").removeClass("active");
		$(".statusRadio[value="+status.val()+"]").addClass("active");
		var link = "<?php echo $this->createUrl('/payment/jsonlist').'?id='.$model->id; ?>";
		var addlink = "<?php echo $this->createUrl('/payment/add'); ?>";
		var updatelink = "<?php echo $this->createUrl('/payment/jsonupdate'); ?>";
		var datagrid = new DatabaseGrid(link, addlink, updatelink);
		$("#addpayment").on("click", function(){
				$.ajax({
					url: '<?php echo $this->createUrl('/payment/create'); ?>',
					type: 'POST',
					dataType: "html",
					data: {
						id: <?php echo $model->id; ?>			
					},
					success: function (response) 
					{ 
					    datagrid.editableGrid.loadJSON(link);
					},
					error: function(XMLHttpRequest, textStatus, exception) { alert("Ошибка! \n" + errortext); },
					async: true
				});
			});
	});
</script>

<?php
$this->renderPartial('_form', array(
		'model' => $model));
?>
