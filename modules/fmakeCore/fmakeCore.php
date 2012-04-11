<?php
class fmakeCore extends fmakeWhereSelector{
	/**
	 * 
	 * параметры текущего объекта
	 * @var array хранятся как ключ( имя в базе) - значение 
	 */	
	public $params = array();
	/**
	 * 
	 * поля в базе
	 * @var array
	 */
	public $filds = array();
	/**
	 * 
	 * если объект был создан 
	 * @var bool
	 */
	public $new = false;
	/**
	 * 
	 * имя PRIMARY KEY
	 * @var string
	 */
	public $idField = "id";
	/**
	 * 
	 * основная таблица с которой работает класс 
	 * @var string
	 */
	public $table = "";	
	/**
	 * @var dataBaseController
	 */
	public $dataBase;
	/**
	 * поле по которому будут сортироваться записи
	 * @var string 
	 */
	public $order = false;
	/**
	 * 
	 * класс отображения в системе администрирования, пока не используется 
	 * @var adminViewer 
	 */
	private $adminViewer;
	
	/**
	 * 
	 * Конструктор
	 * @param $id если хотим создать клас для определенной записи, то посылаем ему id
	 */
	function __construct($id = false){
		if($id){
			$this->id = $id;
		}
		$this->order = $this->order ? $this->order: $this->idField;
		$this->setDataBase();
	}
	
	/**
	 * 
	 * Установка базы данных, если хотим выполнять запросы к другому серверу базы данных,
	 * выставляем класс в конструкторе
	 * @param $dataBaseSet
	 */
	function setDataBase($dataBaseSet = false){
		if($dataBaseSet){
			$this->dataBase = &$dataBaseSet;
		}else{
			global $dataBase;
			$this->dataBase = &$dataBase;
		}
	}
	/**
	 * 
	 * класс отображения данного элемента в системе администрирования 
	 */
	function getAdminViewer(){
		return  $this->adminViewer = new adminViewer();
	}
	
	/**
	 * 
	 * Добавление параметра в массив параметров
	 * @param string $key
	 * @param unknown_type $value значение параметра
	 */
	function addParam ($key, $value){
		
		$this->params[$key] = $value;
		
	}

	/**
	 * 
	 * получаем поля таблицы
	 */
	function getFilds(){
		$r = $this->dataBase->query("SHOW COLUMNS FROM `".$prefix.$this->table."`", __LINE__);
		if ($r && $this->dataBase->num_rows($r)){
			
			while ($obj = $this->dataBase->fetch_array()){
				if(in_array($obj['Field'], $this->filds)) continue;
				$this->filds[] = $obj['Field'];
			}
		}
	}
	
	/**
	 * 
	 * поиск по таблице 
	 * @param string $search что ищем
	 * @param string $where условия 
	 * @param bool $active учитывать выключенные
	 */
	function getBySearch($search, $where, $active = false){
		$select = $this->dataBase->SelectFromDB(__LINE__);
		if($active) 
			$select -> addWhere("active='1'");
		$_where = "";
		if($where)
			foreach($where as $key=>$w) {$_where .=$this->table.".".$w.((count($where)>($key+1))?", ":'');}

		$select -> addWhere("MATCH ({$_where}) AGAINST ('".trim($search)."' IN BOOLEAN MODE)");
		return $select -> addFrom($this->table) -> addOrder($this->order) -> queryDB();
	}

	/**
	 * 
	 * Создание нового объекта, с использованием массива params, c учетов поля position
	 */
	function newItem(){
		$insert = $this->dataBase->InsertInToDB(__LINE__);	
			
		$insert	-> addTable("`".$this->table."`");
		$this->getFilds();
		
		if($this->filds){
			if(in_array('position',$this->filds)){
				$select = $this->dataBase->SelectFromDB(__LINE__);
				$position = $select -> addFild('MAX(`position`) AS `position`') -> addFrom($this->table) -> queryDB();
				$this->params['position'] = $position[0]['position'] + 1;
			}
			
			foreach($this->filds as $fild){
				if(!isset($this->params[$fild]) || $fild == 'id') continue; 
				$insert -> addFild("`".$fild."`", $this->params[$fild]);
			}
			
		}
		$insert->queryDB();
		$this->id = $insert	-> getInsertId();
	}

	/**
	 * 
	 * Установка id записи
	 * @param $id
	 */
	function setId($id){
		$this->id = $id;
	}
	
