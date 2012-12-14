<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/commonDatabaseGrid.js"></script>

<script>
	$(function(){
		datagrid = new DatabaseGrid({
			fetchUrl: "<?php echo $this->createUrl('/orderStatus/jsonlist'); ?>",
			updateUrl: "<?php echo $this->createUrl('/orderStatus/jsonupdate'); ?>",
			init:
				function(grid){
					grid.setCellRenderer("name", new CellRenderer({render: function(cell, value) {
						var rowId = grid.getRowId(cell.rowIndex);
						var column = this.column;
						var displayValue = value;
						$("<span>").append(displayValue).addClass("dotted").appendTo(cell);
					}}));
					grid.setCellRenderer("sort_order", new CellRenderer({render: function(cell, value) {
						var rowId = grid.getRowId(cell.rowIndex);
						var column = this.column;
						var displayValue = value;
						$("<span>").append(displayValue).addClass("dotted").appendTo(cell);
					}}));
					grid.setCellRenderer("key", new CellRenderer({render: function(cell, value) {
						var rowId = grid.getRowId(cell.rowIndex);
						$("#order_"+rowId).addClass("row-"+value);
						var displayValue = value;
						$("<span>").append(displayValue).appendTo(cell);
					}}));
				}
		});
		
	});
</script>

<h1>Статусы заказа</h1>

<form class="form pull-right">
    <div class="input-append span">
	    <input type="search" id="filter" class="span2" autofocus>
	    <!-- <button type="button" class="btn"><i class="icon-remove"></i>&nbsp;</button> -->
	    <button type="button" class="btn disabled"><i class="icon-search"></i>&nbsp;</button>
    </div>
</form>
<div class="clearfix"> </div>
<div id="tablecontent"></div>
<div class="pagination pagination-centered">
	<ul id="paginator">
	</ul>
</div>

