<section class="content">
  <?php if ($this->session->flashdata('failed')) : ?>
    <div class="alert alert-warning" role="alert">
      <?= $this->session->flashdata('failed') ?>
    </div>
  <?php endif; ?>
  <?php if ($this->session->flashdata('success')) : ?>
    <div class="alert alert-success" role="alert">
      <?= $this->session->flashdata('success') ?>
    </div>
  <?php endif; ?>
  <div class="panel panel-primary">
    <div class="panel-heading">
      <div style="display: flex; justify-content: flex-end;">
        <h1>Input Data Kaizen</h1>
      </div>
    </div>
    <div class="panel-body cl-md-12">
      <form action="<?= base_url('SystemIntegration/KaizenPekerjaTks/input/addKaizen') ?>" method="post" enctype="multipart/form-data">
        <div class="row">
          <div class="form-group col-md-12">
            <label class="col-md-2">No Induk</label>
            <div class="col-md-5 inputNo">
              <select name="slcNoind" id="slcNoind" class="form-control select2" required>
              </select>
            </div>
          </div>
          <div class="form-group col-md-12">
            <label class="col-md-2">Nama</label>
            <div class="col-md-5">
              <input name="employeeName" placeholder="-- Terisi otomatis --" id="employeeName" type="text" class="form-control" readonly>
            </div>
          </div>
          <div class="form-group col-md-12" hidden>
            <label class="col-md-2">Kode Seksi</label>
            <div class="col-md-5">
              <input name="sectionCode" placeholder="-- Terisi otomatis --" id="sectionCode" type="text" class="form-control" readonly>
            </div>
          </div>
          <div class="form-group col-md-12">
            <label class="col-md-2">Seksi</label>
            <div class="col-md-5">
              <input name="employeeSection" placeholder="-- Terisi otomatis --" id="employeeSection" type="text" class="form-control" readonly>
            </div>
          </div>
          <div class="form-group col-md-12">
            <label class="col-md-2">Unit</label>
            <div class="col-md-5">
              <input name="employeeUnit" placeholder="-- Terisi otomatis --" id="employeeUnit" type="text" class="form-control" readonly>
            </div>
          </div>
          <div class="form-group col-md-12">
            <label class="col-md-2">Judul Kaizen</label>
            <div class="col-md-5">
              <textarea name="kaizenTitle" id="kaizenTitle" cols="50" rows="4" placeholder="Tulis judul kaizen" class="form-control <?= form_error('kaizenTitle') ? 'is-invalid' : '' ?> " required></textarea>
              <div class="invalid-feedback">
                <?php echo form_error('kaizenTitle') ?>
              </div>
            </div>
          </div>
          <div class="form-group col-md-12">
            <label class="col-md-2">Kategori Kaizen</label>
            <div class="col-md-3">
              <select name="slcKaizenCategory" id="slcKaizenCategory" aria-placeholder="Pilih kategori kaizen" class="form-control <?= form_error('slcKaizenCategory') ? 'is-invalid' : '' ?>" required>
                <?php foreach ($kaizenCategory as $zenzen) : ?>
                  <option value="<?= $zenzen ?>"><?= $zenzen ?></option>
                <?php endforeach; ?>
              </select>
              <div class="invalid-feedback">
                <?php echo form_error('slcKaizenCategory') ?>
              </div>
            </div>
          </div>
          <div class="form-group col-md-12">
            <div class="col-md-6">
              <label for="inputFile">Lampiran Kaizen (jpg/pdf) yang sudah diotorisasi atasan</label>
              <input name="file" type="file" id="inputFile" class="form-control-file " accept="application/pdf, image/jpeg, image/jpg, image/png" required>
            </div>
          </div>
        </div>
        <div style="text-align: right;">
          <input type="submit" class="btn btn-success" name="btn" value="Save">
          <a href="<?= base_url("SystemIntegration/KaizenPekerjaTks/input") ?>" class="btn btn-danger btn-large">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>