
<div class="form-horizontal">
<?php 
	$form=$this->beginWidget('CActiveForm', array(
		'id'=>'login-form',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	));
	$users=User2::model()->with('profile')->findAll();
?>
	<legend>Вход в систему</legend>
	<div class="controls-group ">
		<label class="control-label" for="LoginForm_username">Пользователь: </label>
		<div class="controls">
			<?php echo $form->dropDownList($model, 'username',
				GxHtml::listDataEx($users, 'username', 'profile.lastname'), array('class' => 'span3')); ?>
		</div>
	</div>

	<div class="controls-group ">
		<label class="control-label" for="LoginForm_password">Пароль: </label>
		<div class="controls">
			<?php echo $form->textField($model, 'password', array('class' => 'span3')); ?>
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			<label class="checkbox">
				<?php echo $form->checkBox($model,'rememberMe', array('class' => 'span1')); ?> Запомнить меня на этом компьютере
			</label>
			<button type="submit" class="btn btn-large btn-primary">Войти</button>
		</div>
	</div>


<?php $this->endWidget(); ?>
</div><!-- form -->
