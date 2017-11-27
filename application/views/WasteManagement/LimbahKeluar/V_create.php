<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('WasteManagement/LimbahKeluar/create');?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('WasteManagement/LimbahKeluar/');?>">
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
                                <div class="box-header with-border">Create Limbah Keluar</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="cmbJenisLimbahKeluarHeader" class="control-label col-lg-4">Jenis Limbah</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbJenisLimbahKeluarHeader" name="cmbJenisLimbahKeluarHeader" class="select2" data-placeholder="Choose an option" style="width: 100%" required>
                                                        <option value=""></option>
                                                        <?php foreach ($jenis_limbah as $limbah) { ?>
                                                        <option value="<?php echo $limbah['id_jenis_limbah']; ?>"><?php echo $limbah['jenis_limbah']; ?></option>
                                                        <?php }?> 
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="cmbSatuanheader" class="control-label col-lg-4">Satuan</label>
                                                <div class="col-lg-4">
                                                    <input type="text" name="cmbSatuanHeader" class="form-control" id="SatuanLimbahKeluar" readonly>
                                                </div>
                                            </div>
                                            <!-- lah gak ada cmbJenisSumberHeader -->
                                            <div class="form-group">
                                                <label for="cmbJenisSumberHeader" class="control-label col-lg-4">Jenis Sumber</label>
                                                <div class="col-lg-4">
                                                    <input type="text" name="cmbJenisSumberHeader" class="form-control" id="SumberLimbahKeluar" readonly>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="cmbPerlakuanHeader" class="control-label col-lg-4">Perlakuan</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbPerlakuanHeader" name="cmbPerlakuanHeader" class="select select2" data-placeholder="Choose an option" style="width: 100%">
                                                        <option value=""></option>
                                                        <?php foreach ($perlakuan as $plkn) { ?>
                                                        <option value="<?php echo $plkn['id_perlakuan']; ?>"><?php echo $plkn['limbah_perlakuan'];?></option>
                                                        <?php }?> 
                                                    </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtTanggalKeluarHeader" class="control-label col-lg-4">Tanggal Keluar</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('d M Y')?>" name="txtTanggalKeluarHeader" class="date form-control" data-date-format="yyyy-mm-dd" id="txtTanggalKeluarHeader" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtJumlahKeluarHeader" class="control-label col-lg-4">Jumlah Keluar</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Jumlah Keluar" name="txtJumlahKeluarHeader" id="txtJumlahKeluarHeader" class="form-control" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtTujuanLimbahHeader" class="control-label col-lg-4">Tujuan Limbah</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Tujuan Limbah" name="txtTujuanLimbahHeader" id="txtTujuanLimbahHeader" class="form-control" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtNomorDokHeader" class="control-label col-lg-4">Nomor Dok</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Nomor Dok" name="txtNomorDokHeader" id="txtNomorDokHeader" class="form-control" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtSisaLimbahHeader" class="control-label col-lg-4">Sisa Limbah</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Sisa Limbah" name="txtSisaLimbahHeader" id="txtSisaLimbahHeader" class="form-control" />
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