<?php
/*
* cPHPezMail Version 1.2 (2005-09-09 12:55 pm +7 GMT)
* COPYRIGHT 2004-2005 CHARIN NAWARITLOHA.
* Contact: inews@charinnawaritloha.net
*/
class utlMailer
{
	var $aHeader;
	var $aMessage;
	var $aPOSTFileAttach;
	var $aLocalFileAttach;
	var $sFrom;
	var $aTo;
	var $sMimeBoundary;
	var $sAltBoundary;
	var $sBodyText;
	var $sBodyHTML;
	var $sSubject;
	var $sCharset;
	var $nEncoding;
	var $sTempFileName;
	var $aMimeType;
	var $sDefaultMimeType;
	
	function __construct()
	{
		$this->aLocalFileAttach = array();
		$this->aPOSTFileAttach = array();
		$this->aHeader = array();
		$this->aMessage = array();
		$this->sMimeBoundary = '==Multipart_Boundary_X'. md5(time()) .'X';
		$this->sAltBoundary = '==Alternative_Boundary_X'. md5(time()) .'X';
		$this->aTo = array();
		$this->aCc = array();
		$this->aBcc = array();
		$this->sFrom = '';
		$this->sBodyHTML = '';
		$this->sBodyText = '';
		$this->sSubject = '';
		$this->sCharset = 'iso-8859-1';
		$this->nEncoding = 7;
		$this->sTempFileName = ROOT.'/temp/' . md5(time()) . '.tmp';
		$this->sDefaultMimeType = 'application/octet-stream';
		$this->aMimeType = array (
			'ai' => 'application/postscript',
			'aif' => 'audio/x-aiff',
			'aifc' => 'audio/x-aiff',
			'aiff' => 'audio/x-aiff',
			'asc' => 'text/plain',
			'au' => 'audio/basic',
			'avi' => 'video/x-msvideo',
			'bcpio' => 'application/x-bcpio',
			'bin' => 'application/octet-stream',
			'bmp' => 'image/bmp',
			'cdf' => 'application/x-netcdf',
			'cgm' => 'image/cgm',
			'class' => 'application/octet-stream',
			'cpio' => 'application/x-cpio',
			'cpt' => 'application/mac-compactpro',
			'csh' => 'application/x-csh',
			'css' => 'text/css',
			'dcr' => 'application/x-director',
			'dir' => 'application/x-director',
			'djv' => 'image/vnd.djvu',
			'djvu' => 'image/vnd.djvu',
			'dll' => 'application/octet-stream',
			'dms' => 'application/octet-stream',
			'doc' => 'application/msword',
			'dtd' => 'application/xml-dtd',
			'dvi' => 'application/x-dvi',
			'dxr' => 'application/x-director',
			'eps' => 'application/postscript',
			'etx' => 'text/x-setext',
			'exe' => 'application/octet-stream',
			'ez' => 'application/andrew-inset',
			'gif' => 'image/gif',
			'gram' => 'application/srgs',
			'grxml' => 'application/srgs+xml',
			'gtar' => 'application/x-gtar',
			'gzip' => 'application/x-gzip',
			'hdf' => 'application/x-hdf',
			'hqx' => 'application/mac-binhex40',
			'htm' => 'text/html',
			'html' => 'text/html',
			'ice' => 'x-conference/x-cooltalk',
			'ico' => 'image/x-icon',
			'ics' => 'text/calendar',
			'ief' => 'image/ief',
			'ifb' => 'text/calendar',
			'iges' => 'model/iges',
			'igs' => 'model/iges',
			'jpe' => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'jpg' => 'image/jpeg',
			'js' => 'application/x-javascript',
			'kar' => 'audio/midi',
			'latex' => 'application/x-latex',
			'lha' => 'application/octet-stream',
			'lzh' => 'application/octet-stream',
			'm3u' => 'audio/x-mpegurl',
			'man' => 'application/x-troff-man',
			'mathml' => 'application/mathml+xml',
			'me' => 'application/x-troff-me',
			'mesh' => 'model/mesh',
			'mid' => 'audio/midi',
			'midi' => 'audio/midi',
			'mov' => 'video/quicktime',
			'movie' => 'video/x-sgi-movie',
			'mp2' => 'audio/mpeg',
			'mp3' => 'audio/mpeg',
			'mpe' => 'video/mpeg',
			'mpeg' => 'video/mpeg',
			'mpg' => 'video/mpeg',
			'mpga' => 'audio/mpeg',
			'ms' => 'application/x-troff-ms',
			'msh' => 'model/mesh',
			'mxu' => 'video/vnd.mpegurl',
			'nc' => 'application/x-netcdf',
			'oda' => 'application/oda',
			'ogg' => 'application/ogg',
			'pbm' => 'image/x-portable-bitmap',
			'pdb' => 'chemical/x-pdb',
			'pdf' => 'application/pdf',
			'pgm' => 'image/x-portable-graymap',
			'pgn' => 'application/x-chess-pgn',
			'png' => 'image/png',
			'pnm' => 'image/x-portable-anymap',
			'ppm' => 'image/x-portable-pixmap',
			'ppt' => 'application/vnd.ms-powerpoint',
			'ps' => 'application/postscript',
			'qt' => 'video/quicktime',
			'ra' => 'audio/x-realaudio',
			'ram' => 'audio/x-pn-realaudio',
			'ras' => 'image/x-cmu-raster',
			'rdf' => 'application/rdf+xml',
			'rgb' => 'image/x-rgb',
			'rm' => 'audio/x-pn-realaudio',
			'roff' => 'application/x-troff',
			'rpm' => 'audio/x-pn-realaudio-plugin',
			'rtf' => 'text/rtf',
			'rtx' => 'text/richtext',
			'sgm' => 'text/sgml',
			'sgml' => 'text/sgml',
			'sh' => 'application/x-sh',
			'shar' => 'application/x-shar',
			'silo' => 'model/mesh',
			'sit' => 'application/x-stuffit',
			'skd' => 'application/x-koan',
			'skm' => 'application/x-koan',
			'skp' => 'application/x-koan',
			'skt' => 'application/x-koan',
			'smi' => 'application/smil',
			'smil' => 'application/smil',
			'snd' => 'audio/basic',
			'so' => 'application/octet-stream',
			'spl' => 'application/x-futuresplash',
			'src' => 'application/x-wais-source',
			'sv4cpio' => 'application/x-sv4cpio',
			'sv4crc' => 'application/x-sv4crc',
			'svg' => 'image/svg+xml',
			'swf' => 'application/x-shockwave-flash',
			't' => 'application/x-troff',
			'tar' => 'application/x-tar',
			'tcl' => 'application/x-tcl',
			'tex' => 'application/x-tex',
			'texi' => 'application/x-texinfo',
			'texinfo' => 'application/x-texinfo',
			'tif' => 'image/tiff',
			'tiff' => 'image/tiff',
			'tr' => 'application/x-troff',
			'tsv' => 'text/tab-separated-values',
			'txt' => 'text/plain',
			'ustar' => 'application/x-ustar',
			'vcd' => 'application/x-cdlink',
			'vrml' => 'model/vrml',
			'vxml' => 'application/voicexml+xml',
			'wav' => 'audio/x-wav',
			'wbmp' => 'image/vnd.wap.wbmp',
			'wbxml' => 'application/vnd.wap.wbxml',
			'wml' => 'text/vnd.wap.wml',
			'wmlc' => 'application/vnd.wap.wmlc',
			'wmls' => 'text/vnd.wap.wmlscript',
			'wmlsc' => 'application/vnd.wap.wmlscriptc',
			'wrl' => 'model/vrml',
			'xbm' => 'image/x-xbitmap',
			'xht' => 'application/xhtml+xml',
			'xhtml' => 'application/xhtml+xml',
			'xls' => 'application/vnd.ms-excel',
			'xml' => 'application/xml',
			'xpm' => 'image/x-xpixmap',
			'xsl' => 'application/xml',
			'xslt' => 'application/xslt+xml',
			'xwd' => 'image/x-xwindowdump',
			'xyz' => 'chemical/x-xyz',
			'zip' => 'application/zip');

		//If you want to make default value TO DO here
		//make default header
		$this->AddHeader('MIME-Version', '1.0');
	}
	
