
<?php 
	$form = $this->beginWidget('GxActiveForm', array(
		'id' => 'order-form',
		'enableAjaxValidation' => true,
	));
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
	)->findAll();
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
	)->findAll();
?>

	<?php //echo $form->errorSummary($model); ?>
		<div class="controls controls-row row">
			<label class="span2 lead"><strong><?php echo $model->createdateformatted; ?></strong></label>
			<?php echo $form->textField($model, 'create_date', array('class' => 'hidden')); ?>
			<label class="span3 lead">Заказ №<strong> <?php echo $model->global_number.'_'.$model->client->code; ?></strong></label>
			<?php echo $form->textField($model, 'global_number', array('class' => 'hidden')); ?>
		</div>
		<div class="controls controls-row row">
			&nbsp;
		</div>
		<div class="controls controls-row row">
			<label class="span1" for="Order_client_number">№ заказа оформленный у клиента</label>&nbsp;
			<?php echo $form->textField($model, 'client_number', array('class' => 'span1')); ?>
			<label class="span1" for="Order_client_id">клиент (редакция)</label>
			<?php echo $form->dropDownList($model, 'client_id',
				GxHtml::listDataEx(Client::model()->findAllAttributes(null, true), null, 'name'), array('class' => 'span2')); ?>
			<label class="span1" for="Order_manager_id">менеджер</label>
			<?php echo $form->dropDownList($model, 'manager_id',
				GxHtml::listDataEx($managers, null, 'profile.lastname'), array('class' => 'span2')); ?>
			<label class="span1" for="Order_designer_id">дизайнер</label>
			<?php echo $form->dropDownList($model, 'designer_id',
				GxHtml::listDataEx($designers, null, 'profile.lastname'), array('class' => 'span2')); ?>
		</div>
		<hr>
		<div class="controls controls-row row">
			<label class="span1" for="Order_customername">Наименование заказчика</label>
			<?php echo $form->textField($model, 'customername', array('class' => 'span2')); ?>
			<label class="span1" for="Order_order_type_id">Вид заказа</label>
			<?php echo $form->dropDownList($model, 'order_type_id',
				GxHtml::listDataEx(OrderType::model()->findAllAttributes(null, true), null, 'name'), array('class' => 'span2')); ?>
			<label class="span1" for="Order_difficulty_id">Сложность</label>
			<?php echo $form->dropDownList($model, 'difficulty_id',
				GxHtml::listDataEx(Difficulty::model()->findAllAttributes(null, true), null, 'name'), array('class' => 'span2')); ?>
			<label class="span1" for="Order_priority_id">Приоритет</label>
			<?php echo $form->dropDownList($model, 'priority_id',
				GxHtml::listDataEx(Priority::model()->findAllAttributes(null, true), null, 'name'), array('class' => 'span1')); ?>	
		</div>
		<div class="controls controls-row row">
			<label class="span1" for="Order_comment">Комментарий к заказу</label>
			<?php echo $form->textField($model, 'comment', array('class' => 'span5', 'maxlength' => 200)); ?>
		</div>
		<hr>
		<div class="controls controls-row row">
			<label class="span1" for="Order_chromaticity_id">Цветность</label>
			<?php echo $form->textField($model, 'chromaticityname', array('class' => 'span2')); ?>
			<!-- <?php echo $form->dropDownList($model, 'chromaticity_id',
				GxHtml::listDataEx(Chromatisity::model()->findAllAttributes(null, true), null, 'name'), array('class' => 'span2')); ?>
			-->
			<label class="span1" for="Order_density_id">Разрешение</label>
			<?php echo $form->textField($model, 'densityname', array('class' => 'span2')); ?>
			<!-- <?php echo $form->dropDownList($model, 'density_id',
				GxHtml::listDataEx(Density::model()->findAllAttributes(null, true), null, 'name'), array('class' => 'span2')); ?>
			-->
			<label class="spanq" for="Order_size_x">Формат</label>
			<?php echo $form->textField($model, 'size_x', array('class' => 'span1')); ?>
			<label class="spanq" for="Order_size_y">x</label>
			<?php echo $form->textField($model, 'size_y', array('class' => 'span1')); ?>
			<label class="span1" for="Order_measure_unit_id">Ед. изм</label>
			<?php echo $form->dropDownList($model, 'measure_unit_id',
				GxHtml::listDataEx(MeasureUnit::model()->findAllAttributes(null, true), null, 'name'), array('class' => 'span1')); ?>
		</div>
		<div class="controls controls-row row">
			<label><?php echo GxHtml::encode($model->getRelationLabel('orderStatusHistories')); ?></label>
			<?php echo $form->checkBoxList($model, 'orderStatusHistories', GxHtml::encodeEx(GxHtml::listDataEx(OrderStatusHistory::model()->findAllAttributes(null, true)), false, true)); ?>
			<label><?php echo GxHtml::encode($model->getRelationLabel('payments')); ?></label>
			<?php echo $form->checkBoxList($model, 'payments', GxHtml::encodeEx(GxHtml::listDataEx(Payment::model()->findAllAttributes(null, true)), false, true)); ?>
		</div>
		<hr>
		<div class="controls controls-row row">
			<label class="lead span2">Статус: </label>
			<div class="btn-group span10" data-toggle="buttons-radio">
				<button type="button" class="statusRadio btn btn-work" value="work"><i class="icon-active-ok"></i> в разработку</button>
				<button type="button" class="statusRadio btn btn-confirm active" value="confirm"><i class="icon-active-ok"></i> на утверждение</button>
				<button type="button" class="statusRadio btn btn-agreed" value="agreed"><i class="icon-active-ok"></i> согласовано</button>
				<button type="button" class="statusRadio btn btn-changed" value="changed"><i class="icon-active-ok"></i> изменения</button>
				<button type="button" class="statusRadio btn btn-cancelled" value="cancelled"><i class="icon-active-ok"></i> отменено</button>
				<button type="button" class="statusRadio btn btn-paused" value="paused"><i class="icon-active-ok"></i> приостановлено</button>
				<button type="button" class="statusRadio btn btn-done" value="done"><i class="icon-active-ok"></i> готово</button>
			</div>
			<?php echo $form->textField($model, 'orderStatus', array('class' => 'hidden')); ?>
		</div>
<!-- echo GxHtml::submitButton(Yii::t('app', 'Save')); -->
		<div class="controls controls-row row pull-right">
			<button class="btn btn-large btn-primary span3">
				Оформить
			</button>
		</div>

<?php
$this->endWidget();
?>
