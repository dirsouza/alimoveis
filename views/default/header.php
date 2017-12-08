<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" type="image/png" href="../../src/img/favicon.png">
        <title>ALImóveis</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="../../lib/plugins/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="../../lib/plugins/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="../../lib/plugins/Ionicons/css/ionicons.min.css">
        <!-- Date Picker -->
        <link rel="stylesheet" href="../../lib/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="../../lib/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="../../lib/plugins/datatables/css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" href="../../lib/plugins/datatables/extension/responsive/css/responsive.bootstrap.min.css">
        <!-- Select2 -->
        <link rel="stylesheet" href="../../lib/plugins/select2/css/select2.min.css">
        <!-- Toastr -->
        <link rel="stylesheet" href="../../lib/plugins/toastr/css/toastr.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="../../lib/template/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="../../lib/template/css/skins/skin-blue.css">
        <!-- Personal CSS -->
        <link rel="stylesheet" href="../../lib/personal/css/personal.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>

    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <a href="/" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini">
                        <img src="../../src/img/ALI.png" alt="ALI">
                    </span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg">
                        <img src="../../src/img/ALImoveis.png" alt="ALImoveis">
                    </span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="hidden-xs user-login">
                                <i class="glyphicon glyphicon-user" data-toggle="tooltip" data-placement="left" title data-original-title="Usuário"><span> <?php $user = explode(" ", $desName); echo $user[0]; ?></span></i>
                            </li>
                            <li>
                                <a href="/logout">
                                    <i class="glyphicon glyphicon-log-out"><span class="hidden-xs"> Sair</span></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