	function SetFrom($str_Email, $str_ScreenName='')
	{
		if($str_ScreenName)
			$this->sFrom = "$str_ScreenName <$str_Email>";
		else
			$this->sFrom = "$str_Email";
	}

	function AddTo($str_Email, $str_ScreenName='')
	{
		$str_Email = explode(",", $str_Email);
		foreach($str_Email as $key=>$_str_Email)
		{
			$_str_Email = trim($_str_Email);
			
			($key==0)?
				$this->aTo[] = ($str_ScreenName)?"$str_ScreenName <$_str_Email>":"<$_str_Email>"
			:
				$this->AddCc($_str_Email, $str_ScreenName);
		}
	}
	
	function AddCc($str_Email, $str_ScreenName='')
	{
		if($str_ScreenName)
			$this->aCc[] = "$str_ScreenName <$str_Email>";
		else
			$this->aCc[] = "$str_Email";
	}

	function AddBcc($str_Email, $str_ScreenName='')
	{
		if($str_ScreenName)
			$this->aBcc[] = "$str_ScreenName <$str_Email>";
		else
			$this->aBcc[] = "$str_Email";
	}

	function AddHeader($str_Header, $str_Value='')
	{
		$this->aHeader[] = $str_Header . ': ' . $str_Value;
	}

