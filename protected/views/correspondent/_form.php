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
		<div class="row-half">
			<?php echo $form->labelEx($model, "provider_id"); ?>
			<?php echo $form->dropDownList($model, "provider_id", CHtml::listData(WoodProvider::model()->sorted()->findAll(), 'id', 'name'), array("class" => "select2", "empty" => "Не задано")); ?>
			<?php echo $form->error($model, "provider_id"); ?>
		</div>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? "Добавить" : "Сохранить"); ?>
		<input type="button" onclick="$.fancybox.close(); return false;" value="Отменить">
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->