	/**
	 * 
	 * Удаление записи, перед использованием надо установить id записи
	 */
	function delete(){
		
		$delete = $this->dataBase->DeleteFromDB( __LINE__ );		
		$delete	-> addTable($this->table) -> addWhere("`".$this->idField."`='".$this->id."'") -> queryDB();
	}
	/**
	 * 
	 * Обновление записи, с использованием массива params, перед использованием надо установить id записи 
	 */
	function update() {
		if(!$this->filds)
			$this->getFilds();

		foreach($this->filds as $fild)
		{
			if(!isset($this->params[$fild]) || $fild == $this->idField) continue; 
			$update =  $this->dataBase->UpdateDB( __LINE__);
			$update	-> addTable("`".$this->table."`") -> addFild("`".$fild."`", $this->params[$fild]) -> addWhere("{$this->idField}='".$this->id."'") -> queryDB();
		}
	}

	/**
	 * 
	 * Смена значения на противоположное простого enum (0,1), перед использованием надо установить id записи
	 * @param string $field поле
	 */
	function setEnum($field)
	{
		
		$update = $this->dataBase->UpdateDB( __LINE__);
		$update	-> addTable($this->table) -> addFild("$field", "IF($field='1','0','1')", false) -> addWhere("{$this->idField}='".$this->id."'") -> queryDB();
	}

	/**
	 * 
	 * установка поля `index` для записи, перед использованием надо установить id записи.
	 * используется для обозначения началоного объекта, например главной страницы сайта
	 */
	function setIndex()
	{
		$update = $this->dataBase->UpdateDB( __LINE__);			
		$update	-> addTable($this->table) -> addFild("`index`", '0') -> queryDB();
		$update	-> addTable($this->table) -> addFild("`index`", '1') -> addWhere("`id` = '".$this->id."'") -> queryDB();
	}
	/**
	 * 
	 * получения позиции текущей записи, перед использованием надо установить id записи
	 * @return int текущая позиция
	 */
	function getThisOrder() 
	{
		$arr = $this->getInfo();
		return $arr['position'];
	}

	/**
	 * 
	 * поднять элемент на уровень выше, изменив поле position, перед использованием надо установить id записи
	 */
	function getUp (){
		
		$order = $this->getThisOrder();
		$select = $this->dataBase->SelectFromDB( __LINE__);
		$arr = $select -> addFrom($this->table) -> addWhere("`position` < '$order' ") -> addOrder('position', 'DESC')  -> addLimit(0, 1) -> queryDB();
		$arr = $arr[0];
		
		if($arr)
		{
			$update = $this->dataBase->UpdateDB( __LINE__);
			$update	-> addTable($this->table) -> addFild("`position`", $order) -> addWhere("`".$this->idField."` = '".$arr['id']."'") -> queryDB();
			$update	-> addTable($this->table) -> addFild("`position`", $arr['position']) -> addWhere("`".$this->idField."` = '".$this->id."'") -> queryDB();
		}
	}
	/**
	 * 
	 * опустить элемент на уровень ниже, изменив поле position, перед использованием надо установить id записи
	 */
	function getDown (){
		
		$order = $this->getThisOrder();
		$select = $this->dataBase->SelectFromDB( __LINE__);
		$arr = $select -> addFrom($this->table) -> addWhere("`position` > '$order' ") -> addOrder('position', 'ASC')  -> addLimit(0, 1) -> queryDB();
		$arr = $arr[0];

		if($arr){
			
			$update = $this->dataBase->UpdateDB( __LINE__);			
			$update	-> addTable($this->table) -> addFild("`position`", $order) -> addWhere("`{$this->idField}` = '".$arr['id']."'") -> queryDB();
			$update	-> addTable($this->table) -> addFild("`position`", $arr['position']) -> addWhere("`{$this->idField}` = '".$this->id."'") -> queryDB();
			
		}
	}
	/**
	 * 
	 * активировать элемент, перед использованием надо установить id записи
	 */
	function active() {
		
		$update = $this->dataBase->UpdateDB( __LINE__);	
		$update	-> addTable($this->table)	-> addFild("active", "NOT(active)", false) -> addWhere("id='".$this->id."'") -> queryDB();
		
	}
	/**
	 * 
	 * получить все данные записи, перед использованием надо установить id записи
	 * @return array масив всех данных записи
	 */
	function getInfo () 
	{
		$select = $this->dataBase->SelectFromDB( __LINE__);
		$arr = $select -> addFrom($this->table) -> addWhere("`".$this->idField."`='".$this->id."'") -> queryDB();	
		return $arr[0];
	}
	/**
	 * 
	 * Получить все записи в таблице
	 * @param bool $active учитывать выключенные
	 * @return array все имеющиеся записи в таблице
	 */
	function getAll ($active = false) {
		
		$select = $this->dataBase->SelectFromDB( __LINE__);
		if($this->order)
			$select -> addOrder($this->order, (($this->order_as)?$this->order_as:ASC));
		if($active)
			$select -> addWhere("active='1'");
		return $select -> addFrom($this->table) -> queryDB();
		
	}

