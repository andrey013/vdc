<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/pageOrderList.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/date.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/daterangepicker.js"></script>

<script>
	$(function(){
		var timesetdate = EditableGrid.prototype.localisset('timesetdate') ? EditableGrid.prototype.localget('timesetdate') : Date.today().toString('dd.MM.yyyy');
		EditableGrid.prototype.localset('timesetdate', Date.today().toString('dd.MM.yyyy'));
		var diff = (Date.today() - Date.parseExact(timesetdate, 'dd.MM.yyyy'))/(1000*60*60*24);

		var start = EditableGrid.prototype.localisset('start') ? EditableGrid.prototype.localget('start') : Date.today().add({ days: -6 }).toString('dd.MM.yyyy');
		var end   = EditableGrid.prototype.localisset('end') ? EditableGrid.prototype.localget('end') : Date.today().toString('dd.MM.yyyy');
		if(diff!=0){
			start = Date.parseExact(start, 'dd.MM.yyyy').add({ days: diff });
			end   = Date.parseExact(end, 'dd.MM.yyyy').add({ days: diff });
		}
		EditableGrid.prototype.localset('start', start.toString('dd.MM.yyyy'));
		EditableGrid.prototype.localset('end', end.toString('dd.MM.yyyy'));
		datagrid = new DatabaseGrid({
			fetchUrl: "<?php echo $this->createUrl('/order/jsonlist'); ?>"+"?start="+start.toString('dd.MM.yyyy')+"&end="+ end.toString('dd.MM.yyyy'),
			updateUrl: "<?php echo $this->createUrl('/order/jsonupdate/'); ?>",
			editUrl: "<?php echo $this->createUrl('/order/update/'); ?>",
			init:
				function(grid){
					grid.setCellRenderer("filter", new CellRenderer({render: function(cell, value) {
						var info = $.parseJSON(value);
						var rowId = grid.getRowId(cell.rowIndex);
						$("#order_"+rowId).addClass("row-"+info.order_status);
						cell.innerHTML = "<a href=\"" + "<?php echo $this->createUrl('/order/update/'); ?>" + "/id/" + rowId + "\">" +
						 "<i class='icon-edit'></i></a>";
						$(cell).hide();
						$(cell).parent().on('dblclick', function(event) {
								window.location = "<?php echo $this->createUrl('/order/update/'); ?>" + "/id/" + rowId;
							})
					}}));
					grid.setHeaderRenderer("filter", new CellRenderer({render: function(cell, value) {
						$(cell).hide();
					}}));
					grid.setCellRenderer("comment", new CellRenderer({render: function(cell, value) {
						var rowId = grid.getRowId(cell.rowIndex);
						$("<div>").append(value).addClass("two-liner").appendTo(cell);
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
					grid.setCellRenderer("designer_id", new CellRenderer({render: function(cell, value) {
						var rowId = grid.getRowId(cell.rowIndex);
						var renderValue = grid.getColumn("designer_id").getOptionValuesForRender()[value];
						$("<span>").append((renderValue?renderValue:"--").replace(/ /g,"&nbsp;")).addClass("dotted").appendTo(cell);
					}}));
					grid.setCellEditor("designer_id", new SelectCellEditor({
							adaptHeight: false,
							adaptWidth: true,
							minWidth: 25 
						}));
					grid.setHeaderRenderer("client_price", new CellRenderer({render: function(cell, value) {
						$(cell).attr('colspan', 3).append(value);
					}}));
					grid.setHeaderRenderer("designer_price", new CellRenderer({render: function(cell, value) {
						$(cell).hide();
					}}));
					grid.setHeaderRenderer("penny", new CellRenderer({render: function(cell, value) {
						$(cell).hide();
					}}));
					grid.setHeaderRenderer("disabled", new CellRenderer({render: function(cell, value) {
						$("<div>").append($("<input type='checkbox'>").on('click', function(){
								var designer_paidIndex = grid.getColumnIndex("disabled");
								var idIndex = grid.getColumnIndex("id");
								var ids = [];
								for(var i = 0; i < grid.getRowCount() ; i++){
									if(!grid.getValueAt(i, designer_paidIndex))
										ids.push(grid.getRowId(i));
								}
								if(confirm('Удалить ' + ids.length + ' зак.')){
									$.ajax({
										url: '<?php echo $this->createUrl('/order/jsonupdate'); ?>',
										type: 'POST',
										dataType: "html",
										data: {
											ids: ids,
											colname: 'disabled',
											newvalue: 1
										},
										success: function (response) 
										{ 
										    grid.loadJSON(grid.fetchUrl);
										},
										async: true
									});
								} else {
									$(this).attr("checked", false);
								}
							})
						).append($("<br>")).append('<i class="icon-remove"></i>').appendTo(cell);
					}}));
					grid.setHeaderRenderer("paid", new CellRenderer({render: function(cell, value) {
						$("<div>").append($("<input type='checkbox'>").on('click', function(){
								var designer_paidIndex = grid.getColumnIndex("paid");
								var idIndex = grid.getColumnIndex("id");
								var ids = [];
								for(var i = 0; i < grid.getRowCount() ; i++){
									if(!grid.getValueAt(i, designer_paidIndex))
										ids.push(grid.getRowId(i));
								}
								if(confirm('Оплатить ' + ids.length + ' зак.')){
									$.ajax({
										url: '<?php echo $this->createUrl('/order/jsonupdate'); ?>',
										type: 'POST',
										dataType: "html",
										data: {
											ids: ids,
											colname: 'paid',
											newvalue: 1
										},
										success: function (response) 
										{ 
										    grid.loadJSON(grid.fetchUrl);
										},
										async: true
									});
								} else {
									$(this).attr("checked", false);
								}
							})
						).append($("<br>")).append(value).appendTo(cell);
					}}));
					grid.setHeaderRenderer("designer_paid", new CellRenderer({render: function(cell, value) {
						$("<div>").append(
							$("<input type='checkbox'>").on('click', function(){
								var designer_paidIndex = grid.getColumnIndex("designer_paid");
								var idIndex = grid.getColumnIndex("id");
								var ids = [];
								for(var i = 0; i < grid.getRowCount() ; i++){
									if(!grid.getValueAt(i, designer_paidIndex))
										ids.push(grid.getRowId(i));
								}
								if(confirm('Оплатить дизайнерам ' + ids.length + ' зак.')){
									$.ajax({
										url: '<?php echo $this->createUrl('/order/jsonupdate'); ?>',
										type: 'POST',
										dataType: "html",
										data: {
											ids: ids,
											colname: 'designer_paid',
											newvalue: 1			
										},
										success: function (response) 
										{ 
										    grid.loadJSON(grid.fetchUrl);
										},
										async: true
									});
								} else {
									$(this).attr("checked", false);
								}
									
							})
						).append($("<br>")).append(value).appendTo(cell);
					}}));
					grid.setCellRenderer("paid", new CheckboxCellRenderer({render: function(element, value) {
							// convert value to boolean just in case
							value = (value && value != 0 && value != "false") ? true : false;

							// if check box already created, just update its state
							if (element.firstChild) { element.firstChild.checked = value; return; }
							
							// create and initialize checkbox
							var htmlInput = document.createElement("input"); 
							htmlInput.setAttribute("type", "checkbox");

							// give access to the cell editor and element from the editor field
							htmlInput.element = element;
							htmlInput.cellrenderer = this;

							// this renderer is a little special because it allows direct edition
							var cellEditor = new CellEditor();
							cellEditor.editablegrid = this.editablegrid;
							cellEditor.column = this.column;
							htmlInput.onclick = function(event) {
								element.rowIndex = this.cellrenderer.editablegrid.getRowIndex(element.parentNode); // in case it has changed due to sorting or remove
								element.isEditing = true;
								cellEditor.applyEditing(element, htmlInput.checked ? true : false); 
							};

							if(!value)element.appendChild(htmlInput);
							htmlInput.checked = value;
							htmlInput.disabled = (!this.column.editable || !this.editablegrid.isEditable(element.rowIndex, element.columnIndex));
							
							element.className = "boolean";
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
			tableClass: "table-condensed orders",
			sort: false
		});
			
		  	$('#reportrange').daterangepicker(	{
				ranges: {
					//'Сегодня': ['today', 'today'],
					//'Вчера': ['yesterday', 'yesterday'],
					'7 дней': [Date.today().add({ days: -6 }), 'today'],
					'30 дней': [Date.today().add({ days: -29 }), 'today'],
					'Этот месяц': [Date.today().moveToFirstDayOfMonth(), Date.today().moveToLastDayOfMonth()],
					'Прошлый месяц': [Date.today().moveToFirstDayOfMonth().add({ months: -1 }), Date.today().moveToFirstDayOfMonth().add({ days: -1 })]
				},
				opens: 'left',
				format: 'dd.MM.yyyy',
				startDate: start,
				endDate: end,
				//minDate: '01/01/2012',
				//maxDate: '12/31/2013',
				locale: {
					applyLabel: 'OK',
					fromLabel: 'От',
					toLabel: 'До',
					customRangeLabel: 'Другой',
					daysOfWeek: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт','Сб'],
					monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
					firstDay: 1
				}
			},
			function(start, end) {
				$('#reportrange span').html(start.toString('dd.MM.yyyy') + ' - ' + end.toString('dd.MM.yyyy'));
				datagrid.fetchGrid("<?php echo $this->createUrl('/order/jsonlist'); ?>"+"?start="+start.toString('dd.MM.yyyy')+"&end="+ end.toString('dd.MM.yyyy'));
				EditableGrid.prototype.localset('start', start.toString('dd.MM.yyyy'));
				EditableGrid.prototype.localset('end', end.toString('dd.MM.yyyy'));
			});

			$('#reportrange span').html(start.toString('dd.MM.yyyy') + ' - ' + end.toString('dd.MM.yyyy'));
			//datagrid.fetchGrid("<?php echo $this->createUrl('/order/jsonlist'); ?>"+"?start="+start.toString('dd.MM.yyyy')+"&end="+ end.toString('dd.MM.yyyy'));
			$('option[value=""]').addClass('muted');
		
		$("#clearButton").on("click", function(){
			$('[id^="filter"]').val("");
			$('#filter').keyup();
		});
	});
</script>
<?php
$role_id = User2::model()->with('profile')->findByPk(Yii::app()->user->id)->role_id;
if(  $role_id=='Admin' || $role_id=='Manager'){ ?>
<a class="btn btn-large btn-magenta" id="add" href="<?php echo $this->createUrl('/order/create'); ?>">
    Оформить заказ
</a>

<?php } ?>
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
<form class="controls controls-row pull-right down7px">
	<a class="btn span" id="add" target="_blank" href="<?php echo $this->createUrl('/order/print'); ?>">
	    <i class="icon-print"></i> Печать
	</a>
	<button id="clearButton" type="button" class="btn span"><i class="icon-trash"></i> Сброс</button>
	<?php echo GxHtml::dropDownList('filter_order_status', '',
			GxHtml::listDataEx(OrderStatus::model()->findAllAttributes('name, `key`', true), 'key', 'name'),
			array('class' => 'span2', 'empty' => '* Статус')); ?>
	<div id="reportrange" class="btn span" style="background: #fff; cursor: pointer; padding: 4px 10px; border: 1px solid #ccc">
		<i class="icon-calendar icon-large"></i>
		<span></span> <b class="caret" style="margin-top: 8px"></b>
	</div>
    <div class="input-append span">
    	
	    <input type="text" id="filter" class="" style="width:90px" autofocus>
	    <div class="btn-group">
    	<button type="button" class="btn disabled">&nbsp;<i class="icon-search"></i></button>
    	<span></span>
    	</div>
    </div>
</form>

<div class="clearfix"></div>
<div class="controls controls-row">
	<?php echo GxHtml::dropDownList('filter_order_type', '',
			GxHtml::listDataEx(OrderType::model()->findAllAttributes(null, true, 'disabled=0'), null, 'name'),
			array('class' => 'span2', 'empty' => '* Вид заказа')); ?>
	<?php if($role_id!='Designer') echo GxHtml::dropDownList('filter_manager', '',
			GxHtml::listDataEx($managers, null, 'profile.lastname'),
			array('class' => 'span2', 'empty' => '* Имя менеджера')); ?>
	<?php if($role_id!='Designer') echo GxHtml::dropDownList('filter_designer', '',
			GxHtml::listDataEx($designers, null, 'profile.lastname'),
			array('class' => 'span2', 'empty' => '* Имя дизайнера')); ?>
	<?php if($role_id!='Designer') echo GxHtml::dropDownList('filter_client', '',
			GxHtml::listDataEx(Client::model()->findAllAttributes(null, true, 'disabled=0'), null, 'name'),
			array('class' => 'span2', 'empty' => '* Редакция')); ?>
	<?php if($role_id!='Designer') echo GxHtml::dropDownList('filter_paid', '',
			array('1' => 'Оплаченные', '0' => 'Не оплаченные'),
			array('class' => 'span2', 'empty' => '* Оплата')); ?>
	<?php echo GxHtml::dropDownList('filter_changed', '',
			array('1' => 'Измененные', '0' => 'Не измененные'),
			array('class' => 'span2', 'empty' => '* Измененность')); ?>

</div>
<div class="clearfix"></div>
<div id="tablecontent"></div>
<div class="pagination pagination-centered">
	<ul id="paginator">
	</ul>
</div>
