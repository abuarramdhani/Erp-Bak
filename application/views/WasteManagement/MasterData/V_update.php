<style>
 #txtAjaxSatuanLimbah{
   text-transform: capitalize;
 }
</style>
<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('WasteManagement/MasterData/update/'.$id);?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('WasteManagement/MasterData/');?>">
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
                                <div class="box-header with-border">Update Limbah Jenis</div>
                                <?php
                                    foreach ($LimbahJenis as $headerRow):
                                ?>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Id Jenis Limbah</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Jenis Limbah" class="form-control" value="<?php echo $headerRow['id_jenis_limbah']; ?>" disabled/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtKodeLimbahHeader" class="control-label col-lg-4">Kode Limbah</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Jenis Limbah" name="txtKodeLimbahHeader" id="txtKodeLimbahHeader" class="form-control" value="<?php echo $headerRow['limbah_kode']; ?>" required/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtJenisLimbahHeader" class="control-label col-lg-4">Jenis Limbah</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Jenis Limbah" name="txtJenisLimbahHeader" id="txtJenisLimbahHeader" class="form-control" value="<?php echo $headerRow['limbah_jenis']; ?>" required/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtSatuanLimbahHeader" class="control-label col-lg-4">Satuan Limbah</label>
                                                <div class="col-lg-4">
                                                    <select style="width:100%;" class="select select2" name="txtSatuanLimbahHeader[]" id="txtSatuanLimbahHeader" multiple="multiple">
                                                      <?php foreach ($SatuanLimbahAll as $key) {?>
                                                        <option value="<?=$key['satuan'] ?>" <?php if (strstr($headerRow['satuan_all'], $key['satuan'])){echo 'selected';} ?> ><?= $key['satuan'] ?></option>
                                                      <?php } ?>
                                                    </select>

                                                    <input type="hidden" placeholder="Satuan Limbah" name="txtIDSatuanLimbahHeader" id="txtSatuanLimbahHeader" class="form-control" value="<?php echo $headerRow['satuan_id']; ?>"/>
                                                </div>
                                                <div class="col-lg-2">
                                                  <button type="button" data-toggle="modal" data-target="#modalAddSatuan" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="txtSumberLimbahHeader" class="control-label col-lg-4">Sumber Limbah</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Jenis Limbah" name="txtSumberLimbahHeader" id="txtSumberLimbahHeader" class="form-control" value="<?php echo $headerRow['sumber_limbah']; ?>" required/>
                                                    <input type="hidden" placeholder="Jenis Limbah" name="txtIDSumberLimbahHeader" id="txtSumberLimbahHeader" class="form-control" value="<?php echo $headerRow['sumber_id'] ?>"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtSumberLimbahHeader" class="control-label col-lg-4">Konversi Limbah (TON)</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Konversi Limbah" name="txtKonversiLimbahHeader" id="txtKonversiLimbahHeader" class="form-control" value="<?php echo $headerRow['konversi']; ?>" required/>
                                                    <input type="hidden" placeholder="Konversi Limbah" name="txtIDKonversiLimbahHeader" id="txtIDKonversiLimbahHeader" class="form-control" value="<?php echo $headerRow['konversi_id'] ?>"/>
                                                    <p class="help-block"> Example : 0.123 (gunakan titik pengganti koma)</p>
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

<!-- Modal AddSatuan -->
<div class="modal fade" id="modalAddSatuan" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
  <div style="transform: translateY(50%);" class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tambah Satuan Limbah</h4>
      </div>
      <div class="modal-body">
        <div class="loader"></div>
        <div clas="loader-txt">
          <div class="form-group">
            <label for="txtAjaxSatuanLimbah" class="control-label col-lg-4">Satuan Limbah</label>
            <div class="col-lg-4">
                <input type="text" placeholder="Satuan Limbah" name="txtAjaxSatuanLimbah" id="txtAjaxSatuanLimbah" class="form-control" value="" required/>
            </div>
          </div>
          <div class="text-center">
            <button class="btn btn-primary" type="button" onclick="addSatuan()" id="btn-addSatuan" name="button"><i class="fa fa-plus"></i> Tambah</button>
          </div>
        </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>
<!-- End Modal -->
