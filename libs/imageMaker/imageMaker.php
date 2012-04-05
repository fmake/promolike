<?php
class imageMaker {
	
	public $images;
	public $imagesData;
	function __construct($url_images = false){
		$this->images = $url_images;
		return $this;
	}
	
	function setPath($url_images){
		$this->images = $url_images;
	}
	
	//$text_wantermark -текст 
	//$font - шрифт
	//$r,$g,$b - RGB цвет текста
	//wantermark_text('www.zachetov.net', 'tahoma.ttf', 0, 0, 0);
	function wantermark_text($text_wantermark,$font,$r,$g,$b){
		include 'api.watermark.php';
		$watermark = new watermark();
		$img = imagecreatefromjpeg($this->images);
		$im=$watermark->create_watermark_text($img,$text_wantermark,$font,$r,$g,$b,100);
		imagejpeg($im,$this->images);
	}
	//вантермарк с изображением png по центру
	function wantermark_img($url_wantermark) {
		include 'api.watermark.php';
		$watermark = new watermark();
		$main_img_obj = imagecreatefromjpeg($this->images);
		$watermark_img_obj	= imagecreatefrompng($url_wantermark);
		$return_img_obj			= $watermark->create_watermark( $main_img_obj, $watermark_img_obj, 66 );
		imagejpeg( $return_img_obj,$this->images, 50 );
	}
	//$w = ширина фотки
	//$h = высота фотки
	//$obrezanie_foto = обрезать ли фотку если фотка больше размеров
	//$folder = true - записывать в папку c фоткой с префиксом tmp_ или false - в папку по умолчанию 
	//$prefix = дополнительный префикс по умолчанию он пуст
	//$format = формат конвертирования фотки (jpg|png|bmp|gif)
	function resize($w=false,$h=false,$obrezanie_foto=false,$folder=false,$prefix='',$format=false){
		require_once 'phpthumb/phpthumb.class.php';
		$trumb = new phpthumb();
		$trumb->setSourceData(file_get_contents($this->imagesData ? $this->imagesData : $this->images));
		$file = preg_replace('#(.*)/#','','./'.$this->images);
		if($format){
			$file = preg_replace('#.(jpg|jpeg|png|bmp|gif)#i', '',$file);
			$catalog = preg_replace('#'.$file.'.(jpg|jpeg|png|bmp|gif)#i','',''.$this->images);
			$trumb->setParameter('config_output_format', $format);
		}
		else $catalog = preg_replace('#'.$file.'#','',''.$this->images);

		if($folder){
			if($format)$output_filename = $folder.$prefix.$file.'.'.$format;
			else $output_filename = $folder.$prefix.$file;
		}
		else{
			
			if($format)$output_filename = '/images/temp/'.$prefix.$file.'.'.$format;
			else $output_filename = '/images/temp/'.$prefix.$file;
		}
		
		//echo $output_filename."end";
		if($w)$trumb->setParameter('w',$w);
		if($h)$trumb->setParameter('h',$h);
		if($obrezanie_foto)$trumb->setParameter('zc', 1);
		
		if ($trumb->GenerateThumbnail()) { // this line is VERY important, do not remove it!
			if ($trumb->RenderToFile($output_filename)) {
				// do something on success
				//echo 'Successfully rendered to "'.$output_filename.'"';
				return $file.".".$format;
			} else {
				// do something with debug/error messages
				//echo 'Failed:<pre>'.implode("\n\n", $trumb->debugmessages).'</pre>';
			}
		} else {
			// do something with debug/error messages
			//echo 'Failed:<pre>'.$trumb->fatalerror."\n\n".implode("\n\n", $trumb->debugmessages).'</pre>';
		}
		
	}
	
	function convert($format){
		
	}
}
?>