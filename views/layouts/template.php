<?php
require_once ('./views/layouts/modules/head.php');
?>

<body>
  <?php
  require_once ('./views/layouts/modules/header.php');
  ?>

  <?php

  // require_once ('./views/modules/home.php');
  
  $RouteCtrl = new RouteCtrl();
  $RouteCtrl->whitelist('home');

  ?>

  <?php
  require_once ('./views/layouts/modules/footer.php');
  ?>


</body>

</html>