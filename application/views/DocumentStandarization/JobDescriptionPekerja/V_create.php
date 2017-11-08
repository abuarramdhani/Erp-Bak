<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('DocumentStandarization/JobDescriptionPekerja/create');?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('DocumentStandarization/JobDescriptionPekerja/');?>">
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
                                <div class="box-header with-border">Create Jobdesk Employee</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="cmbDepartemen-DocumentJobDesc" class="control-label col-lg-4">Departemen</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbDepartemen-DocumentJobDesc" name="cmbDepartemen" class="select2" data-placeholder="Pilih" style="width: 100%" required="">
                                                        <option value=""></option>
                                                        <?php
                                                            foreach ($ambilDepartemen as $Departemen) 
                                                            {
                                                                echo '  <option value="'.$Departemen['kode_departemen'].'">
                                                                            '.$Departemen['nama_departemen'].'
                                                                        </option>';
                                                            }
                                                        ?>
                                                    </select>   
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="cmbBidang-DocumentJobDesc" class="control-label col-lg-4">Bidang</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbBidang-DocumentJobDesc" name="cmbBidang" class="select2" data-placeholder="Pilih" style="width: 100%">
                                                        <option value=""></option>
                                                    </select>   
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="cmbUnit-DocumentJobDesc" class="control-label col-lg-4">Unit</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbUnit-DocumentJobDesc" name="cmbUnit" class="select2" data-placeholder="Pilih" style="width: 100%">
                                                        <option value=""></option>
                                                    </select>   
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="cmbSeksi-DocumentJobDesc" class="control-label col-lg-4">Seksi</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbSeksi-DocumentJobDesc" name="cmbSeksi" class="select2" data-placeholder="Pilih" style="width: 100%">
                                                        <option value=""></option>
                                                    </select>   
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="cmbPekerja-JobDesc" class="control-label col-lg-4">Pekerja</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbPekerja-JobDesc" name="cmbPekerja-JobDesc" class="select2" data-placeholder="Pilih" style="width: 100%" required="">
                                                        <option value=""></option>
                                                    </select>   
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="cmbJD" class="control-label col-lg-4">Job Description</label>
                                                <div class="col-lg-4">
                                                    <select name="cmbJD" id="cmbJD" class="select2" required="" data-placeholder="Pilih" style="width: 100%">
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-lg-12">
                                            <br />
                                            <br />
                                            <div class="row">
                                                <div class="nav-tabs-custom">
                                                    <ul class="nav nav-tabs">
                                                    </ul>
                                                    <div class="tab-content">
                                                    </div>
                                                </div>
                                            </div>
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