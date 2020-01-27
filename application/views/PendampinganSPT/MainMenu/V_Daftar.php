<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta name="author" content="" />
        <meta name="description" content="" />
        <meta name="theme-color" content="#3c8dbc">
        <title>Pendampingan SPT | Daftar</title>

        <link type="image/x-icon" rel="shortcut icon" href="<?= base_url('assets/img/logo.ico') ?>">
        <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css') ?>" />
        <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/select2/select2.min.css') ?>" />
        <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/Font-Awesome/3.2.0/css/font-awesome.css') ?>" />
        <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/Font-Awesome/4.3.0/css/font-awesome.min.css') ?>" />
        <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/Font-Awesome/4.3.0/css/font-awesome-animation.css') ?>" />
        <link type="text/css" rel="stylesheet" href="<?= base_url('assets/theme/css/AdminLTE.min.css') ?>" />
        <link type="text/css" rel="stylesheet" href="<?= base_url('assets/theme/css/skins/_all-skins.min.css') ?>" />

        <!-- Custom Style -->
        <style>
            label {
                font-weight: normal;
            }

            .form-group {
                margin-bottom: 3px !important;
            }    
            .swal-font-small {
                font-size: 1.5rem !important;
            }
            .swal2-shown {
                padding-right: 0px !important;
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
                                    <img src="<?= base_url('assets/theme/img/user.png') ?>" class="user-image" alt="User Image">
                                    <span class="hidden-xs">GUEST</span>
                                </a>
                            </li>
                            <li class="hidden-xs hidden-sm">
                                <a href="<?= base_url('PendampinganSPT/Daftar') ?>">
                                    <i class="fa fa-envelope-square"></i> Daftar Pendampingan SPT
                                </a>
                            </li>
                            <li class="hidden-xs hidden-sm">
                                <a href="http://quick.com">
                                    <i class="fa fa-sign-out"></i> Back
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
        </div>

        <!-- Main content -->
        <section class="content" style="background: url(<?= base_url('assets/img/3.jpg') ?>); background-size: cover;">
            <div class="row">
                <div class="col-md-1"></div>
                <!-- /.col -->
                <div class="col-md-10">
                        <div class="box box-primary container-fluid ">
                            <div class="box-header with-border text-center">
                                <h4><b>PENDAFTARAN PELAPORAN SPT TAHUNAN 2019 ORANG PRIBADI</b></h3>
                                <h5>- KHUSUS UNTUK PEKERJA CV. KARYA HIDUP SENTOSA YANG MEMILIKI NPWP -</h4>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="text-justify">
                                    <h4 class="text-center"><span class="bd-content-title text-red"><b>PERHATIAN !</b></span></h4>
                                    <dl>
                                        <dd>Mohon membaca informasi berikut sebelum Anda melakukan pendaftaran pendampingan pengisian SPT Tahunan 2019.</dd>
                                        <dd>Pendaftaran pendampingan pengsisian SPT Tahunan Orang Pribadi tahun 2019 ini hanya diperuntukan kepada <b>Pekerja CV. Karya Hidup Sentosa (bukan OS) yang memiliki NPWP</b>.</dd>
                                    </dl>
                                    <p class="text-center"><b>Jadwal pendampingan akan disusulkan kemudian, dan akan diinformasikan melalui email pekerja dan email seksi.</b></p>
                                </div>
                                <br>
                                <div class="PSPTRegisterFormField">
                                    <div class="form-group">
                                        <label for="txtPSPTIdentityNumber" class="col-sm-2 control-label">No. Induk</label>
                                        <div class="input-group col-sm-5">
                                            <span class="input-group-addon"><i style="width:15px;" class="fa fa-list-ol"></i></span>
                                            <input class="form-control" id="txtPSPTIdentityNumber" placeholder="Nomor Induk">
                                            <span class="input-group-addon spnPSPTLoading" style="display: none"><i style="width:15px;" class="fa fa-spinner fa-spin"></i></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="txtPSPTWorkerStats" class="col-sm-2 control-label">Status Pekerja</label>
                                        <div class="input-group col-sm-5">
                                            <span class="input-group-addon"><i style="width:15px;" class="fa fa-signal"></i></span>
                                            <input class="form-control" id="txtPSPTWorkerStats" placeholder="Status Pekerja" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="txtPSPTWorkerName" class="col-sm-2 control-label">Nama</label>
                                        <div class="input-group col-sm-5">
                                            <span class="input-group-addon"><i style="width:15px;" class="fa fa-user"></i></span>
                                            <input class="form-control" id="txtPSPTWorkerName" placeholder="Nama Pekerja" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="txtPSPTSection" class="col-sm-2 control-label">Seksi</label>
                                        <div class="input-group col-sm-5">
                                            <span class="input-group-addon"><i style="width:15px;" class="fa fa-users"></i></span>
                                            <input class="form-control" id="txtPSPTSection" placeholder="Seksi Pekerja" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="slcPSPTWorkLocation" class="col-sm-2 control-label">Lokasi Kerja</label>
                                        <div class="input-group col-sm-5">
                                            <span class="input-group-addon"><i style="width:15px;" class="fa fa-map-marker"></i></span>
                                            <select id="slcPSPTWorkLocation" class="form-control" style="width: 100%;">
                                                <option selected="selected" disabled="disabled"></option>
                                                <option>PUSAT</option>
                                                <option>TUKSONO</option>
                                            </select>
                                        </div>
                                    </div><br>
                                </div>
                                <div class="text-justify">
                                    <p>Mohon dicek kembali data di atas, jika belum sesuai silahkan diperbaiki sesuai data yang benar dan jika sudah sesuai klik "<b>Kirim</b>".</p>
                                    <a href="" class="linkPSPTDetailSchedule"><p>Untuk melihat jadwal dan lokasi pendampingan, silahkan klik link berikut.</p></a>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <div class="pull-right">
                                    <button type="button" class="btn btn-primary btnPSPTRegister"><i class="fa fa-send"></i> Kirim</button>
                                </div>
                                <button type="reset" class="btn btn-default btnPSPTRefresh"><i class="fa fa-refresh"></i> Refresh</button>
                            </div>
                            <!-- /.box-footer -->
                        </div>
                        <!-- /. box -->
                    </form>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->

        <div id="mdlPSPTAlertNPWP" class="modal fade" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-slg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-warning"></i> Peringatan</h4>
                    </div>
                    <div class="modal-body" style="word-wrap: break-word">
                        <p class="text-justify">Data NPWP Anda tidak terdapat di data hubker, silahkan mengisikan nomor NPWP Anda di kotak dibawah ini.</p><br>
                        <div class="form-group">
                            <div class="col-sm-1"></div>
                            <div class="input-group col-sm-10">
                                <span class="input-group-addon"><i style="width:15px;" class="fa fa-sort-numeric-asc "></i></span>
                                <input class="form-control" id="txtPSPTTRN" placeholder="Nomor Pokok Wajib Pajak">
                            </div>
                            <div class="col-sm-1"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-remove"></i> Batal</button>
                        <button type="button" class="btn btn-primary btnPSPTRegister"><i class="fa fa-send-o"></i> Kirim</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="mdlPSPTAlertRegister" class="modal fade" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-slg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body" style="word-wrap: break-word">
                        <p class="text-justify"></p><br>
                        <div class="form-group">
                            <div class="col-sm-1"></div>
                            <div class="input-group col-sm-10">
                                <span class="input-group-addon"><i style="width:15px;" class="fa fa-sort-numeric-desc"></i></span>
                                <input class="form-control" id="txtPSPTRegisterId" placeholder="Nomor Pendaftaran" readonly>
                            </div>
                            <div class="col-sm-1"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary pull-right" data-dismiss="modal"><i class="fa fa-remove"></i> Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="mdlPSPTDetailSchedule" class="modal fade" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-slg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-info"></i> Informasi</h4>
                    </div>
                    <div class="modal-body" style="word-wrap: break-word">
                        <p class="text-center text-red">Jadwal dan lokasi pendampingan belum tersedia.</p><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary pull-right" data-dismiss="modal"><i class="fa fa-remove"></i> Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <footer class="main-footer" style="margin:0;">
            <div class="pull-right hidden-xs">
                Page rendered in <strong>{elapsed_time}</strong> seconds.
                <strong>Copyright &copy; Quick 2015<?php if ( date('Y') > 2015 ) { echo '-'.date('Y'); } ?>.</strong> All rights reserved.
            </div>
            <b>Version</b> 1.0.0
        </footer>

        <script>
            const baseurl = "<?= base_url() ?>";
        </script>
        <script src="<?= base_url('assets/plugins/jquery-2.1.4.min.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('assets/plugins/jQueryUI/jquery-ui.min.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('assets/plugins/bootstrap/3.3.7/js/bootstrap.min.js') ?>"></script>
        <script src="<?= base_url('assets/plugins/sweetalert2.all.min.js');?>"></script>
        <script src="<?= base_url('assets/plugins/sweetalert2.all.js');?>"></script>
        <script src="<?= base_url('assets/plugins/sweetAlert/sweetalert.js') ?>"></script>
        <script src="<?= base_url('assets/plugins/select2/select2.full.min.js') ?>"></script>
        <script src="<?= base_url('assets/js/customPSPT.js');?>"></script>
    </body>
</html>