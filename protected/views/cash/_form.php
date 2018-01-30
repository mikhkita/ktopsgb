<div class="b-popup-form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'faculties-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>
	<input type="hidden" name="Cash[type_id]" value="<?=$_GET["type_id"]?>">

	<div class="row clearfix">
		<div class="row-half">
			<?php echo $form->labelEx($model,'date'); ?>
			<?php echo $form->textField($model,'date', array('maxlength' => 50, 'required' => true, 'class' => 'date' )); ?>
			<?php echo $form->error($model,'date'); ?>
		</div>
		<div class="row-half line-inputs">
			<?php echo $form->labelEx($model,'negative'); ?>
			<?php echo $form->radioButtonList($model,'negative', array(0 => "Входящий", 1 => "Исходящий"), array("separator"=>"", "class" => "autofirst")); ?>
			<?php echo $form->error($model,'negative'); ?>
		</div>
	</div>

	<div class="row clearfix">
		<div class="row-half">
			<?php echo $form->labelEx($model,'sum'); ?>
			<?php echo $form->textField($model,'sum',array('class' => "numeric", 'maxlength'=>120, 'required'=>true)); ?>
			<?php echo $form->error($model,'sum'); ?>
		</div>
		<div class="row-half line-inputs">
			<?php echo $form->labelEx($model,'cheque'); ?>
			<?php echo $form->radioButtonList($model,'cheque', array(0 => "Нет", 1 => "Есть"), array("separator"=>"", "class" => "autofirst")); ?>
			<?php echo $form->error($model,'cheque'); ?>
		</div>
	</div>

	<div class="row clearfix">
		<div class="row-half">
			<?php echo $form->labelEx($model,'reason'); ?>
			<?php echo $form->textField($model, 'reason', array('class'=>'autocomplete', 'data-values' => Cash::getReasons($_GET["type_id"]) )); ?>
			<?php echo $form->error($model,'reason'); ?>
		</div>
		<div class="row-half">
			<?php echo $form->labelEx($model,'comment'); ?>
			<?php echo $form->textField($model,'comment',array('maxlength'=>120)); ?>
			<?php echo $form->error($model,'comment'); ?>
		</div>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
		<input type="button" onclick="$.fancybox.close(); return false;" value="Отменить">
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->