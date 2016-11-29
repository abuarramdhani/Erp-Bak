<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo $action ?>" class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Transaksi Hitung THR</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/TransaksiHitungThr/');?>">
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
                                Transaksi Hitung THR
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
	                                            <label for="txtTanggal" class="control-label col-lg-4">Tanggal</label>
	                                            <div class="col-lg-4">
	                                                <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTanggal" value="<?php echo $tanggal ?>" class="form-control" data-date-format="yyyy-mm-dd" id="txtTanggal" />
	                                            </div>
	                                        </div>
									<div class="form-group">
                                            <label for="txtPeriode" class="control-label col-lg-4">Periode</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Periode" name="txtPeriode" id="txtPeriode" class="form-control" value="<?php echo $periode; ?>" onkeypress="return isNumberKeyAndStrip(event)" maxlength="7"//>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtNoind" class="control-label col-lg-4">No Induk</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Noind" name="txtNoind" id="txtNoind" class="form-control" value="<?php echo $noind; ?>" onkeypress="return isNumberKey(event)" maxlength="7"//>
                                            </div>
                                    </div>
									<div class="form-group">
	                                            <label for="cmbKdStatusKerja" class="control-label col-lg-4">Status Kerja</label>
	                                            <div class="col-lg-4">
	                                                <select id="cmbKdStatusKerja" name="cmbKdStatusKerja" class="select2" data-placeholder="Choose an option"><option value=""></option>
                                                        <?php
                                                        foreach ($pr_master_status_kerja_data as $row) {
															$slc='';if($row->kd_status_kerja==$kd_status_kerja){$slc='selected';}
                                                            echo '<option '.$slc.' value="'.$row->kd_status_kerja.'">'.$row->status_kerja.'</option>';
                                                        }
                                                        ?></select>
	                                            </div>
	                                        </div>
									<div class="form-group">
	                                            <label for="txtDiangkat" class="control-label col-lg-4">Diangkat</label>
	                                            <div class="col-lg-4">
	                                                <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtDiangkat" value="<?php echo $diangkat ?>" class="form-control" data-date-format="yyyy-mm-dd" id="txtDiangkat" />
	                                            </div>
	                                        </div>
									<div class="form-group">
                                            <label for="txtLamaThn" class="control-label col-lg-4">Lama Tahun</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Lama Thn" name="txtLamaThn" id="txtLamaThn" class="form-control increment-form" value="<?php echo $lama_thn; ?>" onkeypress="return isNumberKey(event)" maxlength="7"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtLamaBln" class="control-label col-lg-4">Lama Bulan</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Lama Bln" name="txtLamaBln" id="txtLamaBln" class="form-control increment-form" value="<?php echo $lama_bln; ?>" onkeypress="return isNumberKey(event)" maxlength="7"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtGajiPokok" class="control-label col-lg-4">Gaji Pokok</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Gaji Pokok" name="txtGajiPokok" id="txtGajiPokok" class="form-control" value="<?php echo $gaji_pokok; ?>" onkeypress="return isNumberKeyAndDot(event)" maxlength="7"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtThr" class="control-label col-lg-4">THR</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Thr" name="txtThr" id="txtThr" class="form-control" value="<?php echo $thr; ?>" onkeypress="return isNumberKeyAndDot(event)" maxlength="7"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtPersentaseUbthr" class="control-label col-lg-4">Persentase Ubthr</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Persentase Ubthr" name="txtPersentaseUbthr" id="txtPersentaseUbthr" class="form-control" value="<?php echo $persentase_ubthr; ?>" onkeypress="return isNumberKey(event)" maxlength="7" />
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtUbthr" class="control-label col-lg-4">UBTHR</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Ubthr" name="txtUbthr" id="txtUbthr" class="form-control" value="<?php echo $ubthr; ?>" onkeypress="return isNumberKey(event)" maxlength="7"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtKodePetugas" class="control-label col-lg-4">Kode Petugas</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Kode Petugas" name="txtKodePetugas" id="txtKodePetugas" class="form-control" value="<?php echo $kode_petugas; ?>" onkeypress="return isNumberKey(event)" maxlength="7"/>
                                            </div>
                                    </div>

	    <input type="hidden" name="txtIdTransaksiThr" value="<?php echo $id_transaksi_thr; ?>" /> </div>
                                
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