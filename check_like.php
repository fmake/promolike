<?
require ('./libs/FController.php');

$promoLike = new promoLike_like();
$promoLikeHistory = new promoLike_likehistory();
$promoLike_place = new promoLike_socialset();
$promoLike_textlike = new promoLike_textlike();
$promoLike_page = new promoLike_page();
$PlaceUser = new fmakeSiteUser();

/*выгружаем все лайки со статусом новый*/
$date_check = strtotime("-2 day",time());
$likes = $promoLike->getAllLikeStatus(3,"`date_placed`<'{$date_check}'");
//printAr($likes);

$array_users_wall_vk = array();
$array_users_wall_twitter = array();

if($likes)foreach ($likes as $key=>$item){
	//$user = $PlaceUser->getUserSocialParam($item['id_user_place'],$item['id_place']);
	//$item['info_user'] = $user; 
	//printAr($item);
	switch ($item['id_place']){
		case '2':
			if(isset($array_users_wall_vk[$item[id_user_place]])){
				$res = $array_users_wall_vk[$item[id_user_place]];
				//echo("<br/>------------ЙУХУ обошлись без прокси-------------------<br/>");
			}
			else{
				$url = 'http://'.$hostname.'/vkontakte.php?id_user='.$item[id_user_place].'&id_soc_set='.$item['id_place'].'&id_like='.$item[$promoLike->idField].'&action=get_wall_vk';
				$curl = new cURL();
				$curl -> init();
				$curl -> get($url);
				$result = $curl -> data();
				$res = json_decode($result);
			}
			//printAr($res);
			if($res->error->error_code==14){
				$plase_array_error[$item['id_place']] = false;
				echo("Ошибка капча.<br/>");
			}
			elseif($res->error->error_code==5){
				echo("Просрочен tocken<br/>");
			}
			elseif($res->response){	
				$array_users_wall_vk[$item[id_user_place]] = $res;
				//printAr($res);
				$is_like_wall = $promoLike->checkLikeWall($item['id_place'],$array_users_wall_vk[$item[id_user_place]]->response,$item['like_text'],$item['url']);
				echo("<br/>--Параметры: текст - '{$item[like_text]}'; url - '{$item[url]}' --<br/>");
				if($is_like_wall){
					$promoLike->setId($item[$promoLike->idField]);
					//$promoLike->addParam('id_place', $item_place);
					//$promoLike->addParam('id_user_place', $item[id_user_place]);
					$promoLike->addParam('status', 4);
					$promoLike->update();
					$item_info = $promoLike->getInfo();
					$promoLikeHistory->dublicateHistory($item_info);
					echo("есть запись");
					echo("<br/>------------<br/>");
					printAr($is_like_wall);
					echo("<br/>------------<br/>");
				}
				else{
					$promoLike->setId($item[$promoLike->idField]);
					//$promoLike->addParam('id_place', $item_place);
					//$promoLike->addParam('id_user_place', $item[id_user_place]);
					$promoLike->addParam('status', 5);
					$promoLike->update();
					$item_info = $promoLike->getInfo();
					$promoLikeHistory->dublicateHistory($item_info);
					
					echo("нету записи");		
				}
				
				echo("<br />проверили лайк в vkontakte.ru с Id = {$item[$promoLike->idField]} Id_user = {$item[id_user_place]}<br/>");
			}
			echo("<br />--------------------------------------------------<br />");	
			break;
		case '3':
			if(isset($array_users_wall_twitter[$item[id_user_place]])){
				$res = $array_users_wall_twitter[$item[id_user_place]];
				echo("<br/>------------ЙУХУ обошлись без прокси-------------------<br/>");
			}
			else{
				$url = 'http://'.$hostname.'/twitter.php?id_user='.$item[id_user_place].'&id_soc_set='.$item['id_place'].'&action=get_posts_wall&key=1029384756';
				$curl = new cURL();
				$curl -> init();
				$curl -> get($url);
				$result = $curl -> data();
				$res = json_decode($result);
				$array_users_wall_twitter[$item[id_user_place]] = $res;
				//echo('qq');
				//printAr($res);
			}
			
			$is_like_wall = $promoLike->checkLikeWall($item['id_place'],$array_users_wall_twitter[$item[id_user_place]],$item['like_text'],$item['url']);
			echo("<br/>--Параметры: текст - '{$item[like_text]}'; url - '{$item[url]}' --<br/>");
			if($is_like_wall){
				$promoLike->setId($item[$promoLike->idField]);
				//$promoLike->addParam('id_place', $item_place);
				//$promoLike->addParam('id_user_place', $item[id_user_place]);
				$promoLike->addParam('status', 4);
				$promoLike->update();
				$item_info = $promoLike->getInfo();
				$promoLikeHistory->dublicateHistory($item_info);
				echo("есть запись");
				echo("<br/>------------<br/>");
				printAr($is_like_wall);
				echo("<br/>------------<br/>");
			}
			else{
				$promoLike->setId($item[$promoLike->idField]);
				//$promoLike->addParam('id_place', $item_place);
				$promoLike->addParam('id_user_place', $item[id_user_place]);
				$promoLike->addParam('status', 5);
				$promoLike->update();
				$item_info = $promoLike->getInfo();
				$promoLikeHistory->dublicateHistory($item_info);
				echo("<br/>------------<br/>");
				echo("нету записи");	
				echo("<br/>------------<br/>");	
			}
			
			echo("проверили лайк в twitter.com с Id = {$item[$promoLike->idField]} Id_user = {$item[id_user_place]}<br/>");	
			echo("<br />--------------------------------------------------<br />");			
			break;	
		}		
}

?>