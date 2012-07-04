<?
require ('./libs/FController.php');
require './modules/APIvk/vkapi.php';

$promoLikePlace = new promoLike_socialset();
$promoLikeUsers = new fmakeSiteUser();
$fmakeSiteUsers = new fmakeSiteUser();
$promoLikeUsers->idField = "id";
$promoLikeUsers->table = $promoLikeUsers->table_social;


$all_place_users = $promoLikeUsers->getAll(true);

if($all_place_users)foreach ($all_place_users as $key=>$item){
	switch ($item[$promoLikePlace->idField]){
		case '1':
			break;
		case '2':			
			$vk = new fmakeVkapi();
			$api_id = '2629628';
			$result = $vk->isUserTokenVK($api_id,$item[$fmakeSiteUsers->idField],$item[$promoLikePlace->idField]);
			printAr($result);
			if($result->response){
				echo('qq<br/>');
				$promoLikeUsers->setId($item['id']);
				$promoLikeUsers->addParam('active',1);
				$promoLikeUsers->update();
			}
			else{
				$promoLikeUsers->setId($item['id']);
				$promoLikeUsers->addParam('active',0);
				$promoLikeUsers->update();
			}
			break;
		case '3':
			
			break;
	}
}

?>