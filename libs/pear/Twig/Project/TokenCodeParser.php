<?php
class Twig_Project_TokenCodeParser extends Twig_TokenParser
{
  public function parse(Twig_Token $token)
  {
  	
  	$lineno = $token->getLine();
  	//printAr($this->parser);
    $name = $this->parser->getStream()->expect(Twig_Token::STRING_TYPE)->getValue();
    //$this->parser->getStream()->expect(Twig_Token::NAME_TYPE, 'endcode');
    $value = false;
   
    
    $this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);
    
    return new Twig_Project_SetNode($name, $lineno, $this->getTag());
  	
  }
 
  public function getTag()
  {
    return 'phpcode';
  }
}
?>