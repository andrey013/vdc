<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/commonDatabaseGrid.js"></script>

<script>
	$(function(){
		datagrid = new DatabaseGrid("<?php echo $this->createUrl('/vdcuser/jsonlist'); ?>",
			"<?php echo $this->createUrl('/vdcuser/update/'); ?>",
			"<?php echo $this->createUrl('/vdcuser/jsonupdate/'); ?>");
	});
</script>

<button class="btn btn-large btn-magenta" id="add">
    Создать
</button>

<form class="form pull-right">
    <div class="input-append span">
	    <input type="text" id="filter" class="span2">
	    <button type="button" class="btn disabled"><i class="icon-search"></i>&nbsp;</button>
    </div>
</form>

<div id="tablecontent"></div>
<div class="pagination pagination-centered">
	<ul id="paginator">
	</ul>
</div>
