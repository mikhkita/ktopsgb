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
		<div class="row-half" style="display:none;">
			<?php echo $form->labelEx($model, "plant_id"); ?>
			<?php echo $form->dropDownList($model, "plant_id", CHtml::listData(Plant::model()->findAll(), 'id', 'name'), array("class" => "select2", "required" => true)); ?>
			<?php echo $form->error($model, "plant_id"); ?>
		</div>
	</div>
	<div class="row">
		<h1>Позиции</h1>
	</div>
	<? $cols = ($plant->is_price)?"five":"fourth"; ?>
	<div class="clearfix" style="text-align: left;">
		<div class="row-<?=$cols?>">
			<label>Длина <span class="required">*</span></label>
		</div>
		<div class="row-<?=$cols?>">
			<label>Толщина <span class="required">*</span></label>
		</div>
		<div class="row-<?=$cols?>">
			<label>Ширина <span class="required">*</span></label>
		</div>
		<div class="row-<?=$cols?>">
			<label>Количество <span class="required">*</span></label>
		</div>
		<? if( $plant->is_price ): ?>
			<div class="row-<?=$cols?>">
				<label>Цена <span class="required">*</span></label>
			</div>
		<? endif; ?>
	</div>	
	<div class="b-for-new-inputs without-error-labels">
		<? if( isset($model->items) && count($model->items) ): ?>
			<? foreach ($model->items as $i => $item): ?>
				<div class="row clearfix" data-id="<?=$i?>">
					<div class="row-<?=$cols?>">
						<input type="text" name="Items[<?=$i?>][length]" id="le-<?=$i?>" value="<?=$item->length?>" maxlength="30" class="float" required>
					</div>
					<div class="row-<?=$cols?>">
						<input type="text" name="Items[<?=$i?>][thickness]" id="th-<?=$i?>" value="<?=$item->thickness?>" maxlength="30" class="float" required>
					</div>
					<div class="row-<?=$cols?>">
						<input type="text" name="Items[<?=$i?>][width]" id="wi-<?=$i?>" value="<?=$item->width?>" maxlength="30" class="float" required>
					</div>
					<div class="row-<?=$cols?>">
						<input type="text" name="Items[<?=$i?>][count]" id="co-<?=$i?>" value="<?=$item->count?>" maxlength="30" class="float" required>
					</div>
					<? if( $plant->is_price ): ?>
						<div class="row-<?=$cols?>">
							<input type="text" name="Items[<?=$i?>][price]" id="pr-<?=$i?>" value="<?=$item->price?>" maxlength="30" class="float" required>
						</div>
					<? endif; ?>
				</div>	
			<? endforeach; ?>
		<? endif; ?>
	</div>
	<div class="row buttons">
		<input type="button" class="add-new-inputs" value="Добавить позиции">
	</div>
	<div class="b-board-sum">
		Всего кубов: <b>0</b> куб. м.
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? "Добавить" : "Сохранить"); ?>
		<input type="button" onclick="$.fancybox.close(); return false;" value="Отменить">
	</div>

<?php $this->endWidget(); ?>

<div id="input-template" style="display: none;">
	<div class="row clearfix" data-id="#">
		<div class="row-<?=$cols?>">
			<input type="text" name="Items[#][length]" id="le-#" maxlength="30" class="float" required>
		</div>
		<div class="row-<?=$cols?>">
			<input type="text" name="Items[#][thickness]" id="th-#" maxlength="30" class="float" required>
		</div>
		<div class="row-<?=$cols?>">
			<input type="text" name="Items[#][width]" id="wi-#" maxlength="30" class="float" required>
		</div>
		<div class="row-<?=$cols?>">
			<input type="text" name="Items[#][count]" id="co-#" maxlength="30" class="float" required>
		</div>
		<? if( $plant->is_price ): ?>
			<div class="row-<?=$cols?>">
				<input type="text" name="Items[#][price]" id="pr-#" maxlength="30" class="float" required>
			</div>
		<? endif; ?>
	</div>	
</div>

</div><!-- form -->