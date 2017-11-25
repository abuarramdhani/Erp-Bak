<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('WasteManagement/LimbahKeluar/update/'.$id);?>" class="form-horizontal">
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
                                <div class="box-header with-border">Update Limbah Keluar</div>
                                <?php
                                    foreach ($LimbahKeluar as $headerRow):
                                ?>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
											<div class="form-group">
                                                <label for="txtTanggalKeluarHeader" class="control-label col-lg-4">Tanggal Keluar</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTanggalKeluarHeader" value="<?php echo date('d M Y',strtotime($headerRow['tanggal_keluar'])) ;?>" class="date form-control" data-date-format="yyyy-mm-dd" id="txtTanggalKeluarHeader" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtJumlahKeluarHeader" class="control-label col-lg-4">Jumlah Keluar</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Jumlah Keluar" name="txtJumlahKeluarHeader" id="txtJumlahKeluarHeader" class="form-control" value="<?php echo $headerRow['jumlah_keluar']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtTujuanLimbahHeader" class="control-label col-lg-4">Tujuan Limbah</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Tujuan Limbah" name="txtTujuanLimbahHeader" id="txtTujuanLimbahHeader" class="form-control" value="<?php echo $headerRow['tujuan_limbah']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtNomorDokHeader" class="control-label col-lg-4">Nomor Dok</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Nomor Dok" name="txtNomorDokHeader" id="txtNomorDokHeader" class="form-control" value="<?php echo $headerRow['nomor_dok']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtSisaLimbahHeader" class="control-label col-lg-4">Sisa Limbah</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Sisa Limbah" name="txtSisaLimbahHeader" id="txtSisaLimbahHeader" class="form-control" value="<?php echo $headerRow['sisa_limbah']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="cmbJenisLimbahHeader" class="control-label col-lg-4">Jenis Limbah</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbJenisLimbahHeader" name="cmbJenisLimbahHeader" class="select select2" data-placeholder="Choose an option" style="width: 100%">
                                                        <option value=""></option>
                                                        <?php foreach ($jenis_limbah as $limbah) { ?>
                                                        <option value="<?php echo $limbah['id_jenis_limbah']; ?>" <?php if($limbah['id_jenis_limbah']==$headerRow['jenis_limbah']) echo "selected"; ?>><?php echo $limbah['jenis_limbah']; ?></option>
                                                        <?php }?> 
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="cmbPerlakuanHeader" class="control-label col-lg-4">Perlakuan</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbPerlakuanHeader" name="cmbPerlakuanHeader" class="select select2" data-placeholder="Choose an option" style="width: 100%">
                                                        <option value=""></option>
                                                        <?php foreach ($perlakuan as $plkn) { ?>
                                                        <option value="<?php echo $plkn['id_perlakuan']; ?>" <?php if($plkn['id_perlakuan']==$headerRow['perlakuan']) {echo "selected";} ?>><?php echo $plkn['limbah_perlakuan']; ?>
                                                        </option>
                                                        <?php }?> 
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="cmbSatuanHeader" class="control-label col-lg-4">Satuan</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbSatuanHeader" name="cmbSatuanHeader" class="select select2" data-placeholder="Choose an option" style="width: 100%">
                                                        <option value=""></option>
                                                        <?php foreach ($satuan as $stn) { ?>
                                                        <option value="<?php echo $stn['id_satuan']; ?>" <?php if($stn['id_satuan']==$headerRow['satuan']) {echo "selected";} ?>><?php echo $stn['limbah_satuan']; ?>
                                                        </option>
                                                        <?php }?> 
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
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>