<?
class utlPicture
{
	public $bg = "/images/picbg.gif";
	public $font = "/images/fonts/tahoma.ttf";
	public $symbols = "23456789abcdeghkmnpqsuvxyz";
	public $line = "";

	function __construct()
	{
	
	}

	function genPic($length = 5)
	{
		for($i=1; $i<=$length; $i++)
			$this->line .= $this->symbols[rand(0, strlen($this->symbols))];

		$bg = imagecreatefromgif(ROOT.$this->bg);
		$color = imagecolorallocate($bg, 0, 0, 0);
		imagettftext($bg, 12, 0, 2, 15, $color, ROOT.$this->font, $this->line);
		header("Content-type: image/png");
		imagepng($bg);
		imagedestroy($bg);
	}

	function getLine()
	{
		return $this->line;
	}
}
?>