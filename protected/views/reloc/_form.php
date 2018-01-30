<div class="b-popup-form">

<?php $form=$this->beginWidget("CActiveForm", array(
	"id" => "faculties-form",
	"enableAjaxValidation" => false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row tc clearfix">
		<div class="row" style="width: 100%; max-width: 350px;">
			<?php echo $form->labelEx($model, "date"); ?>
			<?php echo $form->textField($model, "date", array("maxlength" => 20, "required" => true, "class" => "date current" )); ?>
			<?php echo $form->error($model, "date"); ?>
		</div>
	</div>
	<table class="b-table">
		<tr>
			<th><?=$labels["name"]?></th>
			<? foreach ($planks as $i => $plank): ?>
				<th><?=$plank->name?></th>
			<? endforeach; ?>
			<th><?=$labels["day_pay"]?></th>
		</tr>
		<? foreach ($workers as $i => $worker): ?>
			<tr>
				<td><?=$worker->name?></td>
				<? foreach ($planks as $j => $plank): ?>
					<td><input type="text" class="float" autocomplete="off" name="Reloc[<?=$worker->id?>][planks][<?=$plank->id?>]" value="<?=((isset($reloc[$worker->id."-".$plank->id]))?$reloc[$worker->id."-".$plank->id]->count:"")?>"></td>
				<? endforeach; ?>
				<td><input type="text" class="float" autocomplete="off" name="Reloc[<?=$worker->id?>][day_pay]" value="<?=((isset($salary[$worker->id]))?$salary[$worker->id]->day_pay:"")?>"></td>
			</tr>
		<? endforeach; ?>
	</table>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? "Добавить" : "Сохранить"); ?>
		<input type="button" onclick="$.fancybox.close(); return false;" value="Отменить">
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->