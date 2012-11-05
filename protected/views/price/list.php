<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/commonDatabaseGrid.js"></script>

<script>
	$(function(){
		datagrid = new DatabaseGrid({
			fetchUrl: "<?php echo $this->createUrl('/price/jsonlist'); ?>",
			updateUrl: "<?php echo $this->createUrl('/price/jsonupdate/'); ?>",
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
					//grid.setCellRenderer("jsonprojects", renderer);
					//grid.setCellRenderer("highpriorityjsonprojects", renderer);
					grid.setCellRenderer('name', new CellRenderer({render: function(cell, value) {
						var rowId = grid.getRowId(cell.rowIndex);
						var column = this.column;
						var displayValue = value;
						$("<span>").append(displayValue).appendTo(cell);
						if(value.length>0){
							$(cell).attr('rowspan', 2);
						}else{
							$(cell).hide();
						}
					}}));
				},
			tableClass: 'table-price',
			sort: false
		});
		
	});
</script>

<h1>Прайс</h1>

<button class="pull-right btn btn-large btn-magenta">Просмотр прайса</button>

<div class="clearfix"></div>
<div id="tablecontent"></div>
<div class="pagination pagination-centered">
	<ul id="paginator">
	</ul>
</div>
