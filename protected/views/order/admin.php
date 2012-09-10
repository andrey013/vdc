<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'Manage'),
);

$this->menu = array(
		array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index')),
		array('label'=>Yii::t('app', 'Create') . ' ' . $model->label(), 'url'=>array('create')),
	);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('order-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2)); ?></h1>

<p>
You may optionally enter a comparison operator (&lt;, &lt;=, &gt;, &gt;=, &lt;&gt; or =) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo GxHtml::link(Yii::t('app', 'Advanced Search'), '#', array('class' => 'search-button')); ?>
<div class="search-form">
<?php $this->renderPartial('_search', array(
	'model' => $model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'order-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		'id',
		'create_date',
		'global_number',
		'client_number',
		array(
				'name'=>'client_id',
				'value'=>'GxHtml::valueEx($data->client)',
				'filter'=>GxHtml::listDataEx(Client::model()->findAllAttributes(null, true)),
				),
		array(
				'name'=>'manager_id',
				'value'=>'GxHtml::valueEx($data->manager)',
				'filter'=>GxHtml::listDataEx(Manager::model()->findAllAttributes(null, true)),
				),
		/*
		array(
				'name'=>'designer_id',
				'value'=>'GxHtml::valueEx($data->designer)',
				'filter'=>GxHtml::listDataEx(Designer::model()->findAllAttributes(null, true)),
				),
		array(
				'name'=>'customer_id',
				'value'=>'GxHtml::valueEx($data->customer)',
				'filter'=>GxHtml::listDataEx(Customer::model()->findAllAttributes(null, true)),
				),
		array(
				'name'=>'order_type_id',
				'value'=>'GxHtml::valueEx($data->orderType)',
				'filter'=>GxHtml::listDataEx(OrderType::model()->findAllAttributes(null, true)),
				),
		array(
				'name'=>'difficulty_id',
				'value'=>'GxHtml::valueEx($data->difficulty)',
				'filter'=>GxHtml::listDataEx(Difficulty::model()->findAllAttributes(null, true)),
				),
		array(
				'name'=>'priority_id',
				'value'=>'GxHtml::valueEx($data->priority)',
				'filter'=>GxHtml::listDataEx(Priority::model()->findAllAttributes(null, true)),
				),
		'comment',
		array(
				'name'=>'chromaticity_id',
				'value'=>'GxHtml::valueEx($data->chromaticity)',
				'filter'=>GxHtml::listDataEx(Chromatisity::model()->findAllAttributes(null, true)),
				),
		array(
				'name'=>'density_id',
				'value'=>'GxHtml::valueEx($data->density)',
				'filter'=>GxHtml::listDataEx(Density::model()->findAllAttributes(null, true)),
				),
		'size_x',
		'size_y',
		array(
				'name'=>'measure_unit_id',
				'value'=>'GxHtml::valueEx($data->measureUnit)',
				'filter'=>GxHtml::listDataEx(MeasureUnit::model()->findAllAttributes(null, true)),
				),
		*/
		array(
			'class' => 'CButtonColumn',
		),
	),
)); ?>