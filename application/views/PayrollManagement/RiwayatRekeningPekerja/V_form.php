<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo $action ?>" class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Riwayat Rekening Pekerja</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/RiwayatRekeningPekerja/');?>">
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
                                Riwayat Rekening Pekerja
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
	                                                <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTglBerlaku" value="<?php echo $tgl_berlaku ?>" class="form-control class-datepicker-erp-pr" data-date-format="yyyy-mm-dd" id="txtTglBerlaku" />
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
	                                            <label for="cmbKdBank" class="control-label col-lg-4">Kd Bank <?php echo $kd_bank; ?></label>
	                                            <div class="col-lg-2">
	                                                <select id="cmbKdBank" name="cmbKdBank" class="form-control select2" data-placeholder="Choose an option"><option value=""></option>
                                                        <?php
                                                        foreach ($pr_master_bank_data as $row) {
                                                            $slc = '';
                                                            if ($row->kd_bank_induk == $kd_bank) {
                                                                $slc = 'selected';
                                                            }
                                                            echo '<option value="'.$row->kd_bank_induk.'" '.$slc.'>'.$row->kd_bank_induk.'</option>';
                                                        }
                                                        ?></select>
	                                            </div>
	                                        </div>
									<div class="form-group">
                                            <label for="txtNoRekening" class="control-label col-lg-4">No Rekening</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="No Rekening" name="txtNoRekening" id="txtNoRekening" class="form-control" value="<?php echo $no_rekening; ?>"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtNamaPemilikRekening" class="control-label col-lg-4">Nama Pemilik Rekening</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Nama Pemilik Rekening" name="txtNamaPemilikRekening" id="txtNamaPemilikRekening" class="form-control text-uppercase" value="<?php echo $nama_pemilik_rekening; ?>"/>
                                            </div>
                                    </div>
	    <input type="hidden" name="txtIdRiwRekPkj" value="<?php echo $id_riw_rek_pkj; ?>" /> </div>
                                
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