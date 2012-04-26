<FORM name='{$form->formName}' action='{$form->formAction}' method='{$form->formMethod}' enctype='{$form->formEnctype}'>
	<fieldset>
		<legend>{$form->formLegend}</legend>
		<?
		foreach ($form->elements as $id=>$elements){
			switch($elements->type){
				case "NEWTEXT":?>
					<dl>
						<dt class="mini" ><span><b><?=$elements->caption;?></b></span><br /><?=$elements->text?></dt>
						<dd class="full maxi" ><?=$elements->value?></dd>
					</dl>
					<?break;
				case "NEWTEXT_CONFIGS":?>
					<dl>
						<dt class="configs_dt" ><span><b><?=$elements->caption;?></b></span><br /><?=$elements->text?></dt>
						<dd class="full configs_dd" ><?=$elements->value?></dd>
					</dl>
					<?break;
				case "TEXTAREA":?>
					<dl>
						<dt><label for="<?=$elements->name?>" ><?=$elements->caption;?></label><dt>
						<dd>
						<TEXTAREA name='<?=$elements->name;?>' rows='<?=$elements->rows;?>' cols='<?=$elements->cols;?>' id='<?=$elements->name?>'><?=$elements->value;?></TEXTAREA>
						</dd>
					</dl>
					<?break;

				case "CHECKBOX":
					$caption = $elements->caption;
					$elements->caption = null;
					$input = "<";
					$input .= "INPUT type='".$elements->type."' ";
					$input .= "name='".$elements->name."' ";
					$input .= "value='".$elements->value."' ";
					$input .= (($elements->checked==true)? 'checked' : '')." class=\"permissions-checkbox\" >";?>
					<dl>
						<dt><label for="<?=$elements->name?>"><?=$caption;?></label><dt>
						<dd><div class="mini_input"  >
						<?=$input;?>
						</div></dd>
					</dl>
					<?	
					break;

				case "SELECT":
					$input = "<";
					$input .= "select ";
					$input .= "name='".$elements->name."'";
					if($elements->java)
					$input .= " ".$elements->java."";
					
					$input .= "id ='".($elements->id ?$elements->id : $elements->name )."'";
					$input .= " >";
	
					foreach ($elements->options as $options) {
						$input .= "<OPTION value='".$options->value."' ".(($options->selected==true)? 'selected':'')." ".(($options->disabled==true)? 'disabled':'').">";
						$input .= $options->caption."</OPTION>";
					}
					$input .= "</select>";?>
					<dl>
						<dt><label for="<?echo ($elements->id ?$elements->id : $elements->name );?>"><?=$elements->caption;?></label><dt>
						<dd><div class="mini_input"  ><?=$input;?></div></dd>
					</dl>
					<?
					break;

				case "RADIO":
					$input = "";
					foreach ($elements->options as $options) {
						$input .= "\t<label><INPUT TYPE=radio name='".$elements->name."' value='".$options->value."' ".(($options->selected==true)? 'CHECKED':'').">";
						$input .= $options->caption."</label><br>\n";
					}?>
					<dl>
						<dt><?=$elements->caption;?><dt>
						<dd>
						<?=$input;?>
						</dd>
					</dl>
					<?
					break;
				case "HTML":
					$input = "";
					$caption = $elements->name;
					$input .= $elements->value."<br>\n";?>
					<dl>
						{$elements->value}
					</dl>
					<?
					break;
				case "HIDDEN":
					$input = "<";
					$input .= "INPUT type='".$elements->type."' ";
					$input .= "name='".$elements->name."' ";
					$input .= "size='".$elements->size."' ";
					$input .= "value='".$elements->value."' ";
					$input .= "id='".$elements->name."' ";
					$input .= (($elements->checked==true)? 'checked' : '').">";	?>
						<?=$input;?>
		
					<?
					break;
				case 'SUBMIT':
					$input = "<";
					$input .= "INPUT type='".$elements->type."' ";
					$input .= "name='".$elements->name."' ";
					$input .= "size='".$elements->size."' ";
					$input .= "value='".$elements->value."' ";
					$input .= "id='".$elements->name."' class=\"button2\" ";
					$input .= (($elements->checked==true)? 'checked' : '').">";	?>
					<p class="submit-buttons">
						<?=$input;?>
						<input class="button2" id="reset" name="reset" value="Вернуть" type="reset">
					</p>
					<?
				break;
				default:
					$input = "<";
					$input .= "INPUT type='".$elements->type."' ";
					$input .= "name='".$elements->name."' ";
					$input .= "size='".$elements->size."' ";
					$input .= "value='".$elements->value."' ";
					$input .= "id='".$elements->name."' ";
					$input .= (($elements->checked==true)? 'checked' : '').">";	?>
					<dl>
						<dt><label for="<?=$elements->name?>"><?=$elements->caption;?></label><br />
							<?=$elements->text?>
						<dt>
						<dd>
						<?=$input;?>
						</dd>
					</dl>
					<?
					
			}
		}
		?>
		
		
	</fieldset>
</FORM>
