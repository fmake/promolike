<?php 
	ini_set('memory_limit','128M' );
	require('../../libs/FController.php');
	$modulObj = new fmakeAdminController();
	require_once(ROOT.'/admin/checklogin.php');
	//printAr($_GET);
	if($_GET[sort]){
		$array = $_GET[sort];
		$fmakeGalleryImage = new fmakeGalleryNew_Image();
		foreach ($array as $key=>$item){
			$fmakeGalleryImage->editImageSort($_GET[id_gallery], $item, $key);
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<title>Галлерея</title>
	<link rel="stylesheet" type="text/css" media="screen" href="templates/screen.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="js/uploadify/uploadify.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="js/overlay/overlay-minimal.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="js/tags/tags.css" />
	<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui.custom.min.js"></script>
	<script type="text/javascript" src="js/tools.overlay.min.js"></script>
	<script type="text/javascript" src="js/uploadify/swfobject.js"></script>
	<script type="text/javascript" src="js/uploadify/jquery.uploadify.min.js"></script>
	<script type="text/javascript" src="js/tags/tags.js"></script>
</head>
<body style="padding: 20px;">
<?php if($_GET[id_gallery]){?>
<script type="text/javascript">

$(document).ready(function(){
	$("#uploadify").uploadify({
		'uploader': 'js/uploadify/uploadify.swf',
		'script': '/modules/fmakeGalleryNew/uploadify.php?id_gallery=<?php echo($_GET[id_gallery]); ?>',
		'checkScript': '/modules/fmakeGalleryNew/check.php',
		//'scriptData': '"action": "upload"',
		'folder': '/images/galleries/',
		'multi': true,
		'fileDesc': 'Image Files',
		'fileExt': '*.jpg;*.JPG;*.png;*.gif',
		'simUploadLimit': 2,
		'sizeLimit': 7097152,
		'buttonText': ' ',
		'buttonImg':'images/button-fmake-gallery.gif',
		'width': 153,
		'height': 38,
		'auto': true,
		'cancelImg': '/modules/fmakeGalleryNew/js/uploadify/cancel.png',
		'onComplete': function(event, queueID, fileObj, response, data) {
            var uploadList = $('#uploadList');
            //alert(data);
            uploadList.append("<li><img class=\"thb\" width=\"145\" src=\"/images/galleries/<?php echo($_GET[id_gallery]); ?>/thumbs/"+escape(fileObj.name) + "\" alt=\"" + fileObj.name + "\" class=\"thb\" /><input type=\"hidden\" name=\"sort[]\" value=\"" + escape(fileObj.name) + "\" /></li>");
        },
        'onAllComplete': function(){
            $(".thbButtons").hide();
        }
	});
    $('#uploadFiles').click(function(){
        $('#uploadify').uploadifyUpload();
        return false;
    });
    $('#clearQueue').click(function(){
        $('#uploadify').uploadifyClearQueue();
        return false;
    });
	if($('#uploadList').length > 0){
        $(".thbButtons").hide();
        $("#uploadList li").live("mouseover", function(){
                $(this).find(".thbButtons").show();
        });
        $("#uploadList li").live("mouseout", function(){
                $(this).find(".thbButtons").hide();
        });
        $(".thbButtons .delete").live("click", function(event){
            if(confirm('Are you sure you want to delete this image?')){
                $.get($(this).attr('href'));
                $(this).parent().parent('li').remove();            
            }
            return false;
        });
       
	}
	 $("#uploadList").sortable();
});
</script>

<h2 class="second">Модуль загрузки файлов.</h2>

<form action="index.php" method="get" enctype="multipart/form-data">
	<input type="hidden" name="id_gallery" value="<?php echo($_GET[id_gallery]); ?>">
<div id="uploadContainer">
		<!-- <p><strong>TIP:</strong> You can select multiple files with CTRL and SHIFT combinations.</p>  -->
        <input id="uploadify" name="uploadify" type="file" /> 
        <!-- <a href="#" id="uploadFiles">Upload Files</a> | <a href="#" id="clearQueue">Clear Queue</a> -->
</div>
<!--  <p id="sortdesc">Drag the images to and click save below to update the order in which they are displayed.</p> -->
<div id="uploadFiles"><ul id="uploadList" class="ui-sortable">
<?php 
	$absitem_photo = new fmakeGalleryNew_Image();
	$all_photo = $absitem_photo->getFullPhoto($_GET[id_gallery]);
	if($all_photo){
		foreach($all_photo as $photo){
			$content .='<li>
							<img class="thb" width="150" src="/images/galleries/'.$_GET[id_gallery].'/thumbs/'.$photo[image].'">
							<input type="hidden" name="sort[]" value="'.$photo[image].'" />
						</li>';
		}
		echo($content);
	}
?>
</ul></div>
<div class="submit">
	 <input type="submit" id="cmdsort" name="cmdsort" value="Сохранить сортировку" title="Нажмите для сохранения сортировки" />
</div>
</form>
<?php }else{?>
<h1>Для того чтобы начать работать с галлереей сохраните пожалуйста проект.</h1>
<?php }?>
<div class="overlay" id="overlay"> 
    <div class="contentWrap"></div>  
</div>
</body>
</html>
