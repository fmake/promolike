<?php
/**
 * 
 * Лайк, размещенная ссылка
 * @author 1
 *
 */
class promoLike_textlike extends fmakeCore{
	
	public $idField = "id_text_like";
	public $table = "text_like";
	public $order = "date_placed";
	public $imgFolder = "images/image_textlike/";
	
	/**
	 * 
	 * Все тексты лайков для страницы
	 * @param int $id_page
	 */
	
	function getAllTextPage($id_page,$active = false){
		$select = $this->dataBase->SelectFromDB(__LINE__);
		$fmakePage = new promoLike_page();
		if($active)
			$select -> addWhere("active='1'");
		return $select->addFrom($this->table)->addWhere($fmakePage->idField.' = '.$id_page.'')->addWhere("`delete_page` = '0'")->queryDB();
	}

	/**
	 * 
	 * Колличество текстов лайков на странице
	 * @param int $id_page
	 */
	
	function getAllTextPageCount($id_page){
		$select = $this->dataBase->SelectFromDB(__LINE__);
		$fmakePage = new promoLike_page();
		$result = $select->addFild("COUNT(*)")->addFrom($this->table)->addWhere($fmakePage->idField.' = '.$id_page.'')->addWhere("`delete_page` = '0'")->queryDB();
		return $result[0]["COUNT(*)"];
	}
	
	/**
	 * 
	 * Рандомный активный текст страницы 
	 * @param int $id_page
	 */
	
	function getRandTextActive($id_page)
	{
		$select = $this->dataBase->SelectFromDB(__LINE__);
		$fmakePage = new promoLike_page();
		$result = $select->addFrom($this->table)->addWhere($fmakePage->idField.' = '.$id_page.'')->addWhere("`active` = '1'")->addWhere("`delete_page` = '0'")->addOrder("RAND()")->addLimit(0,1)->queryDB();
		return $result[0];
		//$update = $this->dataBase->UpdateDB( __LINE__);
		//$update	-> addTable($this->table) -> addFild("active", "IF('active'='1','0','1')", false) -> addWhere("{$this->idField}='".$this->id."'") -> queryDB();
	}
	
	/**
	 * 
	 * Делаем превью изображения
	 * @param string $tmp_file
	 * @param string $name_file
	 */
	
	function addPreviewFoto($tmp_file,$name_file){
		$id_gal = $this->id;
		$dirs = explode("/", $this->imgFolder.$id_gal);
		$dirname = ROOT."/";
		
		foreach($dirs as $dir){
			$dirname = $dirname.$dir."/";
			if(!is_dir($dirname)) mkdir($dirname);	
		}
		if(!is_dir($dirname.'/thumbs/')) mkdir($dirname.'/thumbs/');
		//echo $dirname;
		$images = new imageMaker($name_file);
		$images->imagesData = $tmp_file;
		
		$images->resize(800,false,false,$dirname.'/','',false);
		
		$images->resize(48,48,true,$dirname.'/thumbs/','',false);
				
		$this->addParam("image", $name_file);
		$this->update();
	}
	
	/**
	 * 
	 * удаление изображений
	 */
	
	function deleteImages(){
		$info = $this->getInfo();
		$this->image = $info['image'];
		
		if(file_exists(ROOT."/".$this->imgFolder.$this->id."/".$this->image))
			@unlink(ROOT."/".$this->imgFolder.$this->id."/".$this->image);	
	}
	
	/**
	 * удаление
	 * @see fmakeCore::delete()
	 */
	
	
	function delete(){ 
		$this->deleteImages();
		parent::delete();
	}
	
	/**
	 * 
	 * Удаление записи
	 */
	function deleteTextPage($id_textpage,$id_page){
		$update =  $this->dataBase->UpdateDB( __LINE__);
		$fmakePage = new promoLike_page();		
		$update	-> addTable($this->table) -> addFild("`delete_page`", 1) -> addWhere($this->idField."='".$id_textpage."'") -> addWhere($fmakePage->idField."='".$id_page."'") -> queryDB();
	}
	
	function resize($filename, $sx=0, $sy=0)
	{
		$imagearr = getimagesize($filename);
		switch($imagearr['mime']) {

			case 'image/jpeg':
				$im = @imagecreatefromjpeg($filename)
					or die("Couldn't initialize new GD image stream.");
			break;

			case 'image/gif':
				$im = @imagecreatefromgif($filename)
					or die("Couldn't initialize new GD image stream.");
			break;

			case 'image/png':
				$im = @imagecreatefrompng($filename)
					or die("Couldn't initialize new GD image stream.");
			break;

			case 'image/bmp':
				$im = @imagecreatefrombmp($filename)
					or die("Couldn't initialize new GD image stream.");
			break;

			default:
				die("Couldn't initialize new GD image stream.");
		}

		$width	= imagesx($im);
		$height	= imagesy($im);

		if ($sx && $sy) {
			if($width >= $height)
				$sy = ($sx * $height) / $width;
			
			if($width < $height)
				$sx = ($sy * $width) / $height;
		}
		else if ($sx && !$sy)
			$sy = ($sx * $height) / $width;
		else if (!$sx && $sy)
			$sx = ($sy * $width) / $height;
		else if (!$sx && !$sy)
			return $im;
		
		if ($sx > $width)
		{
			$sx = $width;
			$sy = $height;
		}
			
		$im1 = @imagecreatetruecolor($sx, $sy)
			or die("Couldn't initialize new GD image stream.");

		@imagecopyresampled($im1, $im, 0, 0, 0, 0, $sx, $sy, $width, $height);

		imagedestroy($im);
		return $im1;
	}
}