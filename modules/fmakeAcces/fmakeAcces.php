<?php 
	class fmakeAcces extends fmakeCore{
		
		function getAccessQuery($field,$where){
			return $this->getFieldWhereSqlQuery($field,$where);
		}
		
		function getAccessStandartQuery($role){
			return $this->getAccessQuery(array('id_modul'),array("id_role ='{$role}'"));
		}
		
		function getByModulId($idModul,$fild = false){
	
			$select = $this->dataBase->SelectFromDB(__LINE__);
			if($fild){
				 $select -> addFild($fild);
			}
			return $select -> addFrom($this->table) -> addWhere("id_modul = '{$idModul}'") -> queryDB();	
			
		}
		
		function deleteByModulRoleId($idModul,$idRole){
		
			$delete = $this->dataBase->DeleteFromDB(__LINE__);	
			$delete	-> addTable($this->table) -> addWhere("id_modul = '{$idModul}'") -> addWhere("id_role = '{$idRole}'") -> queryDB();
			
		}
		
		function arraySimple($arr,$key){
			for($i=0;$i<count($arr);$i++){
				$arr[$i] = $arr[$i][$key];
			}
			return $arr;
		}
		
		function setAcces($idModul,$rols){
		
			$allCurrenRole = $this->arraySimple($this->getByModulId($idModul,"id_role"),"id_role");
			//printAr($allCurrenRole);
			//printAr($rols);
			if(!$allCurrenRole)$allCurrenRole = array();
			if(!$rols)$rols = array();
			
			//находим те роли которе надо удалить и которые надо добавить
			$deleteRole = array_diff($allCurrenRole,$rols);
			$addRole = array_diff($rols,$allCurrenRole);
			
			foreach ($deleteRole as $del){
				$this->deleteByModulRoleId($idModul,$del);
			}
			
			foreach ($addRole as $rol){
				$this->addParam("id_modul" , $idModul);
				$this->addParam("id_role" , $rol);
				$this->newItem();
			}
		
		}
		
	}
?>