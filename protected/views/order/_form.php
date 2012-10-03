<div class="container">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'order-form',
	'enableAjaxValidation' => true,
));
?>

	<?php echo $form->errorSummary($model); ?>

		<div class="controls controls-row">
			<label class="span1"><b><?php echo Yii::app()->dateFormatter->format('d.MM.yyyy', $model->create_date); ?></b></label>
			<label class="span2">Заказ № <b><?php echo $model->global_number.'_kl'; ?><b></label>
		</div>
		<div class="controls controls-row row">
			<label class="span1" for="Order_client_number">№ заказа оформленный у клиента</label>&nbsp;
			<?php echo $form->textField($model, 'client_number', array('class' => 'span2')); ?>
			<label class="span1" for="Order_client_id">клиент (редакция)</label>
			<?php echo $form->dropDownList($model, 'client_id',
				GxHtml::listDataEx(Client::model()->findAllAttributes(null, true), null, 'name'), array('class' => 'span2')); ?>
			<label class="span1" for="Order_manager_id">менеджер</label>
			<?php echo $form->dropDownList($model, 'manager_id',
				GxHtml::listDataEx(Manager::model()->findAllAttributes(null, true), null, 'name'), array('class' => 'span2')); ?>
			<label class="span1" for="Order_designer_id">дизайнер</label>
			<?php echo $form->dropDownList($model, 'designer_id',
				GxHtml::listDataEx(Designer::model()->findAllAttributes(null, true), null, 'name'), array('class' => 'span2')); ?>
		</div>
		<div class="controls controls-row">
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
				GxHtml::listDataEx(Priority::model()->findAllAttributes(null, true), null, 'name'), array('class' => 'span2')); ?>	
		</div>
		<div class="controls controls-row">
			<label class="span1" for="Order_comment">Комментарий к заказу</label>
			<?php echo $form->textField($model, 'comment', array('class' => 'span10', 'maxlength' => 200)); ?>
		</div>
		<div class="controls controls-row">
			<label class="span1" for="Order_chromaticity_id">Цветность</label>
			<?php echo $form->dropDownList($model, 'chromaticity_id',
				GxHtml::listDataEx(Chromatisity::model()->findAllAttributes(null, true), null, 'name'), array('class' => 'span1')); ?>
			<label class="span1" for="Order_density_id">Разрешение</label>
			<?php echo $form->dropDownList($model, 'density_id',
				GxHtml::listDataEx(Density::model()->findAllAttributes(null, true), null, 'name'), array('class' => 'span1')); ?>
			<label class="span1" for="Order_size_x">Формат</label>
			<?php echo $form->textField($model, 'size_x', array('class' => 'span1')); ?>
			<label class="spanq" for="Order_size_y">x</label>
			<?php echo $form->textField($model, 'size_y', array('class' => 'span1')); ?>
			<label class="span1" for="Order_measure_unit_id">Ед. изм</label>
			<?php echo $form->dropDownList($model, 'measure_unit_id',
				GxHtml::listDataEx(MeasureUnit::model()->findAllAttributes(null, true), null, 'name'), array('class' => 'span1')); ?>
		</div>

		<label><?php echo GxHtml::encode($model->getRelationLabel('orderStatusHistories')); ?></label>
		<?php echo $form->checkBoxList($model, 'orderStatusHistories', GxHtml::encodeEx(GxHtml::listDataEx(OrderStatusHistory::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('payments')); ?></label>
		<?php echo $form->checkBoxList($model, 'payments', GxHtml::encodeEx(GxHtml::listDataEx(Payment::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->