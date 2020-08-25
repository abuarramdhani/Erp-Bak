</div>
</div>
<footer class="main-footer" style="margin:0;">
    <div class="pull-right hidden-xs">
        Page rendered in <strong>{elapsed_time}</strong> seconds.
        <strong>Copyright &copy; Quick 2015<?php if (date('Y') > 2015) {
                                                echo '-' . date('Y');
                                            } ?>.</strong> All rights reserved.
    </div>
    <b>Version</b> 1.0.0
</footer>
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
<script src="<?= base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js') ?>"></script>
<script src="<?= base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/intro.js-2.9.3/intro.js') ?>"></script>
<script src="<?= base_url('assets/plugins/multiselect/js/bootstrap-multiselect.js') ?>"></script>
<script src="<?= base_url('assets/plugins/fine-uploader/jquery.fine-uploader.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/fine-uploader/fine-uploader.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/chartjs/Chart.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/redactor/js/redactor.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/jquery.number.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/uniform/jquery.uniform.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/inputlimiter/jquery.inputlimiter.1.3.1.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/select2/select2.full.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/chosen/chosen.jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/colorpicker/js/bootstrap-colorpicker.js') ?>"></script>
<script src="<?= base_url('assets/plugins/tagsinput/jquery.tagsinput.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/validVal/js/jquery.validVal.min.js') ?>"></script>
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
<script src="<?= base_url('assets/plugins/monthPicker/monthpicker.js') ?>"></script>
<script src="<?= base_url('assets/plugins/print/print.min.js') ?>"></script>
<script src="<?= base_url('assets/js/formValidation.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery-maskmoney.js') ?>"></script>
<script src="<?= base_url('assets/plugins/howler/howler.js') ?>"></script>
<script src="<?= base_url('assets/plugins/fakeLoading/fakeLoading.js') ?>"></script>


<!-- CUSTOM JAVASCRIPT FOR APPLICATION | DO NOT EDIT!! -->
<script src="<?= base_url('assets/js/custom.js') ?>"></script>
<script src="<?= base_url('assets/js/customTIMS.js') ?>"></script>
<script src="<?= base_url('assets/js/customMPK.js') ?>"></script>
<!-- END OF CUSTOM JAVASCRIPT | DO NOT EDIT!! -->


<script>
    var id_gd;
    if (counter_row <= 0) {
        var counter_row = 0;
    }
    $(function() {
        $('#dataTables-example').dataTable({
            "bSort": false
        });
        $('#dataTables-customer').dataTable({
            "bSort": false,
            "searching": false,
            "bLengthChange": false,
            "bDestroy": true
        });
        $(".textarea").wysihtml5();
        $('.pp-date').datepicker({
            "autoclose": true,
            "todayHiglight": true,
            "allowClear": true,
            "format": 'dd M yyyy'
        });
        $('[data-toggle="tooltip"]').tooltip();
        formInit();
        <?php
        if ($this->session->flashdata('delete-menu-respond')) {
            switch ($this->session->flashdata('delete-menu-respond')) {
                case 1:
                    if ($this->session->flashdata('delete-menu-name')) {
                        echo "
                            Swal.fire({
                                text: 'Terjadi kesalahan saat menghapus menu ' + '" . $this->session->flashdata('delete-menu-name') . "',
                                confirmButtonText: 'Tutup',
                                type: 'error'
                            });
                        ";
                    }
                    break;
                case 2:
                    if ($this->session->flashdata('delete-menu-name')) {
                        echo "
                            Swal.fire({
                                text: 'Menu ' + '" . $this->session->flashdata('delete-menu-name') . "' + ' berhasil dihapus',
                                confirmButtonText: 'Tutup',
                                type: 'success'
                            });
                        ";
                    }
                    break;
            }
        }
        if ($this->session->flashdata('delete-menu-list-respond')) {
            switch ($this->session->flashdata('delete-menu-list-respond')) {
                case 1:
                    if ($this->session->flashdata('delete-menu-list-name')) {
                        echo "
                            Swal.fire({
                                text: 'Terjadi kesalahan saat menghapus menu list ' + '" . $this->session->flashdata('delete-menu-list-name') . "',
                                confirmButtonText: 'Tutup',
                                type: 'error'
                            });
                        ";
                    }
                    break;
                case 2:
                    if ($this->session->flashdata('delete-menu-list-name')) {
                        echo "
                            Swal.fire({
                                text: 'Menu list ' + '" . $this->session->flashdata('delete-menu-list-name') . "' + ' berhasil dihapus',
                                confirmButtonText: 'Tutup',
                                type: 'success'
                            });
                        ";
                    }
                    break;
            }
        }
        if ($this->session->flashdata('delete-sub-menu-respond')) {
            switch ($this->session->flashdata('delete-sub-menu-respond')) {
                case 1:
                    echo "
                        Swal.fire({
                            text: 'Terjadi kesalahan saat menghapus sub menu',
                            confirmButtonText: 'Tutup',
                            type: 'error'
                        });
                    ";
                    break;
                case 2:
                    echo "
                        Swal.fire({
                            text: 'Sub menu berhasil dihapus',
                            confirmButtonText: 'Tutup',
                            type: 'success'
                        });
                    ";
                    break;
            }
        }
        ?>
    });

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) return false;
        return true;
    }

    function noInput(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode != 13) return false;
        return true;
    }

    function callModal(link) {
        $('#myModal').modal({
            show: true,
            remote: link
        });
    }
    $(document).ready(function() {
        $('.logmenu1[href!=#], .logmenu2[href!=#], logmenu3[href!=#]').click(function() {
            let menu = $(this).text().trim()

            $.ajax({
                data: {
                    menu1: menu
                },
                type: 'POST',
                url: baseurl + 'getLog'
            });
        })
    })
</script>
</body>

</html>