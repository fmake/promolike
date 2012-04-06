<script src="/js/admin/jquery.js" type="text/javascript"></script>
<script src="/js/admin/jqueryFileTree.js" type="text/javascript"></script>
<link href="/styles/jqueryFileTree.css" rel="stylesheet" type="text/css" media="screen" />
<? $xajax->printJavascript("/xajax/"); ?>

<style type="text/css">
.demo {
				width: 200px;
				height: 400px;
				border-top: solid 1px #BBB;
				border-left: solid 1px #BBB;
				border-bottom: solid 1px #FFF;
				border-right: solid 1px #FFF;
				background: #FFF;
				overflow: scroll;
				padding: 5px;
			}
			
			P.note {
				color: #999;
				clear: both;
			}

</style>
<script type="text/javascript">			
	$(document).ready( function() {

		
		$('#fileTreeDemo_4').fileTree({ root: '/includes/', script: '/admin/jqueryFileTree.php', folderEvent: 'dblclick', expandSpeed: 1, collapseSpeed: 1 }, function(file) { 
			xajax_getFile(file);
		});
		
	});
</script>


<div class="example">
	<h2>Выберите шаблон</h2>
	<div id="fileTreeDemo_4" class="demo"></div>
</div>