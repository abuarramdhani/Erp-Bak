<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $f[0]['SLIDE_SHOW_NAME'] ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link type="image/x-icon" rel="shortcut icon" href="<?= base_url('assets/img/logo.ico') ?>">
    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css') ?>" />
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
    <style type="text/css">
        body {
            background: white;
            font-family: 'Arial';
            background-size: cover;
            overflow-x: hidden;
            font-size: 11px;
        }

        @keyframes example {
            from {
                background-color: white;
            }

            to {
                background-color: red;
            }
        }

        @keyframes wumbo {
            from {
                color: black;
            }

            to {
                color: white;
            }
        }
    </style>
</head>