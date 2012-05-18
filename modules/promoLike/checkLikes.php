<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class promoLike_checkLikes extends fmakeCore {
    public function getArrayLikes($json){
        $likes_array = json_decode($json, true);
        return $likes_array;
    }
    
    public function searchLike($array_likes, $array_likes_from_db){
        foreach ($array_likes as $key => $value) {
            foreach ($array_likes_from_db as $like) {
                if($value == $like){
                    
                }
            }
        }
    }
}
?>
