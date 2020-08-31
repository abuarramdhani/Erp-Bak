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
    <title>QuickERP Login</title>
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
    <script src="<?= base_url('assets/plugins/sweetalert2.all.min.js');?>"></script>
    <script src="<?= base_url('assets/plugins/sweetalert2.all.js');?>"></script>
    <!-- <script src="<?= base_url('assets/plugins/sweetAlert/sweetalert.js') ?>"></script> -->
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

        @media (max-width: 800px) {
            .login-box {
                max-width: 90% !important;
            }

            .is-mobile-full {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
        }
        .swal2-popup {
          font-size: 1.6rem !important;
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
<?php 
    // untuk slide show
    $start = strtotime("2020-08-30");
    $now = strtotime(date('Y-m-d'));
    $diff = ($now - $start) / (60 * 60 * 24);
?>
<body id="body">
<div class="ch-container">
    <div class="main">
        <div class="row">
            <div class="col-md-12 center login-header"></div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="row" style="height: 100%">
                    <div class="col-sm-9 col-sm-offset-3" style="height: 100%;padding-left: 0;">
                        <div class="carousel slide" data-ride="carousel" data-interval="4000">
                            <div class="carousel-inner">
                                <?php 
                                $gambarData = array(
                                    1 => array('1.fakta.jpg',
                                        '2.manipulasi.jpg',
                                        '3.prosedur.jpg',
                                        '4.completion.jpg'
                                    ),
                                    2 => array(
                                        '5.stockopname.jpg',
                                        '6.Segera-tindak-lanjut.jpg',
                                        '7.scw.jpg'
                                    )
                                );

                                $loopData = array();
                                if (in_array($diff%7, array(1,2,3))) {
                                    $loopData = $gambarData[1];
                                }elseif (in_array($diff%7, array(4,5,6,0))) {
                                    $loopData = $gambarData[2];
                                }else{
                                    foreach ($gambarData as $val) {
                                        foreach ($val as $val2) {
                                            $loopData[] = $val2;
                                        }
                                    }
                                }

                                $nomor = 0;
                                foreach ($loopData as $value) {
                                    if ($nomor == 0) {
                                        $active = "active";
                                    }else{
                                        $active = "";
                                    }
                                    ?>
                                        <div class="item <?php echo $active ?>">
                                            <img src="<?php echo base_url('assets/poster/AwarenessData/'.$value) ?>" style="width: 100%;height: auto" alt="<?php echo $value ?>">
                                        </div>
                                    <?php
                                    $nomor++;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="well col-md-6 login-box">
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
                <div class="alert alert-info text-left center">
                   Silahkan masukan username dan password Anda untuk masuk ke Sistem
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

                        <p class="center">
                            <div class="row">
                            <div class="col-md-4"><a class="btn btn-success" data-toggle="modal" data-target="#myRequest">Permintaan Akses</a></div>
                            <div class="col-md-4"> <a class="btn btn-default" data-toggle="modal" data-target="#myModal">Lupa Password ?</a></div>
                            <div class="col-md-4"><button type="submit" class="btn btn-primary">Masuk</button></div>
                            </div>
                        </p>
                    </fieldset>
                </form>
            </div>
            <div class="col-md-3">
                <div class="row" style="height: 100%">
                    <div class="col-sm-9" style="height: 100%;padding-right: 0;">
                        <div class="carousel slide" data-ride="carousel" data-interval="4000">
                            <div class="carousel-inner">
                                <?php 
                                $gambarCovid = array(
                                    1 => array(
                                        '1.Jagajarak.jpg',
                                        '2.Maskerbaikbenar.jpg',
                                        '3.Gantimasker.jpg',
                                        '4.Dontspeak.jpg',
                                        '5.LewatAirborne.jpg'
                                    ),
                                    2 => array(
                                        '6.CuciTangan.jpg',
                                        '7.6lngkah.jpg',
                                        '8.KontakFisik.jpg',
                                        '9.NyedakKeplak.jpg',
                                        '10.Makan.jpg'
                                    ),
                                    3 => array(
                                        '11.Smoker.jpg',
                                        '12.Akuada.jpg',
                                        '13.4jalan.jpg',
                                        '14.Staywithme.jpg'
                                    ),
                                    4 => array(
                                        '15.DontGobaby.jpg',
                                        '16.Janganpegang.jpg',
                                        '17.Openthedor.jpg',
                                        '18.Breath.jpg'
                                    )
                                );
                                
                                $loopCovid = array();
                                if (in_array($diff%14, array(1,2,3))) {
                                    $loopCovid = $gambarCovid[1];
                                }elseif (in_array($diff%14, array(4,5,6,7))) {
                                    $loopCovid = $gambarCovid[2];
                                }elseif (in_array($diff%14, array(8,9,10))) {
                                    $loopCovid = $gambarCovid[3];
                                }elseif (in_array($diff%14, array(11,12,13,0))) {
                                    $loopCovid = $gambarCovid[4];
                                }else{
                                    foreach ($gambarCovid as $val) {
                                        foreach ($val as $val2) {
                                            $loopCovid[] = $val2;
                                        }
                                    }
                                }

                                $nomor = 0;
                                foreach ($loopCovid as $value) {
                                    if ($nomor == 0) {
                                        $active = "active";
                                    }else{
                                        $active = "";
                                    }
                                    ?>
                                        <div class="item <?php echo $active ?>">
                                            <img src="<?php echo base_url('assets/poster/Covid/'.$value) ?>" style="width: 100%;height: auto" alt="<?php echo $value ?>">
                                        </div>
                                    <?php
                                    $nomor++;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"> 
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel" align="center">Anda Lupa Password ? </h4> </div>
                        <div class="modal-body"> Jika Anda lupa password, silahkan membuat ticket / order permintaan melalui <a href='http://ictsupport.quick.com/ticket/upload/'>ICT Support Center (Klik Disini)</a> atau akses url berikut : http://ictsupport.quick.com/ticket/upload/.
                        <br>atau menghubungi ICT di<br>
                        VOIP Internal Ext : 12300 ekstensi 3
                        <br>atau<br> 
                        melalui Whatsapp ke 08112545922.
                        </div>
                    <div class="modal-footer"> 
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                    </div> 
            </div>
        </div>
    </div>
    <div class="modal fade" id="myRequest" tabindex="-1" role="dialog" aria-labelledby="myRequestLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header"> 
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myRequestLabel" align="center">Anda menginginkan Akses ke Sistem ERP?</h4> </div>
                            <div class="modal-body"> Jika Anda ingin mendapatkan Akses ke Quick ERP System, silahkan membuat ticket / order permintaan melalui <a href='http://ictsupport.quick.com/ticket/upload/'>ICT Support Center (Klik Disini)</a> atau akses url berikut : http://ictsupport.quick.com/ticket/upload/.
                            <br>atau menghubungi ICT di<br>
                            VOIP Internal Ext : 12300 ekstensi 3
                            <br>atau<br> 
                            melalui Whatsapp ke 08112545922.
                            </div>
                        <div class="modal-footer"> 
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                        </div> 
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
    var OSName = "Unknown";
    if (window.navigator.userAgent.indexOf("Android")            != -1) OSName="Android";

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
    var error = '<div style="text-align: center;"><h3>Aplikasi Browser ('+ get_browser_info().name +' Versi '+ get_browser_info().version +') Anda <b>tidak memenuhi Spesifikasi Standar Minimum Akses</b> QuickERP.</h3> <h3>Silahkan gunakan Aplikasi Browser berikut : </h3> <h3>- Google Chrome Versi 49 ke Atas</h3><h3>- Chromium Versi 50 ke Atas</h3> <h3>- Mozilla Firefox Versi 45 ke Atas</h3><br><h3>atau </h3><h3>Silahkan <b>menghubungi Bag. Hardware ICT</b> untuk dilakukan installasi / update Browser</h3> <h3><b>di VoIP 12300 Ext. 5 atau Telkomsel MyGroup 628112545922</b></h3><br><h3>--- QuickERP ---</h3></div> nama os : '+OSName;
    if(browser == 'Chrome' || browser == 'Mozila Firefox' || browser == 'Chromium' || browser == 'Safari') {
            if((browser == 'Chrome' && browserVersion < 49 && OSName != 'Android') || (browser == 'Chrome' && browserVersion < 42 && OSName == 'Android')) document.getElementById("body").innerHTML = error;
            if(browser == 'Mozila Firefox' && browserVersion < 45) document.getElementById("body").innerHTML = error;
            if(browser == 'chromium' && browserVersion < 50) document.getElementById("body").innerHTML = error;
            if(browser == 'Safari' && browserVersion !== 604 && browserVersion !== 13) document.getElementById("body").innerHTML = error;
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