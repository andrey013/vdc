
<!-- <h1><?php echo Yii::t('app', 'Create') . ' ' . GxHtml::encode($model->label()); ?></h1> -->

<?php
$this->renderPartial('_form', array(
		'model' => $model,
		'buttons' => 'create'));
?>