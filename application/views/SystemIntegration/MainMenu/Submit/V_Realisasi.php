<style type="text/css">
  .disabled-select {
   background-color:#d5d5d5;
   opacity:0.5;
   border-radius:3px;
   cursor:not-allowed;
   position:absolute;
   top:0;
   bottom:0;
   right:0;
   left:0;
}
</style>
<section class="content">
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-pencil "></i> Submit Realisasi Kaizen</h3>
    </div>
    <form method="post" action="<?php echo base_url('SystemIntegration/KaizenGenerator/SubmitRealisasi/'.$kaizen[0]['kaizen_id']); ?>" id="update-kaizen" role="form">
      <div class="box-body">
        <div class="col-lg-6">
          <div class="form-group">
            <label>Judul</label>
            <input type="text" name="txtJudul" readonly id="txtJudul" class="form-control" placeholder="Masukkan produk/jasa/judul Kaizen..."  value="<?= $kaizen[0]['judul'] ?>">
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
            <label class="checkbox-inline"><input type="checkbox" <?= $kaizen[0]['komponen'] ? 'checked' :'' ?> onclick="return false" value="1" id="checkKaizenKomp"><b>Kaizen Komponen</b></label>
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
           
            <div style="border: 1px solid #d2d6de; background-color: #eee; padding-left: 10px"> <?= $kaizen[0]['usulan_kaizen'] ?></div>
          </div>
        </div>
      </div>
      <div class="box-body" style="background-color: #c5f3c5">
        <div class="col-lg-12">
          <div class="form-group">
            <label>Kondisi Setelah Kaizen</label>
            <textarea class="textareaKaizen" name="txtKondisiAkhir" id="txtKondisiAkhir" required placeholder="Masukkan kondisi setelah kaizen..." style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="form-group">
            <label>Tanggal Realisasi</label>
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" id="txtTanggalRealisasi" name="txtTanggalRealisasi" required value="">
            </div>
          </div>
        </div>
        <div class="col-lg-12 col-offset-6" style="text-align: right;">
          <button type="submit" class="btn btn-primary ">Submit</button>
          <a href="<?php echo base_url('SystemIntegration/KaizenGenerator/View/'.$kaizen[0]['kaizen_id']) ?>";" class="btn btn-warning">Cancel</a>
        </div>
      </div>
      <div class="box-footer">
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

var realisasiSIpage = '1';
</script>
