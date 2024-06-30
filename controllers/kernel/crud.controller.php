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

  public function getByField($data)
  {
    // var_dump($data);
    $crudModel = new CrudModel($this->table, $this->mode);
    return $crudModel->getByField($data);
  }

  public function getBy($data, $sep = 'and')
  {
    if ($sep == 'and') {
      $and = true;
    } else {
      $and = false;
    }

    $crudModel = new CrudModel($this->table, $this->mode);
    return $crudModel->getBy($data, $and);
  }

  public function getByData($campo, $datos)
  {
    $crudModel = new CrudModel($this->table, $this->mode);
    return $crudModel->getByData($campo, $datos);
  }

  public function order($data)
  {
    $crudModel = new CrudModel($this->table, $this->mode);
    return $crudModel->order($data);
  }

  public function update($id, $data)
  {
    $crudModel = new CrudModel($this->table, $this->mode);
    return $crudModel->update($id, $data);
  }


  public function delete($id)
  {
    $crudModel = new CrudModel($this->table, $this->mode);
    return $crudModel->delete($id);
  }

  public function create($data)
  {
    $crudModel = new CrudModel($this->table, $this->mode);
    return $crudModel->create($data);
  }

  public function updateManyManyArray($data)
  {
    $crudModel = new CrudModel($this->table, $this->mode);

    try {
      $crudModel->deleteManyMany($data['searchColumn'], $data['searchValue']);

      foreach ($data['manyValue'] as $key => $value) {
        $crudModel->create(
          [
            $data['searchColumn'] => $data['searchValue'],
            $data['manyColumn'] => $value
          ]
        );
      }

    } catch (\Throwable $th) {
      return false;
    }

  }

  public function rawSql($where = '', $order = '', $limit = '')
  {
    $crudModel = new CrudModel($this->table, $this->mode);
    return $crudModel->rawSql($this->table, $where, $order, $limit);
  }
}