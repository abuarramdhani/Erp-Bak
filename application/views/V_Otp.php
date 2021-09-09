<!DOCTYPE html>
<html lang="en">

<!-- header -->

<head>
    <meta charset="UTF-8" />
    <!-- [if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif] -->
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="author" content="" />
    <meta name="description" content="" />
    <meta name="theme-color" content="#3c8dbc">

    <title>Kode Akses</title>
    <link type="image/x-icon" rel="shortcut icon" href="<?= base_url('assets/img/logo.ico') ?>">
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/bootstrap/utilities/spacing.min.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/bootstrap/4.0.0/card.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/select2/select2.min.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/Font-Awesome/3.2.0/css/font-awesome.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/Font-Awesome/4.3.0/css/font-awesome.min.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/Font-Awesome/4.3.0/css/font-awesome-animation.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/ionicons/css/ionicons.min.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/theme/css/AdminLTE.min.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/theme/css/skins/_all-skins.min.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/datatables-latest/datatables.min.css') ?>" />
    <!-- <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/dataTables/dataTables.bootstrap.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/dataTables/buttons.dataTables.min.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/dataTables/extensions/FixedColumns/css/dataTables.fixedColumns.min.css') ?>" /> -->
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/touchspin/jquery.bootstrap-touchspin.min.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/pace/center-atom-pace.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/jQueryUI/jquery-ui.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/uniform/themes/default/css/uniform.default.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/inputlimiter/jquery.inputlimiter.1.0.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/chosen/chosen.min.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/colorpicker/css/colorpicker.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/intro.js-2.9.3/introjs.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/dropzone/basic.min.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/dropzone/dropzone.min.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/tagsinput/jquery.tagsinput.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/daterangepicker-master/daterangepicker.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/datepicker/css/datepicker.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/datetimepicker/build/jquery.datetimepicker.min.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/timepicker/css/bootstrap-timepicker.min.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/switch/static/stylesheets/bootstrap-switch.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/validator/bootstrapValidator.min.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/validator/bootstrapValidator.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/qtip/jquery.qtip.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/iCheck/skins/all.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/redactor/css/redactor.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/fine-uploader/fine-uploader-new.min.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/multiselect/css/bootstrap-multiselect.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/mdtimepicker/mdtimepicker.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/css/animate.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/fullcalendar-1.6.2/fullcalendar/fullcalendar.css') ?>" />
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/fullcalendar-1.6.2/fullcalendar/fullcalendar.print.css') ?>" />
    <script src="<?= base_url('assets/plugins/jquery-2.1.4.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/plugins/jQueryUI/jquery-ui.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/plugins/bootstrap/3.3.7/js/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/modernizr-2.6.2-respond-1.1.0.min.js') ?>" type="text/javascript"></script>
</head>

<!-- Content -->
<section class="content">
    <form method="post" action="<?= base_url('ReqOtp') ?>">
        <div class="row" style="margin-top: 200px;">
            <div class="col-lg-4">
            </div>
            <div class="col-lg-4">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3>Kode Akses Sudah kami kirimkan ke Email : <?= $email[0]['email_internal'] ?> dan MyGroup : <?= $mygroup ?></h3>
                        <h3>Masukan Kode Dibawah ini : </h3>
                        <input type="hidden" id="kode_akses" value="<?= $otp ?>">
                        <input type="hidden" id="user_name" name="user_name" value="<?= $user ?>">
                        <input type="hidden" id="password_u" name="password_u" value="<?= $pass ?>">

                    </div>
                    <div class="box-body">
                        <div class="col-md-10">
                            <input style="text-align: center;" id="key_akses" class="form-control input-lg" data-inputmask="'alias': '9999'">
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-primary btn-lg" onclick="AksesERPbyOTP()">OK</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
            </div>
            <div class="col-lg-4">
                <div class="col-md-6 hitungmundyur" style="font-size: 12pt;"></div>
                <div class="col-md-6" style="text-align: right;"><button disabled="disabled" id="btn_req" class="btn btn-primary btn-sm">Request Ulang Kode</button></div>

            </div>
            <div class="col-lg-4">
            </div>
        </div>
    </form>
</section>

<!-- Footer -->
<script>
    const baseurl = "<?= base_url() ?>";
</script>
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
<script src="<?= base_url('assets/js/customOTP.js') ?>"></script>

</html>