<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="ru-ru" xml:lang="ru-ru">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Language" content="ru-ru" />
<meta http-equiv="imagetoolbar" content="no" />

<title>Центр администрирования</title>

<link href="/styles/admin.css" rel="stylesheet" type="text/css" media="screen" />


<script type="text/javascript" src="/js/jquery-1.4.2.min.js"></script>

<script>

var menu_state = 'shown';

function makeStripy(tabClass) 
{
   var tabs = document.getElementsByTagName("table");
   for (var e = 0; e < tabs.length; e++){ 
      if (tabs[e].className == tabClass) 
      {
         var rows = tabs[e].getElementsByTagName("tr");
         for (var i = 0; i < rows.length; i++) // строки нумеруются с 0
            rows[i].className += ((i % 2) == 0 ? " oddrows" : " evenrows");
      }
    }
}

function switch_menu()
{
	var menu = document.getElementById('menu');
	var main = document.getElementById('main');
	var toggle = document.getElementById('toggle');
	var handle = document.getElementById('toggle-handle');

	switch (menu_state)
	{
		// hide
		case 'shown':
			main.style.width = '93%';
			menu_state = 'hidden';
			menu.style.display = 'none';
			toggle.style.width = '20px';
			handle.style.backgroundImage = 'url(/images/admin/toggle.gif)';
			handle.style.backgroundRepeat = 'no-repeat';

			
				handle.style.backgroundPosition = '100% 50%';
				toggle.style.left = '0';
			
		break;

		// show
		case 'hidden':
			main.style.width = '76%';
			menu_state = 'shown';
			menu.style.display = 'block';
			toggle.style.width = '5%';
			handle.style.backgroundImage = 'url(/images/admin/toggle.gif)';
			handle.style.backgroundRepeat = 'no-repeat';

			
				handle.style.backgroundPosition = '0% 50%';
				toggle.style.left = '15%';
			
		break;
	}
}

var rusChars = new   Array('а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ч','ц','ш','щ','э','ю','\я','ы','ъ','ь', ' ', '\'', '\"', '\#', '\$', '\%', '\&', '\*', '\,', '\:', '\;', '\<', '\>', '\?', '\[', '\]', '\^', '\{', '\}', '\|', '\!', '\@', '\(', '\)', '\-', '\=', '\+', '\/', '\\','«','»');
var transChars = new Array('a','b','v','g','d','e','jo','zh','z','i','j','k','l','m','n','o','p','r','s','t','u','f','h','ch','c','sh','csh','e','ju','ja','y','', '', '-', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '','','');
var from = "";
 
function convert2EN(from_id,to_id)
  {
  from = document.getElementById(from_id).value;
  from = from.toLowerCase();
  var to = "";
  var len = from.length;
  var character, isRus;
  for(var i=0; i < len; i++)
    {
    character = from.charAt(i,1);
    isRus = false;
    for(var j=0; j < rusChars.length; j++)
      {
      if(character == rusChars[j])
        {
        isRus = true;
        break;
        }
      }
    to += (isRus) ? transChars[j] : character;
    }
   //document.form1.Message.value = to;
   document.getElementById(to_id).value = to;
  }

</script>

</head>
