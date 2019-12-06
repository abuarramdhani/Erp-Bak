<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b><?php echo $Title;?></b></h1></div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <!-- Ganti yang di dalam site url dengan alamat main menu yang diinginkan -->
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('MasterPekerja');?>">
                                    <i class="icon-wrench icon-2x"></i>
                                    <br/>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                            </div>
                            <div class="box-body">
                                <div class="row">
                                  <label class="col-lg-4 text-right">No. Induk</label>
                                  <label class="col-lg-1">:</label>
                                  <div class="col-lg-4">
                                    <select class="select select2 form-control" id="TPJ_noind">
                                      <option></option>
                                      <?php foreach ($noind as $key) { ?>
                                        <option value="<?php echo $key['noind'] ?>"><?php echo $key['noind'].' - '.$key['nama'] ?></option>
                                      <?php } ?>
                                    </select>
                                  </div>
                                </div>
                                <br>
                                <div class="row">
                                  <label class="col-lg-4 text-right">Pekerjaan Saat Ini</label>
                                  <label class="col-lg-1">:</label>
                                  <div class="col-lg-4">
                                    <input type="text" class="form-control" id="TPJ_pkj_saat_ini" readonly>
                                  </div>
                                </div>
                                <br>
                                <div class="row">
                                  <label class="col-lg-4 text-right">Pekerjaan Baru</label>
                                  <label class="col-lg-1">:</label>
                                  <div class="col-lg-4">
                                    <select class="select select2 form-control" id="TPJ_pekerjaan">
                                      <option></option>
                                    </select>
                                  </div>
                                </div>
                                <br>
                                <div class="row">
                                  <label class="col-lg-4 text-right">Tanggal Berlaku</label>
                                  <label class="col-lg-1">:</label>
                                  <div class="col-lg-4">
                                    <input type="text" class="form-control" id="tanggalBerlaku">
                                  </div>
                                </div>
                                <br>
                                <div class="row">
                                  <div class="col-lg-12 text-center">
                                    <div class="panel-footer">
                                      <button type="button" name="button" class="btn btn-danger" onclick="goback()">Back</button>&emsp;
                                      <button type="button" name="button" class="btn btn-info" id="TPJ_reload">Reset</button>&emsp;
                                      <button type="button" name="button" class="btn btn-success" id="TPJ_save">Simpan</button>
                                    </div>
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
