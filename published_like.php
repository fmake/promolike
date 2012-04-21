<?
require ('./libs/FController.php');

$promoLike = new promoLike_like();

/*выгружаем все лайки со статусом новый*/
$likes = $promoLike->getAllLikeStatus(1);

foreach ($likes as $key=>$item){
	echo("id лайк - ".$item[$promoLike->idField]."<br/>");
}

?>