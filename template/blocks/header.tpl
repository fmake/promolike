<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>{modul.title}</title>
	<meta name="description" content="{modul.description}" />
	<meta name="keywords" content="{modul.keywords}" />
	<link rel="stylesheet" type="text/css" href="/styles/main.css" />
	<meta http-equiv="X-UA-Compatible" content="IE=7" />
	<script type="text/javascript" src="/js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="/js/scripts.js"></script>
	
	<!--[if lte IE 6]>
		<script type="text/javascript" src="/js/ie6-fix.js"></script>
	<![endif]-->
	<!--[if IE]>
		<link rel="stylesheet" type="text/css" href="/styles/ie.css" />
	<![endif]-->
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
[[if xajax ]]
	[[phpcode` $context['xajax'] -> printJavascript("/libs/xajax/"); `]]
[[endif]]	
</head>