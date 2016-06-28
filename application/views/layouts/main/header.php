<?php
    /**
     * @var $this CI_Loader
     */
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= isset($title) ? $title : 'Camilion' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= $this->registerAssets($assets) ?>
</head>


<body class="skin-green-light sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="<?= site_url() ?>" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><i class="ion ion-android-home"></i></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><span class="ion-leaf"></span> <b>Camilion</b> <span style="font-size: 8pt;">live green!</span></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Menu</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                    <!-- Full screen -->
                    <li class="dropdown fullscreen">
                        <a href="#" onclick="BigScreen.toggle()" class="dropdown-toggle" id="screen"
                           data-toggle="dropdown"
                           data-toggle="tooltip" title="Pantalla completa">
                            <i class="ion ion-monitor"></i>
                        </a>
                    </li>

                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img
                                    src=""
                                    class="user-image" alt="User Image"/>
                                <span class="hidden-xs"><?= 'xxx'?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img
                                        src=""
                                        class="img-circle" alt="User Image"/>
                                    <p>
                                        xxx</small>
                                    </p>
                                </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="" class="btn btn-default btn-flat">Perfil</a>
                                </div>
                                <div class="pull-right">
                                    <a href="" style="" id="logout"
                                       class="btn btn-default btn-flat">Cerrar sesi&oacute;n</a>
                                </div>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
        </nav>
        <script>
        </script>
    </header>