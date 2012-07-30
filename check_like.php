<?
require ('./libs/FController.php');

$promoLike = new promoLike_like();
$promoLikeHistory = new promoLike_likehistory();
$promoLike_place = new promoLike_socialset();
$promoLike_textlike = new promoLike_textlike();
$promoLike_page = new promoLike_page();
$PlaceUser = new fmakeSiteUser();

/*выгружаем все лайки со статусом новый*/
$likes = $promoLike->getAllLikeStatus(3);
//printAr($likes);
if($likes)foreach ($likes as $key=>$item){
	$user = $PlaceUser->getUserSocialParam($item['id_user_place'],$item['id_place']);
	$item['info_user'] = $user; 
	printAr($item);		
}

?>