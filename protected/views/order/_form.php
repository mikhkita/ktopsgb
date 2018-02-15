<div class="b-popup-form">

<?php $form=$this->beginWidget("CActiveForm", array(
	"id" => "faculties-form",
	"enableAjaxValidation" => false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<input type="hidden" name="Order[company_id]" value="<?=$_GET["company_id"]?>">
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
			<?php echo $form->labelEx($model, "number"); ?>
			<?php echo $form->textField($model, "number", array("maxlength" => 12, "class" => "numeric")); ?>
			<?php echo $form->error($model, "number"); ?>
		</div>
		<div class="row-half">
			<?php echo $form->labelEx($model, "category_id"); ?>
			<?php echo $form->dropDownList($model, "category_id", CHtml::listData(Category::model()->findAll(), 'id', 'name'), array("class" => "select2", "empty" => "Не задано", "required" => true)); ?>
			<?php echo $form->error($model, "category_id"); ?>
		</div>
	</div>

	<div class="row clearfix">
		<div class="row-half">
			<?php echo $form->labelEx($model, "correspondent_id"); ?>
			<?php echo $form->dropDownList($model, "correspondent_id", CHtml::listData(Correspondent::model()->findAll(), 'id', 'name'), array("class" => "select2", "empty" => "Не задано", "required" => true)); ?>
			<?php echo $form->error($model, "correspondent_id"); ?>
		</div>
		<div class="row-half">
			<?php echo $form->labelEx($model,"sum"); ?>
			<?php echo $form->textField($model,"sum", array("maxlength" => 20, "required" => true, "class" => "float" )); ?>
			<?php echo $form->error($model,"sum"); ?>
		</div>
	</div>

	<div class="row clearfix">
		<?php echo $form->labelEx($model, "purpose"); ?>
		<?php echo $form->textArea($model, "purpose", array("maxlength" => 256)); ?>
		<?php echo $form->error($model, "purpose"); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? "Добавить" : "Сохранить"); ?>
		<input type="button" onclick="$.fancybox.close(); return false;" value="Отменить">
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->