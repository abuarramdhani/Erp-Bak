<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/DataLKHSeksi');?>">
                                    <i class="icon-wrench icon-2x"></i>
                                    <br/>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
          
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title"><?= $Title ?></h3>
                            </div>
                            <div class="box-body">
                                <form id="clearData" class="form-horizontal" method="post" action="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/DataLKHSeksi/doClearData');?>">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">
                                            Pilih Periode
                                        </label>
                                        <div class="col-lg-2">
                                            <select name="slcBulan" class="form-control select2" data-placeholder="Select Month" style="width: 100%">
                                                <option value=""></option>
                                                <?php
                                                    for($i = 1; $i <= 12; $i++){
                                                        echo '<option value="'.$i.'">'.date("F", mktime(0, 0, 0, $i, 1)).'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <input type="text" name="txtTahun" class="form-control" placeholder="Tahun">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-4 col-lg-2" id="errorClearData">
                                            
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" id="btnPreClearData" class="btn btn-primary btn-block" style="float: right;">Kosongkan</button>
                                            <div class="modal fade" id="clear-alert">
                                                <div class="modal-dialog modal-sm">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-red">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title">Kosongkan Data?</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                        Apakah Anda yakin ingin menghapus data LKH Seksi pada periode tersebut?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            <button id="btnClearData" type="button" class="btn btn-danger">Kosongkan Data</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>    
        </div>
    </div>
</section>

<script>
    $(".uploadBtn").change(function () {
        var path = $(this)[0].files;
        if (path.length > 1) {
            $(this).closest('.row').find('.uploadFile').val(path.length + ' Files selected');
        }
        else{
            for (var i = path.length - 1; i >= 0; i--) {
                $(this).closest('.row').find('.uploadFile').val(path[i].name);
            }
        }
    });
</script>