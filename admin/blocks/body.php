<body>
<table cellpadding="0" cellspacing="0" border="0" class="main">
  <tr>
    <td align="center" style="height:100%"><div style="margin:0px 10px 5px 10px; width: 250px;">
        <table cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td><a href="/admin/"><img src="/images/admin/pic.gif" alt="" width="24" height="24" border="0"></a></td>
            <td><img src="/images/admin/spacer.gif" alt="" width="5" height="1" border="0"></td>
            <td><strong>Система администрирования<br>
              сайта:</strong></td>
          </tr>
        </table>
        <strong><a href="http://<?=$hostname?>" title="<?=$hostname?>" target="_blank">www.<?=$hostname?></a></strong></div>
      <div style="margin:10px 10px 5px 10px; width: 250px; height:100%;" id="menu">
	<? $out = ""; echo getTree(0, "admin_modul"); ?>
      </div>
      <div style="margin:10px 10px 0px 10px; width: 250px;">
        <table cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td><img src="/images/admin/pass.gif" alt="" width="24" height="24" border="0"></td>
            <td align="left"><strong><a href="/admin/?modul=set_pass" title="Смена пароля">Смена пароля</a></strong></td>
          </tr>
          <tr>
            <td><img src="/images/admin/logout.gif" alt="" width="24" height="24" border="0"></td>
            <td align="left"><strong><a href="/admin/?action=logout" title="Выход">Выход</a></strong></td>
          </tr>
        </table>
      </div></td>
    <td style="width:100%"><span class="caption"><?=$caption?></span>
      <div style="margin:10px 10px 10px 0px; padding-top: 50px;"><?=$content?>
      </div></td>
  </tr>
</table>
</body>
</html>