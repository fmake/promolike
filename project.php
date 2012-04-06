<?
error_reporting(7);
require('./libs/FController.php');
require './libs/login.php';

if(!$user->isLogined()){
			header("HTTP/1.1 301 Moved Permanently");
			header('Location: /index.php');
}

require './modules/APIvk/vkapi.php';

require_once ("./libs/xajax_project.php");

/*-------активность главного меню--------*/
$active_menu = 2;
$globalTemplateParam->set('active_menu',$active_menu);
/*-------активность главного меню--------*/

$globalTemplateParam->set('request_tmp',$_REQUEST);
//printAr($_REQUEST);
$userObj = new fmakeSiteUser();
//printAr($user);
$id_user = $user->id;
//$id_user = 1;
switch ($request->action){
	case 'create':
		$fmakeProject = new promoLike_project();
		$name_project = $request->getEscape('company_name');
		$isproject = $fmakeProject->isProject($id_user, $name_project);
		$isproject = sizeof($isproject);
		if($isproject>=1 && $request->getEscape('id_project')=='') {
			$error[] = 'Такой проект у вас уже есть.';
			$globalTemplateParam->set('error',$error);
			$globalTemplateParam->set('name_project',$name_project);
		}
		else{
			if($request->getEscape('id_project')!=''){
				$fmakeProject->setId($request->getEscape('id_project'));
				$tmp_project = $fmakeProject->getInfo();
				if(($tmp_project['caption']!=$name_project && $isproject>=1) || ($tmp_project['caption']==$name_project && $isproject>=2)){
					$error[] = 'Такой проект у вас уже есть.';
					$globalTemplateParam->set('error',$error);
					$globalTemplateParam->set('name_project',$name_project);
					break;					
				}
				elseif ($name_project==''){
					$error[] = 'Заполните пункт название проекта.';
					$globalTemplateParam->set('error',$error);
					$globalTemplateParam->set('name_project',$name_project);
					break;
				}
				else{
					$fmakeProject->addParam('caption', $name_project);
					$fmakeProject->update();					
				}
				
			}
			elseif ($name_project==''){
				$error[] = 'Заполните пункт название проекта.';
				$globalTemplateParam->set('error',$error);
				$globalTemplateParam->set('name_project',$name_project);
				break;
			}
			else{
				$fmakeProject->addParam('id_user', $id_user);
				$fmakeProject->addParam('caption', $name_project);
				$fmakeProject->addParam('date', time());
				$fmakeProject->newItem();
			}
			$project = $fmakeProject->getInfo();			
			header("HTTP/1.1 301 Moved Permanently");
			header('Location: /project.php?id_project='.$project[$fmakeProject->idField].'&action=add_page');
		}
	break;
	case 'add_page':
		if($request->getEscape('id_project')){
			$fmakeProject = new promoLike_project();
			$fmakeProject->setId($request->getEscape('id_project'));
			$project = $fmakeProject->getInfo();
			if($project){
				$fmakePage = new promoLike_page();
				$pages = $fmakePage->getAllPageUser($id_user,$request->getEscape('id_project'));
				if($request->getEscape('id_page')){
					$fmakePage = new promoLike_page();
					$fmakeTekstLike = new promoLike_textlike();
					$fmakePage->setId($request->getEscape('id_page'));
					$page = $fmakePage->getInfo();
					$textlikes = $fmakeTekstLike->getAllTextPage($page[$fmakePage->idField]);
					$globalTemplateParam->set('page',$page);
					$globalTemplateParam->set('textlikes',$textlikes);
					$param_update = true;
					$globalTemplateParam->set('update',$param_update);
				}
				$globalTemplateParam->set('project',$project);
				$globalTemplateParam->set('pages',$pages);
				$template = "project/project_second.tpl";
				$template = $twig->loadTemplate($template);
				$template->display($globalTemplateParam->get());
				exit;	
			}
			else{
				header("HTTP/1.1 301 Moved Permanently");
				header('Location: /project.php');				
			}
		}
		else{
			header("HTTP/1.1 301 Moved Permanently");
			header('Location: /project.php');			
		}	
	break;		
	case 'add_text':
		if($request->getEscape('id_project')){
			$fmakeProject = new promoLike_project();
			$fmakeProject->setId($request->getEscape('id_project'));
			$project = $fmakeProject->getInfo();
			
			/*социальные сети*/
			$SocialSet = new promoLike_socialset();
			$SocialSet->table = $SocialSet->table_name;
			$full_soc_set = $SocialSet->getAll(true);
			/*социальные сети*/
			
			if($project){
				switch($request->action_add_text_page){
					case 'add_text':
						$fmakePage = new promoLike_page();
						$fmakeProject = new promoLike_project();
						$fmakeUser = new fmakeSiteUser();
						$fmakeTekstLike = new promoLike_textlike();
						$id_project = $request->getEscape('id_project');
						$id_user = $request->getEscape('id_user');
						$flag = true;
						$count_array_name = sizeof($request->pagetitle);
						
						foreach($request->text as $param_name){
							if(!$param_name){
								$flag = false;
								break;
							}  
						}
						foreach($request->pagetitle as $param_name){
							if(!$param_name){
								$flag = false;
								break;
							}  
						}

						if($flag){
							foreach($request->pagetitle as $param_name){
								if($fmakePage->isPage($id_user, $id_project, mysql_real_escape_string($param_name))){
									$error['alert'] = '
									<script type="text/javascript">
										alert("Смените название страницы. Вы повторяетесь.");
									</script>';
									break;
								}
							}
							$size = $count_array_name;
							for($i=0;$i<$size;$i++){
								$fmakeTekstLike->addParam('id_page', $request->getEscape('id_page'));
								$fmakeTekstLike->addParam('caption', mysql_real_escape_string($request->pagetitle[$i]));
								$fmakeTekstLike->addParam('text_like', mysql_real_escape_string($request->text[$i]));
								$fmakeTekstLike->newItem();		
								$item_text_like = $fmakeTekstLike->getInfo(); 
								/*социальные сети*/
								$SocialSet = new promoLike_socialset();
								foreach ($full_soc_set as $key=>$item){
									if($request->socset[$item['id_social_set']][$i]) $SocialSet->addSocialSet($item['id_social_set'],$item_text_like['id_text_like']);
								}
								/*социальные сети*/
								
								if($_FILES['image']['name'][$i]) $fmakeTekstLike -> addPreviewFoto($_FILES['image']['tmp_name'][$i],$_FILES['image']['name'][$i]); 
							}
							if($request->add_next_button){
								header("HTTP/1.1 301 Moved Permanently");
								header('Location: /myprojects.php');
							}
						}
						else{
							$error['alert'] = '
									<script type="text/javascript">
										alert("Название страницы и текст обязательн для заполнения");
									</script>';
							
							$globalTemplateParam->set('error_size',sizeof($request->text));
						}
					break;
					case 'update_text':
						$fmakePage = new promoLike_page();
						$fmakeProject = new promoLike_project();
						$fmakeUser = new fmakeSiteUser();
						$fmakeTekstLike = new promoLike_textlike();
						$id_project = $request->getEscape('id_project');
						$id_user = $request->getEscape('id_user');	
						$fmakePage->setId($request->getEscape('id_page'));
						if($request->getEscape('pagetitle')!=''){
							$fmakeTekstLike->setId($request->getEscape('id_text_page'));
							$fmakeTekstLike->addParam('id_page', $request->getEscape('id_page'));
							$fmakeTekstLike->addParam('caption', mysql_real_escape_string($request->getEscape('pagetitle')));
							$fmakeTekstLike->addParam('text_like', mysql_real_escape_string($request->getEscape('text')));
							$fmakeTekstLike->update();	
							
							$item_text_like = $fmakeTekstLike->getInfo();
							/*социальные сети*/
							$SocialSet = new promoLike_socialset();
							foreach ($full_soc_set as $key=>$item){
								if($request->socset[$item['id_social_set']] && !$SocialSet->isSocialSetFilters($item['id_social_set'],$item_text_like['id_text_like'])) $SocialSet->addSocialSet($item['id_social_set'],$item_text_like['id_text_like']);
								elseif(!$request->socset[$item['id_social_set']] && $SocialSet->isSocialSetFilters($item['id_social_set'],$item_text_like['id_text_like'])) $SocialSet->deleteSocialSet($item['id_social_set'],$item_text_like['id_text_like']);
							}
							/*социальные сети*/	
							
							if($_FILES['image']['name']) $fmakeTekstLike -> addPreviewFoto($_FILES['image']['tmp_name'],$_FILES['image']['name']);
							
							if($request->add_next_button){
								header("HTTP/1.1 301 Moved Permanently");
								header('Location: /myprojects.php');
							}
							if($action){
								$error['alert'] = '
									<script type="text/javascript">
										document.location = document.getElementById("next_link").href;
									</script>';
							}
							else{
								$error['alert'] = '
									<script type="text/javascript">
									alert("страница `'.$request->pagetitle.'` добавлена/отредактирована");
									</script>';
							}
						}
						else{
							$error['alert'] = '
									<script type="text/javascript">
									alert("Заголовок обязателен для заполнения");
									</script>';
						}
					break;
				}
				
				$fmakePage = new promoLike_page();
				$pages = $fmakePage->getAllPageUser($id_user,$request->getEscape('id_project'));
				$id_page = ($request->id_page)? $request->id_page: $pages[0][$fmakePage->idField];
				if($pages){
					$fmakeTekstLike = new promoLike_textlike();
					$textlikes = $fmakeTekstLike->getAllTextPage($id_page);
					$globalTemplateParam->set('textlikes',$textlikes);
				}
								
				$globalTemplateParam->set('project',$project);
				$globalTemplateParam->set('pages',$pages);
				$globalTemplateParam->set('id_page',$id_page);
				$globalTemplateParam->set('error',$error);
				$globalTemplateParam->set('full_soc_set',$full_soc_set);
				$template = "project/project_text.tpl";
				$template = $twig->loadTemplate($template);
				$template->display($globalTemplateParam->get());
				exit;
			}
			else{
				header("HTTP/1.1 301 Moved Permanently");
				header('Location: /project.php');				
			}
		}
		else{
			header("HTTP/1.1 301 Moved Permanently");
			header('Location: /project.php');			
		}	
	break;	
}

if($request->id_project){
	$fmakeProject = new promoLike_project($request->getEscape('id_project'));
	$project = $fmakeProject->getInfo();
	if($project){
		$fmakePage = new promoLike_page();
		$pages = $fmakePage->getAllPageUser($id_user,$request->getEscape('id_project'));
		$globalTemplateParam->set('project',$project);
		$globalTemplateParam->set('pages',$pages);
	}
	else{
		header("HTTP/1.1 301 Moved Permanently");
		header('Location: /project.php');				
	}
}	

$template = "project/project_first.tpl";
$template = $twig->loadTemplate($template);
$template->display($globalTemplateParam->get());
?>