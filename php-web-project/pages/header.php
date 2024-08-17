<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Team Null.">
  <meta name="keywords" content="dashboard, index, main">

  <title>Team Null.</title>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,300" rel="stylesheet">
  <!-- Styles -->
  <link href="styles/core.min.css" rel="stylesheet">
  <link href="styles/basics.css" rel="stylesheet">
  <link href="styles/navbar.css" rel="stylesheet">
  <link href="styles/style.css" rel="stylesheet">
  <link href="styles/parallax.css" rel="stylesheet">
</head>
<body data-provide="pace">
  <!-- Preloader -->
  <div class="preloader">
    <div class="spinner-dots">
      <span class="dot1"></span>
      <span class="dot2"></span>
      <span class="dot3"></span>
    </div>
  </div>
  <section class="panel headersec" data-section-name="header">
    <header class="topbar topbar-expand-lg bb-1 border-secondary">
      <div class="topbar-left">
        <span class="topbar-btn topbar-menu-toggler"><i>&#9776;</i></span>
        <span class="topbar-brand"><img src="assets/img/logo.png" alt="logo-icon" style="height:45px;"></span>

        <div class="topbar-divider d-none d-xl-block"></div>

        <nav class="topbar-navigation">
          <ul class="menu">
            <li class="menu-item active">
              <a class="menu-link no-underline" href="index.php">
                <span class="pe-7s-home pe-lg pe-va"></span>
                <span class="title">Αρχική</span>
              </a>
            </li>
<!--
            <li class="menu-item">
              <a class="menu-link no-underline" href="#">
                <span class="pe-7s-albums pe-lg pe-va"></span>
                <span class="title">Κατηγορίες</span>
              </a>
            </li>
          -->

            <li class="menu-item">
              <a class="menu-link no-underline" href="index.php?page=how_it_works">
                <span class="pe-7s-help1 pe-lg pe-va"></span>
                <span class="title">Πως λειτουργεί;</span>
              </a>
            </li>
          </ul>
        </nav>
      </div>

      <div class="topbar-right">


<?php require_once 'core/init.php';
           $user = new User();

           if($user->isLoggedIn()) {
           ?>
        <a class="topbar-btn no-underline" href="#qv-global" data-toggle="quickview"><i class="pe-7s-more pe-lg"></i></a>
        <div class="topbar-divider d-none d-xl-block"></div>
        <ul class="topbar-btns">
          <li class="dropdown">
            <span class="topbar-btn" data-toggle="dropdown"><span class="title" style="padding-right: 15px;">Καλώς όρισες, <?php echo escape($user->data()->username); ?> </span> <img class="avatar" src="assets/img/avatar/1.jpg" alt="..."></span>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item no-underline" href="index.php?page=profile"><i class="pe-7s-user pe-lg"></i> Προφίλ</a>
              <?php if ($user->data()->group==0) { ?>
              <a class="dropdown-item no-underline cursor-pointer"  href="index.php?page=admin"><i class="pe-7s-tools pe-lg"></i> Διαχειριστής</a>
              <?php } ?>
              <?php if ($user->data()->group==1) { ?>
              <a class="dropdown-item no-underline cursor-pointer" data-provide="modaler" data-url="wallet.php" data-is-modal="true"><i class="pe-7s-wallet pe-lg"></i> Πορτοφόλι</a>
              <?php } ?>
              <?php if ($user->data()->group==2) { ?>
              <a class="dropdown-item no-underline"  href="index.php?page=newevent" ><i class="pe-7s-plus pe-lg"></i> Δημιουργία νέας εκδήλωσης</a>
              <?php } ?>
              <div class="dropdown-divider no-underline"></div>
              <a class="dropdown-item no-underline" href="logout.php"><i class="pe-7s-power pe-lg"></i> Έξοδος</a>
            </div>
          </li>
          <!-- END Notifications -->
        </ul>
        <?php
          } else {
       ?>
          <div><button class="btn btn-outline btn-primary" data-provide="modaler" data-url="register.php" data-is-modal="true">Εγγραφή</button></div>
          <div class="text-secondary" style="margin:10px;"> ή </div>
          <div><button class="btn btn-outline btn-primary" data-provide="modaler" data-url="login.php" data-is-modal="true">Είσοδος</button></div>


         <?php } ?>



      </div>
    </header>
  </section>
  <!-- END Topbar -->
