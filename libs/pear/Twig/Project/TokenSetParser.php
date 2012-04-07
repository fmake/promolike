<?php
class Twig_Project_TokenSetParser extends Twig_TokenParser
{
  public function parse(Twig_Token $token)
  {
  	$lineno = $token->getLine();
    $name = $this->parser->getStream()->expect(Twig_Token::STRING_TYPE)->getValue();
    $this->parser->getStream()->expect(Twig_Token::NAME_TYPE, 'endcode');
    $value = new Twig_Node_Expression_Name("","");
    $this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);
    return new Twig_Project_SetNode($name, $value, $lineno, $this->getTag());
  	
  }
 
  public function getTag()
  {
    return 'phpcode';
  }
}
?>