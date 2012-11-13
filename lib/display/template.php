<?php
namespace display;

class TemplateMissingError extends \ErrorException {};

class Template {
  private $file;
  private $assignments = array();
  private $namespace;
  
  function __construct($file, $namespace = __NAMESPACE__) {
    $this->file = $file;
    $this->namespace = $namespace;
  }
  
  function __toString() {
    return $this->file;
  }
  
  function file() {
    return $this->file;
  }
  
  function exists() {
    return file_exists($this->file);
  }
  
  function assign($name, $value) {
    $this->assignments[$name] = $value;
  }
  
  function obtain($name) {
    return $this->assignments[$name];
  }
  
  function render(array $assignments = array()) {
    if(!$this->exists()) {
      throw new TemplateMissingError("Template file $this does not exist!");
    }
    
    $assignments = array_merge($this->assignments, $assignments);
    if($this->exists()) {
      include_once __DIR__."/functions.php";
      
      $output = capture_file_within($this->namespace, $this->file, $assignments);
      return $output;
    }
  }
}
?>