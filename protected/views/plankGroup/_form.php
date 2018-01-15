<div class="b-popup-form">

<?php $form=$this->beginWidget("CActiveForm", array(
	"id" => "faculties-form",
	"enableAjaxValidation" => false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model, "name"); ?>
		<?php echo $form->textField($model, "name", array("maxlength" => 32, "required" => true)); ?>
		<?php echo $form->error($model, "name"); ?>
	</div>

	<div class="row clearfix">
		<div class="row-half">
			<?php echo $form->labelEx($model, "short"); ?>
			<?php echo $form->textField($model, "short", array("maxlength" => 8, "required" => true)); ?>
			<?php echo $form->error($model, "short"); ?>
		</div>
		<div class="row-half">
			<?php echo $form->labelEx($model, "price"); ?>
			<?php echo $form->textField($model, "price", array("maxlength" => 20, "required" => true, "class" => "float")); ?>
			<?php echo $form->error($model, "price"); ?>
		</div>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? "Добавить" : "Сохранить"); ?>
		<input type="button" onclick="$.fancybox.close(); return false;" value="Отменить">
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->