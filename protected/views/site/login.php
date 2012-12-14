<script>
	$(function(){
		$("#LoginForm_username").on('change', function(){
			if($(this).val()){
				$("#forgetDiv").fadeIn();
			}else{
				$("#forgetDiv").fadeOut();
			}
		});
		<?php if(!isset($user)){ ?>
			$("#LoginForm_username").change();
		<?php } ?>
		$("#forgetDiv").on('click', function(){
			if(confirm("На почту пользователя " + $("#LoginForm_username").val() + ", указанную в системе придет письмо с дальнейшими указаниями. Продолжить?")){
				$.ajax({
					type: "GET",
					url: "<?php echo $this->createUrl('/site/sendRecoveryMail'); ?>",
					data: { username: $("#LoginForm_username").val()}
				}).done(function( msg ) {
					alert("Письмо успешно отправлено");
				});
			}
			
		});
	});
</script>
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
	if(isset($user)){
		$users=array($user);
	}else{
		$users=User2::model()->with('profile')->findAll('disabled = 0');
	}
?>
	<div class="control-group">
		<label class="control-label" for="LoginForm_username">Пользователь: </label>
		<div class="controls">
			<?php
			if(count($users)>1){
				echo $form->dropDownList($model, 'username',
					GxHtml::listDataEx($users, 'username', 'profile.lastname', 'role'), array('empty' => 'Выберите имя'));
			}else{
				echo $form->dropDownList($model, 'username',
					GxHtml::listDataEx($users, 'username', 'profile.lastname'));
			}
			?>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="LoginForm_password">
			<?php if(isset($user)){ ?>
				Новый пароль:
			<?php }else{ ?>
				Пароль:
			<?php } ?>
		</label>
		<div class="controls">
			<?php echo $form->passwordField($model, 'password'); ?>
		</div>
		<div class="controls" style="margin-bottom: -20px;">
			<a id="forgetDiv" style="display:none;" href="#">Забыл пароль</a>
		</div>
		<?php if(isset($user)){ ?>
			<input type="hidden" name="LoginForm[activkey]" value="<?php echo $user->activkey; ?>"></input>
		<?php } ?>
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
