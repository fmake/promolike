<?php
class Twig_Project_SetNode extends Twig_Node
{
  protected $name;
  protected $value;
 
  public function __construct($name, $linenon,$tag)
  {
  	
    parent::__construct(array(), array('name' => $name), $lineno, $tag);
 
    $this->name = $name;
    $this->value = $value;
    
  }
 
  public function compile(Twig_Compiler $compiler)
  {
  	
    $compiler
      ->addDebugInfo($this)
      //->write('$context[\''.$this->name.'\'] = ')
      //->write($this->value)
      ->write($this->name)
      ->raw(";\n")
    ;
    
  }
}
?>