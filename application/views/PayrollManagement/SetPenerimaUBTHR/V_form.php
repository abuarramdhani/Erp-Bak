<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo $action ?>" class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Set Penerima UBTHR</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/SetPenerimaUBTHR/');?>">
                                        <i class="icon-wrench icon-2x"></i>
                                        <span><br/></span>
                                    </a>                             
                                </div>
                            </div>
                        </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                Set Penerima UBTHR
                            </div>
                        <div class="box-body">
                            <div class="panel-body">
                                <?php if (validation_errors() <> '') {
                                echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4><i class="fa fa-times"></i> &nbsp; Error! Please check the following errors:</h4>';
                                echo validation_errors(); 
                                echo "</div>";
                            }
                                ?>
                                <div class="row">
									<div class="form-group">
                                        <label for="txtTglBerlaku" class="control-label col-lg-4">Tanggal Berlaku</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtTglBerlaku" id="txtTglBerlaku" class="form-control" value="<?php echo $tgl_berlaku; ?>"/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtTglTberlaku" class="control-label col-lg-4">Tanggal Tak Berlaku</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtTglTberlaku" id="txtTglTberlaku" class="form-control" value="<?php echo $tgl_tberlaku; ?>"/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtKdStatusKerja" class="control-label col-lg-4">Kode Status Kerja</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtKdStatusKerja" id="txtKdStatusKerja" class="form-control" value="<?php echo $kd_status_kerja; ?>" maxlenght="1"/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtPersentaseTHR" class="control-label col-lg-4">Persentase THR</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtPersentaseTHR" id="txtPersentaseTHR" class="form-control" value="<?php echo $persentase_thr; ?>" maxlenght="5"/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtPersentaseUBTHR" class="control-label col-lg-4">Persentase UBTHR</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtPersentaseUBTHR" id="txtPersentaseUBTHR" class="form-control" value="<?php echo $persentase_ubthr; ?>" maxlenght="5"/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtKodePetugas" class="control-label col-lg-4">Kode Petugas</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtKodePetugas" id="txtKodePetugas" class="form-control" value="<?php echo $kd_petugas; ?>" maxlenght="7"/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtTanggalRecord" class="control-label col-lg-4">Tanggal Record</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtTanggalRecord" id="txtTanggalRecord" class="form-control" value="<?php echo $tgl_record; ?>" />
                                        </div>
                                    </div>
									<input type="hidden" name="txtIdSetting" value="<?php echo $id_setting; ?>" />
								</div>
                                
                            </div>
                            <div class="panel-footer">
                                <div class="row text-right">
                                    <a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
                                    &nbsp;&nbsp;
                                    <button type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</section>