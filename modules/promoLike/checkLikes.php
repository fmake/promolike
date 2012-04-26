<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class promoLike_checkLikes extends fmakeCore {
    public function getArrayLikes($json){
        return $json;
    }
    
    public function searchLike($array_likes, $array_likes_from_db){
        return false;
    }
}
?>
