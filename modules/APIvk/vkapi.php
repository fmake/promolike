<?php
 
 class fmakeVkapi {
     public $tocken                = '';
     private $api_id            = '';

    
     public function __construct($api_id='',$tocken='') {
         $this->api_id = $api_id;
		 $this->tocken = $tocken;
     }
    
    
	public function desktop_api($method, $data='') {

		if ($data) {
			foreach ($data as $k => $v) {
				$str .= ''.$k.'='.$v.'&';
			}
		}
		//ksort($postdata, SORT_STRING);
		$str .='access_token='.$this->tocken; 
		$url = 'https://api.vkontakte.ru/method/'.$method.'?'.$str;
		$curl = new cURL();
		$curl -> init();
		$curl -> get($url);
		$result = $curl -> data();
		$res = json_decode($result);
		return $res;
	}
 
 	public function isUserTokenVK($api_id,$id_user,$id_soc_set){
 		$SocialUser = new fmakeSiteUser();
		$params_user_vk = $SocialUser->getUserSocialParam($id_user,$id_soc_set);
		$this->api_id = $api_id;
		$this->tocken = $params_user_vk['tocken'];
		$array_param = array('uids'=>$params_user_vk['uid']);
		
		$send_vk_wall_messages = $this->desktop_api('users.get', $array_param);
		
		$result = $send_vk_wall_messages;
		
		return $result;
	}
	
    public function SendMessageWall($api_id,$id_user,$id_soc_set,$textpage,$link){
		$SocialUser = new fmakeSiteUser();
		$params_user_vk = $SocialUser->getUserSocialParam($id_user,$id_soc_set);
		//$vk = new fmakeVkapi($api_id,$params_user_vk['tocken']);
		$this->api_id = $api_id;
		$this->tocken = $params_user_vk['tocken'];
		$message = urlencode($textpage['text_like']);
		$array_param = array('owner_id'=>$params_user_vk['uid'],'message'=>$message);
		$image = ROOT."/images/image_textlike/{$textpage['id_text_like']}/thumbs/{$textpage['image']}";
		//$image = ROOT."/images/image_textlike/{$textpage['id_text_like']}/{$textpage['image']}";
		if(file_exists($image)){
			$photo_vk_wall_messages = $this->desktop_api('photos.getWallUploadServer', array('uid'=>$params_user_vk['uid']));

			$resp = $photo_vk_wall_messages->response;

			$ch = curl_init($resp->upload_url);  
			curl_setopt($ch, CURLOPT_POST, 1);
			$filename = '@'.$image;
			curl_setopt($ch, CURLOPT_POSTFIELDS, array('photo'=>"".$filename));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$result = curl_exec($ch);
			curl_close($ch);
			$result = json_decode($result);
			//printAr($result);
			$photo_vk_upload = $this->desktop_api('photos.saveWallPhoto', array('server'=>$result->server,'photo'=>$result->photo,'hash'=>$result->hash));
			//printAr($photo_vk_upload);
			$photo_params = $photo_vk_upload->response[0];
			$array_param['attachments'] = $photo_params->id.',';
		}
		if($link) $array_param['attachments'] .= $link;
		
		$send_vk_wall_messages = $this->desktop_api('wall.post', $array_param);
		return $send_vk_wall_messages;
	}   
 }
 ?>