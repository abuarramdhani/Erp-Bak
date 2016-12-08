<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo $action ?>" class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Hutang Karyawan</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/HutangKaryawan/');?>">
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
                                Hutang Karyawan
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
                                            <label for="txtNoHutangNew" class="control-label col-lg-4">Nomor Hutang</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Nomor Hutang" name="txtNoHutangNew" id="txtNoHutangNew" class="form-control" value="<?php echo $no_hutang; ?>" onkeypress="return isNumberKey(event)" maxlength="11" />
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtNoind" class="control-label col-lg-4">No Induk</label>
                                            <div class="col-lg-4">
                                                <select style="width:100%" id="cmbNoind" name="txtNoind" class="select2" data-placeholder="Choose an option" onchange="getMaxHutang($(this).val())"><option value=""></option>
                                                </select>
                                            </div>
                                    </div>
									<div class="form-group">
	                                            <label for="txtTglPengajuan" class="control-label col-lg-4">Tanggal Pengajuan</label>
	                                            <div class="col-lg-4">
	                                                <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTglPengajuan" value="<?php echo $tgl_pengajuan ?>" class="form-control" data-date-format="yyyy-mm-dd" id="txtTglPengajuan" />
	                                            </div>
	                                        </div>
									<div class="form-group">
                                            <label for="txtTotalHutang" class="control-label col-lg-4">Total Hutang</label>
                                            <div class="col-lg-4">
                                                <input type="number" placeholder="Total Hutang" name="txtTotalHutang" id="txtTotalHutang" class="form-control" value="<?php echo $total_hutang; ?>" onkeypress="return isNumberKey(event)" maxlength="10" />
                                            </div>
                                            <div class="col-lg-3" style="padding-top: 0.5em; padding-left: 0">
                                                <i id="max-hutang">* Max 2x Gaji Pokok ()</i>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtJmlCicilan" class="control-label col-lg-4">Jumlah Cicilan</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Jml Cicilan" name="txtJmlCicilan" id="txtJmlCicilan" class="form-control" value="<?php echo $jml_cicilan; ?>" onkeypress="return isNumberKey(event)" maxlength="2" />
                                            </div>
                                    </div>
									<div class="form-group">
	                                            <label for="cmbStatusLunas" class="control-label col-lg-4">Status Lunas</label>
	                                            <div class="col-lg-4">
	                                                <select style="width:100%" id="cmbStatusLunas" name="cmbStatusLunas" class="select2" data-placeholder="Choose an option"><option value=""></option>
                                                        <?php
															$blm='';if(rtrim($status_lunas)==0){$blm='selected';}
															$sdh='';if(rtrim($status_lunas)==1){$sdh='selected';}
														?>
														<option <?php echo $blm ?> value="0">BELUM LUNAS</option><option value=""></option>
                                                        <option <?php echo $sdh ?> value="1">LUNAS</option></select>
	                                            </div>
	                                        </div>
									<div class="form-group">
                                            <label for="txtKodePetugas" class="control-label col-lg-4">Kode Petugas</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Kode Petugas" name="txtKodePetugas" id="txtKodePetugas" class="form-control" value="<?php echo $kode_petugas; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
	                                            <label for="txtTglRecord" class="control-label col-lg-4">Tanggal Record</label>
	                                            <div class="col-lg-4">
	                                                <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTglRecord" value="<?php echo $tgl_record ?>" class="form-control" data-date-format="yyyy-mm-dd" id="txtTglRecord" />
	                                            </div>
	                                        </div>

	    <input type="hidden" name="txtNoHutang" value="<?php echo $no_hutang; ?>" /> </div>
                                
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