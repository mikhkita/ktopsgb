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
			<?php echo $form->labelEx($model, "type_id"); ?>
			<?php echo $form->dropDownList($model, "type_id", CHtml::listData(ParabelType::model()->findAll(), 'id', 'name'), array("class" => "select2", "required" => true)); ?>
			<?php echo $form->error($model, "type_id"); ?>
		</div>
	</div>

	<div class="row clearfix">
		<? foreach ($providers as $i => $provider): ?>
			<div class="row-half">
				<label for="provider-<?=$provider->id?>"><?=$provider->name?></label>
				<input type="text" class="float" name="Provider[<?=$provider->id?>]" id="provider-<?=$provider->id?>" value="<? if( isset($model->cubages[$provider->id]) ): ?><?=$model->cubages[$provider->id]?><? endif; ?>">
			</div>
			<? if( $i % 2 == 1 ): ?>
				</div>
				<div class="row clearfix">
			<? endif; ?>
		<? endforeach; ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? "Добавить" : "Сохранить"); ?>
		<input type="button" onclick="$.fancybox.close(); return false;" value="Отменить">
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->