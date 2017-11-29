<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">

    <title><?php echo $title; ?></title>
    <meta name="application-name" content="Business Advantage Admin">
    <meta name="Description" content=""/>
    <meta name="keywords" content=""/>
    <meta name="robots" content="noindex,nofollow"/>
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/images/icons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" href="/valorinrete/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/valorinrete/css/bootstrap-theme.min.css"/>
    <link rel="stylesheet" href="/valorinrete/css/bootstrap-datetimepicker.min.css"/>
    <link rel="stylesheet" href="/valorinrete/css/bootstrap-datepicker3.standalone.min.css" />
    <link rel="stylesheet" href="/valorinrete/css/bootstrap-datepicker.css"/>
    <link rel="stylesheet" href="/valorinrete/css/dataTables.bootstrap.min.css"/>
    <link rel="stylesheet" href="/valorinrete/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="/valorinrete/css/futura.css"/>
    <link rel="stylesheet" href="/valorinrete/css/back.css"/>
    <link rel="stylesheet" href="/valorinrete/css/fonts.css"/>
    <link rel="stylesheet" href="/valorinrete/css/style.css"/>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="/js/html5shiv.js"></script>
    <script src="/js/html5shiv-printshiv.js"></script>
    <script src="/js/respond.js"></script>
    <![endif]-->

    <script src="/valorinrete/js/jquery-2.2.4.min.js"></script>
    <script src="/valorinrete/js/bootstrap.min.js"></script>
    <script src="/valorinrete/js/moment-with-locales.min.js"></script>
    <script src="/valorinrete/js/bootstrap-datetimepicker.min.js"></script>
    <script src="/valorinrete/js/bootstrap-datepicker.js"></script>
    <!--<script src="/js/ckeditor/ckeditor.js"></script>-->
    <script src="//cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
    <script src="/valorinrete/js/jquery.dataTables.min.js"></script>
    <script src="/valorinrete/js/dataTables.bootstrap.min.js"></script>
    <script src="/valorinrete/js/chart/Chart.bundle.min.js"></script>

</head>
<body class="<?php echo @$page; ?>">
<div class="container-fluid h100p pad0">
    <nav class="navbar navbar-default">
        <div class="navbar-header">
            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="#" class="navbar-brand">Valorinrete</a>
        </div>
        <div id="navbarCollapse" class="collapse navbar-collapse">
            <?php $this->load->helper('url'); ?>
            <ul class="nav navbar-nav">
                <li><a href="<?php echo site_url('col/login'); ?>">Login COL</a></li>
                <li><a href="<?php echo site_url('istituto/login'); ?>">Login Istituto</a></li>
                <li><a href="<?php echo site_url('col/sign_up'); ?>">Registrazione COL</a></li>
                <li><a href="<?php echo site_url('istituto/sign_up'); ?>">Registrazione Istituto</a></li>
                <li><a href="<?php echo site_url('col/index'); ?>">Back-end COL</a></li>
                <li><a href="<?php echo site_url('istituto/index'); ?>">Back-end Istituto</a></li>
            </ul>
        </div>
    </nav>