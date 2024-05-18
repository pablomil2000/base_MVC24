<?php

class TemplateController
{
  public $layout_path = "./views/layouts/"; //* Default path
  public $layout_name = "template"; //* Default layout

  public function __construct($layout_path = '', $layout_name = '')
  {
    if ($layout_path != '') {
      $this->layout_path = $layout_path;
    }
    if ($layout_name != '') {
      $this->layout_name = $layout_name;
    }
  }

  public function load()
  {
    require_once ($this->layout_path . $this->layout_name . ".php");
  }
}