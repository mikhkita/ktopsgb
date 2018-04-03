<?

if( !isset($extensions) ){
    $extensions = $_GET['extensions'];
}

if( !isset($maxFiles) ){
    $maxFiles = ( (isset($_GET["maxFiles"]) && intval($_GET["maxFiles"]) > 0 && ($_GET["maxFiles"]) < 10000)?$_GET["maxFiles"]:"1");
}

if( !isset($title) ){
    $title = $_GET['title'];
}

if( !isset($selector) ){
    $selector = $_GET['selector'];
}

if( !isset($afterLoad) ){
    $afterLoad = $_GET['afterLoad'];
}

if( !isset($tmpPath) ){
    $tmpPath = (isset($_GET['tmpPath']))?$_GET['tmpPath']:NULL;
}

?>

<div class="hidden" id="tp_head_text_data"><?=$title?></div>
<!-- <form action="/adv/setAdvImg?id=" method="POST" id="uploader"> -->
    <div class="upload">
        <h3><?=$title?></h3>
        <!-- <div class="max-files">Оставшееся количество изображений: <span class="max-files-count" data-count=""></span></div> -->
        <div id="uploaderPj">Ваш браузер не поддерживает Flash.</div>
        <div class="b-save-buttons">
            <a href="#" class="plupload_button plupload_save">Сохранить</a>
            <a href="#" class="plupload_button plupload_cancel" >Отменить</a>
        </div>
    </div>
    <div class="b-upload-overlay"></div>
<!-- </form> -->
<script>
$(function () {
    var maxfiles = <?=$maxFiles?>,
        error = false;

    $("#uploaderPj").pluploadQueue({
        runtimes : 'html5',                          
        url : "<? echo Yii::app()->createUrl('/uploader/upload'); ?>",
        max_file_size : '30mb',
        max_file_count: maxfiles,
        chunk_size : '1mb',
        unique_names : true,
        multi_selection:false,
        resize: {
            width: 800,
            height: 600
        },
        filters : [
            {title : "Files", extensions : "<?=$extensions?>" }
        ],
        init : {
            FilesAdded: function(up, files) {
                for( var i = up.files.length-1 ; i > 0 ; i-- ){
                    if( i >= maxfiles ) up.files.splice(i,1);
                }
                if (up.files.length >= maxfiles) {
                    $('.plupload_add').hide();
                    $('#uploaderPj').addClass("blocked_brow");
                }
                $(".max-files-count").html( maxfiles - up.files.length );
            },
            FilesRemoved: function(up, files) {
                $(".max-files-count").html( maxfiles - up.files.length );
                if (up.files.length < maxfiles) {
                    $('.plupload_add').show();
                    $('#uploaderPj').removeClass("blocked_brow");
                }
            },
            UploadComplete: function(){
                var tmpArr = [];
                if( !error ){
                    $(".plupload_filelist .plupload_done").each(function(){
                        tmpArr.push($(this).find("input").eq(0).val());
                    });
                    $("<?=$selector?>").val(<?if(isset($tmpPath)):?>"<?=$tmpPath?>/"+<?endif;?>tmpArr.join(',')).trigger("change");
                    $(".plupload_save").click();
                    $(".b-save-buttons").fadeIn(300);

                    <?if(isset($afterLoad)):?>
                        customHandlers["<?=$afterLoad?>"](tmpArr);
                    <?endif;?>
                }
            },
            FileUploaded: function(upldr, file, object) {
                var myData;
                try {
                    myData = eval(object.response);
                } catch(err) {
                    myData = eval('(' + object.response + ')');
                }
                if( myData.result != "success" ){
                    error = true;
                    alert(myData.error.message);
                }
            }
        }
    });
    if( !maxfiles ){
        $('.plupload_add').addClass("plupload_disabled");
        $('#uploaderPj').addClass("blocked_brow");
    }

});
</script>
