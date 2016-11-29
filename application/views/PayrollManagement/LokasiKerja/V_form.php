<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo $action ?>" class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Lokasi Kerja</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/LokasiKerja/');?>">
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
                                Lokasi Kerja
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
                                        <label for="txtIdLokasiKerjaNew" class="control-label col-lg-4">Id Lokasi Kerja</label>
                                        <div class="col-lg-4">
                                            <input type="text" placeholder="Lokasi Kerja" name="txtIdLokasiKerjaNew" id="txtIdLokasiKerjaNew" class="form-control" value="<?php echo $id_lokasi_kerja; ?>" maxlength="2"/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtLokasiKerja" class="control-label col-lg-4">Lokasi Kerja</label>
                                        <div class="col-lg-4">
                                            <input type="text" placeholder="Lokasi Kerja" name="txtLokasiKerja" id="txtLokasiKerja" class="form-control" value="<?php echo $lokasi_kerja; ?>"  maxlength="50"/>
                                        </div>
                                    </div>
									<input type="hidden" name="txtIdLokasiKerja" value="<?php echo $id_lokasi_kerja; ?>" />
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