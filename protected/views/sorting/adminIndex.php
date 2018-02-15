<div class="b-section-nav clearfix">
	<div class="b-section-nav-back clearfix">
		<span class="left"><b>Компания:</b></span>
		<ul class="b-section-menu clearfix left">
			<? foreach ($companies as $key => $company): ?>
				<li><a href="<?=$this->createUrl('/'.$this->adminMenu['cur']->code.'/adminindex', array('company_id' => $company->id))?>"<? if($company->id == $_GET["company_id"]): ?> class="active"<? endif; ?>><?=$company->name?></a></li>
			<? endforeach; ?>
		</ul>

		<? /* ?>
		<span class="left"><b>Показывать:</b></span>
		<ul class="b-section-menu clearfix left">
			<li><a href="<?=$this->createUrl('/'.$this->adminMenu['cur']->code.'/adminindex', array("company_id" => $_GET["company_id"]))?>"<? if($this->isCurrentMonth($filter)): ?> class="active"<? endif; ?>>Текущий месяц</a></li>
			<li><a href="<?=$this->createUrl('/'.$this->adminMenu['cur']->code.'/adminindex', array("previous" => true, "company_id" => $_GET["company_id"]))?>"<? if($this->isPreviousMonth($filter)): ?> class="active"<? endif; ?>>Предыдущий месяц</a></li>
		</ul>

		<ul style="margin-left: 44px;" class="b-section-menu clearfix left">
			<li><a href="<?=$this->createUrl("/uploader/form", array("afterLoad" => "submitFile", "extensions" => "txt", "maxFiles" => "1", "selector" => "#file"))?>" class="b-get-file">Импорт</a></li>
		</ul>
		
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
<h1 class="b-with-nav"><?=$this->adminMenu["cur"]->name?></h1>
<input type="hidden" name="company_id" value="<?=$_GET["company_id"]?>">
<table class="b-table" border="1">
	<tr>
		<th><?=$labels["date"]?></th>
		<th><?=$labels["number"]?></th>
		<th><?=$labels["correspondent_id"]?></th>
		<th><?=$labels["purpose"]?></th>
		<th><?=$labels["sum"]?></th>
		<th><?=$labels["category_id"]?></th>
	</tr>
	<? if(count($data)): ?>
		<? foreach ($data as $i => $item): ?>
			<tr>
				<td class="tc"><?=$item->date?></td>
				<td><?=$item->number?></td>
				<td><?=$item->correspondent->name?></td>
				<td><?=$item->purpose?></td>
				<td class="tr <?=(($item->negative)?"red":"green")?>"><?=(($item->negative)?"-":"+")?><?=number_format( $item->sum, 0, ',', '&nbsp;' )?></td>
				<td>
					<?php $form=$this->beginWidget('CActiveForm', array(
						"action" => Yii::app()->createUrl('/'.$this->adminMenu["cur"]->code.'/adminUpdate', array('id' => $item->id)),
						"method" => "POST",
						"htmlOptions" => array(
							"class" => "b-with-select2"
						),
					)); ?>
						<?php echo $form->dropDownList($item, "category_id", $options, array("class" => "select2 b-ajax-update")); ?>
					<?php $this->endWidget(); ?>
				</td>
			</tr>
		<? endforeach; ?>
	<? else: ?>
		<tr>
			<td colspan=10>Все поручения распределены</td>
		</tr>
	<? endif; ?>
</table>
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
</div>
<? if( Yii::app()->user->checkAccess('updateOrder') ): ?>
<div class="tc">
	<a href="<?php echo $this->createUrl("/".$this->adminMenu["cur"]->code."/adminSubmit", array("company_id" => $_GET['company_id']))?>" class="b-butt">Утвердить все поручения</a>
</div>
<? endif; ?>

<form action="<?=Yii::app()->createUrl("/sorting/adminimport", array("company_id" => $_GET['company_id']))?>" method="POST" id="fileForm">
	<input type="hidden" name="file" id="file">
</form>
