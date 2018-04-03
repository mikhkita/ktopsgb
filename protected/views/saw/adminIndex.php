<div class="b-section-nav clearfix">
	<div class="b-section-nav-back clearfix">
		<span class="left"><b>Пилорама:</b></span>
		<ul class="b-section-menu clearfix left">
			<? foreach ($sawmills as $key => $sawmill): ?>
				<li><a href="<?=$this->createUrl('/'.$this->adminMenu['cur']->code.'/adminindex', array('sawmill_id' => $sawmill->id))?>"<? if($sawmill->id == $_GET["sawmill_id"]): ?> class="active"<? endif; ?>><?=$sawmill->name?></a></li>
			<? endforeach; ?>
		</ul>
	</div>
</div>
<? if( Yii::app()->user->checkAccess("updateSaw") ): ?><a href="<?php echo $this->createUrl("/".$this->adminMenu["cur"]->code."/admincreate",array("sawmill_id" => $_GET["sawmill_id"]))?>" class="ajax-form ajax-create b-butt b-top-butt b-with-nav">Добавить день</a><? endif; ?>
<h1 class="b-with-nav"><?=$this->adminMenu["cur"]->name?></h1>
<?php $form=$this->beginWidget("CActiveForm"); ?>
<table class="b-table" border="1">
	<tr>
		<th><?=$labels["date"]?></th>
		<? foreach ($planks as $key => $plank): ?>
			<th><?=$plank->name?> (<?=$plank->group->short?>)</th>
		<? endforeach; ?>
		<th><?=$labels["salary"]?></th>
		<th style="width: 90px;">Действия</th>
	</tr>
	<tr class="b-filter">
		<td></td>
		<? foreach ($planks as $key => $plank): ?>
			<td></td>
		<? endforeach; ?>
		<td></td>
		<td><a href="#" class="b-clear-filter">Сбросить</a></td>
	</tr>
	<? if( count($data) ): ?>
		<? foreach ($data as $i => $item): ?>
			<? $item->getCubages(); ?>
			<tr>
				<td class="tc"><?=$item->date?></td>
				<? foreach ($planks as $key => $plank): ?>
					<td class="tr"><? if( isset($item->cubages[$plank->id]) ): ?><?=$item->cubages[$plank->id]?><? endif; ?></td>
				<? endforeach; ?>
				<td class="tr"><?=number_format( $item->getMoney(), 0, ',', '&nbsp;' )?></td>
				<td>
					<? if( Yii::app()->user->checkAccess("updateSaw") ): ?>
						<a href="<?php echo Yii::app()->createUrl("/".$this->adminMenu["cur"]->code."/adminupdate",array("id"=>$item->id, "sawmill_id" => $_GET["sawmill_id"]))?>" class="ajax-form ajax-update b-tool b-tool-update" title="Редактировать <?=$this->adminMenu["cur"]->vin_name?>"></a>
						<a href="<?=Yii::app()->createUrl('/'.$this->adminMenu["cur"]->code.'/admindelete',array('id'=>$item->id, "sawmill_id" => $_GET["sawmill_id"]))?>" class="ajax-form ajax-delete b-tool b-tool-delete" title="Удалить <?=$this->adminMenu["cur"]->vin_name?>"></a></a>
					<? endif; ?>
				</td>
			</tr>
		<? endforeach; ?>
	<? else: ?>
		<tr><td colspan=100>Записей не найдено</td></tr>
	<? endif; ?>
</table>
<?php $this->endWidget(); ?>
<div class="b-pagination-cont clearfix">
    <?php $this->widget("CLinkPager", array(
        "header" => "",
        "lastPageLabel" => "последняя &raquo;",
        "firstPageLabel" => "&laquo; первая", 
        "pages" => $pages,
        "prevPageLabel" => "< назад",
        "nextPageLabel" => "далее >"
    )) ?>
    <div class="b-lot-count">Всего дней: <?=$count?></div>
</div>