	function SetSubject($str_Subject)
	{
		$this->sSubject = $str_Subject;
	}
	
	function SetBodyText($str_Text)
	{
		$this->sBodyText = $str_Text;
	}
	
	function SetBodyHTML($str_HTML)
	{
		$this->sBodyHTML = $str_HTML;
	}
	
	function AddAttachPOSTFile($array_POSTFile)
	{
		$this->aPOSTFileAttach[] = $array_POSTFile;
	}
	
	function AddAttachLocalFile($str_LocalFile, $str_MimeType='')
	{
		if(!$str_MimeType)
		{
			//Auto detect mime type from file extention
			preg_match("/\.[^.]+$/", $str_LocalFile, $aExt);
			$sExt = strtolower(str_replace('.', '', $aExt[0]));
			if($sExt)
			{
				if(isset($this->aMimeType[$sExt]))
					$str_MimeType = $this->aMimeType[$sExt];
				else
					$str_MimeType = $this->sDefaultMimeType;
			}
			else
				$str_MimeType = $this->sDefaultMimeType;
		}
	
		$aLocalFile = array();
		$aLocalFile['tmp_name'] = $str_LocalFile;
		$aLocalFile['name'] = preg_replace("/[^\/]*\//", '', $str_LocalFile);
		$aLocalFile['type'] = $str_MimeType;
		$aLocalFile['size'] = filesize($str_LocalFile);
		$this->aLocalFileAttach[] = $aLocalFile;
	}

	function SetCharset($str_Charset)
	{
		$this->sCharset = $str_Charset;
	}
	
	function SetEncodingBit($int_Encoding)
	{
		$this->nEncoding = $int_Encoding;
	}

	//Generate Header for EML format
	function ExportEML()
	{
		$aHeaderTemp = $this->aHeader;	
		$this->AddHeader('To', implode(', ', $this->aTo));
		$this->AddHeader('Subject', $this->sSubject);
		$this->AddHeader('Date', date('r'));
		$sEmailHeader = $this->_MakeHeader();
		$sEmailBody = $this->_MakeMessage();
		$sEMail = $sEmailHeader . "\r\n\r\n" . $sEmailBody;
		$this->aHeader = $aHeaderTemp;
		return $sEMail;
	}
	
	//Send E-mail
	function Send()
	{
		$sTo = implode(', ', $this->aTo);
		$bResponse = mail($sTo, $this->sSubject, $this->_MakeMessage(), $this->_MakeHeader());
		return $bResponse;
	}
	
