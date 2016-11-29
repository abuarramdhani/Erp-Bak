<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo $action ?>" class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Transaksi Hutang</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/TransaksiHutang/');?>">
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
                                Transaksi Hutang
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
                                        <label for="txtIdTransaksiHutangNew" class="control-label col-lg-4">ID Transaksi Hutang</label>
                                        <div class="col-lg-4">
                                            <input type="text" placeholder="ID Transaksi Hutang" name="txtIdTransaksiHutangNew" id="txtIdTransaksiHutangNew" class="form-control" value="<?php echo $id_transaksi_hutang; ?>" onkeypress="return isNumberKey(event)" maxlength="14" />
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtNoHutang" class="control-label col-lg-4">No Hutang</label>
                                        <div class="col-lg-4">
                                            <input type="text" placeholder="No Hutang" name="txtNoHutang" id="txtNoHutang" class="form-control" value="<?php echo $no_hutang; ?>" onkeypress="return isNumberKey(event)" maxlength="11"/>
                                        </div>
                                    </div>
									<div class="form-group">
	                                    <label for="txtTglTransaksi" class="control-label col-lg-4">Tanggal Transaksi</label>
	                                    <div class="col-lg-4">
											<input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTglTransaksi" value="<?php echo $tgl_transaksi ?>" class="form-control" data-date-format="yyyy-mm-dd" id="txtTglTransaksi" />
	                                    </div>
	                                </div>
									<div class="form-group">
	                                    <label for="cmbJenisTransaksi" class="control-label col-lg-4">Jenis Transaksi</label>
	                                    <div class="col-lg-4">
	                                        <select style="width:100%" id="cmbJenisTransaksi" name="cmbJenisTransaksi" class="select2" data-placeholder="Choose an option"><option value=""></option>
                                                <?php
                                                    foreach ($pr_jns_transaksi_data as $row) {
													$slc='';if( rtrim($row->kd_jns_transaksi)==rtrim($jenis_transaksi)){$slc='selected';}
                                                    echo '<option '.$slc.' value="'.$row->kd_jns_transaksi.'">'.$row->jns_transaksi.'</option>';
                                                    }
                                                ?>
											</select>
	                                    </div>
									</div>
									<div class="form-group">
                                        <label for="txtJumlahTransaksi" class="control-label col-lg-4">Jumlah Transaksi</label>
                                        <div class="col-lg-4">
                                            <input type="text" placeholder="Jumlah Transaksi" name="txtJumlahTransaksi" id="txtJumlahTransaksi" class="form-control" value="<?php echo $jumlah_transaksi; ?>" onkeypress="return isNumberKeyAndDot(event)" maxlength="7"/>
                                        </div>
                                    </div>
									<div class="form-group">
	                                    <label for="cmbLunas" class="control-label col-lg-4">Lunas</label>
	                                    <div class="col-lg-4">
	                                        <select style="width:100%" id="cmbLunas" name="cmbLunas" class="select2" data-placeholder="Choose an option"><option value=""></option>
												<?php
													$blm='';if($lunas==0){$blm='selected';}
													$sdh='';if($lunas==1){$sdh='selected';}
												?>
												<option <?php echo $blm?> value="0">BELUM LUNAS</option><option value=""></option>
                                                <option <?php echo $sdh?> value="1">LUNAS</option>
											</select>
	                                    </div>
	                                </div>
									<input type="hidden" name="txtIdTransaksiHutang" value="<?php echo $id_transaksi_hutang; ?>" />
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