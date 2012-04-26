<?php


    
	class cURL{
		
		
		private $curl = NULL;
		
		
		var $url;
		
		
		var $post_data;
		
		
		var $data;
		
		var $user_cookie_file = '';
		var $cookie_in_file;
		var $user_agent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8';
			/*'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 2.0.50727; .NET CLR 1.1.4322)',
	'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; FunWebProducts; (R1 1.5); .NET CLR 1.1.4322)',
	'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; FunWebProducts; .NET CLR 1.1.4322; .NET CLR 2.0.50727; InfoPath.1)',
	'Mozilla/5.0 (Windows; U; Windows NT 5.1; pl; rv:1.8.1.11) Gecko/20071127 Firefox/2.0.0.11',
	'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)',
	'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1) ; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30)',
	'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.1.4322; InfoPath.1)',
	'Mozilla/5.0 (Windows; U; Windows NT 5.1; fr; rv:1.8.1.11) Gecko/20071127 Firefox/2.0.0.11',
	'Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.8.0.6) Gecko/20060728 Firefox/1.5.0.6',
	'Mozilla/4.0 (compatible; MSIE 7.0; AOL 9.0; Windows NT 6.0; SLCC1; .NET CLR 2.0.50727; Media Center PC 5.0; .NET CLR 3.0.04506)',
	'Opera/9.25 (Windows NT 5.1; U; pl)',
	'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; AT&amp;T CSM6.0; .NET CLR 1.1.4322)',
	'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.0.7) Gecko/20060909 Firefox/1.5.0.7',
	'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; FDM)',
	'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 2.0.50727; .NET CLR 1.1.4322; .NET CLR 3.0.04506.30; InfoPath.2)',
	'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0; .NET CLR 2.0.50727)',
	'Mozilla/4.0 (compatible; MSIE 6.0; Windows 98; 3305; Wanadoo 6.1)',
	'Opera/9.20 (Windows NT 5.1; U; ru)',
	'Opera/9.23 (Windows NT 5.1; U; ru)',
	'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; FileDownloader; .NET CLR 1.0.3705; .NET CLR 1.1.4322; InfoPath.1; FileDownloader; Media Center PC 4.0; .NET CLR 2.0.50727; MEGAUPLOAD 2.0)',
	'Opera/9.21 (Windows NT 5.0; U; ru)',
	'Opera/9.25 (Windows NT 5.1; U; bg)',
	'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.1.4322; PeoplePal 3.0)',
	'Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420.1 (KHTML, like Gecko) Version/3.0 Mobile/4A93 Safari/419.3',
	'Mozilla/4.0 (compatible; MSIE 6.0; Windows 98; FunWebProducts)',
	'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1); afcid=Wadf57d6951da76af4c6f0b08181c298d',
	'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; MEGAUPLOAD 2.0)',
	'Opera/8.54 (Windows NT 5.1; U; ru)',
	'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; YComp 5.0.0.0; .NET CLR 1.0.3705; .NET CLR 2.0.50727; .NET CLR 3.0.04506.648)SAMSUNG-SGH-P910/1.0 SHP/VPP/R5 NetFront/3.3 SMM-MMS/1.2.0 profile/MIDP-2.0 configuration/CLDC-1.1',
	'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; ADVPLUGIN|K115|165|S548873517|dial; 666XXX040507; .NET CLR 2.0.50727)',
	'Mozilla/4.0 (compatible; MSIE 6.0; Windows 98; Win 9x 4.90; Maxthon))'); */
			
	
		var $error;
		
		var $referer;
		
		
		function init(){
			
			$this->curl = curl_init();
			
			if( !$this->curl ){
				$this->error = curl_error($this->curl);
				return;
			}
			$this->set_opt(CURLOPT_RETURNTRANSFER,true);
			$this->set_opt(CURLOPT_CONNECTTIMEOUT,30);
			$this->set_opt(CURLOPT_USERAGENT,$this->user_agent);
			$this->set_opt(CURLOPT_HEADER,false);
			$this->set_opt(CURLOPT_ENCODING,'gzip,deflate');
			///////////////////////////////////////////////////////////////////////////////////////////////////////////
			//$this->set_opt(CURLOPT_FOLLOWLOCATION,true);

			
			//$this->set_opt(CURLOPT_COOKIESESSION,true);
			//$this->set_opt(CURLOPT_COOKIEFILE,'cookiefile');
			//echo $this->user_cookie_file;
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
				$this->error = 'Не удалось записать в файл. Проверьте правильность пути или права на файл.';
			}
			
			return false;
		}
		
		
		function get($url){
			
			$this->url = $url;
			
			if( empty($this->url) ){
				$this->error = 'Не указан URL';
				return false;
			}
			
			$this->set_opt(CURLOPT_URL,$this->url);
			$this->set_opt(CURLOPT_POST,false);

			return $this->exec();			
		}
		
		
		function https_get($url){
			
			$this->url = $url;
			
			if( empty($this->url) ){
				$this->error = 'Не указан URL';
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