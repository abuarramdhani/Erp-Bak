<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo $action ?>" class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Riwayat Tarif Jkk</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/RiwayatTarifJkk/');?>">
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
                                Riwayat Tarif Jkk
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
	                                            <label for="cmbIdKantorAsal" class="control-label col-lg-4">Id Kantor Asal</label>
	                                            <div class="col-lg-4">
	                                                <select id="cmbIdKantorAsal" name="cmbIdKantorAsal" class="select2" data-placeholder="Choose an option"><option value=""></option>
                                                        <?php
                                                        foreach ($pr_kantor_asal_data as $row) {
                                                            $slc = '';
                                                            if (rtrim($row->id_kantor_asal) == rtrim($id_kantor_asal)) {
                                                                $slc = 'selected';
                                                            }
                                                            echo '<option value="'.$row->id_kantor_asal.'" '.$slc.'>'.$row->kantor_asal.'</option>';
                                                        }
                                                        ?></select>
	                                            </div>
	                                        </div>
									<div class="form-group">
	                                            <label for="cmbIdLokasiKerja" class="control-label col-lg-4">Id Lokasi Kerja</label>
	                                            <div class="col-lg-4">
	                                                <select id="cmbIdLokasiKerja" name="cmbIdLokasiKerja" class="select2" data-placeholder="Choose an option"><option value=""></option>
                                                        <?php
                                                        foreach ($pr_lokasi_kerja_data as $row) {
                                                            $slc = '';
                                                            if (rtrim($row->id_lokasi_kerja) == rtrim($id_lokasi_kerja)) {
                                                                $slc = 'selected';
                                                            }
                                                            echo '<option value="'.$row->id_lokasi_kerja.'" '.$slc.'>'.$row->lokasi_kerja.'</option>';
                                                        }
                                                        ?></select>
	                                            </div>
	                                        </div>
									<div class="form-group">
                                            <label for="txtTarifJkk" class="control-label col-lg-4">Tarif Jkk</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Tarif Jkk" name="txtTarifJkk" id="txtTarifJkk" class="form-control" value="<?php echo $tarif_jkk; ?>"/>
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
									<div class="form-group">
                                            <label for="txtStatusAktif" class="control-label col-lg-4">Status Aktif</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Status Aktif" name="txtStatusAktif" id="txtStatusAktif" class="form-control" value="<?php echo $status_aktif; ?>"/>
                                            </div>
                                    </div>

	    <input type="hidden" name="txtIdTarifJkk" value="<?php echo $id_tarif_jkk; ?>" /> </div>
                                
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