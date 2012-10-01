<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model, 'id'); ?>
		<?php echo $form->textField($model, 'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'create_date'); ?>
		<?php echo $form->textField($model, 'create_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'global_number'); ?>
		<?php echo $form->textField($model, 'global_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'client_number'); ?>
		<?php echo $form->textField($model, 'client_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'client_id'); ?>
		<?php echo $form->dropDownList($model, 'client_id', GxHtml::listDataEx(Client::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'manager_id'); ?>
		<?php echo $form->dropDownList($model, 'manager_id', GxHtml::listDataEx(Manager::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'designer_id'); ?>
		<?php echo $form->dropDownList($model, 'designer_id', GxHtml::listDataEx(Designer::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'customer_id'); ?>
		<?php echo $form->dropDownList($model, 'customer_id', GxHtml::listDataEx(Customer::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'order_type_id'); ?>
		<?php echo $form->dropDownList($model, 'order_type_id', GxHtml::listDataEx(OrderType::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'difficulty_id'); ?>
		<?php echo $form->dropDownList($model, 'difficulty_id', GxHtml::listDataEx(Difficulty::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'priority_id'); ?>
		<?php echo $form->dropDownList($model, 'priority_id', GxHtml::listDataEx(Priority::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'comment'); ?>
		<?php echo $form->textField($model, 'comment', array('maxlength' => 200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'chromaticity_id'); ?>
		<?php echo $form->dropDownList($model, 'chromaticity_id', GxHtml::listDataEx(Chromatisity::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'density_id'); ?>
		<?php echo $form->dropDownList($model, 'density_id', GxHtml::listDataEx(Density::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'size_x'); ?>
		<?php echo $form->textField($model, 'size_x'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'size_y'); ?>
		<?php echo $form->textField($model, 'size_y'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'measure_unit_id'); ?>
		<?php echo $form->dropDownList($model, 'measure_unit_id', GxHtml::listDataEx(MeasureUnit::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row buttons">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
