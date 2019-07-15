<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-11 text-right">
            <h1><b><?=$Title ?></b></h1>
          </div>
            <div class="col-lg-1">
              <a href="" class="btn btn-default btn-lg" style="">
                <i class="icon-wrench icon-2x"></i>
              </a>
            </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-body">
                <div class="row">
                  <div class="col-lg-12">
                    <form class="form-horizontal" action="<?php echo base_url('WasteManagement/LogbookHarianLimbah/Export') ?>" method="POST" target="_blank">
                      <div class="col-lg-6">
                        <div class="box box-solid box-primary">
                          <label style="font-size:20px;" class="bg-primary text-center col-lg-12">Kiriman Masuk</label>
                          <div class="row">
                        <div class="form-group" style="margin-top:5px;">
                          <label class="control-label col-lg-4" style="margin-top:20px;">Periode</label>
                          <div class="col-lg-5" style="margin-top:20px;">
                            <input type="text" name="txtPeriodeLog1" id="periode1" class="date form-control" autocomplete="off" placeholder="masukkan periode">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-lg-4"> Jenis Limbah</label>
                          <div class="col-lg-7">
                            <select class="select select2" name="slcJenisLimbahLog1[]" id="jnslk" style="width: 100%" data-placeholder="Jenis Limbah" multiple="multiple" required="true">
                              <option></option>
                              <?php foreach ($log as $key) {
                                echo "<option value='".$key['id_jenis_limbah']."'>".$key['jenis_limbah']."</option>";
                              }
                               ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="box box-solid box-primary">
                        <label style="font-size:20px;" class="bg-primary text-center col-lg-12">Kiriman Keluar</label>
                        <div class="row">
                        <div class="form-group">
                          <label class="control-label col-lg-4" style="margin-top:20px;">Periode</label>
                          <div class="col-lg-5" style="margin-top:20px;">
                            <input type="text" name="txtPeriodeLog2"  id="periode2" class="date form-control" autocomplete="off" placeholder="masukkan periode">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-lg-4"> Jenis Limbah</label>
                          <div class="col-lg-7">
                            <select class="select select2" name="slcJenisLimbahLog2[]" style="width: 100%" data-placeholder="Jenis Limbah" multiple="multiple" required="true">
                              <option></option>
                              <?php foreach ($log as $key) {
                                echo "<option value='".$key['id_jenis_limbah']."'>".$key['jenis_limbah']."</option>";
                              }
                               ?>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="row">
                            <div class="form-group" style="margin-top:30px;">
                              <label class="control-label col-lg-4">Lokasi Kerja</label>
                              <div class="col-lg-4">
                                <select class="select select2" name="slcLokasiKerjaLog" style="width: 100%" data-placeholder="Lokasi Kerja" required="true">
      														<option></option>
      														<?php foreach ($lokasi as $key) {
      															echo "<option value='".$key['location_code']."'>".$key['location_code']." - ".$key['location_name']."</option>";
      														} ?>
      													</select>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-lg-4">Pilih Kasie</label>
                              <div class="col-lg-4">
                                <select name="user_name" class="select select2" data-placeholder="Pilih Kasie" style="width:100%" required="true">
                                    <option value=""></option>
                                    <?php foreach ($user_name as $user) { ?>
                                    <option value="<?php echo $user['nama']; ?>"><?php echo $user['user_name'].' - '.$user['nama']; ?></option>
                                    <?php }?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="row" style="margin-top:30px;">
                            <div class="form-group">
      												<div class="col-lg-8 text-right">
                                <button type="submit" name="export" value="excel" class="btn btn-success"><i class="fa fa-file-excel-o"> Export Excel</i></a>
      												</div>
                              <div class="col-lg-2 text-left">
      													<button type="submit" name="export" value="pdf" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Export PDF</button>
      												</div>
      											</div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
