<div class="b-popup-form">

<?php $form=$this->beginWidget("CActiveForm", array(
	"id"=>"faculties-form",
	"enableAjaxValidation"=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>
	<input type="hidden" name="Wood[payment_id]" value="<?=$_GET["payment_id"]?>">

	<div class="row clearfix">
		<div class="row-half">
			<?php echo $form->labelEx($model,"date"); ?>
			<?php echo $form->textField($model,"date", array("maxlength" => 20, "required" => true, "class" => "date current" )); ?>
			<?php echo $form->error($model,"date"); ?>
		</div>
		<div class="row-half">
			<?php echo $form->labelEx($model,"car"); ?>
			<?php echo $form->textField($model,"car", array("maxlength" => 50, "required" => true)); ?>
			<?php echo $form->error($model,"car"); ?>
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
			<?php echo $form->textField($model,"price", array("maxlength" => 20, "required" => true, "class" => "float" )); ?>
			<?php echo $form->error($model,"price"); ?>
		</div>
	</div>

	<? if( $_GET["payment_id"] == 1 ): ?>
		<div class="row">
			<?php echo $form->labelEx($model,"who"); ?>
			<?php echo $form->textField($model,"who", array("maxlength" => 128 )); ?>
			<?php echo $form->error($model,"who"); ?>
		</div>
	<? else: ?>
		<div class="row clearfix">
			<div class="row-half">
				<?php echo $form->labelEx($model, "provider_id"); ?>
				<?php echo $form->dropDownList($model, "provider_id", CHtml::listData(WoodProvider::model()->sorted()->findAll(), 'id', 'name'), array("class" => "select2", "empty" => "Не задано", "required" => true)); ?>
				<?php echo $form->error($model, "provider_id"); ?>
			</div>
			<div class="row-half line-inputs">
				<?php echo $form->labelEx($model,'paid'); ?>
				<?php echo $form->radioButtonList($model,'paid', array(1 => "Да", 0 => "Нет"), array("separator"=>"")); ?>
				<?php echo $form->error($model,'paid'); ?>
			</div>
		</div>
	<? endif; ?>

	<div class="row">
		<?php echo $form->labelEx($model,"comment"); ?>
		<?php echo $form->textField($model,"comment", array("maxlength" => 256 )); ?>
		<?php echo $form->error($model,"comment"); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? "Добавить" : "Сохранить"); ?>
		<input type="button" onclick="$.fancybox.close(); return false;" value="Отменить">
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->