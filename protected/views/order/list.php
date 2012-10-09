<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/pageOrderList.js"></script>

<script>
	$(function(){
		datagrid = new DatabaseGrid("<?php echo $this->createUrl('/order/jsonlist'); ?>",
			"<?php echo $this->createUrl('/order/update/'); ?>");
	});
</script>

<a class="btn btn-large btn-magenta" id="add" href="<?php echo $this->createUrl('/order/create'); ?>">
    Оформить заказ
</a>

<form class="form pull-right">
    <div class="input-append">
	    <input type="text" id="filter" class="span2">
	    <button type="button" class="btn disabled">Поиск</button>
    </div>
</form>

<div id="tablecontent"></div>
<div class="pagination pagination-centered">
	<ul id="paginator">
	</ul>
</div>
