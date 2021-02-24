<section class="content">
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-plus"></i> Create Kaizen</h3>
    </div>
    <form method="post" action="<?php echo base_url('SystemIntegration/KaizenGenerator/Submit/create'); ?>" id="add-kaizen" autocomplete="off" role="form">
      <div class="box-body">
        <div class="col-lg-6">
          <div class="form-group">
            <label>Judul</label>
            <input type="text" name="txtJudul" id="txtJudul" class="form-control" placeholder="Masukkan judul Kaizen..." required>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="form-group">
            <label>Pencetus Ide</label>
            <input type="text" name="txtPencetus" id="txtPencetus" class="form-control" placeholder="Masukkan pencetus ide Kaizen..." readonly 
            value="<?= $this->session->employee ?>" required>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="form-group">
            <label>Nomor Induk Pencetus</label>
            <input type="text" name="txtNoInduk" id="txtNoInduk" class="form-control" placeholder="Masukkan nomor induk pencetus ide Kaizen..." readonly value="<?= $this->session->user; ?>"required>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="form-group">
            <label class="checkbox-inline" style="padding: 5px; padding-left: 0" >
              <!-- <button id="chkkkkkkkk" style="display: block;"> -->
              <input type="checkbox" value="1" id="checkKaizenKomp" ><b> &nbsp;Kaizen Komponen</b>
              <!-- </button> -->
            </label>
            <select class="form-control komponenKaizenSI" multiple disabled name="slcKomponen[]">
            </select>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="form-group">
            <label>Kondisi Saat Ini</label>
            <textarea class="textareaKaizen" name="txtKondisiAwal" id="txtKondisiAwal" placeholder="Masukkan kondisi awal..." style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required></textarea>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="form-group">
            <label>Usulan Kaizen</label>
            <textarea class="textareaKaizen" name="txtUsulan" id="txtUsulan" placeholder="Masukkan Usulan kaizen..." style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required></textarea>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="form-group">
            <label>Pertimbangan usulan Kaizen</label>
            <textarea name="txtPertimbangan" id="txtPertimbangan" placeholder="Masukkan pertimbangan pemilihan kaizen..." style="width: 100%; height: 70px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required></textarea>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-group">
            <label>Rencana Realisasi</label>
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right datetimeSI" id="txtRencanaRealisasiSI" name="txtRencanaRealisasi" required>
            </div>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <div class="pull-right">
          <button type="submit" class="btn btn-success">Save</button>
          <button type="button" id="SI_btncanclecrtkaizen" class="btn btn-warning">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</section>
<script src="<?php echo base_url('assets/plugins/ckeditor/ckeditor.js');?>"></script>
<script type="text/javascript">
  CKEDITOR.disableAutoInline = true;
</script>