<div class="b-popup-form">

<?php $form=$this->beginWidget("CActiveForm", array(
	"id" => "faculties-form",
	"enableAjaxValidation" => false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row clearfix">
		<?php echo $form->labelEx($model, "name"); ?>
		<?php echo $form->textField($model, "name", array("maxlength" => 256, "required" => true)); ?>
		<?php echo $form->error($model, "name"); ?>
	</div>

	<div class="row clearfix">
		<div class="row-half">
			<?php echo $form->labelEx($model, "inn"); ?>
			<?php echo $form->textField($model, "inn", array("maxlength" => 12, "class" => "numeric")); ?>
			<?php echo $form->error($model, "inn"); ?>
		</div>
		<div class="row-half line-inputs">
			<?php echo $form->labelEx($model,'is_provider'); ?>
			<?php echo $form->radioButtonList($model,'is_provider', array(0 => "Нет", 1 => "Да"), array("separator"=>"", "class" => "autofirst")); ?>
			<?php echo $form->error($model,'is_provider'); ?>
		</div>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? "Добавить" : "Сохранить"); ?>
		<input type="button" onclick="$.fancybox.close(); return false;" value="Отменить">
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->