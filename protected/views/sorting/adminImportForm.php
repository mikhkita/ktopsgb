<div class="b-popup">
	<h1>Импорт поручений</h1>
	<div class="b-popup-form">

	<?php $form=$this->beginWidget("CActiveForm", array(
		"id" => "faculties-form",
		"enableAjaxValidation" => false,
		"htmlOptions" => array("class" => "no-ajax")
	)); ?>
		<input type="hidden" name="container_id" value="<?=$_GET["container_id"]?>">

		<div class="row">
			<input type="hidden" name="file" id="file">
			<?php $this->renderPartial("/uploader/form", array('maxFiles'=>1, 'extensions'=>'txt', 'title' => 'Импорт платежных поручений', 'selector' => '#file')); ?>
		</div>

		<div class="row buttons">
			<?php echo CHtml::submitButton("Импортировать"); ?>
			<input type="button" onclick="$.fancybox.close(); return false;" value="Отменить">
		</div>

	<?php $this->endWidget(); ?>

	</div><!-- form -->
</div>