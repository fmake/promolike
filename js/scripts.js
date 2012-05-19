function getObj(id){
	return document.getElementById(id);
}

function changeBg(obj,bg){
	$("#"+obj).css("background-image", "url('"+bg+"')" );
}

function addClass(obj,clName,selector) {
	$("#"+selector+" td").removeClass(clName);
	$(obj).addClass(clName);
	
} 

function addClassChoseArea(obj,clName,selector) {
	$("#"+selector+" A").removeClass(clName);
	$(obj).addClass(clName);
	
} 

function moveHindle(left,right,move,startCount,myDx){
	var count = move.find("td").length;
	var current = startCount;
	var speed = 500;
	var dx = 220;
	if(myDx){
		dx = myDx;
	}

	change = 3;
	//alert(count);
	left.css("display","none");
	right.click(function(){
       	if( current >= count ){
        	 return;
       	}
        current+=change;
        move.animate({marginLeft: "-="+dx*change}, speed);
        left.show();
    });
    
    left.click(function(){
    	//alert(current);
    	if(current < startCount + change){
    		//left.hide();
        	return;
        }
    	current-=change;;
    	move.animate({marginLeft: "+="+dx*change}, speed);
    	right.show();
   });
}

function getBodyScrollTop()
{
  return self.pageYOffset || (document.documentElement && document.documentElement.scrollTop) || (document.body && document.body.scrollTop);
} 

function proverkaInt(input) {
	input.value = input.value.replace(/[^\d,]/g, '');
}

function openVKparams(){
	$('#login_vk').css('display','block');
}
function sendWallMessage(){
	alert('qq');
	$('#login_vk #vk_message').css('dicplay','block');
}

