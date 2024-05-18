<?php

class CrudController
{
  private $table;
  private $mode = 'array' || 'object';

  public function __construct($table, $mode = 'array')
  {
    $this->table = $table;
    $this->mode = $mode;
  }

  public function getAll()
  {
    $crudModel = new CrudModel($this->table, $this->mode);
    return $crudModel->getAll();
  }

}