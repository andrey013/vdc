<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/pageOrderList.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/date.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/daterangepicker.js"></script>

<script>
	$(function(){
		$("body").css('background-image','none');
		var start = EditableGrid.prototype.localisset('start') ? EditableGrid.prototype.localget('start') : Date.today().add({ days: -29 });
		var end   = EditableGrid.prototype.localisset('end') ? EditableGrid.prototype.localget('end') : Date.today();
		datagrid = new DatabaseGrid({
			fetchUrl: "<?php echo $this->createUrl('/order/jsonprint'); ?>"+"?start="+start.toString('dd.MM.yyyy')+"&end="+ end.toString('dd.MM.yyyy'),
			updateUrl: "error",
			editUrl: "error",
			init:
				function(grid){
					grid.setCellRenderer("filter", new CellRenderer({render: function(cell, value) {
						var info = $.parseJSON(value);
						var rowId = grid.getRowId(cell.rowIndex);
						//$("#order_"+rowId).addClass("row-"+info.order_status);
						cell.innerHTML = "<a href=\"" + "<?php echo $this->createUrl('/order/update/'); ?>" + "/id/" + rowId + "\">" +
						 "<i class='icon-edit'></i></a>";
						$(cell).hide();
						// $(cell).parent().on('dblclick', function(event) {
						// 		window.location = "<?php echo $this->createUrl('/order/update/'); ?>" + "/id/" + rowId;
						// 	})
					}}));
					grid.setHeaderRenderer("filter", new CellRenderer({render: function(cell, value) {
						$(cell).hide();
					}}));

					grid.setCellRenderer("orderStatusHist.statusformatted", new CellRenderer({render: function(cell, value) {
						var rowId = grid.getRowId(cell.rowIndex);
						var words = value.split(' ');
						if(words.length==2){
							$("<div>").append(words[0]).append("<br>").append(words[1]).appendTo(cell);
						}else{
							$("<div>").append(words[0]+'&nbsp;'+words[1]).append("<br>").append(words[2]).appendTo(cell);
						}
					}}));

					<?php if(User2::model()->with('profile')->findByPk(Yii::app()->user->id)->role_id=='Admin'){ ?>
					grid.setHeaderRenderer("client_price", new CellRenderer({render: function(cell, value) {
						$(cell).attr('colspan', 3).append(value);
					}}));
					grid.setHeaderRenderer("designer_price", new CellRenderer({render: function(cell, value) {
						$(cell).hide();
					}}));
					grid.setHeaderRenderer("penny", new CellRenderer({render: function(cell, value) {
						$(cell).hide();
					}}));
					
					<?php } ?>

					

					grid.filter = function(filterString)
					{
						var grid = this;
						with (this) {

							if (typeof filterString != 'undefined') {
								this.currentFilter = filterString;
								this.localset('listfilter', filterString);
							}

							// if filtering is done on server-side, we are done here
							if (this.serverSide) return setPageIndex(0);
							
							var filters = $('[id^="filter_"]');

							filters.each(function(){
									var field = $(this).attr('id').substr(7);
									grid.localset(field, $(this).val());
								});

							// un-filter if no or empty filter set
							if (currentFilter == null) {
								if (dataUnfiltered != null) {
									data = dataUnfiltered;
									dataUnfiltered = null;
									for (var r = 0; r < getRowCount(); r++){
										var row = data[r];
										row.visible = true;
										var searchValue = $.parseJSON(getValueAt(r, grid.getColumnIndex("filter")));

										filters.each(function(){
											var field = $(this).attr('id').substr(7);
											if($(this).val()){
												if($(this).val()!=searchValue[field]){
													row.visible = false;
												}
											}
										});
									}
									setPageIndex(0);
									tableFiltered();
								}
								return;
							}		

							var words = currentFilter.toLowerCase().split(" ");

							// work on unfiltered data
							if (dataUnfiltered != null) data = dataUnfiltered;

							var rowCount = getRowCount();
							var columnCount = getColumnCount();
							for (var r = 0; r < rowCount; r++) {
								var row = data[r];
								row.visible = true;
								var rowContent = ""; 
								
								var searchValue = $.parseJSON(getValueAt(r, grid.getColumnIndex("filter")));
								rowContent = searchValue["filter"];
								filters.each(function(){
									var field = $(this).attr('id').substr(7);
									if($(this).val()){
										if($(this).val()!=searchValue[field]){
											row.visible = false;
										}
									}
								});
								/*
								// add column values
								for (var c = 0; c < columnCount; c++) {
									if (getColumnType(c) == 'boolean') continue;
									var displayValue = getDisplayValueAt(r, c);
									var value = getValueAt(r, c);
									rowContent += displayValue + " " + (displayValue == value ? "" : value + " ");
								}
								
								// add attribute values
								for (var attributeName in row) {
									if (attributeName != "visible" && attributeName != "originalIndex" && attributeName != "columns") rowContent += row[attributeName];
								}
								*/
								// if row contents do not match one word in the filter, hide the row
								for (var i = 0; i < words.length; i++) {
									var word = words[i];
									var match = false;

									// a word starting with "!" means that we want a NON match
									var invertMatch = word.startsWith("!");
									if (invertMatch) word = word.substr(1);
									
									// if word is of the form "colname/attributename=value" or "colname/attributename!=value", only this column/attribute is used
									var colindex = -1;
									var attributeName = null;
									
									// a word ending with "!" means that a column must match this word exactly
									if (!word.endsWith("!")) {
										if (colindex >= 0) match = (getValueAt(r, colindex) + ' ' + getDisplayValueAt(r, colindex)).trim().toLowerCase().indexOf(word) >= 0;
										else if (attributeName !== null) match = (''+getRowAttribute(r, attributeName)).trim().toLowerCase().indexOf(word) >= 0;
										else match = rowContent.toLowerCase().indexOf(word) >= 0; 
									}
									else {
										word = word.substr(0, word.length - 1);
										if (colindex >= 0) match = (''+getDisplayValueAt(r, colindex)).trim().toLowerCase() == word || (''+getValueAt(r, colindex)).trim().toLowerCase() == word;
										else if (attributeName !== null) match = (''+getRowAttribute(r, attributeName)).trim().toLowerCase() == word;
										else for (var c = 0; c < columnCount; c++) {
											if (getColumnType(c) == 'boolean') continue;
											if ((''+getDisplayValeAt(r, c)).trim().toLowerCase() == word || (''+getValueAt(r, c)).trim().toLowerCase() == word) match = true;
										}
									}

									if (invertMatch ? match : !match) {
										data[r].visible = false;
										break;
									}
								}
							}

							// keep only visible rows in data
							dataUnfiltered = data;
							data = [];
							for (var r = 0; r < rowCount; r++) if (dataUnfiltered[r].visible) data.push(dataUnfiltered[r]);

							// refresh grid (back on first page) and callback
							setPageIndex(0);
							tableFiltered();
						}
					}
				},
			tableClass: "table-condensed table-print",
			sort: false,
			pageSize: 0,
			updateSum: true
		});
	});
