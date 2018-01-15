<div class="b-popup-form">

<?php $form=$this->beginWidget("CActiveForm", array(
	"id"=>"faculties-form",
	"enableAjaxValidation"=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>
	<div class="row clearfix">
		<div class="row-half">
			<?php echo $form->labelEx($model, "date"); ?>
			<?php echo $form->textField($model, "date", array("maxlength" => 20, "required" => true, "class" => "date current" )); ?>
			<?php echo $form->error($model, "date"); ?>
		</div>
		<div class="row-half">
			<?php echo $form->labelEx($model, "sawmill_id"); ?>
			<?php echo $form->dropDownList($model, "sawmill_id", CHtml::listData(Sawmill::model()->findAll(), 'id', 'name'), array("class" => "select2", "required" => true)); ?>
			<?php echo $form->error($model, "sawmill_id"); ?>
		</div>
	</div>

	<div class="row clearfix">
		<? foreach ($planks as $i => $plank): ?>
			<div class="row-fourth">
				<label for="plank-<?=$plank->id?>"><?=$plank->name?> (<?=$plank->group->short?>)</label>
				<input type="text" class="float" name="Plank[<?=$plank->id?>]" id="plank-<?=$plank->id?>" value="<? if( isset($model->cubages[$plank->id]) ): ?><?=$model->cubages[$plank->id]?><? endif; ?>">
			</div>
			<? if( $i % 4 == 3 ): ?>
				</div>
				<div class="row clearfix">
			<? endif; ?>
		<? endforeach; ?>
	</div>

	<div class="row line-inputs">
		<?php echo $form->labelEx($model, "workers"); ?>
		<?=CHTML::checkBoxList("Worker", $workers, CHtml::listData(Worker::model()->findAll(), "id", "name"), array("separator" => "")); ?>
		<?php echo $form->error($model, "workers"); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? "Добавить" : "Сохранить"); ?>
		<input type="button" onclick="$.fancybox.close(); return false;" value="Отменить">
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->