
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/pageOrderList.js"></script>

<a class="btn-large btn-success" id="add" href="<?php echo $this->createUrl('/order/create'); ?>">
    Оформить заказ
</a>

<div id="tablecontent"></div>
<div id="paginator"></div>

<?php /*$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); */ ?>
aa