$(document).ready(function(){	
	/*project.php нажатие на ссылку "еще текст"*/
	$('#form_create_text #add-text').live('click',function(){
		//alert('qq');
		var obj = $(this).parent().parent();
		var size = $('.image_input').size();
		var str1 = '<tr style="padding-bottom: 10px;"><td colspan="2" ><div style="border-bottom: 1px dashed;"><a href="#" class="del_block_text" onclick="return false;">del</a></div></td></tr>';
		var str2 = '<tr><td class="text-middle" >Заголовок</td><td class="text-middle" ><input type="text" name="pagetitle[]"  /></td></tr>';
		var str3 = '<tr><td class="text-middle" >Изображение</td><td class="text-middle" ><input class="image_input" type="file" name="image[]"  /></td></tr>';
		var str4 = '<tr><td class="text-middle" >Текст</td><td class="text-middle" ><textarea name="text[]"></textarea></td></tr>';
		var str5 = '<tr><td class="text-middle">Соц. сети</td><td class="text-middle"><span><input type="checkbox" value="1" style="width: 23px;" class="socset_input"><input type="hidden" value="0" name="socset[2][]" class="socset_input_hidden"><img src="/images/social/no_socialmini2.jpg" class="image-socset" rel_src="/images/social/socialmini2.jpg" rel="" style="margin-top: 3px;"></span><span><input type="checkbox" value="1" style="width: 23px;" class="socset_input"><input type="hidden" value="0" name="socset[3][]" class="socset_input_hidden"><img src="/images/social/no_socialmini3.jpg" class="image-socset" rel_src="/images/social/socialmini3.jpg" rel="" style="margin-top: 3px;"></span></td></tr>';
		obj.before(str1);
		obj.before(str2);
		obj.before(str3);
		obj.before(str4);
		obj.before(str5);
		//alert(str);
	});
	$('#form_create_page #add-page').live('click',function(){
		//alert('qq');
		var obj = $(this).parent().parent();
		var size = $('.text-caption').size();
		var str1 = '<tr style="padding-bottom: 10px;"><td colspan="2" ><div style="border-bottom: 1px dashed;"><a href="#" class="del_block" onclick="return false;">del</a></div></td></tr>';
		var str2 = '<tr><td class="middle" >Название Страницы</td><td class="middle" ><input type="text" name="name[]"  /></td></tr>';
		var str3 = '<tr><td class="middle" >Адрес</td><td class="middle" ><input type="text" name="page_url[]"  /></td></tr>';
		obj.before(str1);
		obj.before(str2);
		obj.before(str3);
		//alert(str);
	});
	
	$('#form_create_page .del_block').live('click',function(){
		var obj = $(this).parent().parent().parent();
		obj.next().remove();
		obj.next().remove();
		obj.remove();
	});
	$('#form_create_text .del_block_text').live('click',function(){
		var obj = $(this).parent().parent().parent();
		obj.next().remove();
		obj.next().remove();
		obj.next().remove();
		obj.remove();
	});
	
	$('.company .head-caption-tr .left img').live('click',function(){
		$(this).parent().find(".pointer").click();
	});
	
	$('.company .head-caption-tr .left .long_link .pointer').live('click',function(){
		var obj_image = $(this).parent().parent().parent().find('.img-action');
		var loop = obj_image.attr('rel_loop');
		var id_project = obj_image.attr('param');
		if($('#table-project'+loop+' .preloader-table-pages-main').is('.preloader-table-pages-main')){
			obj_image.attr('rel','');
			//obj_image.attr('src','/images/plus.gif');
			obj_image.attr('src','/images/minus.gif');
			$('#table-project'+loop).show();
			xajax_showPagesTable(id_project,loop);
		}
		else{
			if(obj_image.attr('rel').length>0){
				obj_image.attr('rel','');
				//obj_image.attr('src','/images/plus.gif');
				obj_image.attr('src','/images/minus.gif');
				obj_image.parent().parent().parent().parent().next().show();
			}
			else{
				obj_image.attr('rel','no-active');
				//obj_image.attr('src','/images/minus.gif');
				obj_image.attr('src','/images/plus.gif');
				obj_image.parent().parent().parent().parent().next().hide();
			}
		}
	});
	
	$('img.image-socset').live('click',function(){
		var rel_src = $(this).attr('rel_src');
		if($(this).attr('rel')=='active'){
			$(this).attr('rel','').attr('rel_src',$(this).attr('src')).attr('src',rel_src);
			$(this).parent().find('input.socset_input_hidden').attr('value','0');
			$(this).parent().find('input.socset_input').removeAttr('checked');
		}
		else{
			$(this).attr('rel','active').attr('rel_src',$(this).attr('src')).attr('src',rel_src);
			$(this).parent().find('input.socset_input_hidden').attr('value','1');
			$(this).parent().find('input.socset_input').attr('checked','checked');
		}
	});
	$('input.socset_input').live('click',function(){
		$(this).parent().find('img.image-socset').click();
	});
	
	$(".company-detals .page-tr .list-actives").live('click',function(){
		var id_user = $(this).attr('user');
		var id_place = $(this).attr('place');
		var load = $(this).attr('load');
		if($(this).attr('rel')=='active'){
			$(this).attr('rel','');
			$(this).text('Лента активности');
			$('#list-active-place-'+id_place).hide();
		}
		else{
			$(this).attr('rel','active');
			$(this).text('Закрыть ленту активности');
			$('#list-active-place-'+id_place).show();
			if(!load){
				$(this).attr('load','1');
				xajax_showListActive(id_user,id_place);
			}
		}
		
	});
	
	$(".company-detals .page-tr .page-textlikes").live('click',function(){
		var id_page = $(this).attr('page');
		var load = $(this).attr('load');
		if($(this).attr('rel')=='active'){
			$(this).attr('rel','');
			$(this).text('Показать тексты');
			$('#textlikes-page'+id_page).parent().parent().hide();
		}
		else{
			$(this).attr('rel','active');
			$(this).text('Скрыть тексты');
			$('#textlikes-page'+id_page).parent().parent().show();
			if(!load){
				$(this).attr('load','1');
				xajax_showTextsPage(id_page);
			}
		}
		
	});
	$(".add_button_like img").live('click',function(){
		$(this).hide();
		$(this).parent().parent().find(".form_add_like").show();
	});
	$(".button_count_like").live('click',function(){
		var obj_input = $(this).parent().find("input");
		var id_place = obj_input.attr("id_place");
		$(this).parent().hide();
		$(this).parent().parent().find(".add_button_like img").show();
		var count = parseInt(obj_input.val());
		if(!count) count = 0;
		$("#count_like_full_"+id_place).html(count);
		var image = $(this).parent().parent().parent().find(".image-socset");
		if(image.attr('rel')!='active') image.click();
		//xajax_addCountLike(obj_input.attr("id_text_like"),obj_input.attr("id_user"),obj_input.attr("id_project"),obj_input.attr("id_place"),obj_input.val());
	});
});
