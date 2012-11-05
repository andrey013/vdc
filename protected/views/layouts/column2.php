<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="row">
	<div class="span2">
		<ul class="nav nav-list">
			<li class="nav-header">Пользователи</li>
			<li <?php if($this->getRoute()=='client/list'){ ?>class="active"<? } ?>>
				<a href="<?php echo $this->createUrl('/client/list'); ?>"><i class="icon-home"></i> Редакции</a>
			</li>
			<li <?php if($this->getRoute()=='vdcuser/list'){ ?>class="active"<? } ?>>
				<a href="<?php echo $this->createUrl('/vdcuser/list'); ?>"><i class="icon-user"></i> Пользователи</a>
			</li>
			<li><a href="#"><i class="icon-envelope"></i> Рассылка</a></li>
			<li class="nav-header">Прайс</li>
			<li <?php if($this->getRoute()=='difficulty/list'){ ?>class="active"<? } ?>>
				<a href="<?php echo $this->createUrl('/difficulty/list'); ?>"><i class="icon-signal"></i> Сложность</a>
			</li>
			<li <?php if($this->getRoute()=='orderType/list'){ ?>class="active"<? } ?>>
				<a href="<?php echo $this->createUrl('/orderType/list'); ?>"><i class="icon-book"></i> Вид заказа</a>
			</li>
			<li <?php if($this->getRoute()=='price/list'){ ?>class="active"<? } ?>>
				<a href="<?php echo $this->createUrl('/price/list'); ?>"><i class="icon-th"></i> Прайс</a>
			</li>

			<li class="divider"></li>
			<li <?php if($this->getRoute()=='priority/list'){ ?>class="active"<? } ?>>
				<a href="<?php echo $this->createUrl('/priority/list'); ?>"><i class="icon-tags"></i> Приоритет</a>
			</li>
			<li <?php if($this->getRoute()=='measureUnit/list'){ ?>class="active"<? } ?>>
				<a href="<?php echo $this->createUrl('/measureUnit/list'); ?>"><i class="icon-resize-full"></i> Ед. изм.</a>
			</li>
			<li class="divider"></li>
			<li><a href="#"><i class="icon-folder-open"></i> Документы</a></li>
			<li <?php if($this->getRoute()=='vdcinfo/update'){ ?>class="active"<? } ?>>
				<a href="<?php echo $this->createUrl('/vdcinfo/update'); ?>"><i class="icon-info-sign"></i> Контакты</a>
			</li>
		</ul>
	</div>
	<div class="span10">
		<?php echo $content; ?>
	</div>
</div>
<?php $this->endContent(); ?>