<div class="b-popup b-group-popup">
    <h1>Настройка отображения</h1>
    
    <div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'faculties-form',
        'enableAjaxValidation'=>false,
    )); ?>
        <ul class="b-group-vars b-sortable-cont" id="b-sortable-cont">
            <?=CHTML::checkBoxList("view_fields", $selected, $attributes, array("separator"=>"","baseID"=>"arr".$key,"template"=>"<li class='checkbox-row b-sortable-row'>{input}{label}</li>")); ?>
        </ul>

        <div class="b-checkbox-nav">
            <a href="#" class="select-all" data-items=".b-group-vars input[type='checkbox']:not([value='number'])">Выделить все</a>
            <a href="#" class="select-none" data-items=".b-group-vars input[type='checkbox']:not([value='number'])">Сбросить выделение</a>
        </div>

        <div class="row buttons">
            <input type="hidden" name="submit" value="1">
            <?php echo CHtml::submitButton('Сохранить'); ?>
            <input type="button" onclick="$.fancybox.close(); return false;" value="Отменить">
        </div>

    <?php $this->endWidget(); ?>

    </div><!-- form -->
</div>