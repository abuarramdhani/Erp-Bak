<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('DocumentStandarization/MasterJobDescription/create');?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('DocumentStandarization/MasterJobDescription/');?>">
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
                                <div class="box-header with-border">Create Jobdesk</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">

                                            <div class="form-group">
                                                <label for="txtKodesieHeader" class="control-label col-lg-4">Departemen</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbDepartemen" name="cmbDepartemen" class="select2" data-placeholder="Pilih" style="width: 100%" required="">
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
                                                <label for="txtKodesieHeader" class="control-label col-lg-4">Bidang</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbBidang" name="cmbBidang" class="select2" data-placeholder="Pilih" style="width: 100%">
                                                        <option value=""></option>
                                                    </select>   
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtKodesieHeader" class="control-label col-lg-4">Unit</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbUnit" name="cmbUnit" class="select2" data-placeholder="Pilih" style="width: 100%">
                                                        <option value=""></option>
                                                    </select>   
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtKodesieHeader" class="control-label col-lg-4">Seksi</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbSeksi" name="cmbSeksi" class="select2" data-placeholder="Pilih" style="width: 100%">
                                                        <option value=""></option>
                                                    </select>   
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtJdNameHeader" class="control-label col-lg-4">Job Desk</label>
                                                <div class="col-lg-4">
                                                    <input type="text" style="text-transform: uppercase;" name="txtJdNameHeader" id="txtJdNameHeader" class="form-control" required="" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txaJdDetailHeader" class="control-label col-lg-4">Tugas Utama</label>
                                                <div class="col-lg-7">
                                                    <textarea name="txaJdDetailHeader" id="txaJdDetailHeader" class="form-control ckeditor" required=""></textarea>
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