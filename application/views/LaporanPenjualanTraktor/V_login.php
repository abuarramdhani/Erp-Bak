<!DOCTYPE html>
<html lang='en' style="height: 100%">

<head>
    <meta http-equiv='Content-Type'>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/bootstrap/4.0.0/bootstrap.min.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/theme/css/AdminLTE.min.css') ?>" />
    <link type="text/css" rel="stylesheet"
        href="<?= base_url('assets/plugins/Font-Awesome/3.2.0/css/font-awesome.css') ?>" />
    <link type="text/css" rel="stylesheet"
        href="<?= base_url('assets/plugins/Font-Awesome/4.3.0/css/font-awesome.min.css') ?>" />
    <link type="text/css" rel="stylesheet"
        href="<?= base_url('assets/plugins/Font-Awesome/4.3.0/css/font-awesome-animation.css') ?>" />
    <script src="<?= base_url('assets/plugins/jquery-2.1.4.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/plugins/jQueryUI/jquery-ui.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/plugins/bootstrap/3.3.7/js/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/modernizr-2.6.2-respond-1.1.0.min.js') ?>" type="text/javascript">
    </script>
    <title>Login - TR2</title>
    <style>
    .button-login {
        color: white;
        width: 100%;
        background-image: linear-gradient(to bottom right, #37b4fb, #ea6fd6);
        border: none;
    }

    .button-login:hover {
        background-image: linear-gradient(to bottom right, #ea6fd6, #37b4fb);
    }
    </style>
</head>

<body style="margin:unset;height:100%">
    <div style="background-image:linear-gradient(to top right, #C34A88, #3F8FC0);height:100%;position:relative">
        <div style="position: absolute;top: 48%;left: 50%;transform: translate(-50%, -50%);width:30%;height:60%;">
            <div class="box" style="width:100%;height:100%;border-radius:10px;border-top:none;background-color:white">
                <div class="box-body"
                    style="height:100%;width:100%;border-radius:10px;box-shadow: 0 0 12px 0px #3c3c3cd1;">
                    <div id="loading-login-lpt" style="display:none">
                        <div
                            style="padding:30px;width:100%;height:100%;display:flex;justify-content:center;align-items:center">
                            <div style="width:fit-content;height:fit-content">
                                <center><img style="width:100%" src="<?= base_url('assets/img/gif/loading15.gif') ?>">
                                </center>
                            </div>
                        </div>
                    </div>
                    <div id="content-input-uspas-lpt" style="padding:30px;">
                        <table style="width:100%">
                            <tr>
                                <td style="display:flex;align-content:center;">
                                    <div style="width:90px;height:75px;overflow:hidden;margin: 0 auto;">
                                        <img style="width:100%"
                                            src="http://quick.com/wp-content/uploads/2020/02/MONITORING-PENJULAN-TR2-Small.png">
                                    </div>
                                </td>
                                <td style="font-size:26px;">
                                    <div style="width:fit-content;margin:0 auto;color:#5F5F5F"><b>Monitoring</b>
                                        <br>Penjualan TR2
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <hr style="background: linear-gradient(to right, #ea6fd6, #37b4fb);height: 1px;">
                                </td>
                            </tr>
                            <!-- <form action="<?= base_url('laporanPenjualanTraktor/logined') ?>" method="POST"> -->
                            <tr>
                                <td colspan="2" style="padding:20px 0">
                                    <div style="display:flex">
                                        <div
                                            style="width:42px;height:36px;background-color:#467bdd;display:flex;align-items:center;justify-content:center">
                                            <i class="fa fa-user" style="margin:auto;color:white"></i>
                                        </div>
                                        <div style="width:100%">
                                            <input id="username-login-lpt" type="text" class="form-control"
                                                style="border:none;background-color:#f7f7f7" placeholder="username"
                                                required autocomplete="off">
                                        </div>
                                    </div>
                                    <div style="margin:15px 0;display:flex">
                                        <div
                                            style="width:42px;height:36px;background-color:#467bdd;display:flex;align-items:center;justify-content:center">
                                            <i class="fa fa-key" style="margin:auto;color:white"></i>
                                        </div>
                                        <div style="width:100%">
                                            <input id="password-login-lpt" type="password" class="form-control"
                                                style="border:none;background-color:#f7f7f7" placeholder="password"
                                                required>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <button id="button-login-view-lpt" class="btn button-login">
                                        <b>LOGIN</b>
                                    </button>
                                </td>
                            </tr>
                            <!-- </form> -->
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="<?= base_url('assets/plugins/slimScroll/jquery.slimscroll.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/fastclick/fastclick.min.js') ?>"></script>
<script src="<?= base_url('assets/theme/js/app.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-latest/datatables.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/table2excel/jquery.table2excel.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/sweetalert2.all.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/sweetalert2.all.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/canvasjs/canvasjs.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/chartjs/Chart.js') ?>"></script>
<script src="<?= base_url('assets/plugins/moment.js') ?>"></script>
<script src="<?= base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js') ?>"></script>
<script src="<?= base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/input-mask/3.x') ?>/dist/jquery.inputmask.bundle.js"></script>
<script src="<?= base_url('assets/plugins/input-mask/3.x') ?>/dist/inputmask/phone-codes/phone.js"></script>
<script src="<?= base_url('assets/plugins/input-mask/3.x') ?>/dist/inputmask/phone-codes/phone-be.js"></script>
<script src="<?= base_url('assets/plugins/input-mask/3.x') ?>/dist/inputmask/phone-codes/phone-ru.js"></script>
<script src="<?= base_url('assets/plugins/input-mask/3.x') ?>/dist/inputmask/bindings/inputmask.binding.js"></script>
<script src="<?= base_url('assets/plugins/intro.js-2.9.3/intro.js') ?>"></script>
<script src="<?= base_url('assets/plugins/multiselect/js/bootstrap-multiselect.js') ?>"></script>
<script src="<?= base_url('assets/plugins/touchspin/jquery.bootstrap-touchspin.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/fine-uploader/jquery.fine-uploader.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/fine-uploader/fine-uploader.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/chartjs/Chart.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/redactor/js/redactor.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/mdtimepicker/mdtimepicker.js') ?>"></script>
<script src="<?= base_url('assets/plugins/html2canvas/html2canvas.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/highchart/highcharts.js') ?>"></script>
<script src="<?= base_url('assets/plugins/highchart/exporting.js') ?>"></script>
<script src="<?= base_url('assets/plugins/highchart/offline-exporting.js') ?>"></script>
<script src="<?= base_url('assets/plugins/jquery.number.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/uniform/jquery.uniform.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/inputlimiter/jquery.inputlimiter.1.3.1.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/select2/select2.full.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/chosen/chosen.jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/colorpicker/js/bootstrap-colorpicker.js') ?>"></script>
<script src="<?= base_url('assets/plugins/tagsinput/jquery.tagsinput.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/validVal/js/jquery.validVal.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/dropzone/dropzone.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/daterangepicker-master/moment.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/daterangepicker-master/moment-precise-range.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datepicker/js/bootstrap-datepicker.js') ?>"></script>
<script src="<?= base_url('assets/plugins/daterangepicker-master/daterangepicker.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/timepicker/js/bootstrap-timepicker.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datetimepicker/build/jquery.datetimepicker.full.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datetimepicker/build/jquery.datetimepicker.full.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datetimepicker/build/jquery.datetimepicker.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/switch/static/js/bootstrap-switch.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/jquery.dualListbox-1.3/jquery.dualListBox-1.3.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/autosize/jquery.autosize.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/jasny/js/bootstrap-inputmask.js') ?>"></script>
<script src="<?= base_url('assets/plugins/jquery-validation-1.11.1/dist/jquery.validate.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/validator/bootstrapValidator.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/validator/bootstrapValidator.js') ?>"></script>
<script src="<?= base_url('assets/plugins/jquery.mask.js') ?>"></script>
<script src="<?= base_url('assets/plugins/iCheck/icheck.js') ?>"></script>
<script src="<?= base_url('assets/plugins/jquery.toaster/jquery.toaster.js') ?>"></script>
<script src="<?= base_url('assets/js/formsInit.js') ?>"></script>
<script src="<?= base_url('assets/js/ajaxSearch.js') ?>"></script>
<script src="<?= base_url('assets/js/HtmlFunction.js') ?>"></script>
<script src="<?= base_url('assets/js/ChainArea.js') ?>"></script>
<script src="<?= base_url('assets/plugins/jQuery/jquery.toaster.js') ?>"></script>
<script src="<?= base_url('assets/plugins/qtip/jquery.qtip.js') ?>"></script>
<script src="<?= base_url('assets/plugins/jasny-bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/inputmask/inputmask.bundle.js') ?>"></script>
<script src="<?= base_url('assets/plugins/sweetAlert/sweetalert.js') ?>"></script>
<script src="<?= base_url('assets/plugins/table-to-CSV/table2csv.js') ?>"></script>
<script src="<?= base_url('assets/plugins/table-to-CSV/tableHTMLExport.js') ?>"></script>
<script src="<?= base_url('assets/plugins/table-to-CSV/jspdf.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/table-to-CSV/jspdf.plugin.autotable.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/table-to-CSV/tableExport.js') ?>"></script>
<script src="<?= base_url('assets/plugins/table-to-CSV/FileSaver.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/monthPicker/monthpicker.js') ?>"></script>
<script src="<?= base_url('assets/plugins/print/print.min.js') ?>"></script>
<script src="<?= base_url('assets/js/formValidation.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery-maskmoney.js') ?>"></script>
<script src="<?= base_url('assets/plugins/howler/howler.js') ?>"></script>
<script src="<?= base_url('assets/plugins/fakeLoading/fakeLoading.js') ?>"></script>
<script src="<?= base_url('assets/plugins/fullcalendar-1.6.2/fullcalendar/fullcalendar.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-latest/datetime-moment.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-latest/RowsGroup/dataTables.rowsGroup.js') ?>"></script>

<script src="<?= base_url('assets/js/customLPT.js') ?>" type="text/javascript"></script>

<html>