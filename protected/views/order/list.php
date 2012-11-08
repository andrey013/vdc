<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/pageOrderList.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/date.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/daterangepicker.js"></script>

<script>
	$(function(){
		datagrid = new DatabaseGrid({
			fetchUrl: "<?php echo $this->createUrl('/order/jsonlist'); ?>",
			updateUrl: "<?php echo $this->createUrl('/order/jsonupdate/'); ?>",
			editUrl: "<?php echo $this->createUrl('/order/update/'); ?>",
			init:
				function(grid){
					grid.setCellRenderer("orderStatusHist.key", new CellRenderer({render: function(cell, value) {
						var rowId = grid.getRowId(cell.rowIndex);
						$("#order_"+rowId).addClass("row-"+value);
						cell.innerHTML = "<a href=\"" + "<?php echo $this->createUrl('/order/update/'); ?>" + "/id/" + rowId + "\">" +
						 "<i class='icon-edit'></i></a>";
						$(cell).hide();
						$(cell).parent().on('dblclick', function(event) {
								window.location = "<?php echo $this->createUrl('/order/update/'); ?>" + "/id/" + rowId;
							})
					}}));
					grid.setHeaderRenderer("orderStatusHist.key", new CellRenderer({render: function(cell, value) {
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

					grid.setCellRenderer("designer_id", new CellRenderer({render: function(cell, value) {
						var rowId = grid.getRowId(cell.rowIndex);
						var renderValue = grid.getColumn("designer_id").getOptionValuesForRender()[value];
						$("<span>").append(renderValue.replace(/ /g,"&nbsp;")).addClass("dotted").appendTo(cell);
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

					grid.setCellEditor("designer_id", new SelectCellEditor({
							adaptHeight: false,
							adaptWidth: true,
							minWidth: 25 
						}));
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
				startDate: Date.today().add({ days: -29 }),
				endDate: Date.today(),
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
			});
			$('#reportrange span').html(Date.today().add({ days: -29 }).toString('dd.MM.yyyy') + ' - ' + Date.today().toString('dd.MM.yyyy'));
		
	});
</script>

<?php if(  User2::model()->with('profile')->findByPk(Yii::app()->user->id)->role_id=='Admin'
		|| User2::model()->with('profile')->findByPk(Yii::app()->user->id)->role_id=='Manager'){ ?>
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
<form class="form pull-right">
	<div id="reportrange" class="btn span" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
		<i class="icon-calendar icon-large"></i>
		<span></span> <b class="caret" style="margin-top: 8px"></b>
	</div>
    <div class="input-append span">
	    <input type="text" id="filter" class="span2" autofocus>
	    <button type="button" class="btn disabled"><i class="icon-search"></i>&nbsp;</button>
    </div>
</form>
<div class="clearfix"></div>
<div class="controls controls-row">
	<?php echo GxHtml::dropDownList('order_type', '',
			GxHtml::listDataEx(OrderType::model()->findAllAttributes(null, true, 'disabled=0'), null, 'name'),
			array('class' => 'span2', 'empty' => '* Вид заказа')); ?>
	<?php echo GxHtml::dropDownList('order_type', '',
			GxHtml::listDataEx(OrderStatus::model()->findAllAttributes(null, true), null, 'name'),
			array('class' => 'span2', 'empty' => '* Статус')); ?>
	<?php echo GxHtml::dropDownList('order_type', '',
			GxHtml::listDataEx(Client::model()->findAllAttributes(null, true, 'disabled=0'), null, 'name'),
			array('class' => 'span2', 'empty' => '* Редакция')); ?>
	<?php echo GxHtml::dropDownList('order_type', '',
			GxHtml::listDataEx($managers, null, 'profile.lastname'),
			array('class' => 'span2', 'empty' => '* ФИО менеджера')); ?>
	<?php echo GxHtml::dropDownList('order_type', '',
			GxHtml::listDataEx($designers, null, 'profile.lastname'),
			array('class' => 'span2', 'empty' => '* ФИО дизайнера')); ?>
</div>
<div class="clearfix"></div>
<div id="tablecontent"></div>
<div class="pagination pagination-centered">
	<ul id="paginator">
	</ul>
</div>
