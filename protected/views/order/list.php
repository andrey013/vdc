<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/pageOrderList.js"></script>

<script>
	$(function(){
		datagrid = new DatabaseGrid("<?php echo $this->createUrl('/order/jsonlist'); ?>");
	});
</script>

<a class="btn btn-large btn-success" id="add" href="<?php echo $this->createUrl('/order/create'); ?>">
    Оформить заказ
</a>

<div id="tablecontent"></div>
<div class="pagination pagination-centered">
	<ul id="paginator">
	</ul>
</div>
