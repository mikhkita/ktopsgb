<div class="b-popup-form b-popup-form-big">

<?php $form=$this->beginWidget("CActiveForm", array(
	"id"=>"faculties-form",
	"enableAjaxValidation"=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>
	<div class="row clearfix">
		<div class="row-fourth">
			<?php echo $form->labelEx($model, "exporter_id"); ?>
			<?php echo $form->dropDownList($model, "exporter_id", CHtml::listData(Exporter::model()->with("group.branches")->findAll("branches.branch_id=".$_GET["branch_id"]), "id", "name"), array("class" => "select2", "empty" => "Не задано")); ?>
			<?php echo $form->error($model, "exporter_id"); ?>
		</div>
		<div class="row-fourth">
			<?php echo $form->labelEx($model, "exporter_group_id"); ?>
			<?php echo $form->dropDownList($model, "exporter_group_id", CHtml::listData(ExporterGroup::model()->with("branches")->findAll("branches.branch_id=".$_GET["branch_id"]), "id", "name"), array("class" => "select2", "empty" => "Не задано", "required" => true)); ?>
			<?php echo $form->error($model, "exporter_group_id"); ?>
		</div>
		<div class="row-fourth">
			<?php echo $form->labelEx($model, "number"); ?>
			<?php echo $form->textField($model, "number", array("maxlength" => 15, "required" => true)); ?>
			<?php echo $form->error($model, "number"); ?>
		</div>
		<div class="row-fourth">
			<?php echo $form->labelEx($model, "station_id"); ?>
			<?php echo $form->dropDownList($model, "station_id", CHtml::listData(Station::model()->findAll("branch_id=".$_GET["branch_id"]), "id", "name"), array("class" => "select2", "required" => true)); ?>
			<?php echo $form->error($model, "station_id"); ?>
		</div>
	</div>
	<div class="row clearfix">
		<div class="row-half">
			<?php echo $form->labelEx($model, "way_id"); ?>
			<?php echo $form->dropDownList($model, "way_id", CHtml::listData(Way::model()->findAll(), "id", "name"), array("class" => "select2", "empty" => "Не задано", "required" => true)); ?>
			<?php echo $form->error($model, "way_id"); ?>
		</div>
		<div class="row-fourth">
			<?php echo $form->labelEx($model, "destination_id"); ?>
			<?php echo $form->dropDownList($model, "destination_id", CHtml::listData(Destination::model()->findAll(), "id", "name"), array("class" => "select2", "empty" => "Не задано", "required" => true)); ?>
			<?php echo $form->error($model, "destination_id"); ?>
		</div>
		<div class="row-fourth">
			<?php echo $form->labelEx($model, "owner_id"); ?>
			<?php echo $form->dropDownList($model, "owner_id", CHtml::listData(Owner::model()->findAll(), "id", "name"), array("class" => "select2", "empty" => "Не задано")); ?>
			<?php echo $form->error($model, "owner_id"); ?>
		</div>
	</div>
	<div class="row clearfix">
		<div class="row-fourth">
			<?php echo $form->labelEx($model, "carrier_id"); ?>
			<?php echo $form->dropDownList($model, "carrier_id", CHtml::listData(Carrier::model()->findAll(), "id", "name"), array("class" => "select2", "empty" => "Не задано")); ?>
			<?php echo $form->error($model, "carrier_id"); ?>
		</div>
		<div class="row-fourth">
			<?php echo $form->labelEx($model, "stamp_type_id"); ?>
			<?php echo $form->dropDownList($model, "stamp_type_id", CHtml::listData(StampType::model()->findAll(), "id", "name"), array("class" => "select2", "empty" => "Не задано")); ?>
			<?php echo $form->error($model, "stamp_type_id"); ?>
		</div>
		<div class="row-fourth">
			<?php echo $form->labelEx($model, "stamp_num"); ?>
			<?php echo $form->textField($model, "stamp_num", array("maxlength" => 15)); ?>
			<?php echo $form->error($model, "stamp_num"); ?>
		</div>
		<div class="row-fourth">
			<?php echo $form->labelEx($model, "weight"); ?>
			<?php echo $form->textField($model, "weight", array("maxlength" => 11, "class" => "numeric")); ?>
			<?php echo $form->error($model, "weight"); ?>
		</div>
	</div>
	<div class="row clearfix">
		<div class="row-fourth">
			<?php echo $form->labelEx($model, "loading_date"); ?>
			<?php echo $form->textField($model, "loading_date", array("maxlength" => 20, "class" => "date" )); ?>
			<?php echo $form->error($model, "loading_date"); ?>
		</div>
		<div class="row-fourth">
			<?php echo $form->labelEx($model, "loading_place_id"); ?>
			<?php echo $form->dropDownList($model, "loading_place_id", CHtml::listData(LoadingPlace::model()->findAll(), "id", "name"), array("class" => "select2", "empty" => "Не задано")); ?>
			<?php echo $form->error($model, "loading_place_id"); ?>
		</div>
		<div class="row-fourth">
			<?php echo $form->labelEx($model, "shipment_num"); ?>
			<?php echo $form->textField($model, "shipment_num", array("maxlength" => 15)); ?>
			<?php echo $form->error($model, "shipment_num"); ?>
		</div>
		<div class="row-fourth">
			<?php echo $form->labelEx($model, "railway_num"); ?>
			<?php echo $form->textField($model, "railway_num", array("maxlength" => 15)); ?>
			<?php echo $form->error($model, "railway_num"); ?>
		</div>
	</div>
	<div class="row clearfix">
		<div class="row-fourth">
			<?php echo $form->labelEx($model, "dt"); ?>
			<?php echo $form->textField($model, "dt", array("maxlength" => 30)); ?>
			<?php echo $form->error($model, "dt"); ?>
		</div>
		<div class="row-fourth">
			<?php echo $form->labelEx($model, "issue_date"); ?>
			<?php echo $form->textField($model, "issue_date", array("maxlength" => 20, "class" => "date" )); ?>
			<?php echo $form->error($model, "issue_date"); ?>
		</div>
		<div class="row-fourth">
			<?php echo $form->labelEx($model, "consignee_id"); ?>
			<?php echo $form->dropDownList($model, "consignee_id", CHtml::listData(Consignee::model()->findAll(), "id", "name"), array("class" => "select2", "empty" => "Не задано")); ?>
			<?php echo $form->error($model, "consignee_id"); ?>
		</div>
		<div class="row-fourth">
			<?php echo $form->labelEx($model, "border_date"); ?>
			<?php echo $form->textField($model, "border_date", array("maxlength" => 20, "class" => "date" )); ?>
			<?php echo $form->error($model, "border_date"); ?>
		</div>
	</div>
	<div class="row clearfix">
		<div class="row-half">
			<?php echo $form->labelEx($model, "container_place"); ?>
			<?php echo $form->textArea($model, "container_place", array("maxlength" => 5000)); ?>
			<?php echo $form->error($model, "container_place"); ?>
		</div>
		<div class="row-half row">
			<?php echo $form->labelEx($model, "arrival_date"); ?>
			<?php echo $form->textField($model, "arrival_date", array("maxlength" => 20, "class" => "date" )); ?>
			<?php echo $form->error($model, "arrival_date"); ?>
		</div>
		<div class="row-half">
			<?php echo $form->labelEx($model, "container_date"); ?>
			<?php echo $form->textField($model, "container_date", array("maxlength" => 20, "class" => "date" )); ?>
			<?php echo $form->error($model, "container_date"); ?>
		</div>
	</div>
	<div class="row clearfix">
		<div class="row-fourth">
			<?php echo $form->labelEx($model, "kc"); ?>
			<?php echo $form->textField($model, "kc", array("maxlength" => 30)); ?>
			<?php echo $form->error($model, "kc"); ?>
		</div>
		<div class="row-fourth">
			<?php echo $form->labelEx($model, "st"); ?>
			<?php echo $form->textField($model, "st", array("maxlength" => 30)); ?>
			<?php echo $form->error($model, "st"); ?>
		</div>
		<div class="row-fourth">
			<?php echo $form->labelEx($model, "dhl_st"); ?>
			<?php echo $form->textField($model, "dhl_st", array("maxlength" => 30)); ?>
			<?php echo $form->error($model, "dhl_st"); ?>
		</div>
		<div class="row-fourth">
			<?php echo $form->labelEx($model, "dhl_fit"); ?>
			<?php echo $form->textField($model, "dhl_fit", array("maxlength" => 30)); ?>
			<?php echo $form->error($model, "dhl_fit"); ?>
		</div>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? "Добавить" : "Сохранить"); ?>
		<input type="button" onclick="$.fancybox.close(); return false;" value="Отменить">
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->