<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=8" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="ru" />
	<title><?php echo $this->pageTitle; ?></title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"> 
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.qtip.min.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/reset.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.fancybox.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/preloader.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/select2.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/plupload/jquery.plupload.queue/css/jquery.plupload.queue.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin.css?4" />

	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.qtip.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/plupload/plupload.full.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/plupload/jquery.plupload.queue/jquery.plupload.queue.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/tinymce/jquery.tinymce.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/tinymce/tinymce.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/select2.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/KitProgress.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.fancybox.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.maskedinput.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/numericInput.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/TweenMax.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/admin.js?4"></script>
    <?php foreach ($this->scripts AS $script): ?><script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/<?php echo $script?>.js"></script><? endforeach; ?>
</head>
<body>
    <div class="b-for-image-form"></div>
    <? if( Yii::app()->user->isGuest ): ?>
        <?php echo $content;?>
    <? else: ?>
        <div class="nav_container">
            <div class="who_am_i">
                <div class="b-user clearfix">
                    <div class="b-user-icon"></div>
                    <div class="b-user-info">
                        <h3><? echo $this->user->name; ?> <? echo $this->user->surname; ?></h3>
                        <small></small>
                    </div>
                </div>
                <div class="b-panel">
                    <div class="b-panel-icons">
                        <div class="b-panel-icons-wrap">
                            <div class="b-panel-icons-item b-panel-icons-home clearfix"><a title="Рабочий стол" href="/"></a></div>
                            <div class="b-panel-icons-item b-panel-icons-logout clearfix"><a title="Выйти" href="<?php echo $this->createUrl('site/logout')?>"></a></div>
                       </div>
                    </div>
                </div>
            </div>
            <ul class="modules">
                <?foreach ($this->adminMenu["items"] as $i => $menuItem):?>
                    <? if( ($menuItem->rule == NULL || Yii::app()->user->checkAccess($menuItem->rule) ) && $this->checkSubAccess($menuItem) ): ?>
                        <li class="b-menu-item" data-name="<?=$menuItem->code?>">
                            <a href="<?php echo $this->createUrl('/'.$menuItem->code.'/adminindex')?>" <? if(count($menuItem->submenu)): ?>class="b-menu-accordeon"<? endif; ?>><?=$menuItem->name?></a>
                            <? if(count($menuItem->submenu)): ?>
                                <ul class="b-submenu">
                                <?foreach ($menuItem->submenu as $j => $item):?>
                                   <? if( $item->rule == NULL || Yii::app()->user->checkAccess($item->rule) ): ?>
                                        <li data-name="<?=$item->code?>"><a href="<?php echo $this->createUrl('/'.$item->code.'/adminindex')?>"><?=$item->name?></a></li>
                                    <? endif; ?> 
                                <?endforeach;?>
                                </ul>
                            <? endif; ?>
                        </li>
                    <? endif; ?>
                <?endforeach;?>
            </ul>
            <? if(Yii::app()->params['debug']): ?>
                <div class="b-debug"><?=$this->debugText?></div>
            <? endif; ?>
        </div>
        <div class="main">
            <div class="b-main-center">
                <?php echo $content;?>
                <? 
                    list($queryCount, $queryTime) = Yii::app()->db->getStats();
                    echo "Кол-во запросов: $queryCount, Общее время запросов: ".sprintf('%0.5f',$queryTime)."s";
                ?>
            </div>
        </div>
    <? endif; ?>
</body>
</html>
