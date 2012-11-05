<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/commonDatabaseGrid.js"></script>

<script>
	$(function(){
		datagrid = new DatabaseGrid({
			fetchUrl: "<?php echo $this->createUrl('/designer/jsonlist'); ?>",
			updateUrl: "<?php echo $this->createUrl('/designer/jsonupdate/'); ?>",
			init:
				function(grid){
					var renderer = new CellRenderer({render: function(cell, value) {
						var rowId = grid.getRowId(cell.rowIndex);
						var arr = $.parseJSON(value);
						$("<span>").append(arr.length).addClass("dotted").appendTo(cell);
						var text = '';
						$.each(arr, function(index, value) {
							text += value.customerName;
							text += ', ' + value.order_type;
							text += ', ' + value.priority;
							text += ', ' + $("<span>").append('&nbsp; &nbsp;').addClass("row-"+value.status).wrap('<p>').parent().html();
							text += '<br>';
						})
						$(cell).find("span").tooltip({title:text, placement: 'right', html: true});
					}});
					grid.setCellRenderer("jsonprojects", renderer);
					grid.setCellRenderer("highpriorityjsonprojects", renderer);
				}
		});
		
	});
</script>

<!-- <h1>Дизайнеры</h1> -->

<form class="form pull-right">
    <div class="input-append span">
	    <input type="search" id="filter" class="span2" autofocus>
	    <button type="button" class="btn disabled"><i class="icon-search"></i>&nbsp;</button>
    </div>
</form>
<div class="clearfix"></div>
<div id="tablecontent"></div>
<div class="pagination pagination-centered">
	<ul id="paginator">
	</ul>
</div>