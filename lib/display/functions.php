<?php
namespace display {
  use display\html\Helpers;
  
  function image($src, array $attributes = array()) {
    return Helpers::image_tag($src, $attributes);
  }
  
  /**
   * Generates a link-tag with type image/x-icon
   *
   * @param string $name
   * @return string link-tag
   */
  function favicon($name = 'favicon') {
    return Helpers::favicon_link($name);
  }
  
  function tag_attributes(array $attributes, $leading_space = false) {
    return Helpers::tag_attributes($attributes, $leading_space);
  }
  
  /**
   * Renders a content tag
   *
   * @param string $name
   * @param string $content
   * @param array $attributes
   * @return string
   */
  function content_tag($name, $content, array $attributes = array()) {
    return Helpers::content_tag($name, $content, $attributes);
  }
  
  /**
   * Renders a simple tag
   *
   * @param string $name
   * @param array $attributes
   * @return string
   */
  function tag($name, array $attributes = array()) {
    return Helpers::tag($name, $attributes);
  }
  
  /**
   * Capture a closures return or output
   *
   * @param array $arguments
   * @param callable $scope
   * @return string
   */
  function capture($arguments, $block = null) {
    if(is_callable($arguments)) {
      $block = $arguments;
      $arguments = array();
    }
    
    ob_start();
    echo(call_user_func_array($block, (array)$arguments));
    return ob_get_clean();
  }

  /**
   * Captures a file within a namespace
   *
   * @access private
   * @param string $namespace
   * @param string $file
   * @param array $variables
   * @return string
   */
  function capture_file_within($namespace, $file, array $variables = array()) {
    return capture_code_within($namespace, " ?>".file_get_contents($file)."<?php ", $variables);
  }

  /**
   * Captures code within a namespace
   *
   * @param string $namespace
   * @param string $code
   * @param array $variables
   * @return string
   */
  function capture_code_within($namespace, $code, array $variables = array()) {
    ob_start();
    eval_within($namespace, $code, $variables);   
    return ob_get_clean();
  }
  
  /**
   * Eval code inside a specific namespace
   *
   * @access public
   * @param string $__namespace__
   * @param string $__code__
   * @param array $variables
   */
  function eval_within($__namespace__, $__code__, array $variables = array()) {
    if(!empty($variables)) extract($variables);
    unset($variables);
    if(!empty($__code__) and $__code__[strlen($__code__)-1] !== ';') $__code__ .= ';';
    eval("namespace $__namespace__; $__code__");
  }
}
?>