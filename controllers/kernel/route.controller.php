<?php
class RouteCtrl
{

  private $domain = 'http://localhost/';
  private $homdeDir = 'home';

  public function __construct($domain = '', $homdeDir = '')
  {
    $env = parse_ini_file('.env');

    if ($domain != '') {
      $this->domain = $domain;
    } elseif (isset($env['DOMAIN'])) {
      $this->domain = $env['DOMAIN'];
    }

    if ($homdeDir != '') {
      $this->homdeDir = $homdeDir;
    } elseif (isset($env['HOME_DIR'])) {
      $this->homdeDir = $env['HOME_DIR'];
    }

  }

  public function whitelist(...$routeValid)
  {

    if (isset($_GET['url'])) {
      $url = explode("/", $_GET["url"]);
    } else {
      $url[] = 'home';
    }

    if (in_array($url[0], $routeValid)) {
      $redirect = $url[0];
    } else {
      $redirect = 'errors/404';
    }
    // var_dump($url);

    require_once ('./views/modules/' . $redirect . '.php');
    return $url;

  }

  public function __get($name)
  {
    return $this->$name;
  }

}
