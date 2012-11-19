
<div id="loginForm" class="loginForm">
<?php 
	$form=$this->beginWidget('CActiveForm', array(
		'id'=>'login-form',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
		'htmlOptions'=>array(
			'class'=>'form-horizontal',
			'style'=>'padding: 130px 0px 0 0; margin-left: -14px',
		),
	));
	$users=User2::model()->with('profile')->findAll('disabled = 0');
?>
	<div class="control-group">
		<label class="control-label" for="LoginForm_username">Пользователь: </label>
		<div class="controls">
			<?php echo $form->dropDownList($model, 'username',
				GxHtml::listDataEx($users, 'username', 'profile.lastname', 'role'), array('empty' => 'Выберите имя')); ?>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="LoginForm_password">Пароль: </label>
		<div class="controls">
			<?php echo $form->passwordField($model, 'password'); ?>
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<label class="checkbox" for="LoginForm_rememberMe">
				<?php echo $form->checkBox($model,'rememberMe'); ?> Запомнить меня
			</label>
			<button type="submit" class="btn btn-magenta"> Войти </button>
		</div>
	</div>


<?php $this->endWidget(); ?>
<!-- form -->
</div><!-- loginForm -->
