<?php
	/**
	 * 
	 * типы записей, дублируем в дефайне
	 * @var integer
	 */
	define(NEWS_ID, 1);
	define(BLOG_ID, 2);

	class fmakeNotice extends fmakeCore{
		
		public $idField = "notice_id";
		public $table = "notice";
		public $order = "position";
		/**
		 * 
		 * для маленьких картинок
		 * @var string
		 */
		public $prefix_mini = 'small';
		/** для картинок главных новостей
		 * @var string
		 */
		public $prefix_main = 'main';
		public $imgFolder = "images/news/";
		
		/**
		 * 
		 * получить записи по страничнок
		 * @param type_id integer тип  записи
		 * @param $limit лимит на одной странице
		 * @param $page номер страницы начиная с 1
		 * @param $active активные записи
		 */
		function getForPage($type_id,$limit, $page,$active = false){
			$select = $this->dataBase->SelectFromDB( __LINE__);
			if($active)
				$select -> addWhere("active='1'");
			return $select -> addWhere("type_id = ".$type_id) -> addFrom($this->table) -> addOrder($this->order, DESC) -> addLimit((($page-1)*$limit), $limit) -> queryDB();
		}
		
		/**
		 * 
		 * получить записи по страничнок
		 * @param type_id integer тип  записи
		 * @param section_id integer тип  записи
		 * @param $limit лимит на одной странице
		 * @param $page номер страницы начиная с 1
		 * @param $active активные записи
		 */
		function getForPageBySection( $type_id, $section_id,$limit, $page,$active = false){
			$select = $this->dataBase->SelectFromDB( __LINE__);
			if($active){
				$select -> addWhere("active='1'");
			}
			if($section_id){
				$select -> addWhere("section_id = ".$section_id);
			}
			return $select -> addWhere("type_id = ".$type_id)  -> addFrom($this->table) -> addOrder($this->order, DESC) -> addLimit((($page-1)*$limit), $limit) -> queryDB();
		}
		
		/**
		 * 
		 * получить все записи по типу
		 * @param $type_id
		 * @param $active
		 */
		function getAllByType($type_id,$active = false){
			
			$select = $this->dataBase->SelectFromDB( __LINE__);
			if($this->order)
				$select -> addOrder($this->order, (($this->order_as)?$this->order_as:DESC));
			if($active)
				$select -> addWhere("active='1'");
			return $select -> addWhere("type_id = ".$type_id) -> addFrom($this->table) -> queryDB();
		}
		
		/**
		 * 
		 * получить новости
		 */
		function getNews($limit, $page,$active = false){
			return $this->getForPage(NEWS_ID, $limit, $page,$active);
		}
		/**
		 * 
		 * получить новости
		 */
		function getNewsBySectionId($section_id, $limit, $page, $active = false){
			return $this->getForPageBySection(NEWS_ID, $section_id, $limit, $page,$active);
		}
		/**
		 * 
		 * получить главные новости
		 */
		function getMainNews($limit, $page,$active = false){
			$select = $this->dataBase->SelectFromDB( __LINE__);
			if($active)
				$select -> addWhere("active='1'");
			return $select ->addWhere("inmain = 1") -> addWhere("type_id = ".NEWS_ID) -> addFrom($this->table) -> addOrder($this->order, DESC  ) -> addLimit((($page-1)*$limit), $limit) -> queryDB();
		}
		/**
		 * 
		 * получить все новости
		 * @param $active
		 */
		function getAllNews($active = false){
			return $this->getAllByType(NEWS_ID,$active);
		}
		/**
		 * 
		 * получить записи блога
		 */
		function getBlog($limit, $page,$active = false){
			return $this->getForPage(BLOG_ID, $limit, $page,$active);
		}
		/**
		 * 
		 * получить все записи блога
		 * @param $active
		 */
		function getAllBlog($active = false){
			return $this->getAllByType(BLOG_ID,$active);
		}
		
		/**
		*
		* добавление новостей в шаблон с тегами и т.п.
		* @param $section_id int секция
		* @param $limit int колличество
		* @param $page int страница
		*/
		function addTemplateNews($section_id = 0, $limit = 10, $page = 1,$active = true){
			global $globalTemplateParam;
			$noticeObj = new fmakeNotice();
			$sectionObj = new fmakeSection();
			$tags = new fmakeNotice_tags();
			$comments = new fmakeNotice_comment();
			$sectionsTmp = $sectionObj->getAll(true);
			$sections = array(); 
			/**
			 * приводим к виду id => caption
			 */
			$sections[0] = 'Все';
			for($i=0;$i<sizeof($sectionsTmp);$i++){
				$sections[ $sectionsTmp[$i][$sectionObj->idField] ] = $sectionsTmp[$i]['caption']; 
			}
			
			$news = $noticeObj->getNewsBySectionId($section_id, $limit, $page, $active);
			// добавляем теги
			for($i=0;$i < sizeof($news);$i++){
				$news[$i]['tags'] =  $tags -> getTags ($news[$i][ $noticeObj -> idField ]);
				$news[$i]['comments'] = $comments -> getCommentsCount($news[$i][ $noticeObj -> idField ]);
			}
			
			$globalTemplateParam->set("sections", $sections);
			$globalTemplateParam->set("news", $news);
			$globalTemplateParam->set("noticeObj", $noticeObj);
			
		}
		
		function addPreviewFoto($file,$inmain = false){
		
			$dirs = explode("/", $this->imgFolder.$this->id);
			$dirname = ROOT."/";
			
			foreach($dirs as $dir){
				$dirname = $dirname.$dir."/";
				if(!is_dir($dirname)) mkdir($dirname);	
			}
			
			//echo $dirname;
			$images = new imageMaker($file['name']);
			$images->imagesData = $file['tmp_name'];
			
			$image = $images->resize(500,300,false,$dirname.'/','','jpg');
			
			if($inmain){
				$images->setPath($this->prefix_main."_".$file['name']);
				$images->resize(584,356,true,$dirname.'/','','jpg');
			}
			
			$images->setPath($this->prefix_mini."_".$file['name']);
			$images->resize(97,97,true,$dirname.'/','','jpg');
			
			$this->addParam("image", $image);
			$this->update();
			
		}
		
		/**
	 * 
	 * поднять элемент на уровень выше, изменив поле position, перед использованием надо установить id записи
	 */
	function getUp (){
		
		
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
	 * опустить элемент на уровень ниже, изменив поле position, перед использованием надо установить id записи
	 */
	function getDown (){
		
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
		
		function deleteImages(){
			$info = $this->getInfo();
			$this->image = $info['image'];
			if(file_exists(ROOT."/".$this->imgFolder.$this->id."/".$this->prefix_mini."_".$this->image))
				unlink(ROOT."/".$this->imgFolder.$this->id."/".$this->prefix_mini."_".$this->image);
	
			if(file_exists(ROOT."/".$this->imgFolder.$this->id."/".$this->prefix_main."_".$this->image))
				unlink(ROOT."/".$this->imgFolder.$this->id."/".$this->prefix_main."_".$this->image);
	
			if(file_exists(ROOT."/".$this->imgFolder.$this->id."/".$this->image))
				unlink(ROOT."/".$this->imgFolder.$this->id."/".$this->image);	
		}
		
		function delete(){
			$this->deleteImages();
			parent::delete();
		}
		
	}
?>