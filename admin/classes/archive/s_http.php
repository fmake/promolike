<?php


    
	class s_http{
		
		
		private $curl = NULL;
		
		
		var $url;
		
		
		var $post_data;
		
		
		var $data;
		
		var $user_cookie_file = '';
		var $cookie_in_file;
		var $user_agent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8';
		var $error;
		
		var $referer;
		
		
		function init(){
			
			$this->curl = curl_init();
			
			if( !$this->curl ){
				$this->error = curl_error($this->curl);
				return;
			}
			$this->user_cookie_file = $_SERVER['DOCUMENT_ROOT'].'/images/cookies.txt';
			$this->set_opt(CURLOPT_RETURNTRANSFER,true);
			$this->set_opt(CURLOPT_CONNECTTIMEOUT,30);
			if($proxy)$this->set_opt(CURLOPT_PROXY, $proxy);
			$this->set_opt(CURLOPT_USERAGENT,$this->user_agent);
			$this->set_opt(CURLOPT_HEADER,false);
			$this->set_opt(CURLOPT_ENCODING,'gzip,deflate');
			//$this->set_opt(CURLOPT_FOLLOWLOCATION,true);

			
			if($this->cookie_in_file){
				$this->set_opt(CURLOPT_COOKIEFILE, $this->user_cookie_file); 
				$this->set_opt(CURLOPT_COOKIEJAR,  $this->user_cookie_file);
			}else{
				$this->set_opt(CURLOPT_COOKIESESSION,true);
				$this->set_opt(CURLOPT_COOKIEFILE,'cookiefile');
			}
			
			if( !empty($this->referer) ){
				$this->set_opt(CURLOPT_REFERER,$this->referer);
			}
		}
		
		
	    function __destruct() {
	    	if( $this->curl ){
				curl_close($this->curl);
				$this->curl = NULL;
			}
	    }

	   
	    function error(){
	    	return $this->error;
	    }
	    
	  
	    function data(){
	    	return $this->data;
	    }
		
	  
		 function set_opt($opt,$val){
			if( !curl_setopt($this->curl,$opt,$val) ){
				
				$this->error = curl_error($this->curl);
				return false;
			}
			return true;
		}
		
		
		function to_file($name){
			
			if( $f = fopen($name,'w') ){
				
				fwrite($f,$this->data);
				fclose($f);
				return true;
			}
			else{
				$this->error = 'no open file';
			}
			
			return false;
		}
		
		
		function get($url){
			
			$this->url = $url;
			
			if( empty($this->url) ){
				$this->error = 'empty URL';
				return false;
			}
			
			$this->set_opt(CURLOPT_URL,$this->url);
			$this->set_opt(CURLOPT_POST,false);

			return $this->exec();			
		}
		
		
		function https_get($url){
			
			$this->url = $url;
			
			if( empty($this->url) ){
				$this->error = 'empty URL';
				return false;
			}
			
			$this->set_opt(CURLOPT_URL,$this->url);
			$this->set_opt(CURLOPT_SSL_VERIFYHOST,0);
			$this->set_opt(CURLOPT_SSL_VERIFYPEER,false);
			
			return $this->exec();			
		}
		
		
		private function exec(){
			
			if( false == ($this->data = curl_exec($this->curl)) ){
				
				$this->error = curl_error($this->curl);
				return false;
			} 
			
			return true;
		}
		
		
		function post($url,$post_data){
			$this->url = $url;
			$this->post_data = $post_data;
			
			if( empty($this->url) ){
				$this->error = 'Non URL in POST DATA';
				return false;
			}
			
			$this->set_opt(CURLOPT_URL,$this->url);

			// POST
			$this->set_opt(CURLOPT_POST,true);
			$this->set_opt(CURLOPT_POSTFIELDS,$this->post_data);
			
			return $this->exec();
		}
	}	
	
?>