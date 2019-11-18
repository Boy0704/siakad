<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $title ?></title>
    <link rel="shortcut icon" href="<?php echo base_url() ?>images/logo/logouit.png">
    <link href="<?php echo base_url() ?>template/vendors/css/style.css" rel="stylesheet" type="text/css" />
    <!-- <link href="<?php echo base_url() ?>template/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="<?php echo base_url() ?>template/vendors/dist/sweetalert.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="<?php echo base_url() ?>template/vendors/datatables/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>template/vendors/datatables/css/responsive.bootstrap.min.css">
    <link href="<?php echo base_url() ?>template/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>template/vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/select2/select2.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>template/vendors/nprogress/nprogress.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>template/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>template/build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="nav-md footer_fixed">
    <div id="content" class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col menu_fixed">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="<?php echo base_url('login') ?>" class="site_title"><img src="<?php echo base_url(); ?>images/logo/logouit.png"> <span>SIAKAD </span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <?php require_once('template/menu/menu_foto_admin.php') ?>
            <!-- /menu profile quick info -->

            <br />
