<?php

if (!$admin->isLogined())
	die("Доступ запрещен!");

# Поля
$filds = array(
	 'title'=>'Заголовок',
//	 'text'=>'Текст',
	 'redir'=>'url'
);

$absitem = new fmakeNotice($request->id);
	
$actions = array('move',  'active', 'edit', 'delete');


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
					$absitem->addPreviewFoto($_FILES['foto']);
			break;
			case 'update': // Переписать
				foreach ($_POST as $key=>$value)
					$absitem ->addParam($key, $value);
					
				$absitem ->addParam("date", strtotime($_POST['date']));	
				$absitem -> update();

				//echo $_FILES['foto']['tmp_name'];
				if($_FILES['foto']['tmp_name']){
					$absitem->deleteImages();
					$absitem->addPreviewFoto($_FILES['foto']);
				}
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
		
		$form = new utlFormEngine($modul, "/admin/index.php?modul=".$request->modul, "POST", "multipart/form-data");
	
		$form->addHidden("action", (($_GET['action'] == 'new')?'insert':'update'));
		$form->addHidden("id", $items[$absitem->idField]);
		$form->addHidden("type_id", NEWS_ID);
		
		
		
		foreach ($filds as $key=>$fild)
		{
			if($key == 'file') continue;
			$form->addVarchar($fild, $key, (($key == 'date' && $_GET['action'] == 'new')? date("Y-m-d") : $items[$key]));
		}
	
		$form->addVarchar("<em>Дата</em>", "date", $items["date"] ? date("d.m.Y", $items["date"]) : date("d.m.Y") );
		$form->addVarchar("<em>Ключевые</em>", "keywords", $items["keywords"],50,false,"Ключевые слова, как правило используються для того что бы рассказать поисковой сиситеме о вашем сайте");
		$form->addVarchar("<em>Описание</em>", "description", $items["description"]);
		
		
		$_file = $form->addSelect("Шаблон", "file");
			$_file->AddOption(new selectOption("", "Нет файла", (($items['file'] == null)? true : false )));
	
		
		$form->addFile("Основное фото", "foto");
		
		$form->addTextArea("Короткое описание", "short_text", $items['short_text'],1,7);
		$form->addFCKEditor("Текст", "text", $items['text']);
		

		$form->addSubmit("save", "Сохранить");
		$content .= $form->printForm();
		
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