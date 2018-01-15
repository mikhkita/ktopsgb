<div class="b-popup-form">

<?php $form=$this->beginWidget("CActiveForm", array(
	"id" => "faculties-form",
	"enableAjaxValidation" => false,
)); ?>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="row clearfix">
		<div class="row-half">
			<?php echo $form->labelEx($model,"start_date"); ?>
			<?php echo $form->textField($model,"start_date",array("maxlength" => 50, "required" => true, "class" => "date current" )); ?>
			<?php echo $form->error($model,"start_date"); ?>
		</div>
		<div class="row-half">
			<?php echo $form->labelEx($model,"size"); ?>
			<?php echo $form->textField($model,"size",array("maxlength" => 250, "required" => true)); ?>
			<?php echo $form->error($model,"size"); ?>
		</div>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,"cubage"); ?>
		<?php echo $form->textField($model,"cubage",array("maxlength" => 510,  "required" => true)); ?>
		<?php echo $form->error($model,"cubage"); ?>
	</div>

	<div class="row clearfix">
		<div class="row-half">
			<?php echo $form->labelEx($model,"packs"); ?>
			<?php echo $form->textField($model,"packs",array("maxlength" => 120, "required" => true)); ?>
			<?php echo $form->error($model,"packs"); ?>
		</div>
		<div class="row-half">
			<?php echo $form->labelEx($model,"rows"); ?>
			<?php echo $form->textField($model,"rows",array("maxlength" => 120, "required" => true)); ?>
			<?php echo $form->error($model,"rows"); ?>
		</div>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,"comment"); ?>
		<?php echo $form->textArea($model,"comment", array("maxlength" => 1000, "required" => false)); ?>
		<?php echo $form->error($model,"comment"); ?>
	</div>
	<? if( Yii::app()->user->checkAccess("updateDryer") ): ?>
		<div class="row">
			<?php echo $form->labelEx($model,"complete_date"); ?>
			<?php echo $form->textField($model,"complete_date",array("maxlength" => 50, "class" => "date" )); ?>
			<?php echo $form->error($model,"complete_date"); ?>
		</div>
	<? endif; ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? "Добавить" : "Сохранить"); ?>
		<input type="button" onclick="$.fancybox.close(); return false;" value="Отменить">
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->