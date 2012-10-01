
<button class="btn-large btn-success" id="add" href="#">
    Оформить заказ
</button>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 