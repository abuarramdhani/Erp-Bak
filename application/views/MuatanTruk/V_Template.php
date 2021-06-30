<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="author" content="" />
    <meta name="description" content="" />
    <meta name="theme-color" content="#3c8dbc">
    <title>Simulasi Muatan Truk | {Header}</title>

    <link type="image/x-icon" rel="shortcut icon" href="{BaseUrl}assets/img/logo.ico">
    <link type="text/css" rel="stylesheet" href="{BaseUrl}assets/plugins/bootstrap/3.3.7/css/bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="{BaseUrl}assets/plugins/select2/select2.min.css" />
    <link type="text/css" rel="stylesheet" href="{BaseUrl}assets/plugins/Font-Awesome/3.2.0/css/font-awesome.css" />
    <link type="text/css" rel="stylesheet" href="{BaseUrl}assets/plugins/Font-Awesome/4.3.0/css/font-awesome.min.css" />
    <link type="text/css" rel="stylesheet" href="{BaseUrl}assets/plugins/Font-Awesome/4.3.0/css/font-awesome-animation.css" />
    <link type="text/css" rel="stylesheet" href="{BaseUrl}assets/theme/css/AdminLTE.min.css" />
    <link type="text/css" rel="stylesheet" href="{BaseUrl}assets/theme/css/skins/_all-skins.min.css" />
    <link type="text/css" rel="stylesheet" href="{BaseUrl}assets/plugins/datepicker/css/datepicker.css" />
    <link type="text/css" rel="stylesheet" href="{BaseUrl}assets/plugins/datatables-latest/datatables.min.css" />

    <!-- Custom Style -->
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>

<body class="skin-blue-light" style="padding-right: 0px !important;">

    <div class="wrapper">
        <header class="main-header">
            <!-- Logo -->
            <a href="http://quick.com" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>Quick</b></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>Quick</b></span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="user user-menu">
                            <a href="#">
                                <img src="{BaseUrl}assets/theme/img/user.png" class="user-image" alt="User Image">
                                <span class="hidden-xs">GUEST</span>
                            </a>
                        </li>
                        <li class="hidden-xs hidden-sm">
                            <a href="{BaseUrl}{Link}">
                                <i class="fa fa-truck"></i> {Title}
                            </a>
                        </li>
                        <li class="hidden-xs hidden-sm">
                            <a href="{BaseUrl}{Link}">
                                <i class="fa fa-sign-out"></i> Back
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
    </div>

    {Content}

    <footer class="main-footer" style="margin:0;">
        <div class="pull-right hidden-xs">
            Page rendered in <strong>{elapsed_time}</strong> seconds.
            {Copyright}
        </div>
        <b>Version</b> 1.0.0
    </footer>

    <script>
        const baseurl = '{BaseUrl}';
    </script>
    <script src="{BaseUrl}assets/plugins/jquery-2.1.4.min.js" type="text/javascript"></script>
    <script src="{BaseUrl}assets/plugins/jQueryUI/jquery-ui.min.js" type="text/javascript"></script>
    <script src="{BaseUrl}assets/plugins/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="{BaseUrl}assets/plugins/datatables-latest/datatables.min.js"></script>
    <script src="{BaseUrl}assets/plugins/datepicker/js/bootstrap-datepicker.js"></script>
    <script src="{BaseUrl}assets/plugins/sweetalert2.all.min.js"></script>
    <script src="{BaseUrl}assets/plugins/sweetalert2.all.js"></script>
    <script src="{BaseUrl}assets/plugins/sweetAlert/sweetalert.js"></script>
    <script src="{BaseUrl}assets/plugins/select2/select2.full.min.js"></script>
    <script src="{BaseUrl}assets/js/customSMTR.js?v={JSVersion}"></script>
</body>

</html>