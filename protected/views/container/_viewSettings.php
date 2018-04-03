<div class="b-popup b-group-popup">
    <h1>Настройка отображения</h1>
    
    <div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'faculties-form',
        'enableAjaxValidation'=>false,
    )); ?>
        <div class="b-group-vars">
            <? foreach ($attributes as $key => $attrs): ?>
                <div class="b-group-col">
                    <?=CHTML::checkBoxList("view_fields", $selected, $attrs, array("separator"=>"","baseID"=>"arr".$key,"template"=>"<div class='checkbox-row'>{input}{label}</div>")); ?>
                </div>
            <? endforeach; ?>
        </div>

        <div class="b-checkbox-nav">
            <a href="#" class="select-all" data-items=".b-group-col input[type='checkbox']">Выделить все</a>
            <a href="#" class="select-none" data-items=".b-group-col input[type='checkbox']">Сбросить выделение</a>
        </div>

        <div class="row buttons">
            <input type="hidden" name="submit" value="1">
            <?php echo CHtml::submitButton('Сохранить'); ?>
            <input type="button" onclick="$.fancybox.close(); return false;" value="Отменить">
        </div>

    <?php $this->endWidget(); ?>

    </div><!-- form -->
</div>