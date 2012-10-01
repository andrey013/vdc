<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('create_date')); ?>:
	<?php echo GxHtml::encode($data->create_date); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('global_number')); ?>:
	<?php echo GxHtml::encode($data->global_number); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('client_number')); ?>:
	<?php echo GxHtml::encode($data->client_number); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('client_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->client)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('manager_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->manager)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('designer_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->designer)); ?>
	<br />
	<?php /*
	<?php echo GxHtml::encode($data->getAttributeLabel('customer_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->customer)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('order_type_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->orderType)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('difficulty_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->difficulty)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('priority_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->priority)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('comment')); ?>:
	<?php echo GxHtml::encode($data->comment); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('chromaticity_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->chromaticity)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('density_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->density)); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('size_x')); ?>:
	<?php echo GxHtml::encode($data->size_x); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('size_y')); ?>:
	<?php echo GxHtml::encode($data->size_y); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('measure_unit_id')); ?>:
		<?php echo GxHtml::encode(GxHtml::valueEx($data->measureUnit)); ?>
	<br />
	*/ ?>

</div>