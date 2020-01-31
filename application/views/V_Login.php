<!DOCTYPE html>
<html lang="en">
<head>
    <!--
        ===
        This comment should NOT be removed.

        Charisma v2.0.0

        Copyright 2012-2014 Muhammad Usman
        Licensed under the Apache License v2.0
        http://www.apache.org/licenses/LICENSE-2.0

        http://usman.it
        http://twitter.com/halalit_usman
        ===
    -->
    <meta charset="utf-8">
    <title>Login - Quick ERP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Charisma, a fully featured, responsive, HTML5, Bootstrap admin template.">
    <meta name="author" content="Muhammad Usman">
	<link rel="shortcut icon" href="<?php echo base_url('assets/plugins/cm/img/logo.ico');?>">
    <!-- The styles -->
    <link id="bs-css" href="<?php echo base_url('assets/plugins/cm/css/bootstrap-cerulean.min.css');?>" rel="stylesheet">

    <link href="<?php echo base_url('assets/plugins/cm/css/charisma-app.css');?>" rel="stylesheet">
    
    <!-- GLOBAL SCRIPTS -->
    <script src="<?php echo base_url('assets/plugins/jquery-2.0.3.min.js');?>"></script>
    <script src="<?php echo base_url('assets/plugins/bootstrap/3.0.0/js/bootstrap.min.js');?>"></script>
    <!--<script src="<?php echo base_url('assets/plugins/modernizr-2.6.2-respond-1.1.0.min.js');?>"></script>
	
	<script src="<?php echo base_url('assets/js/formsInit.js');?>"></script>
	<script src="<?php echo base_url('assets/js/HtmlFunction.js');?>"></script>
	
    <!-- END GLOBAL SCRIPTS -->
    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- The fav icon -->
    
	<script type="text/javascript">
    	$(document).ready(function(){
    	 $('#pengguna').focus(); 
    	});
	</script>
    <style type="text/css">
        .unsupportedBrowserPlaceholder {
            display: none;
        }
    </style>
    <noscript>
        .main {
            display: none;
        }
        .unsupportedBrowserPlaceholder {
            display: block;
        }
    </noscript>
</head>

<body id="body">
<div class="ch-container">
    <div class="main">
        <div class="row">
            <div class="col-md-12 center login-header"></div>
        </div>
        <div class="row">
            <div class="well col-md-5 center login-box">
                <div class="row left" style="padding:1%;margin-left:-5%;">
                    <div class="col-md-12">
                        <div style="float:left;">
                            <img src="<?php echo base_url('assets/plugins/cm/img/logo4.png');?>" style="max-width:100%;" />
                        </div>
                    </div>
                </div>
                <?php
                if($this->session->gagal){
                ?>
                <div class="alert alert-danger text-left">
                   <?php echo $error;?>
                </div>
                <?php
                }else{
                ?>
                <div class="alert alert-info text-left">
                   Please enter your username and password to login
                </div>
                <?php
                }
                ?>
                <form class="form-horizontal" action="<?php echo site_url('login');?>" method="post">
                    <fieldset>
                        <div class="input-group input-group-lg">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user red"></i></span>
                            <input type="text" name="username" id="username" class="form-control toupper" placeholder="Username" autofocus>
                        </div>
                        <div class="clearfix"></div><br>

                        <div class="input-group input-group-lg">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock red"></i></span>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                        </div>
                        <div class="clearfix"></div>

                        
                        <p class="center col-md-5">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </p>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <div class="unsupportedBrowserPlaceholder" style="text-align: center;">
        <h3>Aplikasi Browser Anda tidak memenuhi Spesifikasi Standar Minimum Akses QuickERP.</h3>
        <h3>Silahkan gunakan Aplikasi Browser berikut : </h3> 
        <h3>- Google Chrome Versi 49 ke Atas</h3>
        <h3>- Chromium Versi 50 ke Atas</h3>
        <h3>- Mozilla Firefox Versi 45 ke Atas</h3>
        <br>
        <h3>atau </h3>
        <h3>Silahkan menghubungi Bag. Hardware ICT untuk dilakukan installasi / update Browser di VoIP 12300 Ext. 5 atau Telkomsel MyGroup 628112545922</h3>
        <br>
        <h3>--- QuickERP ---</h3></body>
</div>

</div>
<script>
    var browser = '';
    var browserVersion = 0;
    if (/Opera[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
        browser = 'Opera';
    } else if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)) {
        browser = 'MSIE';
    } else if (/Navigator[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
        browser = 'Netscape';
    } else if (/Chrome[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
        browser = 'Chrome';
    } else if (/Safari[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
        browser = 'Safari';
        /Version[\/\s](\d+\.\d+)/.test(navigator.userAgent);
        browserVersion = new Number(RegExp.$1);
    } else if (/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
        browser = 'Mozila Firefox';
    } else if (/Chromium[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
        browser = 'chromium';
    }
    if(browserVersion === 0) browserVersion = parseFloat(new Number(RegExp.$1));
    var error = '<div style="text-align: center;"><h3>Aplikasi Browser ('+ get_browser_info().name +' Versi '+ get_browser_info().version +') Anda <b>tidak memenuhi Spesifikasi Standar Minimum Akses</b> QuickERP.</h3> <h3>Silahkan gunakan Aplikasi Browser berikut : </h3> <h3>- Google Chrome Versi 49 ke Atas</h3><h3>- Chromium Versi 50 ke Atas</h3> <h3>- Mozilla Firefox Versi 45 ke Atas</h3><br><h3>atau </h3><h3>Silahkan <b>menghubungi Bag. Hardware ICT</b> untuk dilakukan installasi / update Browser</h3> <h3><b>di VoIP 12300 Ext. 5 atau Telkomsel MyGroup 628112545922</b></h3><br><h3>--- QuickERP ---</h3></div>';
    if(browser == 'Chrome' || browser == 'Mozila Firefox' || browser == 'Chromium') {
            if(browser == 'Chrome' && browserVersion < 49) document.getElementById("body").innerHTML = error;
            if(browser == 'Mozila Firefox' && browserVersion < 45) document.getElementById("body").innerHTML = error;
            if(browser == 'chromium' && browserVersion < 50) document.getElementById("body").innerHTML = error;
    } else {
        document.getElementById("body").innerHTML = error;
    }
    function get_browser_info(){
        var ua=navigator.userAgent,tem,M=ua.match(/(opera|Chrome|safari|Firefox|msie|trident|chromium(?=\/))\/?\s*(\d+)/i) || []; 
        if(/trident/i.test(M[1])){
            tem=/\brv[ :]+(\d+)/g.exec(ua) || []; 
            return {name:'IE ',version:(tem[1]||'')};
            }   
        if(M[1]==='Chrome'){
            tem=ua.match(/\bOPR\/(\d+)/)
            if(tem!=null)   {return {name:'Opera', version:tem[1]};}
            }   
        M=M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
        if((tem=ua.match(/version\/(\d+)/i))!=null) {M.splice(1,1,tem[1]);}
        return {
          name: M[0],
          version: M[1]
        };
    }
</script>

</body>
</html> 