<?php

class FunctionCtrl
{

  public function hasLogin($name = 'user')
  {
    if (isset($_SESSION[$name])) {
      return true;
    } else {
      return false;
    }
  }

  public function isLogin($name = 'user')
  {
    if (isset($_SESSION[$name])) {
      return true;
    } else {
      header('Location: ' . $GLOBALS['RouteCtrl']->domain . 'home');
    }
  }

  public function isGuest($name = 'user')
  {
    if (!isset($_SESSION[$name])) {
      return true;
    } else {
      header('Location: ' . $GLOBALS['RouteCtrl']->domain . 'login');
    }
  }


  public function old($name)
  {
    if (isset($_POST[$name])) {
      return $_POST[$name];
    } else {
      return '';
    }
  }

}