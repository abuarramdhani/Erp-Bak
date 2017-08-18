<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('GeneralAffair/LimbahTransaksi/create');?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('GeneralAffair/LimbahTransaksi/');?>">
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
                                <div class="box-header with-border">Create Limbah Masuk</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
											<div class="form-group">
                                                <label for="txtTanggalTransaksiHeader" class="control-label col-lg-4">Tanggal Masuk</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('d M Y')?>" name="txtTanggalTransaksiHeader" class="date form-control" data-date-format="yyyy-mm-dd" id="txtTanggalTransaksiHeader" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="cmbJenisLimbahHeader" class="control-label col-lg-4">Jenis Limbah</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbJenisLimbahHeader" name="cmbJenisLimbahHeader" class="select select2" data-placeholder="Choose an option" style="width: 100%">
                                                        <option value=""></option>
                                                        <?php foreach ($jenis_limbah as $limbah) { ?>
                                                        <option value="<?php echo $limbah['id_jenis_limbah']; ?>"><?php echo $limbah['jenis_limbah']; ?></option>
                                                        <?php }?> 
                                                    </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="cmbSumberLimbahHeader" class="control-label col-lg-4">Sumber Limbah</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbSumberLimbahHeader" name="cmbSumberLimbahHeader" class="select select2" data-placeholder="Choose an option" style="width: 100%">
                                                        <option value=""></option>
                                                        <?php foreach ($getSeksi as $seksi) { ?>
                                                        <option value="<?php echo $seksi['seksi_id']; ?>"><?php echo $seksi['nama_seksi']; ?></option>
                                                        <?php }?> 
                                                    </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="cmbJenisSumberHeader" class="control-label col-lg-4">Jenis Sumber</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbJenisSumberHeader" name="cmbJenisSumberHeader" class="select select2" data-placeholder="Choose an option" style="width: 100%">
                                                        <option value=""></option>
                                                        <option value="1">Proses Produksi</option>
                                                        <option value="0">Diluar Proses Produksi</option>
                                                    </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="cmbSatuanHeader" class="control-label col-lg-4">Satuan</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbSatuanHeader" name="cmbSatuanHeader" class="select select2" data-placeholder="Choose an option" style="width: 100%">
                                                        <option value=""></option>
                                                        <option value="1">TON</option>
                                                        <option value="0">PCS</option>
                                                    </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtJumlahHeader" class="control-label col-lg-4">Jumlah</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Jumlah" name="txtJumlahHeader" id="txtJumlahHeader" class="form-control" />
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
                                                <label for="txtMaksPenyimpananHeader" class="control-label col-lg-4">Maks Penyimpanan</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('d M Y')?>" name="txtMaksPenyimpananHeader" class="date form-control" data-date-format="yyyy-mm-dd" id="txtMaksPenyimpananHeader" />
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