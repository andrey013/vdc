
<?php 
	$form = $this->beginWidget('GxActiveForm', array(
		'id' => 'order-form',
		'enableAjaxValidation' => true,
	));
	$managers=User2::model()->with(array(
			'authAssignments'=>array(
				// we don't want to select posts
				'select'=>false,
				// but want to get only users with published posts
				'joinType'=>'INNER JOIN',
				'condition'=>'authAssignments.itemname=\'Manager\'',
			),
		),
		'profile'
	)->findAll('disabled=0');
	$designers=User2::model()->with(array(
			'authAssignments'=>array(
				// we don't want to select posts
				'select'=>false,
				// but want to get only users with published posts
				'joinType'=>'INNER JOIN',
				'condition'=>'authAssignments.itemname=\'Designer\'',
			),
		),
		'profile'
	)->findAll('disabled=0');
?>

	<?php //echo $form->errorSummary($model); ?>
		<div class="controls controls-row row">
			<label class="span1 lead down7px"><strong><?php echo $model->createdateformatted; ?></strong></label>
			<?php echo $form->textField($model, 'create_date', array('class' => 'hidden')); ?>
			<label class="span3 lead down7px">Заказ №<strong> <?php echo $model->global_number.'_'.$model->client->code; ?></strong></label>
			<?php echo $form->textField($model, 'global_number', array('class' => 'hidden')); ?>

			<?php if(isset($buttons)) { ?>
				<div class="controls controls-row row pull-right">
					<a href="<?php echo $this->createUrl('/order/list'); ?>" class="btn btn-large span1">
						Отмена
					</a>
					<button class="btn btn-large btn-magenta span2">
						Оформить
					</button>
				</div>
			<?php } else { ?>
				<div class="pull-right">
					<a href="<?php echo $this->createUrl('/order/list'); ?>" class="btn btn-large span2 new-button">
						Назад
					</a>
					<button id="copy-button" type="button" class="btn btn-large btn-magenta span3 new-button">
						Создать на основе
					</button>
					<button id="cancel-button" type="button" class="btn btn-large span2 hidden edit-button">
						Отмена
					</button>
					<button class="btn btn-large btn-magenta span2 hidden edit-button">
						Сохранить
					</button>
				</div>
			<?php } ?>
		</div>
		<hr>
		<div class="controls controls-row row">
			<label class="span2" for="Order_client_number">№ заказа оформленный<br>у клиента</label>
			<?php echo $form->textField($model, 'client_number', array('class' => 'span1 down7px')); ?>
			<label class="span1 down7px" for="Order_client_id">клиент (редакция)</label>
			<?php echo $form->dropDownList($model, 'client_id',
				GxHtml::listDataEx(Client::model()->findAllAttributes(null, true, 'disabled=0'), null, 'name'), array('class' => 'span2 down7px')); ?>
			<label class="span1 down14px" for="Order_manager_id">менеджер</label>
			<?php echo $form->dropDownList($model, 'manager_id',
				GxHtml::listDataEx($managers, null, 'profile.lastname'), array('class' => 'span2 down7px')); ?>
			<label class="span1 down14px" for="Order_designer_id">дизайнер</label>
			<?php echo $form->dropDownList($model, 'designer_id',
				GxHtml::listDataEx($designers, null, 'profile.lastname'), array('class' => 'span2 down7px')); ?>
		</div>
		<hr>
		<div class="controls controls-row row">
			<label class="span2" for="Order_customername">Наименование заказчика</label>
			<?php echo $form->textField($model, 'customername', array('class' => 'span2'.($model->hasErrors('customer_id')?' error':''))); ?>
			<label class="span1" for="Order_order_type_id">Вид заказа</label>
			<?php echo $form->dropDownList($model, 'order_type_id',
				GxHtml::listDataEx(OrderType::model()->findAllAttributes(null, true, 'disabled=0'), null, 'name'), array('class' => 'span2')); ?>
			<label class="span1 down7px" for="Order_difficulty_id">Сложность</label>
			<?php echo $form->dropDownList($model, 'difficulty_id',
				GxHtml::listDataEx(Difficulty::model()->findAllAttributes(null, true, 'disabled=0'), null, 'name'), array('class' => 'span2')); ?>
			<label class="span1 down7px" for="Order_priority_id">Приоритет</label>
			<?php echo $form->dropDownList($model, 'priority_id',
				GxHtml::listDataEx(Priority::model()->findAllAttributes(null, true, 'disabled=0'), null, 'name'), array('class' => 'span1')); ?>	
		</div>
		<div class="controls controls-row row">
			<label class="span2" for="Order_comment">Комментарий к заказу</label>
			<?php echo $form->textField($model, 'comment', array('class' => 'span10', 'maxlength' => 200)); ?>
		</div>
		<hr>
		<div class="controls controls-row row">
			<label class="span2 down7px" for="Order_chromaticity_id">Цветность</label>
			<?php echo $form->textField($model, 'chromaticityname', array('class' => 'span2')); ?>
			<!-- <?php echo $form->dropDownList($model, 'chromaticity_id',
				GxHtml::listDataEx(Chromaticity::model()->findAllAttributes(null, true), null, 'name'), array('class' => 'span2')); ?>
			-->
			<label class="span4 down7px" for="Order_density_id">Разрешение</label>
			<?php echo $form->textField($model, 'densityname', array('class' => 'span2')); ?>
			<!-- <?php echo $form->dropDownList($model, 'density_id',
				GxHtml::listDataEx(Density::model()->findAllAttributes(null, true), null, 'name'), array('class' => 'span2')); ?>
			-->
		</div>
		<div class="controls controls-row row">
			<label class="span2 down7px" for="Order_size_x">Формат</label>
			<?php echo $form->textField($model, 'size_x', array('class' => 'span1')); ?>
			<label class="spanx down7px" for="Order_size_y">x</label>
			<?php echo $form->textField($model, 'size_y', array('class' => 'span1')); ?>
			<!-- <label class="span1" for="Order_measure_unit_id">Ед. изм</label> -->
			<?php echo $form->dropDownList($model, 'measure_unit_id',
				GxHtml::listDataEx(MeasureUnit::model()->findAllAttributes(null, true, 'disabled=0'), null, 'name'), array('class' => 'span1')); ?>
		</div>
		<hr>
		
		<?php if(isset($buttons)) { ?>
		<div class="controls controls-row row">
			<label class="span2" for="Order_clientPrice">Общая стоимость, руб.</label>
			<label class="span2" for="Order_designerPrice">Дизайнеру</label>
		</div>
		<div class="controls controls-row">
			<?php echo $form->textField($model, 'clientPrice', array('class' => 'span2')); ?>
			<?php echo $form->textField($model, 'designerPrice', array('class' => 'span2')); ?>
		</div>
		<?php } else { ?>
		<div class="controls controls-row row">
			<label class="lead span1 down7px">Оплата: </label>
			<button id="addpayment" class="btn span1" type="button">&nbsp;<i class="icon-plus"></i></button>
			<div class="span10" id="tablecontent"></div>
		</div>
		<?php } ?>
		<hr>
		<div class="controls controls-row row">
			<label class="lead span1 down7px">Статус: </label>
			<div class="btn-group  pull-right" data-toggle="buttons-radio">
				<button type="button" class="statusRadio btn btn-work" value="work"><i class="icon-active-ok"></i> в разработку</button>
				<button type="button" class="statusRadio btn btn-confirm active" value="confirm"><i class="icon-active-ok"></i> на утверждение</button>
				<button type="button" class="statusRadio btn btn-agreed" value="agreed"><i class="icon-active-ok"></i> согласовано</button>
				<button type="button" class="statusRadio btn btn-changed" value="changed"><i class="icon-active-ok"></i> изменения</button>
				<button type="button" class="statusRadio btn btn-cancelled" value="cancelled"><i class="icon-active-ok"></i> отменено</button>
				<button type="button" class="statusRadio btn btn-paused" value="paused"><i class="icon-active-ok"></i> приостановлено</button>
				<button type="button" class="statusRadio btn btn-done" value="done"><i class="icon-active-ok"></i> готово</button>
			</div>
			<?php echo $form->textField($model, 'orderStatusHist', array('class' => 'hidden')); ?>
		</div>
		<hr>
