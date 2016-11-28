<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo $action ?>" class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Set Tarif Pekerja Sakit</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/SetTarifPekerjaSakit/');?>">
                                        <i class="icon-wrench icon-2x"></i>
                                        <span><br/></span>
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
                                Set Tarif Pekerja Sakit
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
                                        <label for="txtTingkatan" class="control-label col-lg-4">Tingkatan</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtTingkatan" id="txtTingkatan" class="form-control" value="<?php echo $tingkatan; ?>" maxlength="2"/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtBulanAwal" class="control-label col-lg-4">Bulan Awal</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtBulanAwal" id="txtBulanAwal" class="form-control" value="<?php echo $bulan_awal; ?>" maxlength="2"/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtBulanAkhir" class="control-label col-lg-4">Bulan Akhir</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtBulanAkhir" id="txtBulanAkhir" class="form-control" value="<?php echo $bulan_akhir; ?>" maxlength="2"/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtPersentase" class="control-label col-lg-4">Persentase</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtPersentase" id="txtPersentase" class="form-control" value="<?php echo $persentase; ?>" maxlength="5"/>
                                        </div>
                                    </div>
									<input type="hidden" name="txtKdTarif" value="<?php echo $kd_tarif; ?>" />
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