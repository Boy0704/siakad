<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <base href="<?php echo base_url(); ?>">
  <title><?php echo $title ?></title>
  <link rel="shortcut icon" href="<?php echo base_url() ?>images/logo/logouit.png">
  <link href="<?php echo base_url() ?>template/vendors/css/style.css" rel="stylesheet" type="text/css"/>
  <link href="<?php echo base_url() ?>template/vendors/dist/sweetalert.css" rel="stylesheet" type="text/css"/>
  <!-- Theme style -->
  <link href="<?php echo base_url()?>template/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="<?php echo base_url() ?>template/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?php echo base_url() ?>template/vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">

  <!-- Select2 -->
  <link href="<?php echo base_url() ?>template/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
  <link href="<?php echo base_url() ?>template/vendors/nprogress/nprogress.css" rel="stylesheet">
  <link href="<?php echo base_url() ?>template/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet">
  <link href="<?php echo base_url() ?>template/build/css/custom.min.css" rel="stylesheet">
  <link href="<?php echo base_url() ?>template/vendors/starrr/dist/starrr.css" rel="stylesheet">
  <link href="<?php echo base_url() ?>template/vendors/css/bootstrap-toggle.css" rel="stylesheet">
    <style type="text/css">
    ::selection { background-color: #E13300; color: white; }
    ::-moz-selection { background-color: #E13300; color: white; }
    </style>
</head>
   <body class="nav-md footer_fixed">
    <div class="container body">
      <div id="content" class="main_container">
        <div class="col-md-3 left_col menu_fixed">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="<?php echo base_url('login') ?>" class="site_title"><img src="<?php echo base_url(); ?>images/logo/logouit.png"> <span>SIAKAD</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <?php require_once('template/menu/menu_foto_admin.php') ?>

            <br />
