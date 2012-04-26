<?php
class fmakeGalleryNew extends fmakeSiteModule implements fmakeSiteModule_ExtensionInterface {
		
	public $table = "fmake_gallery";
	public $imgFolder = "images/gallery/";
	
	
	function getByPage($id_catalog ,$limit, $page, $active = false) {
		
		$select = $this->dataBase->SelectFromDB( __LINE__);
		if($active)
			$select -> addWhere("active='1'");
		return $select -> addFrom($this->table) ->addWhere("id_catalog = '{$id_catalog}'") -> addOrder($this->order, ASC) -> addLimit((($page-1)*$limit), $limit) -> queryDB();
	}
	
	function addPreviewFoto($file){
		
		$dirs = explode("/", $this->imgFolder.$this->id);
		$dirname = ROOT."/";
		
		foreach($dirs as $dir){
			$dirname = $dirname.$dir."/";
			if(!is_dir($dirname)) mkdir($dirname);	
		}
		
		//echo $dirname;
		$images = new imageMaker($file['name']);
		$images->imagesData = $file['tmp_name'];
		
		$image = $images->resize(800,600,true,$dirname.'/','','jpg');
		
		$images->setPath($this->prefix_mini."_".$file['name']);
		$images->resize(288,235,true,$dirname.'/','','jpg');
		
		$this->addParam("image", $image);
		$this->update();
		
	}
	
	function getNumRows($id_catalog = false,$active = false) {
		
		$select = $this->dataBase->SelectFromDB( __LINE__);
		if($active)
			$select -> addWhere("active='1'");
		if($id_catalog)
			$select -> addWhere("id_catalog = '{$id_catalog}'");	
		$count = $select -> addFild("COUNT(*)") -> addFrom($this->table) -> queryDB();
		return $count[0]["COUNT(*)"];
	}
	
	function deleteImages(){
		$info = $this->getInfo();
		$this->image = $info['image'];
		if(file_exists(ROOT."/".$this->imgFolder.$this->id."/".$this->prefix_mini."_".$this->image))
			unlink(ROOT."/".$this->imgFolder.$this->id."/".$this->prefix_mini."_".$this->image);

		if(file_exists(ROOT."/".$this->imgFolder.$this->id."/".$this->image))
			unlink(ROOT."/".$this->imgFolder.$this->id."/".$this->image);	
	}
	
	function delete(){
		$this->deleteImages();
		parent::delete();
	}
		
} 