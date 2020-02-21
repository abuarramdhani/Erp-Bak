<div class="col-lg-6">
  <div class="col-lg-4">
    <label>Tanggal Awal = </label>
    <input type="text" name="tgl_awal" id="tgl_awal" value="<?php echo '  '.$awal ?>" style="width: 140px;" readonly>
  </div>
  <div class="col-lg-2 text-center">
    <label>-</label>
  </div>
  <div class="col-lg-4">
    <label>Tanggal Akhir = </label>
    <input type="text" name="tgl_akhir" id="tgl_akhir" value="<?php echo '  '.$akhir ?>" style="width: 140px;" readonly>
  </div>
</div>
<div class="col-lg-12">
  <div class="row col-lg-6">
    <div class="row">
      <div class="form-group">
        <label for="MPK_labPekerja" class="control-label col-lg-4">Status Pekerja</label>
        <div class="col-lg-5">
          <select style="width: 100%" name="MPK_infoPekerja" class="form-control" id="MPK_infoPekerja" data-placeholder="Pilih Status Pekerja" required>
            <option></option>
            <option value="staf">Staf</option>
            <option value="nonstaf">Non Staf</option>
          </select>
        </div>
      </div>
    </div>
  </div>
</div>
<br>
<div class="col-lg-12 hidden" id="groupPekerjaInfo">
  <div class="row">
    <div class="form-group">
      <div class="box box-body box-solid box-success" style="height: 455px; width: 94%; margin-left: 30px">
        <h1 class="bg-info text-center">Daftar Pekerja Non Staf</h1>
        <div class="table-responsive" style="overflow: scroll; height: 320px">
            <table class="table table-bordered table-hover dataTable" style="width: 100%" id="tabelNonStafInfo">
              <thead style="background-color: #e6e6e6; font-size: 15px">
                <tr>
                  <th style="width: 5%; padding-left: 12px">No</th>
                  <th style="width: 15%; text-align: center">Noind</th>
                  <th style="width: 20%; text-align: center">Nama</th>
                  <th style="width: 30%; text-align: center">Seksi</th>
                  <th style="width: 30%; text-align: center">Keterangan</th>
                  <th style="width: 5%; text-align: center">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $noye = 1;
                foreach ($nonstaf as $j) { ?>
                <tr class="tbodyinfononstaf">
                  <td style="text-align: center; padding-top: 15px"><?php echo $noye++ ?></td>
                  <td class="noind-nonstaff"><?php echo $j['noind'] ?></td>
                  <td style="text-align: center;"><?php echo $j['nama'] ?></td>
                  <td style="text-align: center;"><?php echo $j['seksi'] ?></td>
                  <td style="text-align: center;"><?php echo $j['ket'] ?></td>
                  <td style="text-align: center;"><button type="button" class="deletenonstaf btn btn-danger"><i class="fa fa-close"  title="Hapus Row" alt="Hapus Row"></i></button></td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
        </div>
        <button type="button" onclick="nextInfo()" id="btnInfonext" class="btn btn-success" align="right" style="float: middle; margin-top: 10px; margin-right: 20px;"><span class='fa fa-sign-in'> Next</span></button>
      </div>
    </div>
  </div>
</div>
<br>
<div class="col-lg-12 hidden" id="groupPekerjaStafInfo">
  <div class="row">
    <div class="form-group">
      <div class="box box-body box-solid box-success" style="height: 430px; width: 94%; margin-left: 30px">
        <h1 class="bg-info text-center">Daftar Pekerja Staf</h1>
        <div class="table-responsive" style="overflow: scroll; height: 320px">
          <table class="table table-bordered table-hover dataTable" style="width: 100%" id="tabelStafInfo">
            <thead style="background-color: #e6e6e6; font-size: 15px">
              <tr>
                <th style="width: 5%; padding-left: 12px; text-align: center">No</th>
                <th style="width: 10%; text-align: center">Noind</th>
                <th style="width: 20%; text-align: center">Nama</th>
                <th style="width: 30%; text-align: center">Seksi</th>
                <th style="width: 5%; text-align: center">Action</th>
              </tr>
            </thead>
            <tbody id="tbodyinfostaf">
              <?php $no = 1;
              foreach ($staf as $key) {
                if(empty($key['bidang']) || $key['bidang'] == '-' || $key['bidang'] == ''){
                  $seksiii = $key['dept'];
                }else if(empty($key['unit']) || $key['unit'] == '-' || $key['unit'] == ''){
                  $seksiii = $key['bidang'];
                }else if(empty($key['seksi']) || $key['seksi'] == '-' || $key['seksi'] == '') {
                   $seksiii = $key['unit'];
                }else {
                  $seksiii = $key['seksi'];
                } ?>
              <tr class="cloneNew">
                <td style="text-align: center; padding-top: 15px"><?php echo $no++ ?></td>
                <td class='noind-staff'><?php echo $key['noind'] ?></td>
                <td style="text-align: center;"><?php echo $key['nama'] ?></td>
                <td style="text-align: center;"><?php echo $seksiii; ?></td>
                <td style="text-align: center;"><button type="button" class="deletenonstaf btn btn-danger"><i class="fa fa-close"  title="Hapus Row" alt="Hapus Row"></i></button></td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<br>
<div class="col-lg-12 hidden" id="groupAtasanInfo">

</div>
<div class="col-lg-12">
  <div class="row col-lg-6">
    <div class="row">
      <div class="form-group">
        <label for="MPK_approvalInfo" class="control-label col-lg-4">Tertanda</label>
        <div class="col-lg-7">
          <select style="width: 100%;" name="cmbtertandaCutoff" class="form-control select select2 MPK_tertandaInfo" id="MPK_tertandaInfo" readonly>
            <option></option>
            <?php foreach ($hubker as $key){ ?>
              <option <?php if ($key['noind'] == 'B0307'){echo "selected";} ?> value="<?php echo $key['noind'] ?>"><?php echo $key['noind']." - ".$key['nama']; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="MPK_Alasan" class="control-label col-lg-4">Alasan</label>
        <div class="col-lg-5">
          <textarea name="txtaAlasan" id="MPK_txtaAlasan" rows="3" cols="90" value="" readonly></textarea>
        </div>
      </div>
    </div>
  </div>
</div>
<br>
<div class="row col-lg-12" style="margin-top: 30px;">
  <div class="form-group">
    <button type="button" class="btn btn-primary col-lg-2 MPK-btnPratinjauCutoff" id="MPK-btnPratinjauCutoff" disabled>
      Pratinjau
    </button>
    <div class="col-lg-9">
      <textarea id="MPK_txtaIsi" class="form-control" name="MPK_txtaIsi"></textarea>
    </div>
  </div>
</div>
<div hidden id="surat-loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>
