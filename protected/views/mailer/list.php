<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/commonDatabaseGrid.js"></script>

<script>
	$(function(){
		
	});
</script>

<h1>Рассылка</h1>

<!-- <button class="pull-right btn btn-large btn-magenta">Просмотр прайса</button> -->

<form method="post">
	<button class="btn btn-large btn-magenta pull-right">Отправить</button>
	<div class="clearfix"></div>
	<select name="Mailer[role_id]">
		<option value="Admin">Администраторы</option>
		<option value="Designer">Дизайнеры</option>
		<option value="Manager">Менеджеры</option>
	</select>
	<br>
	<textarea name="Mailer[text]" class="span10" style="height: 200px;"></textarea>
</form>