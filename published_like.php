<?
require ('./libs/FController.php');

$plase_array_error = array('1'=>true,'2'=>true,'3'=>true);

$promoLike = new promoLike_like();
$promoLikeHistory = new promoLike_likehistory();
$promoLike_place = new promoLike_socialset();
$promoLike_textlike = new promoLike_textlike();
$promoLike_page = new promoLike_page();
$PlaceUser = new fmakeSiteUser();

/*выгружаем все лайки со статусом новый*/
$likes = $promoLike->getAllLikeStatus(1);
//printAr($likes);
if($likes)foreach ($likes as $key=>$item){

	if($item['id_place']) $user = $PlaceUser->getUserRand($item['id_place'],$item);
	echo('ww');
	if($user){
		/*информация о лайке*/
		$promoLike_textlike->setId($item[$promoLike_textlike->idField]);
		$text_like = $promoLike_textlike->getInfo();
		$promoLike_page->setId($item[$promoLike_page->idField]);
		$page = $promoLike_page->getInfo();
		/*информация о лайке*/
		switch ($item['id_place']){
			case '2':				
				if($plase_array_error[$item['id_place']]){
					$user[id_user] = 5;
					$url = 'http://'.$hostname.'/vkontakte.php?id_user='.$user[id_user].'&id_soc_set='.$item['id_place'].'&id_textlike='.$text_like[$promoLike_textlike->idField].'&action=send_message_vk';
					$curl = new cURL();
					$curl -> init();
					$curl -> get($url);
					$result = $curl -> data();
					$res = json_decode($result);
					if($res->error->error_code==14){
						$plase_array_error[$item['id_place']] = false;
						echo("Ошибка капча.<br/>");
					}
					elseif($res->response){
						$promoLike->setId($item[$promoLike->idField]);
						//$promoLike->addParam('id_place', $item_place);
						$promoLike->addParam('id_user_place', $user[id_user]);
						$promoLike->addParam('status', 3);
						$promoLike->addParam('date_placed', time());
						$promoLike->addParam('url', mysql_real_escape_string($page['url']));
						$promoLike->addParam('like_text', mysql_real_escape_string($text_like['text_like']));
						$promoLike->update();
						$item_info = $promoLike->getInfo();
						$promoLikeHistory->dublicateHistory($item_info);
						
						echo("запостили в контакт сообщение пользователю {$user[id_user]}: {$item_info[like_text]} <br/>");
					}
				}	
				break;
			case '3':
				if($plase_array_error[$item['id_place']]){
					
					echo("запостили в твитер сообщение пользователю {$user[id_user]}: {$item_info[like_text]} <br/>");
					
					$promoLike->setId($item[$promoLike->idField]);
					//$promoLike->addParam('id_place', $item_place);
					$promoLike->addParam('id_user_place', $user[id_user]);
					$promoLike->addParam('status', 3);
					$promoLike->addParam('date_placed', time());
					$promoLike->addParam('url', mysql_real_escape_string($page['url']));
					$promoLike->addParam('like_text', mysql_real_escape_string($text_like['text_like']));
					$promoLike->update();
					$item_info = $promoLike->getInfo();
					$promoLikeHistory->dublicateHistory($item_info);
				}				
				break;	
		}
	}		
}

?>