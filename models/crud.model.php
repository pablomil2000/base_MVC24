<?php

class CrudModel
{

  private $conexion;
  private $table;

  private $mode = 'array' || 'object';

  public function __construct($table, $mode = 'array')
  {
    $conexion = new Conexion();
    $this->conexion = $conexion->conectar();
    $this->table = $table;

    $this->mode = $mode;
  }

  public function getAll()
  {
    $sql = 'SELECT * FROM ' . $this->table;
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute();

    if ($this->mode === 'object')
      $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    else
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
  }


}