<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/commonDatabaseGrid.js"></script>

<script>
	$(function(){
		datagrid = new DatabaseGrid({
			fetchUrl: "<?php echo $this->createUrl('/difficulty/jsonlist'); ?>",
			updateUrl: "<?php echo $this->createUrl('/difficulty/jsonupdate/'); ?>",
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
					
				}
		});
		
	});
</script>

<h1>Сложность</h1>

<button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-magenta" id="add">
    Добавить
</button>

<form class="form pull-right">
    <div class="input-append span">
	    <input type="search" id="filter" class="span2">
	    <!-- <button type="button" class="btn"><i class="icon-remove"></i>&nbsp;</button> -->
	    <button type="button" class="btn disabled"><i class="icon-search"></i>&nbsp;</button>
    </div>
</form>

<div id="tablecontent"></div>
<div class="pagination pagination-centered">
	<ul id="paginator">
	</ul>
</div>


<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<!-- <form class="form-horizontal" style="margin-bottom: 0px"> -->
	<?php 
	$form = $this->beginWidget('GxActiveForm', array(
		'id' => 'difficulty-form',
		'htmlOptions'=>array(
			'class'=>'form-horizontal',
			'style'=>'margin-bottom: 0px',
		),
	));
	?>

		<script>
			$(function(){
				<?php if($model->getErrors()){ ?>
				$('#myModal').modal('show');
				<?php } ?>
			});
		</script>
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">Добавление</h3>
		</div>
		<div class="modal-body">
			<div class="control-group">
				<label class="control-label" for="Difficulty_name">Название</label>
				<div class="controls">
					<!-- <input type="text" id="email" placeholder="Email"> -->
					<?php echo $form->textField($model, 'name'); ?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="Difficulty_sort_order">Порядок сортировки</label>
				<div class="controls">
					<!-- <input type="password" id="password" placeholder="Пароль"> -->
					<?php echo $form->textField($model, 'sort_order'); ?>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Отмена</button>
			<button class="btn btn-magenta">Создать</button>
		</div>
	<!-- </form> -->
	<?php
		$this->endWidget();
	?>
</div>