<div class="b-popup-form">

<?php $form=$this->beginWidget("CActiveForm", array(
	"id" => "faculties-form",
	"enableAjaxValidation" => false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row clearfix">
		<div class="row row-half">
			<?php echo $form->labelEx($model, "date"); ?>
			<?php echo $form->textField($model, "date", array("maxlength" => 20, "required" => true, "class" => "date current" )); ?>
			<?php echo $form->error($model, "date"); ?>
		</div>
	</div>

	<div class="row clearfix">
		<div class="row-half">
			<b><?=$labels["name"]?></b>
		</div>
		<div class="row-fourth">
			<b><?=$labels["k"]?></b>
		</div>
		<div class="row-fourth">
			<b><?=$labels["day_pay"]?></b>
		</div>
	</div>
	<? foreach ($workers as $i => $worker): ?>
		<div class="row clearfix">
			<div class="row-half">
				<?=$worker->name?>
			</div>
			<div class="row-fourth">
				<input type="text" class="float" autocomplete="off" name="Worker[<?=$worker->id?>][k]" value="<?=((isset($salary[$worker->id]))?$salary[$worker->id]->k:"")?>">
			</div>
			<div class="row-fourth">
				<input type="text" class="float" autocomplete="off" name="Worker[<?=$worker->id?>][day_pay]" value="<?=((isset($salary[$worker->id]))?$salary[$worker->id]->day_pay:"")?>">
			</div>
		</div>
	<? endforeach; ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? "Добавить" : "Сохранить"); ?>
		<input type="button" onclick="$.fancybox.close(); return false;" value="Отменить">
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->