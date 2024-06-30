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

  private function fetch($stmt)
  {
    if ($this->mode === 'object')
      $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    else
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
  }

  public function getAll()
  {
    $sql = 'SELECT * FROM ' . $this->table;
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute();

    return $this->fetch($stmt);
  }

  public function getByField($data)
  {
    $sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . $data['column'] . ' = :value';
    $stmt = $this->conexion->prepare($sql);
    $stmt->bindParam(':value', $data['value'], PDO::PARAM_STR);
    $stmt->execute();

    return $this->fetch($stmt);
  }

  public function getByData($campo, $datos)
  {
    $sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . $campo . ' in (' . $datos . ')';
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute();

    return $this->fetch($stmt);
  }

  public function getBy($datos, $and = true)
  {
    if (empty($datos)) {
      $datos = array('id' => '%');
    }

    $sql = "SELECT * FROM " . $this->table . " WHERE ";

    foreach ($datos as $key => $value) {
      if ($and == false) {
        $sql .= " $key LIKE :$key OR ";
      } else {
        $sql .= " $key LIKE :$key AND ";
      }

      $datos2[':' . $key] = $value;
    }
    if ($and == false) {
      $sql = substr($sql, 0, -3);
    } else {
      $sql = substr($sql, 0, -4);
    }

    $stmt = $this->conexion->prepare($sql);

    foreach ($datos2 as $key => $value) {
      $stmt->bindParam($key, $value);
    }

    $stmt->execute($datos2);

    // var_dump($stmt);

    return $stmt->fetchAll();
  }

  public function order($data)
  {
    $sql = 'SELECT * FROM ' . $this->table . ' ORDER BY ' . $data['column'] . ' ' . $data['order'];
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute();

    return $this->fetch($stmt);
  }

  public function update($id, $data)
  {
    $sql = 'UPDATE ' . $this->table . ' SET ';

    $i = 0;
    foreach ($data as $key => $value) {
      $sql .= $key . ' = :' . $key;
      $i++;
      if ($i < count($data)) {
        $sql .= ', ';
      }
    }

    $sql .= ' WHERE id = :id';

    $stmt = $this->conexion->prepare($sql);

    foreach ($data as $key => $value) {
      $stmt->bindValue(':' . $key, $value);
    }

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    return $stmt->execute();
  }

  public function delete($id, $in = true)
  {
    if ($in) {
      $sql = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
    } else {
      $sql = 'DELETE FROM ' . $this->table . ' WHERE id != :id';
    }

    $stmt = $this->conexion->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    return $stmt->execute();
  }

  public function deleteIn($column, $values, $in = true)
  {
    $buscar = '';
    // var_dump($column);
    // array to string
    if (!empty($values)) {
      if (is_array($values)) {
        foreach ($values as $key => $value) {
          $buscar .= $value . ', ';
        }
        if ($buscar != '') {
          $buscar = substr($buscar, 0, -2);
        }
      } else {
        $buscar = $values;
      }
    }


    if ($buscar == '') {
      $buscar = 0;
    }

    if ($in) {
      // eliminar registros cuyo valor en la columna sea igual a alguno de los valores del array
      $sql = 'DELETE FROM ' . $this->table . ' WHERE ' . $column . ' in (:buscar)';
    } else {
      // eliminar registros cuyo valor en la columna no sea igual a alguno de los valores del array
      $sql = 'DELETE FROM ' . $this->table . ' WHERE ' . $column . ' not in (' . $buscar . ')';
    }

    // var_dump($sql);
    $stmt = $this->conexion->prepare($sql);
    if ($in) {
      $stmt->bindParam(':buscar', $buscar, PDO::PARAM_STR);
    }

    return $stmt->execute();
  }

  public function create($data)
  {
    $sql = 'INSERT INTO ' . $this->table . ' (';

    $i = 0;
    foreach ($data as $key => $value) {
      $sql .= $key;
      $i++;
      if ($i < count($data)) {
        $sql .= ', ';
      }
    }

    $sql .= ') VALUES (';

    $i = 0;
    foreach ($data as $key => $value) {
      $sql .= ':' . $key;
      $i++;
      if ($i < count($data)) {
        $sql .= ', ';
      }
    }

    $sql .= ')';

    $stmt = $this->conexion->prepare($sql);

    foreach ($data as $key => $value) {
      $stmt->bindValue(':' . $key, $value);
    }
    $stmt->execute();
    return $this->conexion->lastInsertId();
  }

  public function deleteManyMany($column, $value)
  {
    $sql = 'DELETE FROM ' . $this->table . ' WHERE ' . $column . ' = :value';
    $stmt = $this->conexion->prepare($sql);
    $stmt->bindParam(':value', $value, PDO::PARAM_INT);

    return $stmt->execute();
  }
  public function createManyMany($searchColumn, $searchValue, $manyColumn, $manyValue)
  {
    $sql = 'INSERT INTO ' . $this->table . ' (' . $searchColumn . ', ' . $manyColumn . ') VALUES (:searchValue, :manyValue)';
    $stmt = $this->conexion->prepare($sql);
    $stmt->bindParam(':searchValue', $searchValue, PDO::PARAM_INT);
    $stmt->bindParam(':manyValue', $manyValue, PDO::PARAM_INT);

    return $stmt->execute();
  }

  public function updateManyMany($data)
  {
    $this->deleteManyMany($data['searchColumn'], $data['searchValue']);

    foreach ($data['manyValue'] as $value) {
      $this->createManyMany($data['searchColumn'], $data['searchValue'], $data['manyColumn'], $value);
    }
  }

  public function rawSql($tabla, $where = '', $order = '', $limit = '')
  {
    $sql = "SELECT * FROM $tabla " . $where . ' ' . $order . ' ' . $limit;
    // var_dump($sql);
    $stmt = $this->conexion->query($sql);
    return $stmt->fetchAll();
  }


}