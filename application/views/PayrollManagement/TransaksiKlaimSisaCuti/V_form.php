<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo $action ?>" class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Transaksi Klaim Sisa Cuti</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/TransaksiKlaimSisaCuti/');?>">
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
                                Transaksi Klaim Sisa Cuti
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
                                            <label for="txtNoind" class="control-label col-lg-4">No induk</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Noind" name="txtNoind" id="txtNoind" class="form-control" value="<?php echo $noind; ?>" onkeypress="return isNumberKey(event)" maxlength="7"/>
                                            </div>
                                    </div>
									<div class="form-group">
	                                        <label for="txtPeriode" class="control-label col-lg-4">Periode</label>
	                                        <div class="col-lg-4">
	                                            <input type="text" placeholder="<?php echo date('Y-m')?>" name="txtPeriode" value="<?php echo $periode ?>" class="form-control" onkeypress="return isNumberKeyAndStrip(event)" maxlength="7"/>
	                                        </div>
	                                </div>
									<div class="form-group">
                                            <label for="txtSisaCuti" class="control-label col-lg-4">Sisa Cuti</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Sisa Cuti" name="txtSisaCuti" id="txtSisaCuti" class="form-control" value="<?php echo $sisa_cuti; ?>" onkeypress="return isNumberKey(event)" maxlength="2"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtJumlahKlaim" class="control-label col-lg-4">Jumlah Klaim</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Jumlah Klaim" name="txtJumlahKlaim" id="txtJumlahKlaim" class="form-control" value="<?php echo $jumlah_klaim; ?>" onkeypress="return isNumberKey(event)" maxlength="15"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtKodePetugas" class="control-label col-lg-4">Kode Petugas</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Kode Petugas" name="txtKodePetugas" id="txtKodePetugas" class="form-control" value="<?php echo $kode_petugas; ?>" onkeypress="return isNumberKey(event)" maxlength="7"/>
                                            </div>
                                    </div>
									<div class="form-group">
	                                            <label for="cmbKdJnsTransaksi" class="control-label col-lg-4">Jenis Transaksi</label>
	                                            <div class="col-lg-4">
	                                                <select id="cmbKdJnsTransaksi" name="cmbKdJnsTransaksi" class="select2" data-placeholder="Choose an option"><option value=""></option>
                                                        <?php
                                                        foreach ($pr_jns_transaksi_data as $row) {
															$slc='';if($row->kd_jns_transaksi==6){$slc='selected';}
                                                            echo '<option '.$slc.' value="'.$row->kd_jns_transaksi.'">'.$row->jns_transaksi.'</option>';
                                                        }
                                                        ?></select>
	                                            </div>
	                                        </div>

	    <input type="hidden" name="txtIdCuti" value="<?php echo $id_cuti; ?>" /> </div>
                                
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