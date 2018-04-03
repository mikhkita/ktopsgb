<div class="b-popup-form">

<?php $form=$this->beginWidget("CActiveForm", array(
	"id"=>"faculties-form",
	"enableAjaxValidation"=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>
	<div class="row clearfix">
		<? if(isset($model->container_id)): ?>
			<div class="row-half" style="display:none;">
				<?php echo $form->textField($model, "container_id", array("maxlength" => 50)); ?>
			</div>
		<? endif; ?>
		<?php echo $form->labelEx($model,"name"); ?>
		<?php echo $form->textField($model,"name", array("maxlength" => 128, "required" => true)); ?>
		<?php echo $form->error($model,"name"); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? "Добавить" : "Сохранить"); ?>
		<input type="button" onclick="$.fancybox.close(); return false;" value="Отменить">
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->