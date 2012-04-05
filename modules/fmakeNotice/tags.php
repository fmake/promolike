<?php

	class fmakeNotice_tags extends fmakeCore{
		
		public $idField = "tag_id";
		public $table = "tags";
		public $table_notice_tags = "notice_tags";
		
		/**
		*
		* ƒобавл€ем тег, если его нету
		* @param $name им€ тега
		*/
		function addTag($name){
			$tag = $this->getWhere(array("`name` = '{$name}'"));
			$tag = $tag[0];
			if($tag){
				return $tag;
			}
			$this -> addParam('name',$name);
			$this -> newItem();
			$this -> params = array();
			return $this->getInfo();
		}
		/**
		*
		* ƒобавл€ем тег к записи
		* @param $tagsStr теги
		*/
		function addTags($tagsStr, $notice_id){
			if(!$tagsStr) return;
			$tags = explode (',',$tagsStr);
			global $request ;
			$tagsNotDelete = array();
			for($i=0;$i<sizeof($tags);$i++){
				$tagStr = trim($tags[$i]);
				if(!$tagStr) continue;
				$tagsNotDelete[$i] = $this -> addNoticeTag( $request -> getEscapeVal($tagStr), $notice_id);
			}
			// удал€ем тех, что не прислали
			//printAr($tagsNotDelete);
			if($tagsNotDelete){
				$delete = $this->dataBase->DeleteFromDB( __LINE__ );
				foreach ($tagsNotDelete as $tagNotDelete){
					$delete -> addWhere("`".$this->idField."` != '".$tagNotDelete[$this->idField]."'");
				}
				$delete	-> addTable($this->table_notice_tags) -> addWhere("`notice_id`='".$notice_id."'") -> queryDB();
			}
		}
		/**
		*
		* ƒобавл€ем тег к записи
		* @param $name им€ тега
		* @param $notice_id id записи
		*/
		function addNoticeTag($name,$notice_id){
			$tag = $this -> addTag( $name );
			$tmp = $this->table;
			$this->table = $this->table_notice_tags;
			$item = $this->getWhere(array("`notice_id` = '{$notice_id}'","`{$this->idField}` = '{$tag[$this->idField]}'"));
			if($item){
				$this->table = $tmp;
				return $item[0];
			}
			
			$this -> addParam($this->idField,$tag[$this->idField]);
			$this -> addParam("notice_id",$notice_id);
			
			$this ->newItem();
			$item['notice_id'] = $notice_id;
			$item[$this->idField] = $tag[$this->idField];
			$this -> params = array();
			$this->table = $tmp;
			return $item;
		}
		/**
		*
		* ѕолучить теги дл€ записи
		* @param $name им€ тега
		* @param $notice_id id записи
		*/
		function getTags($notice_id){
			
			$tmp = $this->table;
			$this->table = $this->table_notice_tags;
			$items = $this->getWhere(array("`notice_id` = '{$notice_id}'"));
			$this->table = $tmp;
			for($i=0;$i<sizeof($items);$i++){
				$this->setId($items[$i][$this->idField]);
				$items[$i] = $this->getInfo();
			}
			return $items;
		}
		
		function tagsToString($tags){

			for($i=0;$i<sizeof($tags);$i++){
				$str .= $tags[$i]['name'].', ';
			}
			return $str;
		}
		
		function tagsToJsString($tags){

			for($i=0;$i<sizeof($tags);$i++){
				$str .= '"'.$tags[$i]['name'].'", ';
			}
			return $str;
		}
		
	}
?>