<!-- echo GxHtml::submitButton(Yii::t('app', 'Save')); -->
		<?php if(isset($buttons)) { ?>
		<?php } else { ?>
		<div class="controls controls-row row">
			<label class="lead span1 down7px">Текст: </label>
			
		</div>
		<div class="controls controls-row row pull-left" style="z-index: 10;">
			<div class="span6">
				<?php echo $form->textArea($model, 'text', array('class' => 'span6', 'rows' => '6')); ?>
				<!-- <textarea name="text" cols="200" rows="15" class="span7"></textarea> -->
			</div>
		</div>
		<div class="controls controls-row row pull-right" style="z-index: 9;">
			<div class="span6" style="min-height : 500px" id="commentcontent"></div>
		</div>
		<?php } ?>
<?php
$this->endWidget();
?>
		<?php if(!isset($buttons)) { ?>
		<!-- <div class="clearfix"></div> -->
		<hr class="span6">
		<div class="controls controls-row pull-left">
		<div class="controls controls-row row">
			<label class="lead span6  down7px">Файлы: </label>
		</div>
		<div class="controls controls-row row">
			<!-- The file upload form used as target for the file upload widget -->
			<form id="fileupload1" action="<?php echo $this->createUrl('/file/json'); ?>" method="POST" enctype="multipart/form-data" class="span6">
				<input type="hidden" name="id" value="<?php echo $model->id; ?>">
				<input type="hidden" name="stage" value="1">
				<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
				<div class="row fileupload-buttonbar">
					<!-- The table listing the files available for upload/download -->
					<div class="span6">
						<table role="presentation" class="table table-condensed lefted">
							<thead>
								<tr>
									<th colspan="5">Для разработки
										<!-- The fileinput-button span is used to style the file input field as button -->
										<span class="btn btn-mini btn-magenta fileinput-button">
											<i class="icon-plus icon-white"></i>
											<input type="file" name="files[]" multiple>
										</span>
									</th>
								</tr>
							</thead>
							<tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery">
							</tbody>
						</table>
					</div>

					<!-- The global progress information -->
					<div class="span6 fileupload-progress fade">
						<!-- The global progress bar -->
						<div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
							<div class="bar" style="width:0%;"></div>
						</div>
						<!-- The extended global progress information -->
						<div class="progress-extended">&nbsp;</div>
					</div>
				</div>
				
				<!-- The loading indicator is shown during file processing -->
				<div class="fileupload-loading"></div>
				<br>
			</form>
		</div>
		<div class="controls controls-row row">
			<!-- The file upload form used as target for the file upload widget -->
			<form id="fileupload2" action="<?php echo $this->createUrl('/file/json'); ?>" method="POST" enctype="multipart/form-data" class="span6">
				<input type="hidden" name="id" value="<?php echo $model->id; ?>">
				<input type="hidden" name="stage" value="2">
				<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
				<div class="row fileupload-buttonbar">
					<!-- The table listing the files available for upload/download -->
					<div class="span6">
						<table role="presentation" class="table table-condensed lefted">
							<thead>
								<tr>
									<th colspan="5">На утверждение
										<!-- The fileinput-button span is used to style the file input field as button -->
										<span class="btn btn-mini btn-magenta fileinput-button">
											<i class="icon-plus icon-white"></i>
											<input type="file" name="files[]" multiple>
										</span>
									</th>
								</tr>
							</thead>
							<tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery">
							</tbody>
						</table>
					</div>

					<!-- The global progress information -->
					<div class="span6 fileupload-progress fade">
						<!-- The global progress bar -->
						<div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
							<div class="bar" style="width:0%;"></div>
						</div>
						<!-- The extended global progress information -->
						<div class="progress-extended">&nbsp;</div>
					</div>
				</div>
				
				<!-- The loading indicator is shown during file processing -->
				<div class="fileupload-loading"></div>
				<br>
			</form>
		</div>
		<div class="controls controls-row row">
			<!-- The file upload form used as target for the file upload widget -->
			<form id="fileupload3" action="<?php echo $this->createUrl('/file/json'); ?>" method="POST" enctype="multipart/form-data" class="span6">
				<input type="hidden" name="id" value="<?php echo $model->id; ?>">
				<input type="hidden" name="stage" value="3">
				<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
				<div class="row fileupload-buttonbar">
					
					
					<!-- The table listing the files available for upload/download -->
					<div class="span6">
						<table role="presentation" class="table table-condensed lefted">
							<thead>
								<tr>
									<th colspan="5">Готовые
										<!-- The fileinput-button span is used to style the file input field as button -->
										<span class="btn btn-mini btn-magenta fileinput-button">
											<i class="icon-plus icon-white"></i>
											<input type="file" name="files[]" multiple>
										</span>
									</th>
								</tr>
							</thead>
							<tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery">
							</tbody>
						</table>
					</div>

					<!-- The global progress information -->
					<div class="span6 fileupload-progress fade">
						<!-- The global progress bar -->
						<div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
							<div class="bar" style="width:0%;"></div>
						</div>
						<!-- The extended global progress information -->
						<div class="progress-extended">&nbsp;</div>
					</div>
				</div>
				
				<!-- The loading indicator is shown during file processing -->
				<div class="fileupload-loading"></div>
				<br>
			</form>
		</div>
		</div>
		<?php } ?>

