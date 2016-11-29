<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo $action ?>" class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Set Asuransi</b></h1>

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
                                Set Asuransi
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
	                                                <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTglBerlaku" value="<?php echo $tgl_berlaku ?>" class="form-control" data-date-format="yyyy-mm-dd" id="txtTglBerlaku" />
	                                            </div>
	                                        </div>
									<div class="form-group">
	                                            <label for="txtTglTberlaku" class="control-label col-lg-4">Tanggal Tberlaku</label>
	                                            <div class="col-lg-4">
	                                                <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTglTberlaku" value="<?php echo $tgl_tberlaku ?>" class="form-control" data-date-format="yyyy-mm-dd" id="txtTglTberlaku" />
	                                            </div>
	                                        </div>
									<div class="form-group">
	                                            <label for="cmbKdStatusKerja" class="control-label col-lg-4">Status Kerja</label>
	                                            <div class="col-lg-4">
	                                                <select style="width:100%"  id="cmbKdStatusKerja" name="cmbKdStatusKerja" class="select2" data-placeholder="Choose an option"><option value=""></option>
                                                        <?php
                                                        foreach ($pr_master_status_kerja_data as $row) {
															$slc='';if($row->kd_status_kerja==$kd_status_kerja){$slc='selected';}
                                                            echo '<option '.$slc.' value="'.$row->kd_status_kerja.'">'.$row->status_kerja.'</option>';
                                                        }
                                                        ?></select>
	                                            </div>
	                                        </div>
									<div class="form-group">
                                            <label for="txtJkk" class="control-label col-lg-4">JKK</label>
                                            <div class="col-lg-4">
												<select style="width:100%" id="txtJkk" name="txtJkk" class="select2" data-placeholder="Choose an option"><option value=""></option>
													<?php
														$yes='';if($jkk==1){$yes='selected';}
														$not='';if($jkk==0){$not='selected';}
													?>
													<option <?php echo $yes?> value="1">YA</option>
													<option <?php echo $not?> value="0">TIDAK</option>
												</select>
											</div>
                                    </div>
									<div class="form-group">
                                            <label for="txtJkm" class="control-label col-lg-4">JKM</label>
                                            <div class="col-lg-4">
												<select style="width:100%" id="txtJkm" name="txtJkm" class="select2" data-placeholder="Choose an option"><option value=""></option>
													<?php
														$yes='';if($jkm==1){$yes='selected';}
														$not='';if($jkm==0){$not='selected';}
													?>
													<option <?php echo $yes?> value="1">YA</option>
													<option <?php echo $not?> value="0">TIDAK</option>
												</select>
											</div>
                                    </div>
									<div class="form-group">
                                            <label for="txtJhtKary" class="control-label col-lg-4">JHT Karyawan</label>
                                            <div class="col-lg-4">
                                                <select style="width:100%" id="txtJhtKary" name="txtJhtKary" class="select2" data-placeholder="Choose an option"><option value=""></option>
													<?php
														$yes='';if($jht_kary==1){$yes='selected';}
														$not='';if($jht_kary==0){$not='selected';}
													?>
													<option <?php echo $yes?> value="1">YA</option>
													<option <?php echo $not?> value="0">TIDAK</option>
												</select>
											</div>
                                    </div>
									<div class="form-group">
                                            <label for="txtJhtPrshn" class="control-label col-lg-4">JHT Perusahaan</label>
                                            <div class="col-lg-4">
                                                <select style="width:100%" id="txtJhtPrshn" name="txtJhtPrshn" class="select2" data-placeholder="Choose an option"><option value=""></option>
													<?php
														$yes='';if($jht_prshn==1){$yes='selected';}
														$not='';if($jht_prshn==0){$not='selected';}
													?>
													<option <?php echo $yes?> value="1">YA</option>
													<option <?php echo $not?> value="0">TIDAK</option>
												</select>
											</div>
                                    </div>
									<div class="form-group">
                                            <label for="txtJknKary" class="control-label col-lg-4">JKN Karyawan</label>
                                            <div class="col-lg-4">
												<select style="width:100%" id="txtJknKary" name="txtJknKary" class="select2" data-placeholder="Choose an option"><option value=""></option>
													<?php
														$yes='';if($jkn_kary==1){$yes='selected';}
														$not='';if($jkn_kary==0){$not='selected';}
													?>
													<option <?php echo $yes?> value="1">YA</option>
													<option <?php echo $not?> value="0">TIDAK</option>
												</select>
											</div>
                                    </div>
									<div class="form-group">
                                            <label for="txtJknPrshn" class="control-label col-lg-4">JKN Perusahaan</label>
                                            <div class="col-lg-4">
												<select style="width:100%" id="txtJknPrshn" name="txtJknPrshn" class="select2" data-placeholder="Choose an option"><option value=""></option>
													<?php
														$yes='';if($jkn_prshn==1){$yes='selected';}
														$not='';if($jkn_prshn==0){$not='selected';}
													?>
													<option <?php echo $yes?> value="1">YA</option>
													<option <?php echo $not?> value="0">TIDAK</option>
												</select>
											</div>
                                    </div>
									<div class="form-group">
                                            <label for="txtJpnKary" class="control-label col-lg-4">JPN Karyawan</label>
                                            <div class="col-lg-4">
                                                <select style="width:100%" id="txtJpnKary" name="txtJpnKary" class="select2" data-placeholder="Choose an option"><option value=""></option>
													<?php
														$yes='';if($jpn_kary==1){$yes='selected';}
														$not='';if($jpn_kary==0){$not='selected';}
													?>
													<option <?php echo $yes?> value="1">YA</option>
													<option <?php echo $not?> value="0">TIDAK</option>
												</select>
											</div>
                                    </div>
									<div class="form-group">
                                            <label for="txtJpnPrshn" class="control-label col-lg-4">JPN Perusahaan</label>
                                            <div class="col-lg-4">
												<select style="width:100%" id="txtJpnPrshn" name="txtJpnPrshn" class="select2" data-placeholder="Choose an option"><option value=""></option>
													<?php
														$yes='';if($jpn_prshn==1){$yes='selected';}
														$not='';if($jpn_prshn==0){$not='selected';}
													?>
													<option <?php echo $yes?> value="1">YA</option>
													<option <?php echo $not?> value="0">TIDAK</option>
												</select>
											</div>
                                    </div>
									<div class="form-group">
                                            <label for="txtKdPetugas" class="control-label col-lg-4">Kode Petugas</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Kd Petugas" name="txtKdPetugas" id="txtKdPetugas" class="form-control" value="<?php echo $kd_petugas; ?>" onkeypress="return isNumberKey(event)" maxlength="7" />
                                            </div>
                                    </div>
									<input type="hidden" name="txtTglRec" value="<?php echo $tgl_rec ?>" />
	                                <input type="hidden" name="txtIdSetAsuransi" value="<?php echo $id_set_asuransi; ?>" />
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