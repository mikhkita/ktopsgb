<div class="form b-popup-form">

<?php $form=$this->beginWidget("CActiveForm", array(
	"id" => "faculties-form",
	"enableAjaxValidation" => false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row checkbox-row clearfix">
		<?php echo $form->labelEx($model, "active"); ?>
		<?php echo $form->checkbox($model, "active"); ?>
		<?php echo $form->error($model, "active"); ?>
	</div>

	<div class="row clearfix">
		<div class="row-half">
			<?php echo $form->labelEx($model, "name"); ?>
			<?php echo $form->textField($model, "name", array("maxlength" => 255, "required" => true)); ?>
			<?php echo $form->error($model, "name"); ?>
		</div>
		<div class="row-half">
			<?php echo $form->labelEx($model, "surname"); ?>
			<?php echo $form->textField($model, "surname", array("maxlength" => 255)); ?>
			<?php echo $form->error($model, "surname"); ?>
		</div>
	</div>

	<div class="row clearfix">
		<div class="row-half">
			<?php echo $form->labelEx($model, "login"); ?>
			<?php echo $form->textField($model, "login", array("maxlength" => 255, "required" => true)); ?>
			<?php echo $form->error($model, "login"); ?>
		</div>

		<div class="row-half">
			<?php echo $form->labelEx($model, "password"); ?>
			<?php echo $form->passwordField($model, "password", array("size" => 60, "maxlength" => 128, "required" => true)); ?>
			<?php echo $form->error($model, "password"); ?>
		</div>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, "email"); ?>
		<?php echo $form->textField($model, "email", array("maxlength" => 255, "required" => true)); ?>
		<?php echo $form->error($model, "email"); ?>
	</div>

	<div class="row line-inputs">
		<?php echo $form->labelEx($model, "branches"); ?>
		<?=CHTML::checkBoxList("Branches", $branches, CHtml::listData(Branch::model()->findAll(), "id", "name"), array("separator" => "", "template" => '<div class="line-item">{input}{label}</div>')); ?>
		<?php echo $form->error($model, "branches"); ?>
	</div>

	<div class="row clearfix">
		<div class="row-half">
			<?php echo $form->labelEx($model, "roles"); ?>
			<?=CHTML::checkBoxList("Roles", $roles, CHtml::listData(Role::model()->findAll(), "id", "name"), array()); ?>
			<?php echo $form->error($model, "Roles"); ?>
		</div>
		<div class="row-half">
			<?php echo $form->labelEx($model, "widgets"); ?>
			<?=CHTML::checkBoxList("Widgets", $widgets, CHtml::listData(Widget::model()->findAll(), "id", "name"), array()); ?>
			<?php echo $form->error($model, "widgets"); ?>
		</div>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? "Добавить" : "Сохранить"); ?>
		<input type="button" onclick="$.fancybox.close(); return false;" value="Отменить">
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->