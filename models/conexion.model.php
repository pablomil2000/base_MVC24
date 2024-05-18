<?php
// todo: Review legacy code
class Conexion
{
  public function conectar()
  {
    $env = parse_ini_file('.env');

    $bdTypee = 'MySQL';

    switch ($bdTypee) {
      case 'MySQL':

        $servername = $env["BDservername"];
        $username = $env["BDusername"];
        $password = $env["BDpassword"];
        $dbname = $env["BDname"];

        $conexion = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conexion->exec("set names utf8");

        break;

      case 'SQLite':
        $servername = "libsql://kvl-bot-pablomil2000.turso.io";
        $id = "966872c0-6403-49d4-8876-4598d15de5a5";

        $conexion = new PDO("$servername", $id);

        break;

      default:
        die('No se ha seleccionado un tipo de base de datos');
    }

    return $conexion;
  }
}