	function _MakeHeader()
	{
		$aHeader = $this->aHeader;
		$aHeader[] = "X-Mailer: cPHPezMail,1.2";
		$aHeader[] = 'From: ' . $this->sFrom;
		if($this->aCc)
			$aHeader[] = 'Cc: ' . implode(', ', $this->aCc);
		if($this->aBcc)
			$aHeader[] = 'Bcc: ' . implode(', ', $this->aBcc);
		
		if($this->sBodyHTML || $this->aPOSTFileAttach || $this->aLocalFileAttach) //Check for multipart format
			$aHeader[] = "Content-Type: multipart/mixed;\r\n boundary=\"{$this->sMimeBoundary}\"";
		else
			$aHeader[] = "Content-Type: text/plain; charset={$this->sCharset}";

		return implode("\r\n", $aHeader);
	}

	
	function _MakeMessage()
	{
		$sMessage = '';
		if($this->sBodyHTML || $this->aPOSTFileAttach || $this->aLocalFileAttach) //Check for multipart format
		{
			//Start Multipart Format
			$sMessage .= "This is a multi-part message in MIME format.\r\n";
			
			if($this->sBodyText || $this->sBodyHTML)
			{
				//Open Alternative Part
				$sMessage .= "--{$this->sMimeBoundary}\r\n";
				$sMessage .= "Content-Type: multipart/alternative;\r\n boundary=\"{$this->sAltBoundary}\"\r\n\r\n";
			}
			
			if($this->sBodyText)
			{
				//Plain Text Message
				$sMessage .= "--{$this->sAltBoundary}\r\n";
				$sMessage .= "Content-Type: text/plain; charset={$this->sCharset}\r\nContent-Transfer-Encoding: {$this->nEncoding}bit\r\n\r\n";
				$sMessage .= rtrim($this->sBodyText);
				$sMessage .= "\r\n";
			}

			if($this->sBodyHTML)
			{
				//HTML Message
				$sMessage .= "--{$this->sAltBoundary}\r\n";
				$sMessage .= "Content-Type: text/html; charset={$this->sCharset}\r\nContent-Transfer-Encoding: {$this->nEncoding}bit\r\n\r\n";
				$sMessage .= rtrim($this->sBodyHTML);
				$sMessage .= "\r\n";
			}
			
			if($this->sBodyText || $this->sBodyHTML)
				//Close Alternative Part
				$sMessage .= "--{$this->sAltBoundary}--\r\n\r\n";

			if($this->aPOSTFileAttach)
			{
				//Attach POST Files
				foreach($this->aPOSTFileAttach as $aPOSTFile)
				{					
					if(!$aPOSTFile['size'])
						continue;
						
					if(!is_uploaded_file($aPOSTFile['tmp_name']))
						continue;
						
					if(copy($aPOSTFile['tmp_name'], $this->sTempFileName))
					{
						$fpAttachFile = fopen($this->sTempFileName, 'rb');
						if(!$fpAttachFile)
							continue;

						$sFileData = fread($fpAttachFile, $aPOSTFile['size']);
						fclose($fpAttachFile);
						//@unlink($this->sTempFileName);

						$sFileData = chunk_split(base64_encode($sFileData));
						$sMessage .= "--{$this->sMimeBoundary}\r\n";
						$sMessage .= "Content-Type: {$aPOSTFile['type']};\r\n name=\"{$aPOSTFile['name']}\"\r\n";
						$sMessage .= "Content-Transfer-Encoding: base64\r\n";
						$sMessage .= "Content-Disposition: attachment;\r\n filename=\"{$aPOSTFile['name']}\"\r\n\r\n";

						$sMessage .= $sFileData;
					}
				}
			}
			
			if($this->aLocalFileAttach)
			{
				//Attach Local Files
				foreach($this->aLocalFileAttach as $aLocalFile)
				{
					if(!$aLocalFile['size'])
						continue;
						
					$fpAttachFile = fopen($aLocalFile['tmp_name'], 'rb');
					if(!$fpAttachFile)
						continue;

					$sFileData = fread($fpAttachFile, $aLocalFile['size']);
					fclose($fpAttachFile);

					$sFileData = chunk_split(base64_encode($sFileData));
					$sMessage .= "--{$this->sMimeBoundary}\r\n";
					$sMessage .= "Content-Type: {$aLocalFile['type']};\r\n name=\"{$aLocalFile['name']}\"\r\n";
					$sMessage .= "Content-Transfer-Encoding: base64\r\n";
					$sMessage .= "Content-Disposition: attachment;\r\n filename=\"{$aLocalFile['name']}\"\r\n\r\n";

					$sMessage .= $sFileData;
				}
			}

			
			//Close Message
			$sMessage .= "--{$this->sMimeBoundary}--\r\n";
		}
		else
		{
			//Start Plain Text Format
			$sMessage .= $this->sBodyText;
		}
		return $sMessage;
	}
}
?>