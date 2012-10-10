<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/pageOrderList.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/date.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/daterangepicker.js"></script>

<script>
	$(function(){
		datagrid = new DatabaseGrid("<?php echo $this->createUrl('/order/jsonlist'); ?>",
			"<?php echo $this->createUrl('/order/update/'); ?>");

		$(document).ready(function() {
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
	});
</script>

<a class="btn btn-large btn-magenta" id="add" href="<?php echo $this->createUrl('/order/create'); ?>">
    Оформить заказ
</a>

<form class="form pull-right">
	<div id="reportrange" class="btn span" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
		<i class="icon-calendar icon-large"></i>
		<span></span> <b class="caret" style="margin-top: 8px"></b>
	</div>
    <div class="input-append span3">
	    <input type="text" id="filter" class="span2">
	    <button type="button" class="btn disabled">Поиск</button>
    </div>
</form>

<div id="tablecontent"></div>
<div class="pagination pagination-centered">
	<ul id="paginator">
	</ul>
</div>
