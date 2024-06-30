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

  public function isLogin($name = 'user', $redirect = 'login')
  {
    if (isset($_SESSION[$name])) {
      return true;
    } else {
      header('Location: ' . $GLOBALS['RouteCtrl']->domain . $redirect);
    }
  }

  public function isGuest($name = 'user')
  {
    if (!isset($_SESSION[$name])) {
      return true;
    } else {
      header('Location: ' . $GLOBALS['RouteCtrl']->domain . 'home');
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

  function rdr($url)
  {
    header('Location: ' . $GLOBALS['RouteCtrl']->domain . $url);
  }

  public function helperImage($img, $dir = '')
  {

    // Distingir si la imagene esta en disco o es un enlace que empieza por http

    // var_dump(strpos($img, 'http'));

    if (strpos($img, 'http') === false) {
      return $GLOBALS['RouteCtrl']->domain . $dir;
    } else {
      return $img;
    }

  }


  function handleFileUpload($file, $uploadDir, $oldImg = '')
  {
    // Verificar si se ha subido un archivo sin errores
    if (isset($file) && $file['error'] == UPLOAD_ERR_OK) {
      // Obtener información del archivo subido
      $fileTmpPath = $file['tmp_name'];
      $fileName = $file['name'];
      $fileSize = $file['size'];
      $fileType = $file['type'];
      $fileNameCmps = explode(".", $fileName);
      $fileExtension = strtolower(end($fileNameCmps));

      // Limpiar el nombre del archivo para evitar problemas
      $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

      // Asegurarse de que la carpeta de destino existe
      if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
      }

      // Ruta completa del archivo de destino
      $destPath = $uploadDir . $newFileName;

      // Mover el archivo del directorio temporal a la ubicación deseada
      if (move_uploaded_file($fileTmpPath, $destPath)) {

        // var_dump($oldImg);
        // delete old img
        if ($oldImg != '' && file_exists($uploadDir . $oldImg)) {
          unlink($uploadDir . $oldImg);
        }

        return $newFileName;
      } else {
        return "Hubo un error moviendo el archivo al directorio de destino.";
      }
    } else {
      return "No se ha subido ningún archivo o hubo un error en la subida.";
    }
  }

  function dateFormat($date, $format = 'd/m/Y')
  {
    return date($format, strtotime($date));
  }

  function timeFormat($time, $format = 'H:i')
  {
    return date($format, strtotime($time));
  }

  function dateTimeFormat($datetime, $format = 'd/m/Y H:i')
  {
    return date($format, strtotime($datetime));
  }

  function getAge($date)
  {
    $birthDate = new DateTime($date);
    $today = new DateTime('today');
    $age = $birthDate->diff($today)->y;
    return $age;
  }

  function getDay($date)
  {
    return date('d', strtotime($date));
  }

  function getMonth($date)
  {
    return date('m', strtotime($date));
  }

  function getYear($date)
  {
    return date('Y', strtotime($date));
  }

  function getHour($time)
  {
    return date('H', strtotime($time));
  }

  function getTimeAgo($time)
  {
    $time_ago = strtotime($time);
    $current_time = time();
    $time_difference = $current_time - $time_ago;
    $seconds = $time_difference;
    $minutes = round($seconds / 60);           // value 60 is seconds
    $hours = round($seconds / 3600);           // value 3600 is 60 minutes * 60 sec
    $days = round($seconds / 86400);          // value 86400 is 24 hours * 60 minutes * 60 sec
    $weeks = round($seconds / 604800);          // value 604800 is 7 days * 24 hours * 60 minutes * 60 sec
    $months = round($seconds / 2629440);         // value 2629440 is (365+365+365+365+366)/5/12 * 24 hours * 60 minutes * 60 sec
    $years = round($seconds / 31553280);         // value 31553280 is 365+365+365+365+366 * 24 hours * 60 minutes * 60 sec

    if ($seconds <= 60) {
      $ago = "Just Now";
    } else if ($minutes <= 60) {
      if ($minutes == 1) {
        $ago = "one minute ago";
      } else {
        $ago = "$minutes minutes ago";
      }
    } else if ($hours <= 24) {
      if ($hours == 1) {
        $ago = "an hour ago";
      } else {
        $ago = "$hours hours ago";
      }
    } else if ($days <= 7) {
      if ($days == 1) {
        $ago = "yesterday";
      } else {
        $ago = "$days days ago";
      }
    } else if ($weeks <= 4.3) {  // 4.3 == 30/7
      if ($weeks == 1) {
        $ago = "a week ago";
      } else {
        $ago = "$weeks weeks ago";
      }
    } else if ($months <= 12) {
      if ($months == 1) {
        $ago = "a month ago";
      } else {
        $ago = "$months months ago";
      }
    } else {
      if ($years == 1) {
        $ago = "one year ago";
      } else {
        $ago = "$years years ago";
      }
    }


    return $ago;
  }


  function getDayName(
    $date,
    $wekName = [
      'mon' => 'Lunes',
      'tue' => 'Martes',
      'wed' => 'Miércoles',
      'thu' => 'Jueves',
      'fri' => 'Viernes',
      'sat' => 'Sábado',
      'sun' => 'Domingo',
      'Error' => 'No es un dia de la semana'
    ]
  ) {
    $day = date('D', strtotime($date));
    switch ($day) {
      case 'Mon':
        $text = $wekName['mon'];
        break;
      case 'Tue':
        $text = $wekName['tue'];
        break;
      case 'Wed':
        $text = $wekName['wed'];
        break;
      case 'Thu':
        $text = $wekName['thu'];
        break;
      case 'Fri':
        $text = $wekName['fri'];
        break;
      case 'Sat':
        $text = $wekName['sat'];
        break;
      case 'Sun':
        $text = $wekName['sun'];
        break;
      default:
        $text = $wekName['Error'];
        break;
    }

    return $text;
  }

  public function encript($string, $method = 'sha256')
  {
    switch ($method) {
      case 'sha256':
        $str = hash('sha256', $string);
        break;
      case 'md5':
        $str = hash('md5', $string);
        break;
      case 'sha1':
        $str = hash('sha1', $string);
        break;
      case 'sha512':
        $str = hash('sha512', $string);
        break;


      default:
        $str = hash('sha256', $string);
        break;

    }
    return $str;
  }
}

