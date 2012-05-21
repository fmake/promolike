<?
require ('./libs/FController.php');

$promoLike = new promoLike_like();
$promoLikeHistory = new promoLike_likehistory();
$promoLike_place = new promoLike_socialset();
$promoLike_textlike = new promoLike_textlike();
$PlaceUser = new fmakeSiteUser();

/*выгружаем все лайки со статусом новый*/
$likes = $promoLike->getAllLikeStatus(1);

foreach ($likes as $key=>$item){
	//echo("id лайк - ".$item[$promoLike->idField]." - ".$item['id_page']."<br/>");
	//$plases = $promoLike_place->getSocialSetFilter($item[$promoLike_textlike->idField]);
	//printAr($plases);
	if($item['id_place']){
		/*foreach ($plases as $key=>$it){
			$item_place = $key;
			break;
		}*/
		$user = $PlaceUser->getUserRand($item['id_place'],$item);
		if($user){
			switch ($item_place){
				case '2':
					$promoLike->setId($item[$promoLike->idField]);
					$promoLike->addParam('id_place', $item_place);
					$promoLike->addParam('id_user_place', $user[id_user]);
					$promoLike->addParam('status', 3);
					$promoLike->addParam('date_placed', time());
					$promoLike->update();
					$promoLikeHistory->dublicateHistory($promoLike->getInfo());
					echo("запостили в контакт сообщение пользователю {$user[id_user]}: {$item[like_text]} <br/>");
					break;
				case '3':
					$promoLike->setId($item[$promoLike->idField]);
					$promoLike->addParam('id_place', $item_place);
					$promoLike->addParam('id_user_place', $user[id_user]);
					$promoLike->addParam('status', 3);
					$promoLike->addParam('date_placed', time());
					$promoLike->update();
					$promoLikeHistory->dublicateHistory($promoLike->getInfo());
					echo("запостили в твитер сообщение пользователю {$user[id_user]}: {$item[like_text]} <br/>");
					break;	
			}
		}		
	}
}

?>