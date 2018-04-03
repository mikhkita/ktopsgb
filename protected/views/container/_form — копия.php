<div class="b-popup-form b-popup-form-big">

<?php $form=$this->beginWidget("CActiveForm", array(
	"id"=>"faculties-form",
	"enableAjaxValidation"=>false,
)); ?>

<?

$item = $model;

$attrs = $item->attributes();

?>

	<?php echo $form->errorSummary($item); ?>
	<div class="row clearfix">
		<div class="row-fourth">
			<?php echo $form->labelEx($item, "exporter_id"); ?>
			<? $value = ""; eval($attrs["exporter_id"]["FORM"]); echo $value; ?>
			<?php echo $form->error($item, "exporter_id"); ?>
		</div>
		<div class="row-fourth">
			<?php echo $form->labelEx($item, "exporter_group_id"); ?>
			<? $value = ""; eval($attrs["exporter_group_id"]["FORM"]); echo $value; ?>
			<?php echo $form->error($item, "exporter_group_id"); ?>
		</div>
		<div class="row-fourth">
			<?php echo $form->labelEx($item, "number"); ?>
			<? $value = ""; eval($attrs["number"]["FORM"]); echo $value; ?>
			<?php echo $form->error($item, "number"); ?>
		</div>
		<div class="row-fourth">
			<?php echo $form->labelEx($item, "station_id"); ?>
			<? $value = ""; eval($attrs["station_id"]["FORM"]); echo $value; ?>
			<?php echo $form->error($item, "station_id"); ?>
		</div>
	</div>
	<div class="row clearfix">
		<div class="row-half">
			<?php echo $form->labelEx($item, "way_id"); ?>
			<? $value = ""; eval($attrs["way_id"]["FORM"]); echo $value; ?>
			<?php echo $form->error($item, "way_id"); ?>
		</div>
		<div class="row-fourth">
			<?php echo $form->labelEx($item, "destination_id"); ?>
			<? $value = ""; eval($attrs["destination_id"]["FORM"]); echo $value; ?>
			<?php echo $form->error($item, "destination_id"); ?>
		</div>
		<div class="row-fourth">
			<?php echo $form->labelEx($item, "owner_id"); ?>
			<? $value = ""; eval($attrs["owner_id"]["FORM"]); echo $value; ?>
			<?php echo $form->error($item, "owner_id"); ?>
		</div>
	</div>
	<div class="row clearfix">
		<div class="row-fourth">
			<?php echo $form->labelEx($item, "carrier_id"); ?>
			<? $value = ""; eval($attrs["carrier_id"]["FORM"]); echo $value; ?>
			<?php echo $form->error($item, "carrier_id"); ?>
		</div>
		<div class="row-fourth">
			<?php echo $form->labelEx($item, "stamp_type_id"); ?>
			<? $value = ""; eval($attrs["stamp_type_id"]["FORM"]); echo $value; ?>
			<?php echo $form->error($item, "stamp_type_id"); ?>
		</div>
		<div class="row-fourth">
			<?php echo $form->labelEx($item, "stamp_num"); ?>
			<? $value = ""; eval($attrs["stamp_num"]["FORM"]); echo $value; ?>
			<?php echo $form->error($item, "stamp_num"); ?>
		</div>
		<div class="row-fourth">
			<?php echo $form->labelEx($item, "weight"); ?>
			<? $value = ""; eval($attrs["weight"]["FORM"]); echo $value; ?>
			<?php echo $form->error($item, "weight"); ?>
		</div>
	</div>
	<div class="row clearfix">
		<div class="row-fourth">
			<?php echo $form->labelEx($item, "loading_date"); ?>
			<? $value = ""; eval($attrs["loading_date"]["FORM"]); echo $value; ?>
			<?php echo $form->error($item, "loading_date"); ?>
		</div>
		<div class="row-fourth">
			<?php echo $form->labelEx($item, "loading_place_id"); ?>
			<? $value = ""; eval($attrs["loading_place_id"]["FORM"]); echo $value; ?>
			<?php echo $form->error($item, "loading_place_id"); ?>
		</div>
		<div class="row-fourth">
			<?php echo $form->labelEx($item, "shipment_num"); ?>
			<? $value = ""; eval($attrs["shipment_num"]["FORM"]); echo $value; ?>
			<?php echo $form->error($item, "shipment_num"); ?>
		</div>
		<div class="row-fourth">
			<?php echo $form->labelEx($item, "railway_num"); ?>
			<? $value = ""; eval($attrs["railway_num"]["FORM"]); echo $value; ?>
			<?php echo $form->error($item, "railway_num"); ?>
		</div>
	</div>
	<div class="row clearfix">
		<div class="row-fourth">
			<?php echo $form->labelEx($item, "dt"); ?>
			<? $value = ""; eval($attrs["dt"]["FORM"]); echo $value; ?>
			<?php echo $form->error($item, "dt"); ?>
		</div>
		<div class="row-fourth">
			<?php echo $form->labelEx($item, "issue_date"); ?>
			<? $value = ""; eval($attrs["issue_date"]["FORM"]); echo $value; ?>
			<?php echo $form->error($item, "issue_date"); ?>
		</div>
		<div class="row-fourth">
			<?php echo $form->labelEx($item, "consignee_id"); ?>
			<? $value = ""; eval($attrs["consignee_id"]["FORM"]); echo $value; ?>
			<?php echo $form->error($item, "consignee_id"); ?>
		</div>
		<div class="row-fourth">
			<?php echo $form->labelEx($item, "border_date"); ?>
			<? $value = ""; eval($attrs["border_date"]["FORM"]); echo $value; ?>
			<?php echo $form->error($item, "border_date"); ?>
		</div>
	</div>
	<div class="row clearfix">
		<div class="row-half">
			<?php echo $form->labelEx($item, "container_place"); ?>
			<? $value = ""; eval($attrs["container_place"]["FORM"]); echo $value; ?>
			<?php echo $form->error($item, "container_place"); ?>
		</div>
		<div class="row-half row">
			<?php echo $form->labelEx($item, "arrival_date"); ?>
			<? $value = ""; eval($attrs["arrival_date"]["FORM"]); echo $value; ?>
			<?php echo $form->error($item, "arrival_date"); ?>
		</div>
		<div class="row-half">
			<?php echo $form->labelEx($item, "container_date"); ?>
			<? $value = ""; eval($attrs["container_date"]["FORM"]); echo $value; ?>
			<?php echo $form->error($item, "container_date"); ?>
		</div>
	</div>
	<div class="row clearfix">
		<div class="row-fourth">
			<?php echo $form->labelEx($item, "kc"); ?>
			<? $value = ""; eval($attrs["kc"]["FORM"]); echo $value; ?>
			<?php echo $form->error($item, "kc"); ?>
		</div>
		<div class="row-fourth">
			<?php echo $form->labelEx($item, "st"); ?>
			<? $value = ""; eval($attrs["st"]["FORM"]); echo $value; ?>
			<?php echo $form->error($item, "st"); ?>
		</div>
		<div class="row-fourth">
			<?php echo $form->labelEx($item, "dhl_st"); ?>
			<? $value = ""; eval($attrs["dhl_st"]["FORM"]); echo $value; ?>
			<?php echo $form->error($item, "dhl_st"); ?>
		</div>
		<div class="row-fourth">
			<?php echo $form->labelEx($item, "dhl_fit"); ?>
			<? $value = ""; eval($attrs["dhl_fit"]["FORM"]); echo $value; ?>
			<?php echo $form->error($item, "dhl_fit"); ?>
		</div>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($item->isNewRecord ? "Добавить" : "Сохранить"); ?>
		<input type="button" onclick="$.fancybox.close(); return false;" value="Отменить">
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->