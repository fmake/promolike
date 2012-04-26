<?
class selectOption {
	var $value	=	null;
	var $caption	=	null;
	var $selected	=	false;
	var $disabled	=	false;

	function __construct($value, $caption, $selected, $disabled=false)
	{
		$this->value = $value;
		$this->caption = $caption;
		$this->selected = $selected;
		$this->disabled = $disabled;
	}
}

class formElement
{
	var $id	=	null;
	var $caption	=	null;
	var $name	=	null;
	var $type	=	null;
	var $size	=	null;
	var $value	=	null;
	var $cols	=	null;
	var $rows	=	null;
	var $text	=	null;
	var $checked	=	false;
	var $options = array();
	
	function __construct($id, $caption, $name, $type, $size, $value, $checked, $cols, $rows, $java = null,$text = null)
	{
			$this->id = $id;
			$this->caption = $caption;
			$this->name = $name;
			$this->type = $type;
			$this->size = $size;
			$this->value = $value;
			$this->checked = $checked;
			$this->cols = $cols;
			$this->rows = $rows;
			$this->java = $java;
			$this->text = $text;
	}
	
	function AddOption($option)
	{
		$this->options[] = $option;
	}
}

class utlFormEngine
{
	var $formName	=	null;
	var $formMethod	=	null;
	var $formAction	=	null;
	var $formLegend =   null;
	var $formEnctype	=	null;
	var $elements = array();
	var $template = null;
	var $tplDir = 'template/formstpl/';
	
	function __construct($name,	$action, $method = 'POST', $enctype ='', $template = 'admin_form.tpl',$formLegend = 'Изменение единицы')
	{
		$this->setTemplate(ROOT."/".$this->tplDir.$template);

		$this->formAction = $action;
		$this->formName = $name;
		$this->formMethod = $method;
		$this->formEnctype = $enctype;
		$this->formLegend = $formLegend;
		
		return $this;
	}
	
	function setTemplate($template)
	{	
		$this->template = $template;	
		
	}
	
	function AddElement($element)
	{
		$this->elements[] = $element;
	}

	function addHidden($name, $value)
	{
		$this->AddElement(new formElement("1", "", $name, "HIDDEN", "50", $value, false, "", ""));
		return $this;
	}

	function addVarchar($caption, $name, $value, $size = 50,$id = "1",$text = false)
	{
		$this->AddElement(new formElement($id , $caption, $name, "TEXT", $size, $value, false, "", "",null,$text));
		
		return $this;
	}

	function addPassword($caption, $name,$text = false)
	{
		$this->AddElement(new formElement("1", $caption, $name, "password", "50", "", false, "", "",$text ));
		return $this;
	}

	function addTextArea($caption, $name, $value, $cols, $rows,$text = false)
	{
		$this->AddElement(new formElement("1", $caption, $name, "TEXTAREA", "50", $value, false, $cols, $rows,$text));
		return $this;
	}

	function addSubmit($name, $value)
	{
		$this->AddElement(new formElement("1", "", $name, "SUBMIT", "50", $value, false, "", ""));	
		return $this;
	}

	function addFile($caption, $name,$text = false)
	{
		$this->AddElement(new formElement("addFile", $caption, $name, "file", "50", null, false, "", "",$text ));
		return $this;
	}

	function addFCKEditor($caption, $name, $value,$text = false)
	{
		$oFCKeditor = new FCKeditor($name) ;
		$oFCKeditor->Value = $value;

		$this->AddElement(new formElement("1", $caption, $name, "NEWTEXT", "50", $oFCKeditor->CreateHtml(), false, "", "",null,$text));
		return $this;		
	}
	
	function addFCKEditorConfigs($caption, $name, $value,$text = false)
	{
		$oFCKeditor = new FCKeditor($name) ;
		$oFCKeditor->Value = $value;

		$this->AddElement(new formElement("1", $caption, $name, "NEWTEXT_CONFIGS", "50", $oFCKeditor->CreateHtml(), false, "", "",null,$text));
		return $this;		
	}
	
	function addHtml($name, $value)
	{
		$this->AddElement(new formElement("1", $name, "", "HTML", "50", $value, false, "", ""));
		return $this;		
	}
	function addCheckBox($caption, $name, $value, $checked = false,$text = false)
	{
		$this->AddElement(new formElement("1", $caption, $name, "CHECKBOX", "50", $value, $checked, "", "",$text));
		return $this;
	}

	function addRadio($caption, $name,$text = false)
	{
		return new formElement("radio", $caption, $name, "RADIO", "", "", "", "", "",$text);
	}

	function addSelect($caption, $name, $java = null,$id = "1",$text = false)
	{
		return new formElement($id, $caption, $name, "SELECT", "", "", "", "", "", $java, $text);
	}

	function addDate($caption, $name, $value, $java = null)
	{
		$this->AddElement(new formElement("cal_date", $caption, $name, "DATE", "", $value, "", "", "", $java));
		return $this;
	}

	function printForm()
	{
		
		$patterns[0] = "/%name%/";
		$patterns[1] = "/%input%/";
		$re[0] = "n-n";
		$re[1] = "inn-";
		
		$utlTemplate = new utlTemplate();
		ob_start();
		$utlTemplate->display_file($this->template);
		$form = ob_get_clean();
		ob_end_clean();
		
		
		return $form;
	}
}
?>