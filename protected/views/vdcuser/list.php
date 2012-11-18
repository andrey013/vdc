<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/commonDatabaseGrid.js"></script>

<script>
	$(function(){
		datagrid = new DatabaseGrid({
			fetchUrl: "<?php echo $this->createUrl('/vdcuser/jsonlist'); ?>",
			updateUrl: "<?php echo $this->createUrl('/vdcuser/jsonupdate/'); ?>",
			init:
				function(grid){
					grid.setCellRenderer("emptypassword", new CellRenderer({render: function(cell, value) {
						var rowId = grid.getRowId(cell.rowIndex);
						var column = this.column;
						var displayValue = 'изменить';
						$("<em>").append(displayValue).addClass("dotted").appendTo(cell);
					}}));
					grid.setCellRenderer("lastname", new CellRenderer({render: function(cell, value) {
						var rowId = grid.getRowId(cell.rowIndex);
						var column = this.column;
						var displayValue = value;
						$("<span>").append(displayValue).addClass("dotted").appendTo(cell);
					}}));
					grid.setCellRenderer("role_id", new CellRenderer({render: function(cell, value) {
						var rowId = grid.getRowId(cell.rowIndex);
						var renderValue = grid.getColumn("role_id").getOptionValuesForRender()[value];
						$("<span>").append(renderValue).addClass("dotted").appendTo(cell);
					}}));
					grid.setCellRenderer("profile.client_id", new CellRenderer({render: function(cell, value) {
						var rowId = grid.getRowId(cell.rowIndex);
						var renderValue = grid.getColumn("profile.client_id").getOptionValuesForRender()[value];
						$("<span>").append(renderValue).addClass("dotted").appendTo(cell);
					}}));
					grid.setCellEditor("profile.client_id", new SelectCellEditor({
						adaptHeight: false,
						adaptWidth: true,
						minWidth: 25 
					}));
					grid.setCellEditor("role_id", new SelectCellEditor({
						adaptHeight: false,
						adaptWidth: true,
						minWidth: 25 
					}));
				}
		});
		
	});
</script>

<h1>Пользователи</h1>

<button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-magenta" id="add">
    Добавить пользователя
</button>

<form class="form pull-right">
    <div class="input-append span">
	    <input type="search" id="filter" class="span2">
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
		'id' => 'user-form',
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
			<h3 id="myModalLabel">Добавление пользователя</h3>
		</div>
		<div class="modal-body">
			<div class="control-group">
				<label class="control-label" for="CreateUserForm_client_id">Редакция</label>
				<div class="controls">
					<!-- <input type="text" id="type" placeholder="Тип пользователя"> -->
					<?php echo $form->dropDownList($model, 'client_id',
						GxHtml::listDataEx(Client::model()->findAll(), null, 'name')); ?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="CreateUserForm_type">Тип пользователя</label>
				<div class="controls">
					<!-- <input type="text" id="type" placeholder="Тип пользователя"> -->
					<?php echo $form->dropDownList($model, 'type',
						GxHtml::listDataEx(AuthItem::model()->findAll('description IS NOT NULL'), null, 'description')); ?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="CreateUserForm_email">Email</label>
				<div class="controls">
					<!-- <input type="text" id="email" placeholder="Email"> -->
					<?php echo $form->textField($model, 'email'); ?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="CreateUserForm_password">Пароль</label>
				<div class="controls">
					<!-- <input type="password" id="password" placeholder="Пароль"> -->
					<?php echo $form->textField($model, 'password'); ?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="CreateUserForm_lastname">Имя</label>
				<div class="controls">
					<!-- <input type="text" id="lastname" placeholder="Имя"> -->
					<?php echo $form->textField($model, 'lastname'); ?>
				</div>
			</div>

		</div>
		<div class="modal-footer">
			<button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Отмена</button>
			<button class="btn btn-magenta">Создать пользователя</button>
		</div>
	<!-- </form> -->
	<?php
		$this->endWidget();
	?>
</div>