<section class="content">
  <div class="box box-primary color-palette-box">
    <div class="box-body">
      <div class="nav-tabs-custom">
        <div class="tab-content">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <div class="col-md-12">
                  <label> Piih Gudang </label>
                </div>
                <div class="col-md-4">
                  <select class="select2 form-control" style="width: 100%" name="slcWarehouse" id="selectWare">
                    <option></option>
                    <?php foreach ($warehouse as $key => $value) { ?>
                    <option value="<?= $value['SUBINV'] ?>"><?= $value['SUBINV'] ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <!-- DISINI TEMPAT NARUH FILTER OK------------------------------------------------ -->
              <div class="filterForm" style="display: none;">
              <div class="row">
                  <div class="col-md-12 " style="text-align: center;padding-bottom: 10px">
                      <label><H2><b>FILTER PENGELUARAN BARANG GUDANG</b></H2></label>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-3 " style="text-align: right;">
                      <label>Tanggal SPBS</label>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
<input type="text" value="<?php echo isset($spbs_awal) ? $spbs_awal : ''; ?>" name="txtSpbsAwal" id="tanggal_spbs_1" class="form-control datepicker" style="padding-left: 12px;width: 300px" placeholder="Pilih Tanggal Awal"  />
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group" style="padding-left: 40px">
<input type="text" value="<?php echo isset($spbs_akhir) ? $spbs_akhir : ''; ?>"  name="txtSpbsAkhir" id="tanggal_spbs_2" class="form-control datepicker" style="padding-left: 12px;width: 300px;" placeholder="Pilih Tanggal Akhir" >
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-3 " style="text-align: right;">
                      <label>Tanggal Kirim</label>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
<input type="text" value="<?php echo isset($kirim_awal) ? $kirim_awal : ''; ?>"  name="txtKirimAwal" id="tanggal_kirim_1" class="form-control datepicker" style="padding-left: 12px;width: 300px" placeholder="Pilih Tanggal Awal"  />
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group" style="padding-left: 40px">
<input type="text" value="<?php echo isset($kirim_akhir) ? $kirim_akhir : ''; ?>"  name="txtKirimAkhir" id="tanggal_kirim_2" class="form-control datepicker" style="padding-left: 12px;width: 300px;" placeholder="Pilih Tanggal Akhir" >
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-3" style="text-align: right;">
                      <label>No SPBS</label>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
<input type="text" name="txtSpbsNum" id="spbs_number" class="form-control" style="width: 300px" placeholder="Input Nomor SPBS" value="<?php echo isset($spbs_num) ? $spbs_num : ''; ?>" />
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-3 " style="text-align: right;">
                      <label>Nama Sub</label>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
                          <select class="form-control select2" style="width: 300px" name="txtSubName" id="nama_sub_spbs" data-placeholder="Pilih Gudang">
                              <option></option>
                              <?php foreach ($SUBKONT as $SUBKONT) { ?>
                              <option><?php echo $SUBKONT['VENDOR_NAME']; ?></option>
                              <?php } ?>
                          </select>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-3" style="text-align: right;">
                      <label>No Job</label>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
<input type="text" value="<?php echo isset($job) ? $job : ''; ?>" name="txtJob" id="job_spbs" class="form-control" style="width: 300px" placeholder="Input Job"  />
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-3" style="text-align: right;">
                      <label>Nama Komponen</label>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
<input type="text" value="<?php echo isset($komponen) ? $komponen : ''; ?>" name="komponen" id="komponen" class="form-control" style="width: 300px;" placeholder="Nama Komponen"  />
                      </div>
                  </div>
              </div>
              </div>
<!-- FILTER SAMPAI DISINI ---------------------------------------------------- -->

               <div class="form-group">
                <div class="col-md-12" style="padding-top: 5px">
                  <button class="btn btn-primary" onclick="tampilMPBG(this)" ><i class="fa fa-search"></i> FIND </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-content">
          <!-- <label> Result:</label> -->
          <div class="row">
              <div class="col-md-12">
                 <div class="form-group">
                  <div class="col-md-12 ResultMonitoring"  id="ResultMonitoring"> </div>
                 </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>