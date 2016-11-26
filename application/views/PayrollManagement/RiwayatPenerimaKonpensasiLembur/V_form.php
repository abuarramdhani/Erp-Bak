<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo $action ?>" class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Set Penerima Konpensasi Lembur</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/RiwayatPenerimaKonpensasiLembur/');?>">
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
                                Set Penerima Konpensasi Lembur
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
	                                    <label for="cmbIdKantorAsal" class="control-label col-lg-4">Kantor Asal</label>
	                                    <div class="col-lg-4">
	                                        <select id="cmbIdKantorAsal" name="cmbIdKantorAsal" class="select2" data-placeholder="Choose an option"><option value=""></option>
                                                <?php
													foreach ($pr_kantor_asal_data as $row) {
														$slc='';if($row->id_kantor_asal==$id_kantor_asal){$slc='selected';}
														echo '<option '.$slc.' value="'.$row->id_kantor_asal.'">'.$row->kantor_asal.'</option>';
													}
                                                ?>
											</select>
	                                    </div>
	                                </div>
									<div class="form-group">
	                                    <label for="cmbIdLokasiKerja" class="control-label col-lg-4">Lokasi Kerja</label>
	                                    <div class="col-lg-4">
											<select id="cmbIdLokasiKerja" name="cmbIdLokasiKerja" class="select2" data-placeholder="Choose an option"><option value=""></option>
												<?php
													foreach ($pr_lokasi_kerja_data as $row) {
													$slc2='';if($row->id_lokasi_kerja==$id_lokasi_kerja){$slc2='selected';}
													echo '<option '.$slc2.' value="'.$row->id_lokasi_kerja.'">'.$row->lokasi_kerja.'</option>';
													}
												?>
											</select>
	                                    </div>
	                                </div>
									<div class="form-group">
	                                            <label for="cmbKdStatusKerja" class="control-label col-lg-4">Status Kerja</label>
	                                            <div class="col-lg-4">
	                                                <select id="cmbKdStatusKerja" name="cmbKdStatusKerja" class="select2" data-placeholder="Choose an option"><option value=""></option>
                                                        <?php
                                                        foreach ($pr_master_status_kerja_data as $row) {
															$slc3='';if($row->kd_status_kerja==$kd_status_kerja){$slc3='selected';}
                                                            echo '<option '.$slc3.' value="'.$row->kd_status_kerja.'">'.$row->status_kerja.'</option>';
                                                        }
                                                        ?></select>
	                                            </div>
	                                        </div>
									<div class="form-group">
	                                            <label for="cmbKdJabatan" class="control-label col-lg-4">Jabatan</label>
	                                            <div class="col-lg-4">
	                                                <select id="cmbKdJabatan" name="cmbKdJabatan" class="select2" data-placeholder="Choose an option"><option value=""></option>
                                                        <?php
                                                        foreach ($pr_master_jabatan_data as $row) {
															$slc4='';if($row->kd_jabatan==$kd_jabatan){$slc4='selected';}
                                                            echo '<option '.$slc4.' value="'.$row->kd_jabatan.'">'.$row->jabatan.'</option>';
                                                        }
                                                        ?></select>
	                                            </div>
	                                        </div>
									<div class="form-group">
                                            <label for="txtMinMasaKerja" class="control-label col-lg-4">Min Masa Kerja</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Min Masa Kerja" name="txtMinMasaKerja" id="txtMinMasaKerja" class="form-control" onkeypress="return isNumberKey(event)" value="<?php echo $min_masa_kerja; ?>" maxlength="2"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtProsentase" class="control-label col-lg-4">Prosentase</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Prosentase" name="txtProsentase" id="txtProsentase" class="form-control" onkeypress="return isNumberKey(event)" value="<?php echo $prosentase; ?>" maxlength="5"/>
                                            </div>
                                    </div>
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
                                            <label for="txtKodePetugas" class="control-label col-lg-4">Kode Petugas</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Kode Petugas" name="txtKodePetugas" id="txtKodePetugas" class="form-control" value="<?php echo $kode_petugas; ?>" maxlength="7"/>
                                            </div>
                                    </div>
									<div class="form-group">
	                                            <label for="txtTglRecord" class="control-label col-lg-4">Tgl Record</label>
	                                            <div class="col-lg-4">
	                                                <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTglRecord" value="<?php echo $tgl_record ?>" class="form-control" data-date-format="yyyy-mm-dd" id="txtTglRecord" />
	                                            </div>
	                                        </div>

	    <input type="hidden" name="txtIdRiwayat" value="<?php echo $id_riwayat; ?>" /> </div>
                                
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