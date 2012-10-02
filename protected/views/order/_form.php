<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'order-form',
	'enableAjaxValidation' => true,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="controls controls-row">
			<label><b><?php echo $model->getAttribute('create_date'); ?></b></label>
			<label>Заказ № <?php echo $model->getAttribute('global_number'); ?></label>
		</div>
		<div class="row">
		<?php echo $form->labelEx($model,'create_date'); ?>
		<?php echo $form->textField($model, 'create_date'); ?>
		<?php echo $form->error($model,'create_date'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'global_number'); ?>
		<?php echo $form->textField($model, 'global_number'); ?>
		<?php echo $form->error($model,'global_number'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'client_number'); ?>
		<?php echo $form->textField($model, 'client_number'); ?>
		<?php echo $form->error($model,'client_number'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'client_id'); ?>
		<?php echo $form->dropDownList($model, 'client_id', GxHtml::listDataEx(Client::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'client_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'manager_id'); ?>
		<?php echo $form->dropDownList($model, 'manager_id', GxHtml::listDataEx(Manager::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'manager_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'designer_id'); ?>
		<?php echo $form->dropDownList($model, 'designer_id', GxHtml::listDataEx(Designer::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'designer_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'customer_id'); ?>
		<?php echo $form->dropDownList($model, 'customer_id', GxHtml::listDataEx(Customer::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'customer_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'order_type_id'); ?>
		<?php echo $form->dropDownList($model, 'order_type_id', GxHtml::listDataEx(OrderType::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'order_type_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'difficulty_id'); ?>
		<?php echo $form->dropDownList($model, 'difficulty_id', GxHtml::listDataEx(Difficulty::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'difficulty_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'priority_id'); ?>
		<?php echo $form->dropDownList($model, 'priority_id', GxHtml::listDataEx(Priority::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'priority_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'comment'); ?>
		<?php echo $form->textField($model, 'comment', array('maxlength' => 200)); ?>
		<?php echo $form->error($model,'comment'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'chromaticity_id'); ?>
		<?php echo $form->dropDownList($model, 'chromaticity_id', GxHtml::listDataEx(Chromatisity::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'chromaticity_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'density_id'); ?>
		<?php echo $form->dropDownList($model, 'density_id', GxHtml::listDataEx(Density::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'density_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'size_x'); ?>
		<?php echo $form->textField($model, 'size_x'); ?>
		<?php echo $form->error($model,'size_x'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'size_y'); ?>
		<?php echo $form->textField($model, 'size_y'); ?>
		<?php echo $form->error($model,'size_y'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'measure_unit_id'); ?>
		<?php echo $form->dropDownList($model, 'measure_unit_id', GxHtml::listDataEx(MeasureUnit::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'measure_unit_id'); ?>
		</div><!-- row -->

		<label><?php echo GxHtml::encode($model->getRelationLabel('orderStatusHistories')); ?></label>
		<?php echo $form->checkBoxList($model, 'orderStatusHistories', GxHtml::encodeEx(GxHtml::listDataEx(OrderStatusHistory::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('payments')); ?></label>
		<?php echo $form->checkBoxList($model, 'payments', GxHtml::encodeEx(GxHtml::listDataEx(Payment::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->