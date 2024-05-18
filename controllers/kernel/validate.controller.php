<?php

class ValidateCtrl
{

  public function vltString($string)
  {
    return preg_match('/^[a-zA-Z0-9\s]+$/', $string);
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
    return preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $date);
  }

  public function vltNumber($number)
  {
    return preg_match('/^[0-9]+$/', $number);
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