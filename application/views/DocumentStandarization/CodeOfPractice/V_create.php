<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('DocumentStandarization/COP/create');?>" class="form-horizontal" enctype="multipart/form-data">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('DocumentStandarization/COP/');?>">
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
                                <div class="box-header with-border">Create Code Of Practice</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
											<div class="form-group">
                                                <label for="txtCopNameHeader" class="control-label col-lg-4">Nama Code of Practice</label>
                                                <div class="col-lg-4">
                                                    <input type="text" name="txtCopNameHeader" id="txtCopNameHeader" class="form-control bubbletip-character sensitive-input" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtSopIdHeader" class="control-label col-lg-4">Standard Operating Procedure</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbSOP" name="cmbSOP" class="select2" data-placeholder="Pilih" style="width: 100%" >
                                                        <option value=""></option>
                                                        <?php
                                                            foreach ($daftarSOP as $SOP) 
                                                            {
                                                                echo '  <option value="'.$SOP['id_standard_operating_procedure'].'">
                                                                            '.$SOP['daftar_standard_operating_procedure'].'
                                                                        </option>';
                                                            }
                                                        ?>
                                                    </select>                                                    
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtNoKontrolHeader" class="control-label col-lg-4">Nomor Dokumen</label>
                                                <div class="col-lg-4">
                                                    <input type="text" name="txtNoDocHeader" id="txtNoDocHeader" class="form-control bubbletip-character sensitive-input" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtNoRevisiHeader" class="control-label col-lg-4">Nomor Revisi</label>
                                                <div class="col-lg-4">
                                                    <input type="text" name="txtNoRevisiHeader" id="txtNoRevisiHeader" class="form-control bubbletip-character sensitive-input" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtTanggalHeader" class="control-label col-lg-4">Tanggal Revisi</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" name="txtTanggalHeader" class="date form-control daterangepickersingledate" data-date-format="yyyy-mm-dd" id="txtTanggalHeader" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtJmlHalamanHeader" class="control-label col-lg-4">Jumlah Halaman</label>
                                                <div class="col-lg-4">
                                                    <input type="number" min="0" name="txtJmlHalamanHeader" id="txtJmlHalamanHeader" class="form-control" required="" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtDibuatHeader" class="control-label col-lg-4">Dibuat</label>
                                                <div class="col-lg-4">
                                                     <select id="cmbPekerjaPembuat" name="cmbPekerjaDibuat" class="select2" data-placeholder="Pilih" style="width: 100%" required="">
                                                        <option value=""></option>
                                                        <?php
                                                        /*
                                                            foreach ($pekerjaAll as $Pekerja) 
                                                            {
                                                                echo '  <option value="'.$Pekerja['id_pekerja'].'">'.$Pekerja['daftar_pekerja'].'</option>';
                                                            }
                                                        */
                                                        ?>
                                                    </select>                                                     
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtDiperiksa1Header" class="control-label col-lg-4">Diperiksa 1</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbPekerjaPemeriksa1" name="cmbPekerjaDiperiksa1" class="select2" data-placeholder="Pilih" style="width: 100%" required="">
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtDiperiksa2Header" class="control-label col-lg-4">Diperiksa 2</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbPekerjaPemeriksa2" name="cmbPekerjaDiperiksa2" class="select2" data-placeholder="Pilih" style="width: 100%">
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtDiputuskanHeader" class="control-label col-lg-4">Diputuskan</label>
                                                <div class="col-lg-4">
                                                     <select id="cmbPekerjaPemberiKeputusan" name="cmbPekerjaDiputuskan" class="select2" data-placeholder="Pilih" style="width: 100%" required="">
                                                        <option value=""></option>
                                                    </select> 
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txaCopInfoHeader" class="control-label col-lg-4">Info / Keterangan</label>
                                                <div class="col-lg-7">
                                                    <textarea name="txaCopInfoHeader" id="txaCopInfoHeader" class="form-control ckeditor" ></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtCopFileHeader" class="control-label col-lg-4">Upload File</label>
                                                <div class="col-lg-4">
                                                    <input type="file" name="txtCopFileHeader" id="txtCopFileHeader" class="form-control" />
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