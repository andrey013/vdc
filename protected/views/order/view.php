<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index')),
	array('label'=>Yii::t('app', 'Create') . ' ' . $model->label(), 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Update') . ' ' . $model->label(), 'url'=>array('update', 'id' => $model->id)),
	array('label'=>Yii::t('app', 'Delete') . ' ' . $model->label(), 'url'=>'#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
'id',
'create_date',
'global_number',
'client_number',
array(
			'name' => 'client',
			'type' => 'raw',
			'value' => $model->client !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->client)), array('client/view', 'id' => GxActiveRecord::extractPkValue($model->client, true))) : null,
			),
array(
			'name' => 'manager',
			'type' => 'raw',
			'value' => $model->manager !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->manager)), array('manager/view', 'id' => GxActiveRecord::extractPkValue($model->manager, true))) : null,
			),
array(
			'name' => 'designer',
			'type' => 'raw',
			'value' => $model->designer !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->designer)), array('designer/view', 'id' => GxActiveRecord::extractPkValue($model->designer, true))) : null,
			),
array(
			'name' => 'customer',
			'type' => 'raw',
			'value' => $model->customer !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->customer)), array('customer/view', 'id' => GxActiveRecord::extractPkValue($model->customer, true))) : null,
			),
array(
			'name' => 'orderType',
			'type' => 'raw',
			'value' => $model->orderType !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->orderType)), array('orderType/view', 'id' => GxActiveRecord::extractPkValue($model->orderType, true))) : null,
			),
array(
			'name' => 'difficulty',
			'type' => 'raw',
			'value' => $model->difficulty !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->difficulty)), array('difficulty/view', 'id' => GxActiveRecord::extractPkValue($model->difficulty, true))) : null,
			),
array(
			'name' => 'priority',
			'type' => 'raw',
			'value' => $model->priority !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->priority)), array('priority/view', 'id' => GxActiveRecord::extractPkValue($model->priority, true))) : null,
			),
'comment',
array(
			'name' => 'chromaticity',
			'type' => 'raw',
			'value' => $model->chromaticity !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->chromaticity)), array('chromatisity/view', 'id' => GxActiveRecord::extractPkValue($model->chromaticity, true))) : null,
			),
array(
			'name' => 'density',
			'type' => 'raw',
			'value' => $model->density !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->density)), array('density/view', 'id' => GxActiveRecord::extractPkValue($model->density, true))) : null,
			),
'size_x',
'size_y',
array(
			'name' => 'measureUnit',
			'type' => 'raw',
			'value' => $model->measureUnit !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->measureUnit)), array('measureUnit/view', 'id' => GxActiveRecord::extractPkValue($model->measureUnit, true))) : null,
			),
	),
)); ?>

<h2><?php echo GxHtml::encode($model->getRelationLabel('orderStatusHistories')); ?></h2>
<?php
	echo GxHtml::openTag('ul');
	foreach($model->orderStatusHistories as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('orderStatusHistory/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
?><h2><?php echo GxHtml::encode($model->getRelationLabel('payments')); ?></h2>
<?php
	echo GxHtml::openTag('ul');
	foreach($model->payments as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('payment/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
?>