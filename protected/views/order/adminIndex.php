<div class="b-section-nav clearfix">
	<div class="b-section-nav-back clearfix">
		<span class="left"><b>Компания:</b></span>
		<ul class="b-section-menu clearfix left">
			<? foreach ($companies as $key => $company): ?>
				<li><a href="<?=$this->createUrl('/'.$this->adminMenu['cur']->code.'/adminindex', array('company_id' => $company->id))?>"<? if($company->id == $_GET["company_id"]): ?> class="active"<? endif; ?>><?=$company->name?></a></li>
			<? endforeach; ?>
		</ul>

		<span class="left"><b>Показывать:</b></span>
		<ul class="b-section-menu clearfix left">
			<li><a href="<?=$this->createUrl('/'.$this->adminMenu['cur']->code.'/adminindex', array("company_id" => $_GET["company_id"]))?>"<? if($this->isCurrentMonth($filter)): ?> class="active"<? endif; ?>>Текущий месяц</a></li>
			<li><a href="<?=$this->createUrl('/'.$this->adminMenu['cur']->code.'/adminindex', array("previous" => true, "company_id" => $_GET["company_id"]))?>"<? if($this->isPreviousMonth($filter)): ?> class="active"<? endif; ?>>Предыдущий месяц</a></li>
		</ul>

		<ul style="margin-left: 44px;" class="b-section-menu clearfix left">
			<li><a href="<?=$this->createUrl("/uploader/form", array("afterLoad" => "submitFile", "extensions" => "txt", "maxFiles" => "1", "selector" => "#file"))?>" class="b-get-file">Импорт</a></li>
		</ul>
		<? /* ?>
		<ul style="margin-left: 44px;" class="b-section-menu clearfix left">
			<li><a>Импорт</a>
				<ul class="b-section-submenu">
					<li><a href="" class="b-get-file">Дром&nbsp;платные</a></li>
					<li><a href="" class="b-get-file">Авито&nbsp;бесплатные</a></li>
				</ul>
			</li>
		</ul>
		<? */ ?>
	</div>
</div>
<? if( Yii::app()->user->checkAccess('updateOrder') ): ?><a href="<?php echo $this->createUrl("/".$this->adminMenu["cur"]->code."/adminCreate", array("company_id" => $_GET["company_id"]))?>" class="ajax-form ajax-create b-butt b-top-butt b-with-nav">Добавить</a><? endif; ?>
<h1 class="b-with-nav"><?=$this->adminMenu["cur"]->name?></h1>
<?php $form=$this->beginWidget('CActiveForm'); ?>
<input type="hidden" name="company_id" value="<?=$_GET["company_id"]?>">
<table class="b-table" border="1">
	<tr>
		<th style="width: 210px; min-width: 210px;"><?=$labels["date"]?></th>
		<th><?=$labels["number"]?></th>
		<th><?=$labels["correspondent_id"]?></th>
		<th><?=$labels["purpose"]?></th>
		<th><?=$labels["sum"]?></th>
		<th><?=$labels["category_id"]?></th>
		<th style="width: 100px;">Действия</th>
	</tr>
	<tr class="b-filter">
		<td><?php echo CHtml::activeTextField($filter, 'date_from', array('tabindex' => 0, "placeholder" => "От", "class" => "date")); ?><span class="filter-separator">-</span><?php echo CHtml::activeTextField($filter, 'date_to', array('tabindex' => 0, "placeholder" => "До", "class" => "date")); ?></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td><?php echo CHtml::activeDropDownList($filter, 'category_id', CHtml::listData(Category::model()->active()->findAll(), 'id', 'name'), array("class" => "select2", "empty" => "Все категории", "tabindex" => 1, "placeholder" => "Поиск по категории")); ?></td>
		<td><a href="#" class="b-clear-filter">Сбросить</a></td>
	</tr>
	<? if(count($data)): ?>
		<? foreach ($data as $i => $item): ?>
			<tr>
				<td class="tc"><?=$item->date?></td>
				<td><?=$item->number?></td>
				<td><?=$item->correspondent->name?></td>
				<td><?=$item->purpose?></td>
				<td class="tr <?=(($item->negative)?"red":"green")?>"><?=(($item->negative)?"-":"+")?><?=number_format( $item->sum, 2, ',', '&nbsp;' )?></td>
				<td><?=$item->category->name?></td>
				<td>
					<? if( Yii::app()->user->checkAccess('updateOrder') ): ?><a href="<?php echo Yii::app()->createUrl('/'.$this->adminMenu["cur"]->code.'/adminupdate',array('id'=>$item->id, "company_id" => $_GET["company_id"]))?>" class="ajax-form ajax-update b-tool b-tool-update" title="Редактировать <?=$this->adminMenu["cur"]->vin_name?>"></a>
					<a href="<?=Yii::app()->createUrl('/'.$this->adminMenu["cur"]->code.'/admindelete',array('id'=>$item->id))?>" class="ajax-form ajax-delete b-tool b-tool-delete" title="Удалить <?=$this->adminMenu["cur"]->vin_name?>"></a><? endif; ?>
				</td>
			</tr>
		<? endforeach; ?>
	<? else: ?>
		<tr>
			<td colspan=10>Поручений не найдено. Попробуйте изменить фильтр</td>
		</tr>
	<? endif; ?>
</table>
<?php $this->endWidget(); ?>
<div class="b-pagination-cont clearfix">
    <?php $this->widget('CLinkPager', array(
        'header' => '',
        'lastPageLabel' => 'последняя &raquo;',
        'firstPageLabel' => '&laquo; первая', 
        'pages' => $pages,
        'prevPageLabel' => '< назад',
        'nextPageLabel' => 'далее >'
    )) ?>
    <div class="b-lot-count">Всего поручений: <?=$count?></div>
    <div class="b-total right">
		<div class="b-total-row">
			<span class="b-total-name">Итого: </span>
			<span class="b-total-bold"><?=number_format( $total, 2, '.', '&nbsp;' )?></span>
		</div>
	</div>
</div>

<form action="<?=Yii::app()->createUrl("/sorting/adminimport", array("company_id" => $_GET['company_id']))?>" method="POST" id="fileForm">
	<input type="hidden" name="file" id="file">
</form>
