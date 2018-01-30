<div class="b-popup-form">

<?php $form=$this->beginWidget("CActiveForm", array(
	"id" => "faculties-form",
	"enableAjaxValidation" => false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row clearfix">
		<div class="row-half">
			<?php echo $form->labelEx($model, "name"); ?>
			<?php echo $form->textField($model, "name", array("maxlength" => 64, "required" => true)); ?>
			<?php echo $form->error($model, "name"); ?>
		</div>
		<div class="row-half">
			<?php echo $form->labelEx($model, "post_id"); ?>
			<?php echo $form->dropDownList($model, "post_id", CHtml::listData(Post::model()->findAll(), 'id', 'name'), array("class" => "select2", "empty" => "Не задано", "required" => true)); ?>
			<?php echo $form->error($model, "post_id"); ?>
		</div>
	</div>

	<div class="row clearfix">
		<?php echo $form->labelEx($model, "salary"); ?>
		<?php echo $form->textField($model, "salary", array("maxlength" => 5, "required" => true, "class" => "numeric")); ?>
		<?php echo $form->error($model, "salary"); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? "Добавить" : "Сохранить"); ?>
		<input type="button" onclick="$.fancybox.close(); return false;" value="Отменить">
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->