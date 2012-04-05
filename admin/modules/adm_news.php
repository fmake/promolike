<?php

if (!$admin->isLogined())
	die("Доступ запрещен!");

# Поля
$filds = array(
	 'title'=>'Заголовок',
	 'redir'=>'url'
);

$absitem = new fmakeNotice($request->id);
$section = new fmakeSection();
$tags = new fmakeNotice_tags();

$actions = array('move',  'active', 'edit', 'delete','inmain');


# Actions
switch($request->action)
{
	case 'up':
	case 'down':
	case 'insert':
	case 'update':
	case 'delete':
	case 'index':
	case 'inmenu':
	case 'active':
	default:
		switch($request->action)
		{
			case 'index':
				$absitem->setIndex();
			break;
			case 'inmain':
			case 'inmenu':
			case 'active':
				$absitem->setEnum($request->action);
			break;

			case 'up': // Вверх 
				$absitem->getUp();
			break;

			case 'down': // Вниз
				$absitem->getDown();
			break;

			case 'insert': // Новый
				
				foreach ($_POST as $key=>$value)
					$absitem ->addParam($key, $value);
					
				$absitem ->addParam("date", strtotime($_POST['date']));
					
				$absitem -> newItem();
				if($_FILES['foto']['tmp_name'])
					$absitem->addPreviewFoto($_FILES['foto'],$_POST['inmain']);
					
				$tags->addTags($_POST['tags'],$absitem -> id) ;	
			break;
			case 'update': // Переписать
				foreach ($_POST as $key=>$value)
					$absitem ->addParam($key, $value);
					
				$absitem ->addParam("date", strtotime($_POST['date']));	
				$absitem -> update();
				
				//echo $_FILES['foto']['tmp_name'];
				if($_FILES['foto']['tmp_name']){
					$absitem->deleteImages();
					$absitem->addPreviewFoto($_FILES['foto'],$_POST['inmain']);
				}
				
				$tags->addTags($_POST['tags'],$absitem -> id) ;
			break;
		
			case 'delete': // Удалить
				$absitem -> delete();
			break;
			
		}

		
		$items = $absitem -> getAllNews();
		include('content.php');
	break;
	case 'delimg':
		$absitem -> deleteImage($name = 'icon.png');
	case 'edit':

		$items = $absitem -> getInfo();
		
	$content .= "<div>
				<img src='/".$absitem->imgFolder.$absitem->id."/".$absitem->prefix_mini."_".$items['image']."' >
			  </div>";
	case 'new': // Далее форма
		$tagsStr = $tags -> tagsToString( $tags -> getTags ($items[$absitem->idField]) );
		$tagsJsStr = $tags -> tagsToJsString( $tags -> getAll () );
		
		$content .= '<script type="text/javascript" src="/js/jquery.autocomplete.js"></script>';
		$content .= '<script type="text/javascript" src="/js/localdata.js"></script>';
		
		$form = new utlFormEngine($modul, "/admin/index.php?modul=".$request->modul, "POST", "multipart/form-data");
	
		$form->addHidden("action", (($_GET['action'] == 'new')?'insert':'update'));
		$form->addHidden("id", $items[$absitem->idField]);
		$form->addHidden("type_id", NEWS_ID);
		$modules = $section->getAll();
		$_modul = $form->addSelect("Раздел новостей", "section_id");
				$_modul->AddOption(new selectOption(0, "Нет раздела", (($items['section_id']==0)? true : false )));
			foreach ($modules as $modul)
				$_modul->AddOption(new selectOption($modul['section_id'], (($modul['section_id']==0)? '':'&nbsp;&nbsp;').$modul['caption'], (($modul['section_id']==$items['section_id'])? true : false )));
		$form->AddElement($_modul);
		
		foreach ($filds as $key=>$fild)
		{
			if($key == 'file') continue;
			$form->addVarchar($fild, $key, (($key == 'date' && $_GET['action'] == 'new')? date("Y-m-d") : $items[$key]));
		}
	
		$form->addVarchar("<em>Дата</em>", "date", $items["date"] ? date("d.m.Y H:i:s", $items["date"]) : date("d.m.Y H:i:s") );
		$form->addVarchar("<em>Ключевые</em>", "keywords", $items["keywords"],50,false,"Ключевые слова, как правило используються для того что бы рассказать поисковой сиситеме о вашем сайте");
		$form->addVarchar("<em>Описание</em>", "description", $items["description"]);
		
		$form->addCheckBox('В главные новости', 'inmain', 1, $items['inmain'] ? true : false);
		$form->addFile("Основное фото", "foto");
		
		$form->addTextArea("Короткое описание", "short_text", $items['short_text'],1,7);
		$form->addVarchar("<em>Источник</em>", "resourse", $items["resourse"]);
		$form->addTextArea("Теги ( через запятую )", "tags", $tagsStr,1,2);
		$form->addFCKEditor("Текст", "text", $items['text']);
		

		$form->addSubmit("save", "Сохранить");

		$content .= $form->printForm();
		
		$content .= '<script type="text/javascript">
			var tags = ['.$tagsJsStr.']
		
			$("#tags").autocomplete(tags, {
				multiple: true,
				mustMatch: false,
				autoFill: true
			});
		</script>';
		
		$content .='
			<script>
				$("#title").keyup(function(){
					convert2EN("title","redir");
				});
			</script>
		';
		
		$block = "admin/edit/simple_edit";
		
	break;
}
?>