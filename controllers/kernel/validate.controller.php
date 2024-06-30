<?php

class ValidateCtrl
{

  public function vltString($string)
  {

    // validate strings allowed characters a-z, A-Z, 0-9, space, underscore, dash, dot, comma, :'

    if (preg_match('/^[a-zA-Z0-9\s_.,:\'-]+$/', $string)) {
      return $string;
    }

    return false;
  }

  public function vltEmail($email)
  {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
  }

  public function vltPassword($password)
  {
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,15}$/', $password);
  }

  public function vltDate($date)
  {
    if (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $date)) {
      return $date;
    }
    return false;
  }

  public function vltNumber($number)
  {
    if ($number != '') {
      if (preg_match('/^[0-9]+$/', $number)) {
        return $number;
      }
    }
    return 0;
  }

  public function vltPhone($phone)
  {
    return preg_match('/^[0-9]{10}$/', $phone);
  }

  public function vltUrl($url)
  {
    return filter_var($url, FILTER_VALIDATE_URL);
  }

}