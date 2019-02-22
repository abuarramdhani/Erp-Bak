<body class="hold-transition login-page">
  <section class="content">
    <div class="panel-group">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3>Masukan Data</h3>
        </div>
        <div class="panel-body">

          <form method="post" action="<?php echo base_url('MasterPekerja/KecelakaanKerja/updatePerusahaan/'.$edit[0]['id_perusahaan']);?>" enctype="multipart/form-data">
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="KecelakaanKerja-inputNamaPerusahaan" class="control-label">Nama Perusahaan</label>
                  <input class="form-control" type="text" name="txt_namaPerusahaan" id="KecelakaanKerja-inputNamaPerusahaan" value="<?php echo $edit[0]['nama_perusahaan'];?>">
                </div>               
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  <label for="KecelakaanKerja-inputKodeMitraPerusahaan" class="control-label">Kode Mitra</label>
                  <input class="form-control" type="text" name="txt_kodeMitraPerusahaan" id="KecelakaanKerja-inputKodeMitraPerusahaan" value="<?php echo $edit[0]['kode_mitra'];?>">
                </div>                
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">                   
                <div class="form-group">
                  <label for="KecelakaanKerja-inputAlamatPerusahaan" class="control-label">Alamat</label>
                  <input class="form-control" type="text" name="txt_alamatPerusahaan" id="KecelakaanKerja-inputAlamatPerusahaan" value="<?php echo $edit[0]['alamat'];?>">
                </div> 
              </div>
              <div class="col-lg-2">
                <div class="form-group">
                  <label for="KecelakaanKerja-inputDesaPerusahaan" class="control-label">Desa</label>
                  <input class="form-control" type="text" name="txt_desaPerusahaan" id="KecelakaanKerja-inputDesaPerusahaan" value="<?php echo $edit[0]['desa'];?>">
                </div>
              </div>
              <div class="col-lg-2">
                <div class="form-group">
                  <label for="KecelakaanKerja-inputKecamatanPerusahaan" class="control-label">Kecamatan</label>
                  <input class="form-control" type="text" name="txt_kecamatanPerusahaan" id="KecelakaanKerja-inputKecamatanPerusahaan" value="<?php echo $edit[0]['kecamatan'];?>">
                </div>
              </div>
              <div class="col-lg-2">
                <div class="form-group">
                  <label for="KecelakaanKerja-inputKotaPerusahaan" class="control-label">kota</label>
                  <input class="form-control" type="text" name="txt_kotaPerusahaan" id="KecelakaanKerja-inputKotaPerusahaan" value="<?php echo $edit[0]['kota'];?>">
                </div>
              </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="control-label" for="it_noTelpPerusahaan">No. Telp Perusahaan :</label>
                        <input class="form-control" type="text" name="txt_noTelpPerusahaan" id="it_noTelpPerusahaan" value="<?php echo $edit[0]['no_telp'];?>">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="control-label" for="it_namaKontakPersonilPerusahaan">Nama Kontak Personil Perusahaan :</label> 
                        <input class="form-control" type="text" name="txt_namaKontakPersonilPerusahaan" id="it_namaKontakPersonilPerusahaan" value="<?php echo $edit[0]['contact_person'];?>">
                    </div>
                </div> 
                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="control-label" for="it_keteranganPerusahaan">Keterangan :</label> 
                        <input class="form-control" type="text" name="txt_keteranganPerusahaan" id="it_keteranganPerusahaan" placeholder="nama daerah(spasi)NONSTAFF/STAFF" value="<?php echo $edit[0]['keterangan'];?>">
                    </div>
                </div> 
            </div>
            <div class="row">
              <br>
              <div class="col-lg-2">
                <button class="btn btn-primary" type="submit" id="KecelakaanKerja-btn_SubmitPerusahaan">Submit Di Sini</button>
              </div>
            </div>
          </form>
          
        </div>        
      </div>  
    </div>      
  </section>
 </body>