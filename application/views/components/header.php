<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo "Complaints"; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<!--   <meta http-equiv="Cache-Control" content="no-cache">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0"> -->
  
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href='<?php echo base_url("assets/lib/bootstrap/dist/css/bootstrap.min.css"); ?>' >
  <!-- Font Awesome -->
  <link rel="stylesheet" href='<?php echo base_url("assets/lib/font-awesome/css/font-awesome.min.css");?>' >
  <!-- Ionicons -->
  <!-- <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css"> -->
  <!-- Theme style -->
  <link rel="stylesheet" href='<?php echo base_url("assets/dist/css/AdminLTE.min.css") ?>' >
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href='<?php echo base_url("assets/dist/css/skins/skin-green.min.css"); ?>' >

  <link rel="stylesheet" href='<?php echo base_url("assets/css/styles.css"); ?>' >

  <link rel="stylesheet" href='<?php echo base_url("assets/toastr/build/toastr.css"); ?>' >
  <!-- jQuery 3 -->
  <script src='<?php echo base_url("assets/lib/jquery/dist/jquery.min.js");?>' ></script>


    <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?php echo base_url('assets/lib/plugins/iCheck');?>/all.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/lib');?>/select2/dist/css/select2.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<style>
    .skin-green .sidebar a {
    color: #ffffff !important;
}
</style>
<body class="hold-transition skin-green sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <!-- <a href="../../index2.html" class="logo"> -->
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <!-- <span class="logo-mini"><b>A</b>LT</span> -->
      <!-- logo for regular state and mobile devices -->
      <!-- <span class="logo-lg"><b>Admin</b>LTE</span> -->
    <!-- </a> -->
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
         
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- <img src="../../dist/img/user2-160x160.jpg" class="user-image" alt="User Image"> -->
              <span class="hidden-xs"><?php echo @ucfirst($this->session->userdata('userTitle'));?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <!-- <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"> -->

                <p>
                  <?php echo @ucfirst($this->session->userdata('userTitle'));?>
                  <small>Member since <?php $date = date("d-M-Y",strtotime($this->session->userdata('createdDate')));?> <?php echo @$date;?></small>
                </p>
              </li>
            
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <!--<a href="<?php //echo base_url('Complaints/edit/')?><?php echo $this->session->userdata('userId'); ?>" class="btn btn-default btn-flat">Profile</a>-->
                </div>
                <div class="pull-right">
                  <a href="<?php echo base_url('Complaints/logout')?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
<!--           <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li> -->
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar" style="background-color:#005a31;">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel" style="padding:0!important;">
        <div class="image">
          <!-- <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"> -->
          <img src="<?php echo base_url("assets/images/site_images/logo.png"); ?>" class="img img-responsive " style="max-height:100px; max-width: 100px;margin: 0 auto; ">
        </div>
      </div>
     
      <!-- sidebar menu: : style can be found in sidebar.less -->
      
      <?php //echo $menu_list; ?>
      <ul class="sidebar-menu" data-widget="tree">
         <li class="header text-center" style="margin:0; padding:0;background-color:#083e25; "><span style="color:white; font-size:25px;">Complaints</span></li> 
        
        <li>
          <a href="<?php echo base_url('Complaints/complainants'); ?>">
            <i class="fa fa-users"></i> <span>Complainant</span>
          </a>
        </li>
        
        <li>
          <a href="<?php echo base_url('Complaints/dashboard'); ?>">
            <i class="fa fa-list"></i> <span>Summary</span>
            <!--<span class="pull-right-container">-->
            <!--  small class="label pull-right bg-green">Hot</small>-->
            <!--</span>-->
          </a>
        </li>
        
        <li>
          <a href="<?php echo base_url('Complaints/all_complaints'); ?>">
            <i class="fa fa-building"></i> <span>All Complaints</span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url('Complaints/received'); ?>">
            <i class="fa fa-download"></i> <span>Received</span>

          </a>
        </li>
      <li>
          <a href="<?php echo base_url('Complaints/first_letter'); ?>">
            <i class="fa fa-list-alt"></i> <span>First Letter Sent</span>

          </a>
        </li>
        <li>
          <a href="<?php echo base_url('Complaints/second_letter'); ?>">
            <i class="fa fa-list-alt"></i> <span>Second Letter Sent</span>

          </a>
        </li>
      <li>
          <a href="<?php echo base_url('Complaints/summon'); ?>">
            <i class="fa fa-list"></i> <span>Summon Complaints</span>

          </a>
        </li>
        <li>
          <a href="<?php echo base_url('Complaints/fine'); ?>">
            <i class="fa fa-file"></i> <span>Fine</span>

          </a>
        </li>
        <li>
          <a href="<?php echo base_url('Complaints/second_fine'); ?>">
            <i class="fa fa-file"></i> <span>Second Fined</span>

          </a>
        </li>
        <li>
          <a href="<?php echo base_url('Complaints/fine_collections'); ?>">
            <i class="fa fa-lock"></i> <span>Fine Collections <br /> <span style="margin-left:25px;">Under Land Requisitions</span></span>

          </a>
        </li>
        <li>
          <a href="<?php echo base_url('Complaints/registration_cancelled'); ?>">
            <i class="fa fa-ban"></i> <span>Registration Cencelled</span>

          </a>
        </li>
        <li>
          <a href="<?php echo base_url('Complaints/resolved'); ?>">
            <i class="fa fa-check"></i> <span>Resolved</span>

          </a>
        </li>
      </ul>
   </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->