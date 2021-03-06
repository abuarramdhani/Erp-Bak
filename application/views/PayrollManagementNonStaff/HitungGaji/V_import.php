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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/DataAbsensi');?>">
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
                                <form id="ImportDataAbsensi" class="form-horizontal" method="post" action="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/DataAbsensi/doImport');?>" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">
                                            File
                                        </label>
                                        <div class="col-lg-4">
                                            <div class="input-group">
                                                <input name="file_path" placeholder="Choose File" class="form-control uploadFile" type="text" readonly/>
                                                <span class="input-group-btn">
                                                    <div class="fileUpload btn btn-block btn-primary">
                                                        <span>Browse</span>
                                                        <input name="file" type="file" class="upload uploadBtn" accept=".dbf" required/>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-1" id="server-status">
                                            
                                        </div>
                                    </div>
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
                                            <input type="text" name="txtTahun" class="form-control" placeholder="Tahun" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-4 col-lg-2" id="errorImportData">
                                            
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" id="btnImportDataAbsensi" class="btn btn-primary btn-block" style="float: right;">Import</button>
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