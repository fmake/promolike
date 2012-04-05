<?php

	class fmakeNotice_comment extends fmakeCore{
		
		public $idField = "notice_comment_id";
		public $table = "notice_comment";
		public $order = "date";
		
		
		/**
		*
		* ѕолучить комментарии дл€ записи
		* @param $notice_id id записи
		* @param $limit колличество записей на странице
		* @param $page страница
		*/
		function getCommentsForPage ($notice_id, $limit, $page, $active = false){
		
			$select = $this->dataBase->SelectFromDB( __LINE__);
			if($active)
				$select -> addWhere("active='1'");
			return $select -> addWhere("notice_id = '{$notice_id}'") -> addFrom($this->table) -> addOrder($this->order, DESC) -> addLimit((($page-1)*$limit), $limit) -> queryDB();

		}

		/**
		*
		* ѕолучить колличество комментариев дл€ записи
		* @param $notice_id id записи
		*/
		function getCommentsCount ($notice_id, $active = false){
		
			$select = $this->dataBase->SelectFromDB( __LINE__);
			if($active)
				$select -> addWhere("active='1'");
			$arr = $select -> addFild('count(*) as count') -> addWhere("notice_id = '{$notice_id}'") -> addFrom($this->table) -> queryDB();
			return $arr[0]['count'];
		}
		
	}
?>