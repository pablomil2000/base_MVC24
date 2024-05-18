<?php

class userCtrl extends CrudController
{

  public function login($email, $password)
  {
    $data = [
      'column' => 'email',
      'value' => $email
    ];

    $user = $this->getBy($data);

    // var_dump($user);

    if ($user) {
      if ($password === $user['password']) {
        return true;
      }
    }
    return false;
  }
}