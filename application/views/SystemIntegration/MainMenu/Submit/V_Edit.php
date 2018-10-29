<section class="content">
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-edit"></i> Update Kaizen</h3>
    </div>
    <form method="post" action="<?php echo base_url('SystemIntegration/KaizenGenerator/Edit/'.$kaizen[0]['kaizen_id']); ?>" id="update-kaizen" role="form">
      <div class="box-body">
        <div class="col-lg-6">
          <div class="form-group">
            <label>Judul</label>
            <input type="text" name="txtJudul" id="txtJudul" class="form-control" placeholder="Masukkan produk/jasa/judul Kaizen..."  value="<?= $kaizen[0]['judul'] ?>">
          </div>
        </div>
        <div class="col-lg-3">
          <div class="form-group">
            <label>Pencetus Ide</label>
            <input type="text" name="txtPencetus" id="txtPencetus" class="form-control" placeholder="Masukkan pencetus ide Kaizen..." readonly value="<?= $kaizen[0]['pencetus'] ?>">
          </div>
        </div>
        <div class="col-lg-3">
          <div class="form-group">
            <label>Nomor Induk Pencetus</label>
            <input type="text" readonly name="txtNoInduk" id="txtNoInduk" class="form-control" placeholder="Masukkan nomor induk pencetus ide Kaizen..." value="<?= $kaizen[0]['noinduk'] ?>">
          </div>
        </div>
        <div class="col-lg-12">
          <div class="form-group">
            <label class="checkbox-inline" style="padding: 5px; padding-left: 0"  ><input type="checkbox" <?= $kaizen[0]['komponen'] ? 'checked' :'' ?> value="1" id="checkKaizenKomp"><b> &nbsp;Kaizen Komponen</b></label>
            <select class="form-control komponenKaizenSI" multiple <?= $kaizen[0]['komponen'] ? '' :'disabled' ?> name="slcKomponen[]">
              <?php foreach ($kaizen[0]['komponen'] as $key => $value) { ?>
               <option selected value="<?= $value['id'] ?>"><?= $value['code'].' -- '.$value['name']; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="form-group">
            <label>Kondisi Awal</label>
            <textarea class="textareaKaizen" name="txtKondisiAwal" id="txtKondisiAwal" placeholder="Masukkan kondisi awal..." style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?= $kaizen[0]['kondisi_awal'] ?></textarea>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="form-group">
            <label>Usulan Kaizen</label>
            <textarea class="textareaKaizen" name="txtUsulan" id="txtUsulan" placeholder="Masukkan Usulan kaizen..." style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?= $kaizen[0]['usulan_kaizen'] ?></textarea>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="form-group">
            <label>Pertimbangan</label>
            <textarea name="txtPertimbangan" id="txtPertimbangan" placeholder="Masukkan pertimbangan pemilihan ide kaizen..." style="width: 100%; height: 70px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?= $kaizen[0]['pertimbangan'] ?></textarea>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-group">
            <label>Rencana Realisasi</label>
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right datetimeSI" id="txtRencanaRealisasiSI" name="txtRencanaRealisasi" value="<?php echo date("m/d/Y", strtotime($kaizen[0]['rencana_realisasi'])) ?>">
            </div>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <div class="pull-right">
          <button type="submit" class="btn btn-primary"> Update</button>
          <a href="<?php echo base_url('SystemIntegration/KaizenGenerator/View/'.$kaizen[0]['kaizen_id']) ?>";" class="btn btn-warning">Cancel</a>
        </div>
         <div style="margin-top: 20px" class="col-lg-12">
        <div style="border: 1px solid black" class="row">
          <label class="col-lg-12 " style="background-color: #88cbf1;">
           Log Thread 
          </label>
          <div class="col-lg-12" style="overflow: auto; height: 120px;">
            <?php $x = 0; foreach ($thread as $key => $value) { ?>
             <?php if ($x >= 5) { ?>
                <?php if ($x == 5) { ?>
                    <span id="rmthreadkai">
                      <a  style="cursor: pointer;">Read More</a> .. <br>
                    </span> 
                <?php } ?>
                <span id="threadmorekai" style="display: none">
                  [ <?= date('d/M/Y h:i:s', strtotime($value['waktu'])) ?> ] - <?= $value['detail'] ?><br>
                </span>
                <?php if ($x == 5) { ?>
                     <span id="rlthreadkai" style="display: none"> ..
                    <a  style="cursor: pointer;">Read less</a><br>
                    </span>
                <?php } ?>
              <?php }else{ ?>
              [ <?= date('d/M/Y h:i:s ', strtotime($value['waktu'])) ?> ] - <?= $value['detail'] ?><br>
              <?php } ?>
            <?php $x++; } ?>
          </div>
          </div>
        </div>
      </div>
    </form>

  </div>

</section>
<script src="<?php echo base_url('assets/plugins/ckeditor/ckeditor.js');?>"></script>
<script type="text/javascript">

 CKEDITOR.disableAutoInline = true;
</script>
