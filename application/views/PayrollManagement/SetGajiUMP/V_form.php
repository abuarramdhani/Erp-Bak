<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo $action ?>" class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Set Gaji UMP</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/SetGajiUMP/');?>">
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
                                Set Gaji UMP
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
	                                            <label for="txtLokasiKerja" class="control-label col-lg-4">Lokasi Kerja</label>
	                                            <div class="col-lg-4">
	                                                <select style="width:100%"  id="txtLokasiKerja" name="txtLokasiKerja" class="select2" data-placeholder="Choose an option"><option value=""></option>
                                                        <?php
                                                        foreach ($pr_lokasi_kerja_data as $row) {
															$slc='';if(str_replace(" ","",$row->id_lokasi_kerja)==str_replace(" ","",$id_lokasi_kerja)){$slc='selected';}
                                                            echo '<option '.$slc.' value="'.$row->id_lokasi_kerja.'">'.$row->lokasi_kerja.'</option>';
                                                        }
                                                        ?></select>
	                                            </div>
	                                        </div>
									<div class="form-group">
                                        <label for="txtUMP" class="control-label col-lg-4">UMP</label>
                                        <div class="col-lg-4">
                                            <input type="text" placeholder="Status Kerja" name="txtUMP" id="txtUMP" class="form-control money" onkeypress="return isNumberKey(event)" value="<?php echo $ump; ?>" maxlength="15"/>
                                        </div>
                                    </div>
									<input type="hidden" name="txtKodeUMP" value="<?php echo $kode_ump; ?>" />
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