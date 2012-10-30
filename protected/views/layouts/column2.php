<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="row">
	<div class="span3">
		<ul class="nav nav-list">
			<li class="nav-header">Пользователи</li>
			<li <?php if($this->getRoute()=='vdcuser/list'){ ?>class="active"<? } ?>><a href="#"><i class="icon-user"></i> Пользователи</a></li>
			<li><a href="#"><i class="icon-envelope"></i> Рассылка</a></li>
			<li class="nav-header">Прайс</li>
			<li><a href="#"><i class="icon-signal"></i> Сложность</a></li>
			<li><a href="#"><i class="icon-book"></i> Вид заказа</a></li>
			<li><a href="#"><i class="icon-th"></i> Прайс</a></li>
			<li class="divider"></li>
			<li><a href="#"><i class="icon-tags"></i> Приоритет</a></li>
			<li><a href="#"><i class="icon-resize-full"></i> Единицы измерения</a></li>
			<li class="divider"></li>
			<li><a href="#"><i class="icon-info-sign"></i> Контакты ВДЦ</a></li>
		</ul>
	</div>
	<div class="span9">
		<?php echo $content; ?>
	</div>
</div>
<?php $this->endContent(); ?>