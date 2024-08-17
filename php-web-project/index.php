<?php
  require_once "pages/header.php";
  $page = "home";
  if (isset($_GET['page'])) {
    $page = escape($_GET['page']);
  }
  require_once "pages/" . $page . ".php";
  require_once "pages/footer.php";
?>
