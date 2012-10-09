<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/pageOrderUpdate.js"></script>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/tinymce/jscripts/tiny_mce/tiny_mce.js" ></script >
<script type="text/javascript" >
tinyMCE.init({
        mode : "textareas",
        body_class : "span5",
        theme : "simple"   //(n.b. no trailing comma, this will be critical as you experiment later)
});
</script >


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
