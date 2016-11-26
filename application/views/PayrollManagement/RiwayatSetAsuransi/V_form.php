<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo $action ?>" class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Riwayat Set Asuransi</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/RiwayatSetAsuransi/');?>">
                                        <i class="icon-wrench icon-2x"></i>
                                        <span ><br /></span>
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
                                Riwayat Set Asuransi
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
	                                            <label for="txtTglBerlaku" class="control-label col-lg-4">Tgl Berlaku</label>
	                                            <div class="col-lg-4">
	                                                <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTglBerlaku" value="<?php echo $tgl_berlaku ?>" class="form-control" data-date-format="yyyy-mm-dd" id="txtTglBerlaku" />
	                                            </div>
	                                        </div>
									<div class="form-group">
	                                            <label for="txtTglTberlaku" class="control-label col-lg-4">Tgl Tberlaku</label>
	                                            <div class="col-lg-4">
	                                                <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTglTberlaku" value="<?php echo $tgl_tberlaku ?>" class="form-control" data-date-format="yyyy-mm-dd" id="txtTglTberlaku" />
	                                            </div>
	                                        </div>
									<div class="form-group">
	                                            <label for="cmbKdStatusKerja" class="control-label col-lg-4">Kd Status Kerja</label>
	                                            <div class="col-lg-4">
	                                                <select id="cmbKdStatusKerja" name="cmbKdStatusKerja" class="select2" data-placeholder="Choose an option"><option value=""></option>
                                                        <?php
                                                        foreach ($pr_master_status_kerja_data as $row) {
                                                            $slc = '';
                                                            if (rtrim($row->kd_status_kerja) == rtrim($kd_status_kerja)) {
                                                                $slc = 'selected';
                                                            }
                                                            echo '<option value="'.$row->kd_status_kerja.'" '.$slc.'>'.$row->status_kerja.'</option>';
                                                        }
                                                        ?></select>
	                                            </div>
	                                        </div>
									<div class="form-group">
                                            <label for="txtJkk" class="control-label col-lg-4">Jkk</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Jkk" name="txtJkk" id="txtJkk" class="form-control" value="<?php echo $jkk; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtJkm" class="control-label col-lg-4">Jkm</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Jkm" name="txtJkm" id="txtJkm" class="form-control" value="<?php echo $jkm; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtJhtKary" class="control-label col-lg-4">Jht Kary</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Jht Kary" name="txtJhtKary" id="txtJhtKary" class="form-control" value="<?php echo $jht_kary; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtJhtPrshn" class="control-label col-lg-4">Jht Prshn</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Jht Prshn" name="txtJhtPrshn" id="txtJhtPrshn" class="form-control" value="<?php echo $jht_prshn; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtJknKary" class="control-label col-lg-4">Jkn Kary</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Jkn Kary" name="txtJknKary" id="txtJknKary" class="form-control" value="<?php echo $jkn_kary; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtJknPrshn" class="control-label col-lg-4">Jkn Prshn</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Jkn Prshn" name="txtJknPrshn" id="txtJknPrshn" class="form-control" value="<?php echo $jkn_prshn; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtJpnKary" class="control-label col-lg-4">Jpn Kary</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Jpn Kary" name="txtJpnKary" id="txtJpnKary" class="form-control" value="<?php echo $jpn_kary; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtJpnPrshn" class="control-label col-lg-4">Jpn Prshn</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Jpn Prshn" name="txtJpnPrshn" id="txtJpnPrshn" class="form-control" value="<?php echo $jpn_prshn; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtKdPetugas" class="control-label col-lg-4">Kd Petugas</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Kd Petugas" name="txtKdPetugas" id="txtKdPetugas" class="form-control" value="<?php echo $kd_petugas; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
	                                            <label for="txtTglRec" class="control-label col-lg-4">Tgl Rec</label>
	                                            <div class="col-lg-4">
	                                                <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTglRec" value="<?php echo $tgl_rec ?>" class="form-control" data-date-format="yyyy-mm-dd" id="txtTglRec" />
	                                            </div>
	                                        </div>

	    <input type="hidden" name="txtIdSetAsuransi" value="<?php echo $id_set_asuransi; ?>" /> </div>
                                
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