	/**
	 * 
	 * получить записи из интервала
	 * @param $limit лимит записей
	 * @param $page с какой страницы начинаем
	 * @param $active учитывать выключенные
	 */
	function getByPage($limit, $page, $active = false) {
		
		$select = $this->dataBase->SelectFromDB( __LINE__);
		if($active)
			$select -> addWhere("active='1'");
		return $select -> addFrom($this->table) -> addOrder($this->order, DESC) -> addLimit((($page-1)*$limit), $limit) -> queryDB();
	}
	/**
	 * 
	 * Получить колличество записей в таблице
	 * @param $active учитывать выключенные
	 */
	function getNumRows($active = false) {
		
		$select = $this->dataBase->SelectFromDB( __LINE__);
		if($active)
			$select -> addWhere("active='1'");
		$count = $select -> addFild("COUNT(*)") -> addFrom($this->table) -> queryDB();
		return $count[0]["COUNT(*)"];
	}
	/**
	 * 
	 * Очистить основную таблицу
	 */
	function truncateTable(){
		$SQL = "TRUNCATE TABLE `".$this->table."`";
		$this->dataBase->query($SQL, __LINE__);
	}
	/**
	 * 
	 * Бекап основной таблицы
	 */
	function backUpTable($path) 
	{
		$SQL = "DROP TABLE IF EXISTS `".$this->table."`;\n\n";

		$this -> getFilds();
		$arr = $this -> getAll();

		if($arr) foreach($arr as $row)
		{
			$SQL .= "INSERT INTO `".$this->table."` VALUES (";
			$i = 1;
			foreach($this->filds as $fild)
			{
				$SQL .= "'" . $row[$fild] . "'" . (($i != $this->filds)? ', ':'') . "";
				$i++;
			}
			$SQL .= ");\n";
		}

		$handle = fopen($path . $this->table."_".date("Y-m-d_H-i").".sql", "w+");
		fwrite($handle, $SQL);
		fclose($handle);
	}
	
	/**
	 * 
	 * Использование методов класса
	 */
	function test(){
		
		$classObg = new fmakeCore();
		// установите экспериментальную таблицу, для проверки
		$classObg->table = "";
		echo "<p>Инициализация класса: <b>\$classObg = new fmakeCore();</b><p><br/><br/>";
		echo "<p>Установка не основной базы для класса класса: <b>\$classObg->setDataBase(new dataBaseController(\$FileName, \$db_user_name, $\db_user_pas, \$db_name, \$db_host_name, \$db_port, \$db_crarset, \$pr_name));</b><p><br/><br/>";
		
		$classObg->addParam("test_field", "this is value");
		echo "<p>Добавление параметра: <b>\$classObg->addParam(\"test_field\", \"this is value\");</b><p><br/><br/>";
		if($classObg->table)
			$classObg->getFilds();
		echo "<p>Получение полей таблицы: <b>\$classObg->getFilds();</b><p><br/>";
		if($classObg->table)
			$classObg->getBySearch("search query", "active = 1");
		echo "<p>Получение полей таблицы: <b>\$classObg->getBySearch(\"search query\", \"active = 1\");</b><p><br/><br/>";
		
		$classObg->addParam("test_field", "this is value");
		$classObg->addParam("test_field2", "this is value2");
		if($classObg->table)
			$classObg->newItem();
		
		echo "<p>Создание нового объекта: <b>\$classObg->addParam(\"test_field\", \"this is value\");<br/>
											 \$classObg->addParam(\"test_field2\", \"this is value2\");<br/>
											 \$classObg->newItem();</b><p><br/><br/>";
		
		$classObg->setId(101);
		echo "<p>Установка id: <b>\$classObg->setId(101);</b><p><br/><br/>";
		
		$classObg->setId(101);
		if($classObg->table)
			$classObg->delete();
		echo "<p>Удаление объекта: <b>\$classObg->setId(101);<br/>
											 \$classObg->delete();</b><p><br/><br/>";
		
		$classObg->setId(101);
		if($classObg->table)
			$classObg->update();
		echo "<p>Обновление объекта: <b>\$classObg->setId(101);<br/>
											 \$classObg->update();</b><p><br/><br/>";
		
		$classObg->setId(101);
		if($classObg->table)
			$classObg->setEnum('active');
		echo "<p>Смениа enum: <b>\$classObg->setId(101);<br/>
											 \$classObg->setEnum('active');</b><p><br/><br/>";
		$classObg->setId(101);
		if($classObg->table)
			$classObg->setIndex();
		echo "<p>Делаем объект index: <b>\$classObg->setId(101);<br/>
											 \$classObg->setIndex();</b><p><br/><br/>";
		
		
		/**
		 * остальные функции анологичны, для их использования воспользуйтесб описанием
		 */
	}
	
}
?>