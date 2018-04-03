<div class="b-popup-form">

<?php $form=$this->beginWidget("CActiveForm", array(
	"id"=>"faculties-form",
	"enableAjaxValidation"=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>
	<input type="hidden" name="Cargo[container_id]" value="<?=$_GET["container_id"]?>">

	<div class="row clearfix">
		<div class="row-half">
			<?php echo $form->labelEx($model,"length"); ?>
			<?php echo $form->textField($model,"length", array("maxlength" => 20, "required" => true, "class" => "float")); ?>
			<?php echo $form->error($model,"length"); ?>
		</div>
		<div class="row-half">
			<?php echo $form->labelEx($model,"thickness"); ?>
			<?php echo $form->textField($model,"thickness", array("maxlength" => 20, "required" => true, "class" => "float")); ?>
			<?php echo $form->error($model,"thickness"); ?>
		</div>
	</div>

	<div class="row clearfix">
		<div class="row-half">
			<?php echo $form->labelEx($model, "type_id"); ?>
			<?php echo $form->dropDownList($model, "type_id", CHtml::listData(CargoType::model()->findAll(), 'id', 'name'), array("class" => "select2", "empty" => "Не задано", "required" => true)); ?>
			<?php echo $form->error($model, "type_id"); ?>
		</div>
		<div class="row-half">
			<?php echo $form->labelEx($model,"count"); ?>
			<?php echo $form->textField($model,"count", array("maxlength" => 5, "required" => true, "class" => "numeric")); ?>
			<?php echo $form->error($model,"count"); ?>
		</div>
	</div>

	<div class="row clearfix">
		<div class="row-half">
			<?php echo $form->labelEx($model,"cubage"); ?>
			<?php echo $form->textField($model,"cubage", array("maxlength" => 20, "required" => true, "class" => "float")); ?>
			<?php echo $form->error($model,"cubage"); ?>
		</div>
		<div class="row-half">
			<?php echo $form->labelEx($model,"price"); ?>
			<?php echo $form->textField($model,"price", array("maxlength" => 20, "required" => true, "class" => "float")); ?>
			<?php echo $form->error($model,"price"); ?>
		</div>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? "Добавить" : "Сохранить"); ?>
		<input type="button" onclick="$.fancybox.close(); return false;" value="Отменить">
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->