</script>

<?php
$managers=User2::model()->with(array(
		'authAssignments'=>array(
			// we don't want to select posts
			'select'=>false,
			// but want to get only users with published posts
			'joinType'=>'INNER JOIN',
			'condition'=>'authAssignments.itemname=\'Manager\'',
		),
	),
	'profile'
)->findAll('disabled=0');
$designers=User2::model()->with(array(
		'authAssignments'=>array(
			// we don't want to select posts
			'select'=>false,
			// but want to get only users with published posts
			'joinType'=>'INNER JOIN',
			'condition'=>'authAssignments.itemname=\'Designer\'',
		),
	),
	'profile'
)->findAll('disabled=0');
?>
<div class="hidden">
	<div class="input-prepend input-append span">
    	<div class="btn-group">
    	<button type="button" class="btn disabled"><i class="icon-search"></i>&nbsp;</button>
    	<span></span>
    	</div>
	    <input type="text" id="filter" class="" style="width:100px" autofocus>
	    <div class="btn-group">
	   	<button id="clearButton" type="button" class="btn"><i class="icon-trash"></i>&nbsp;</button>
	   	</div>
    </div>
	<?php echo GxHtml::dropDownList('filter_order_status', '',
			GxHtml::listDataEx(OrderStatus::model()->findAllAttributes('name, `key`', true), 'key', 'name'),
			array('class' => 'span2', 'empty' => '* Статус')); ?>
	<?php echo GxHtml::dropDownList('filter_order_type', '',
			GxHtml::listDataEx(OrderType::model()->findAllAttributes(null, true, 'disabled=0'), null, 'name'),
			array('class' => 'span2', 'empty' => '* Вид заказа')); ?>
	<?php echo GxHtml::dropDownList('filter_manager', '',
			GxHtml::listDataEx($managers, null, 'profile.lastname'),
			array('class' => 'span2', 'empty' => '* Имя менеджера')); ?>
	<?php echo GxHtml::dropDownList('filter_designer', '',
			GxHtml::listDataEx($designers, null, 'profile.lastname'),
			array('class' => 'span2', 'empty' => '* Имя дизайнера')); ?>
	<?php echo GxHtml::dropDownList('filter_client', '',
			GxHtml::listDataEx(Client::model()->findAllAttributes(null, true, 'disabled=0'), null, 'name'),
			array('class' => 'span2', 'empty' => '* Редакция')); ?>
	<?php echo GxHtml::dropDownList('filter_paid', '',
			array('1' => 'Оплаченные', '0' => 'Не оплаченные'),
			array('class' => 'span2', 'empty' => '* Оплата')); ?>
	<?php echo GxHtml::dropDownList('filter_changed', '',
			array('1' => 'Измененные', '0' => 'Не измененные'),
			array('class' => 'span2', 'empty' => '* Измененность')); ?>

</div>

<label class="lead"><strong><?php echo Yii::app()->dateFormatter->format('d.MM.yyyy HH:mm:ss', time()); ?></strong></label>
<div id="tablecontent"></div>
<label class="lead" style="float: right;"><strong id="sum"></strong></label>
