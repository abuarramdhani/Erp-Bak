<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo $action ?>" class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Riwayat Gaji </b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/RiwayatGaji/');?>">
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
                                Riwayat Gaji
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
	                                                <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTglBerlaku" value="<?php echo rtrim($tgl_berlaku) ?>" class="form-control class-datepicker-erp-pr" data-date-format="yyyy-mm-dd" id="txtTglBerlaku" />
	                                            </div>
	                                        </div>
									<div class="form-group">
                                            <label for="txtNoind" class="control-label col-lg-4">Noind</label>
                                            <div class="col-lg-4">
                                                <select class="form-control select2-getNoind" id="txtNoind" name="txtNoind" style="width:100%;" required>
														<option value="<?php echo $noind; ?>"><?php echo $noind; ?></option>
												</select>
                                            </div>
                                    </div>
									<div class="form-group">
	                                            <label for="cmbKdHubunganKerja" class="control-label col-lg-4">Kd Hubungan Kerja</label>
	                                            <div class="col-lg-3">
	                                                <select id="cmbKdHubunganKerja" name="cmbKdHubunganKerja" class="form-control select2" data-placeholder="Choose an option"><option value=""></option>
                                                        <?php
                                                        foreach ($pr_hub_kerja_data as $row) {
                                                            $slc = '';
                                                            if ($row->kd_hubungan_kerja == $kd_hubungan_kerja) {
                                                                $slc = 'selected';
                                                            }
                                                            echo '<option value="'.$row->kd_hubungan_kerja.'" '.$slc.'>'.$row->hubungan_kerja.'</option>';
                                                        }
                                                        ?></select>
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
	                                            <label for="cmbKdJabatan" class="control-label col-lg-4">Kd Jabatan</label>
	                                            <div class="col-lg-4">
	                                                <select id="cmbKdJabatan" name="cmbKdJabatan" class="select2" data-placeholder="Choose an option"><option value=""></option>
                                                        <?php
                                                        foreach ($pr_master_jabatan_data as $row) {
                                                            $slc = '';
                                                            if (str_replace(" ","",$row->kd_jabatan) == str_replace(" ","",$kd_jabatan)) {
                                                                $slc = 'selected';
                                                            }
                                                            echo '<option value="'.$row->kd_jabatan.'" '.$slc.'>'.$row->jabatan.'</option>';
                                                        }
                                                        ?></select>
	                                            </div>
	                                        </div>
									<div class="form-group">
                                            <label for="txtGajiPokok" class="control-label col-lg-4">Gaji Pokok</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Gaji Pokok" name="txtGajiPokok" id="txtGajiPokok" class="form-control money" value="<?php echo rtrim($gaji_pokok); ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtIF" class="control-label col-lg-4">I F</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="I F" name="txtIF" id="txtIF" class="form-control money" value="<?php echo rtrim($i_f); ?>"/>
                                            </div>
                                    </div>

	    <input type="hidden" name="txtIdRiwGaji" value="<?php echo $id_riw_gaji; ?>" /> </div>
                                
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