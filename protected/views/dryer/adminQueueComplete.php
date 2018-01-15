<div class="b-popup">
	<h1>Добавление выгрузки</h1>

	<div class="b-popup-form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'faculties-form',
		'enableAjaxValidation'=>false,
	)); ?>

		<?php echo $form->errorSummary($model); ?>

		<div class="row">
			<?php echo $form->labelEx($model,'complete_date'); ?>
			<?php echo $form->textField($model,'complete_date',array('maxlength'=>120, 'required'=>true, 'class' => 'date current')); ?>
			<?php echo $form->error($model,'complete_date'); ?>
		</div>

		<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
			<input type="button" onclick="$.fancybox.close(); return false;" value="Отменить">
		</div>

	<?php $this->endWidget(); ?>

	</div>
</div>