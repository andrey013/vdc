<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/commonDatabaseGrid.js"></script>

<script>
	$(function(){
		datagrid = new DatabaseGrid("<?php echo $this->createUrl('/vdcuser/jsonlist'); ?>",
			"<?php echo $this->createUrl('/vdcuser/update/'); ?>",
			"<?php echo $this->createUrl('/vdcuser/jsonupdate/'); ?>");
	});
</script>

<h1>Пользователи</h1>

<button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-magenta" id="add">
    Добавить пользователя
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


<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<!-- <form class="form-horizontal" style="margin-bottom: 0px"> -->
	<?php 
	$form = $this->beginWidget('GxActiveForm', array(
		'id' => 'order-form',
		'enableAjaxValidation' => true,
		'htmlOptions'=>array(
			'class'=>'form-horizontal',
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
				<label class="control-label" for="CreateUserForm_lastname">ФИО</label>
				<div class="controls">
					<!-- <input type="text" id="lastname" placeholder="ФИО"> -->
					<?php echo $form->textField($model, 'lastname'); ?>
				</div>
			</div>

		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Отмена</button>
			<button class="btn btn-magenta">Создать пользователя</button>
		</div>
	<!-- </form> -->
	<?php
		$this->endWidget();
	?>
</div>