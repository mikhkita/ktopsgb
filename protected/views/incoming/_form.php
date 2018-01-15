<div class="b-popup-form">

<?php $form=$this->beginWidget("CActiveForm", array(
	"id" => "faculties-form",
	"enableAjaxValidation" => false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row clearfix">
		<div class="row-half">
			<?php echo $form->labelEx($model, "date"); ?>
			<?php echo $form->textField($model, "date", array("maxlength" => 20, "required" => true, "class" => "date current" )); ?>
			<?php echo $form->error($model, "date"); ?>
		</div>
		<div class="row-half">
			<?php echo $form->labelEx($model, "car"); ?>
			<?php echo $form->textField($model, "car", array("maxlength" => 16, "required" => true, "class" => "autocomplete", "data-values" => Incoming::getDistinct("car") )); ?>
			<?php echo $form->error($model, "car"); ?>
		</div>
	</div>

	<div class="row clearfix">
		<?php echo $form->labelEx($model, "cargo"); ?>
		<?php echo $form->textField($model, "cargo", array("maxlength" => 64, "required" => true, "class" => "autocomplete", "data-values" => Incoming::getDistinct("cargo") )); ?>
		<?php echo $form->error($model, "cargo"); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? "Добавить" : "Сохранить"); ?>
		<input type="button" onclick="$.fancybox.close(); return false;" value="Отменить">
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->