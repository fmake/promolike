<?php

	class fmakeNotice_comment extends fmakeCore{
		
		public $idField = "notice_comment_id";
		public $table = "notice_comment";
		public $order = "date";
		
		
		/**
		*
		* �������� ����������� ��� ������
		* @param $notice_id id ������
		* @param $limit ����������� ������� �� ��������
		* @param $page ��������
		*/
		function getCommentsForPage ($notice_id, $limit, $page, $active = false){
		
			$select = $this->dataBase->SelectFromDB( __LINE__);
			if($active)
				$select -> addWhere("active='1'");
			return $select -> addWhere("notice_id = '{$notice_id}'") -> addFrom($this->table) -> addOrder($this->order, DESC) -> addLimit((($page-1)*$limit), $limit) -> queryDB();

		}

		/**
		*
		* �������� ����������� ������������ ��� ������
		* @param $notice_id id ������
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