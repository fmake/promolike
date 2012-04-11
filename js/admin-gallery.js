$(document).ready(function(){	
	$('#link-gallery').live('click',function(){
		$('#iframe-pole').html('<iframe style="overflow: hidden;border: 1px solid black;" width="700" height="400" src="'+$(this).attr('href')+'">');
		$('#iframe').show(200);
		return false;
	});
	$('#edit-image').live('click',function(){
		//var obj = $(this);
		//$('#input_image_name').attr('value',$(this).attr('rel'));
		//var name_image = $(this).attr('rel');
		//var id_gallery = $('#id_gallery').text();
		//$('#iframe-pole').html('<div style="background: white;"><div style="float:left; padding: 20px;"><img width="250" id="overlay-image" src="'+$(this).attr("href")+'"></div><div style="float:left; padding: 20px;"><form><input type="hidden" name="modul" value="project"><input type="hidden" name="action" value="edit"><input type="hidden" name="action2" value="editimage"><input type="hidden" name="id" value="'+id_gallery+'"><input id="input_image_name" type="hidden" name="image" value="'+name_image+'"><label>Title</label><br /><input type="text" name="title"><br /><input id="btn-overlay-save" type="submit" value="Сохранить"></form></div>');
		$('#iframe').show(200);
		return false;
	});
	/*$('#btn-overlay-save').live('click',function(){
		$.ajax({
			  url: "/modules/fmakeGalleryNew/edit-image.php",
			  data: $('#overlay form').serialize(),
			  type: "POST",
			  success: function(data){
				  //alert(jQuery('div#qq',data).html());
				  $('#overlay').css('display','none');
			  }
		});
		
	});*/
});