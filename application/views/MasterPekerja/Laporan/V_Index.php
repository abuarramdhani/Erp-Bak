<body class="hold-transition login-page">
  <section class="content">
    <div class="panel-group">
      <div class="panel panel-primary">
          <div class="panel-heading text-center"><b>LAPORAN KASUS KECELAKAAN KERJA</b></div>
        <div class="panel-body">
          <form>
            <h3 class="text-primary text-center">TAHAP I</h3>
            <div class="btn-group">
              <button id="btn_editPerusahaan" type="button" class="btn btn-primary btn-radius">Edit</button>              
            </div>
            <div class="btn-group">
              <button id="btn_savePerusahaan" type="button" class="btn btn-primary btn-radius">Save</button>
            </div>
                <div class="panel-group"> 
                  <div class="panel panel-primary">
                      <div class="panel-heading"></div>
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-lg-3">
                          <div class="form-group">
                            <label for="slc_cabang" class="control-label">Pilih Cabang</label>
                            <select id="KecelakaanKerja-slc_cabang" name="slc_cabang" class="form-control">
                              <option class="text-mute" selected="selected" disabled="disabled">Pilih Cabang</option>
                              <option value="Yogyakarta">Yogyakarta</option>
                              <option value="Tuksono">Tuksono</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="control-label" for="it_namaPerusahaan">Nama Perusahaan :</label>
                          <input class="form-control" type="text" name="it_namaPerusahaan" id="it_namaPerusahaan" readonly=""> 
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label class="control-label" for="it_kodeProyek">Kode Mitra/Kode Proyek :</label>
                          <input class="form-control" type="text" name="it_kodeProyek" id="it_kodeProyek" readonly="">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="control-label" for="it_alamatPerusahaan">Alamat :</label>
                          <input class="form-control" type="text" name="it_alamatPerusahaan" id="it_alamatPerusahaan" readonly="">
                        </div>               
                      </div>
                      <div class="col-lg-2">
                        <div class="form-group">
                          <label class="control-label" for="it_alamatDesaPerusahaan">Desa :</label>
                          <input class="form-control" type="text" name="it_alamatDesaPerusahaan" id="it_alamatDesaPerusahaan" readonly="">
                        </div>               
                      </div> 
                      <div class="col-lg-2">
                        <div class="form-group">
                          <label class="control-label" for="it_alamatKecamatanPerusahaan">Kecamatan :</label>
                          <input class="form-control" type="text" name="it_alamatKecamatanPerusahaan" id="it_alamatKecamatanPerusahaan" readonly="">
                        </div>               
                      </div>
                      <div class="col-lg-2">
                        <div class="form-group">
                          <label class="control-label" for="it_alamatKotaPerusahaan">Kota :</label>
                          <input class="form-control" type="text" name="it_alamatKotaPerusahaan" id="it_alamatKotaPerusahaan" readonly="">
                        </div>               
                      </div>
                         
                    </div>
                    <div class="row">
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label class="control-label" for="it_noTelpPerusahaan">No. Telp Perusahaan :</label>
                          <input class="form-control" type="text" name="it_noTelpPerusahaan" id="it_noTelpPerusahaan" readonly="">
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label class="control-label" for="it_namaKontakPersonilPerusahaan">Nama Kontak Personil Perusahaan :</label> 
                          <input class="form-control" type="text" name="it_namaKontakPersonilPerusahaan" id="it_namaKontakPersonilPerusahaan" readonly="">
                        </div>
                      </div> 
                    </div>
                    </div>
                  </div>
                </div>
                <div class="panel-group">
                  <div class="panel panel-primary">
                  <div class="panel-heading">
                    
                  </div>
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-lg-3">
                        <div class="form-group has-feedback">
                          <label class="control-label" for="cmbNoindukPekerja">Pilih Pekerja</label>
                          <select class="form-control " name="cmbNoindukPekerja" id="KecelakaanKerja-cmbNoindukPekerja">
                          </select>
                       </div> 
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="control-label">Nama Pekerja :</label>
                          <input class="form-control" type="text" name="it_namaPekerja" readonly="">
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label class="control-label">Nomor Peserta :</label>
                          <input class="form-control" type="text" name="it_nmrPekerja" readonly="">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-6">
                        <label class="control-label">Alamat :</label>
                        <input class="form-control" type="text" name="it_alamatPekerja" readonly="">
                      </div>     
                      <div class="col-lg-2">
                        <div class="form-group">
                          <label class="control-label" for="it_alamatDesaPekerja">Desa :</label>
                          <input class="form-control" type="text" name="it_alamatDesaPekerja" id="it_alamatDesaPekerja" readonly="">
                        </div>               
                      </div> 
                      <div class="col-lg-2">
                        <div class="form-group">
                          <label class="control-label" for="it_alamatKecamatanPekerja">Kecamatan :</label>
                          <input class="form-control" type="text" name="it_alamatKecamatanPekerja" id="it_alamatKecamatanPekerja" readonly="">
                        </div>               
                      </div>
                      <div class="col-lg-2">
                        <div class="form-group">
                          <label class="control-label" for="it_alamatKotaPekerja">Kota :</label>
                          <input class="form-control" type="text" name="it_alamatKotaPekerja" id="it_alamatKotaPekerja" readonly="">
                        </div>               
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2">
                          <div class="form-group">
                            <label for="it_kodePosAlamatPekerja" class="control-label">Kode Pos :</label>
                            <input class="form-control" type="text" name="it_kodePosAlamatPekerja" id="it_kodePosAlamatPekerja" readonly="">
                          </div>
                        </div>
                        <div class="col-lg-4">
                          <div class="form-group">
                            <label for="it_nomorTeleponPekerja" class="control-label">Nomor Telepon :</label>
                            <input class="form-control" type="text" name="it_nomorTeleponPekerja" id="it_nomorTeleponPekerja" readonly="">
                          </div>
                        </div>
                        <div class="col-lg-2">
                        <div class="form-group">
                          <label class="control-label">Jenis Kelamin :</label>
                          <input class="form-control" type="text" name="it_jenkel" readonly="">
                        </div>
                      </div> 
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label class="control-label">Tanggal Lahir :</label>
                          <input class="form-control" type="text" name="it_tglLahir" readonly="">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label class="control-label">Jenis Pekerjaan/Jabatan :</label>
                          <input class="form-control" type="text" name="it_jabatanPekerja" readonly="">
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label class="control-label">Unit/Bidang/Bagian Perusahaan :</label>
                          <input class="form-control" type="text" name="it_bidangPekerja" readonly="">
                        </div>                
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <div class="panel-group">
              <div class="panel panel-primary">
                <div class="panel-heading">
                  
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="control-label">Upah tenaga kerja yang diterima :</label>
                        <select class="form-control" name="slc_upahDiterima">
                          <option value="Perhari">Perhari</option>
                          <option value="Perbulan">Perbulan</option>
                          <option value="Pertahun">Pertahun</option>
                        </select>
                      </div>                                
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="control-label">Jumlah upah yang diterima :</label>
                        <input class="form-control" type="text" name="it_jumlahUpah">
                      </div>                            
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="control-label">Terbilang upah yang diterima :</label>
                        <input class="form-control" type="text" name="it_terbilangUpah">
                      </div>                            
                    </div>
                  </div>
                  <div class="row">                    
                    <div class="col-lg-6">
                      <div class="form-group"> 
                        <label class="control-label">Alamat lokasi kejadian kecelakaan :</label>
                        <input class="form-control" type="text" name="it_alamatKecelakaan">
                      </div>                
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group"> 
                        <label class="control-label">Tempat kejadian kecelakaan :</label>
                        <select class="form-control" name="it_tempatKecelakaan">
                          <option value="di dalam lokasi kerja">Di dalam lokasi kerja</option>
                          <option value="di luar lokasi kerja">Di luar lokasi kerja</option>
                          <option value="lalu lintas">Lalu lintas</option>
                        </select>
                      </div>                
                    </div>
                      <div class="col-lg-2">
                        <div class="form-group">
                          <label class="control-label">Tanggal Kecelakaan :</label>
                          <input type="text" name="" class="KecelakaanKerja-daterangepickersingledatewithtime form-control">
                        </div>
                      </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-2">
                        <div class="form-group">
                          <label class="control-label" for="it_alamatDesaKecelakaan">Desa :</label>
                          <input class="form-control" type="text" name="it_alamatDesaKecelakaan" id="it_alamatDesaKecelakaan">
                        </div>               
                      </div> 
                      <div class="col-lg-2">
                        <div class="form-group">
                          <label class="control-label" for="it_alamatKecamatanKecelakaan">Kecamatan :</label>
                          <input class="form-control" type="text" name="it_alamatKecamatanKecelakaan" id="it_alamatKecamatanKecelakaan">
                        </div>               
                      </div>
                      <div class="col-lg-2">
                        <div class="form-group">
                          <label class="control-label" for="it_alamatKotaKecelakaan">Kota :</label>
                          <input class="form-control" type="text" name="it_alamatKotaKecelakaan" id="it_alamatKotaKecelakaan">
                        </div>               
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label>Tindakan Bahaya Penyebab Kecelakaan</label>
                          <div class="checkbox">
                            <input type="checkbox" name="cb_peralatanBahaya" id="cb_peralatanBahaya" value="Memakai peralatan yang berbahaya">
                            <label class="control-label" for="cb_peralatanBahaya">Memakai peralatan yang berbahaya</label>
                          </div>
                          <div class="checkbox">
                            <input type="checkbox" name="cb_lupaPakaiAPD" id="cb_lupaPakaiAPD" value="Lupa menggunakan APD">
                            <label class="control-label" for="cb_lupaPakaiAPD">Lupa menggunakan APD</label>
                          </div>
                          <div class="checkbox">
                            <input type="checkbox" name="cb_posisiTidakAman" id="cb_posisiTidakAman" value="Posisi saat bekerja tidak aman">
                            <label class="control-label" for="cb_posisiTidakAman">Posisi saat bekerja tidak aman</label>
                          </div>                                       
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <br>
                          <div class="checkbox">
                            <input type="checkbox" name="cb_kecepatanBahaya" id="cb_kecepatanBahaya" value="Bekerja dengan keepatan membahayakan">
                            <label class="control-label" for="cb_kecepatanBahaya">Bekerja dengan keepatan membahayakan</label>
                          </div>
                          <div class="checkbox">
                            <input type="checkbox" name="cb_bongkarPasang" id="cb_bongkarPasang" value="Bongkar pasang barang">
                            <label class="control-label" for="cb_bongkarPasang">Bongkar pasang barang</label>
                          </div>
                          <div class="checkbox">
                            <input type="checkbox" name="cb_bekerjaObjek" id="cb_bekerjaObjek" value="Bekerja dengan objek">
                            <label class="control-label" for="cb_bekerjaObjek">Bekerja dengan objek</label>
                          </div>                                        
                        </div>
                      </div> 
                      <div class="col-lg-4">
                        <div class="form-group">
                          <br>
                          <div class="checkbox">
                            <input type="checkbox" name="cb_gangguanPerhatian" id="cb_gangguanPerhatian" value="Mengalami gangguan perhatian">
                            <label class="control-label" for="cb_gangguanPerhatian">Mengalami gangguan perhatian</label>
                          </div> 
                          <div class="checkbox">
                            <input type="checkbox" name="cb_lalai" id="cb_lalai" value="Lalai">
                            <label class="control-label" for="cb_lalai">Lalai</label>
                          </div>
                          </div>                    
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label>Kondisi yang menimbulkan bahaya dan menjadi pencetus terjadinya kecelakaan</label>
                          </div>
                        </div>
                        <div class="col-lg-4">
                          <div class="form-group">
                            <div class="checkbox">
                              <input type="checkbox" name="cb_pengamananTidakSempurna" id="cb_pengamananTidakSempurna" value="Pengamanan yang tidak sempurna">
                              <label class="control-label" for="cb_pengamananTidakSempurna">Pengamanan yang tidak sempurna</label>
                            </div>                          
                            <div class="checkbox">
                              <input type="checkbox" name="cb_adaKecacatan" id="cb_adaKecacatan" value="Adanya Kecacatan">
                              <label class="control-label" for="cb_adaKecacatan">Adanya Kecacatan</label>
                            </div>                         
                            <div class="checkbox">
                              <input type="checkbox" name="cb_peneranganTidakSempurna" id="cb_peneranganTidakSempurna" value="Penerangan yang tidak sempurna">
                              <label class="control-label" for="cb_peneranganTidakSempurna">Penerangan yang tidak sempurna</label>
                            </div>                          
                            <div class="checkbox">
                              <input type="checkbox" name="cb_suasanaTidakAman" id="cb_suasanaTidakAman" value="Suasana kerja tidak aman">
                              <label class="control-label" for="cb_suasanaTidakAman">Suasana kerja tidak aman</label>
                            </div>                            
                          </div>                          
                        </div>
                        <div class="col-lg-4">
                          <div class="form-group">
                            <div class="checkbox">
                              <input type="checkbox" name="cb_getaranBerbahaya" id="cb_getaranBerbahaya" value="Getaran yang berbahaya">
                              <label class="control-label" for="cb_getaranBerbahaya">Getaran yang berbahaya</label>
                            </div>                         
                            <div class="checkbox">
                              <input type="checkbox" name="cb_perlengkapanTidakAman" id="cb_perlengkapanTidakAman" value="Getaran yang berbahaya">
                              <label class="control-label" for="cb_perlengkapanTidakAman">Perlengkapan yang digunakan tidak aman</label>
                            </div>                         
                            <div class="checkbox">
                              <input type="checkbox" name="cb_peralatanBahanTidakTepat" id="cb_peralatanBahanTidakTepat" value="Penggunaan peralatan/bahan tidak tepat">
                              <label class="control-label" for="cb_peralatanBahanTidakTepat">Penggunaan peralatan/bahan tidak tepat</label>
                            </div>                        
                            <div class="checkbox">
                              <input type="checkbox" name="cb_prosedurTidakAman" id="cb_prosedurTidakAman" value="Adanya prosedur yang tidak aman">
                              <label class="control-label" for="cb_prosedurTidakAman">Adanya prosedur yang tidak aman</label>
                            </div>
                          </div>                          
                        </div>
                        <div class="col-lg-4">
                          <div class="form-group">
                            <div class="checkbox">
                              <input type="checkbox" name="cb_ventilasiTidakSempurna" id="cb_ventilasiTidakSempurna" value="Ventilasi Tidak Sempurna">
                              <label class="control-label" for="cb_ventilasiTidakSempurna">Ventilasi Tidak Sempurna</label>
                            </div>                          
                            <div class="checkbox">
                              <input type="checkbox" name="cb_tekananUdaraTidakAman" id="cb_tekananUdaraTidakAman" value="Tekanan udara yang tidak aman">
                              <label class="control-label" for="cb_tekananUdaraTidakAman">Tekanan udara yang tidak aman</label>
                            </div>                          
                            <div class="checkbox">
                              <input type="checkbox" name="cb_bising" id="cb_bising" value="Bising">
                              <label class="control-label" for="cb_bising">Bising</label>
                            </div>
                            <div class="checkbox">
                              <input type="checkbox" name="cb_adaGerakan" id="cb_adaGerakan" value="Adanya gerakan(perputaran)">
                              <label class="control-label" for="cb_adaGerakan">Adanya gerakan(perputaran)</label>
                            </div>
                          </div>
                        </div>                        
                      </div>
                      <div class="row">
                        <div class="col-lg-3">
                          <div class="form-group">
                            <label class="control-label">Corak kecelakaan yang terjadi</label>
                            <div class="checkbox">
                              <input type="checkbox" name="cb_terbentur" id="cb_terbentur" value="Terbentur">
                              <label for="cb_terbentur" class="control-label">Terbentur</label>
                            </div>
                            <div class="checkbox">
                              <input type="checkbox" name="cb_tertangkap" id="cb_tertangkap" value="Tertangkap">
                              <label for="cb_tertangkap" class="control-label">Tertangkap</label>
                            </div>
                            <div class="checkbox">
                              <input type="checkbox" name="cb_tenggelam" id="cb_tenggelam" value="Tenggelam">
                              <label for="cb_tenggelam" class="control-label">Tenggelam</label>
                            </div>
                            <div class="checkbox">
                              <input type="checkbox" name="cb_tertimbun" id="cb_tertimbun" value="Tertimbun">
                              <label for="cb_tertimbun" class="control-label">Tertimbun</label>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-3">
                          <br>
                          <div class="form-group">
                            <div class="checkbox">
                              <input type="checkbox" name="cb_terpukul" id="cb_terpukul" value="Terpukul">
                              <label for="cb_terpukul" class="control-label">Terpukul</label>
                            </div>
                            <div class="checkbox">
                              <input type="checkbox" name="cb_tergigit" id="cb_tergigit" value="Tergigit">
                              <label for="cb_tergigit" class="control-label">Tergigit</label>
                            </div>
                            <div class="checkbox">
                              <input type="checkbox" name="cb_terjepit" id="cb_terjepit" value="Terjepit">
                              <label for="cb_terjepit" class="control-label">Terjepit</label>
                            </div>
                            <div class="checkbox">
                              <input type="checkbox" name="cb_tergelincir" id="cb_tergelincir" value="Tergelincir">
                              <label for="cb_tergelincir" class="control-label">Tergelincir</label>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-3">
                          <br>
                          <div class="form-group">
                            <div class="checkbox">
                              <input type="checkbox" name="cb_terpapar" id="cb_terpapar" value="Terpapar">
                              <label for="cb_terpapar" class="control-label">Terpapar</label>
                            </div>
                            <div class="checkbox">
                              <input type="checkbox" name="cb_jatuhSama" id="cb_jatuhSama" value="Jatuh dari ketinggian sama">
                              <label for="cb_jatuhSama" class="control-label">Jatuh dari ketinggian sama</label>
                            </div>
                            <div class="checkbox">
                              <input type="checkbox" name="cb_jatuhBeda" id="cb_jatuhBeda" value="Jatuh dari ketinggian berbeda">
                              <label for="cb_jatuhBeda" class="control-label">Jatuh dari ketinggian berbeda</label>
                            </div>
                            <div class="checkbox">
                              <input type="checkbox" name="cb_penghisapan" id="cb_penghisapan" value="Penghisapan(Penyerapan)">
                              <label for="cb_penghisapan" class="control-label">Penghisapan(Penyerapan)</label>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-3">
                          <br>
                          <div class="form-group">
                            <div class="checkbox">
                              <input type="checkbox" name="cb_tersengatListrik" id="cb_tersengatListrik" value="Tersengat aliran listrik">
                              <label for="cb_tersengatListrik" class="control-label">Tersengat aliran listrik</label>
                            </div>
                          </div>                          
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-4">
                          <div class="form-group">
                            <label class="control-label">Sumber penyebab cedera</label>
                            <div class="checkbox">
                              <input type="checkbox" id="cb_mesinPenyebab" name="cb_mesinPenyebab" value="Mesin(Press,Bor,Gergaji,dll)">
                              <label for="cb_mesinPenyebab" class="control-label">Mesin(Press,Bor,Gergaji,dll)</label>
                            </div>
                            <div class="checkbox">
                              <input type="checkbox" id="cb_pengangkutPenyebab" name="cb_pengangkutPenyebab" value="Pengangkut/Pengangkat Barang">
                              <label for="cb_pengangkutPenyebab" class="control-label">Pengangkut/Pengangkat Barang</label>
                            </div>
                            <div class="checkbox">
                              <input type="checkbox" id="cb_perkakasTanganPenyebab" name="cb_perkakasTanganPenyebab" value="Perkakas Pekerjaan Tangan">
                              <label for="cb_perkakasTanganPenyebab" class="control-label">Perkakas Pekerjaan Tangan</label>
                            </div>
                            <div class="checkbox">
                              <input type="checkbox" id="cb_bahanKimiaPenyebab" name="cb_bahanKimiaPenyebab" value="Bahan Kimia">
                              <label for="cb_bahanKimiaPenyebab" class="control-label">Bahan Kimia</label>
                            </div>
                            <div class="checkbox">
                              <input type="checkbox" id="cb_faktorLingkunganPenyebab" name="cb_faktorLingkunganPenyebab" value="Faktor Lingkungan">
                              <label for="cb_faktorLingkunganPenyebab" class="control-label">Faktor Lingkungan</label>
                            </div>
                            <div class="checkbox">
                              <input type="checkbox" id="cb_mudahTerbakarPenyebab" name="cb_mudahTerbakarPenyebab" value="Bahan Mudah Terbakar dan Benda Panas">
                              <label for="cb_mudahTerbakarPenyebab" class="control-label">Bahan Mudah Terbakar dan Benda Panas</label>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-4">
                          <br>
                          <div class="form-group">
                            <div class="checkbox">
                              <input type="checkbox" id="cb_penggerakMula" name="cb_penggerakMula" value="Pengerak mula dan pompa">
                              <label for="cb_penggerakMula" class="control-label">Pengerak mula dan pompa</label>
                            </div>
                            <div class="checkbox">
                              <input type="checkbox" name="cb_conveyor" id="cb_conveyor" value="Conveyor">
                              <label for="cb_conveyor" class="control-label">Conveyor</label>
                            </div>
                            <div class="checkbox">
                              <input type="checkbox" name="cb_pesawatUap" id="cb_pesawatUap" value="Pesawat Uap dan Bejana Tekan">
                              <label for="cb_pesawatUap" class="control-label">Pesawat Uap dan Bejana Tekan</label>
                            </div>
                            <div class="checkbox">
                              <input type="checkbox" name="cb_debuBerbahaya" id="cb_debuBerbahaya" value="Debu Berbahaya">
                              <label for="cb_debuBerbahaya" class="control-label">Debu Berbahaya</label>
                            </div>
                            <div class="checkbox">
                              <input type="checkbox" id="cb_binatang" name="cb_binatang" value="Binatang">
                              <label for="cb_binatang" class="control-label">Binatang</label>
                            </div>
                          </div>
                        </div> 
                        <div class="col-lg-4">
                          <br>
                          <div class="form-group">
                            <div class="checkbox">
                              <input type="checkbox" id="cb_liftPenyebab" name="cb_liftPenyebab" value="Lift(Barang/Orang)">
                              <label for="cb_liftPenyebab" class="control-label">Lift(Barang/Orang)</label>
                            </div>
                            <div class="checkbox">
                              <input type="checkbox" name="cb_alatTransmisiPenyebab" id="cb_alatTransmisiPenyebab" value="Alamat Transmisi Mekanik">
                              <label for="cb_alatTransmisiPenyebab" class="control-label">Alamat Transmisi Mekanik</label>
                            </div>
                            <div class="checkbox">
                              <input type="checkbox" name="cb_peralatanListrik" id="cb_peralatanListrik" value="Peralatan Listrik">
                              <label for="cb_peralatanListrik" class="control-label">Peralatan Listrik</label>
                            </div>
                            <div class="checkbox">
                              <input type="checkbox" name="cb_radiasiPenyebab" id="cb_radiasiPenyebab" value="Radiasi dan Bahan Radioaktif">
                              <label for="cb_radiasiPenyebab" class="control-label">Radiasi dan Bahan Radioaktif</label>
                            </div>
                            <div class="checkbox">
                              <input type="checkbox" id="cb_permukaanLantai" name="cb_permukaanLantai" value="Permukaan Lantai di lingkungan kerja">
                              <label for="cb_permukaanLantai" class="control-label">Permukaan Lantai di lingkungan kerja</label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label class="control-label">Uraian Kejadian Kecelakaan :</label>
                            <br>
                            <label for="bagaimanaTerjadiKecelakaan" class="control-label">- Bagaimana terjadinya kecelakaan</label>
                            <textarea class="form-control" id="bagaimanaTerjadiKecelakaan" rows="5" name="bagaimanaTerjadiKecelakaan"></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label for="sebutkanBagianMesin" class="control-label">- Sebutkan bagian mesin, instalasi bahan atau lingkungan yang menyebabkan cidera <h6><small>*)tidak perlu diisi bagi peserta bukan penerima upah</small></h6></label>
                            <textarea class="form-control" id="sebutkanBagianMesin" rows="5" name="sebutkanBagianMesin"></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-10">
                          <div class="form-group">
                            <label class="control-label">Akibat yang diderita korban :</label><br>
                              <label class="radio-inline"><input type="radio" name="rd_akibat" id="meninggal">Meninggal</label>
                              <label class="radio-inline"><input type="radio" name="rd_akibat" id="luka">Cedera/Luka</label><br>
                            <label for="it_bagianTubuhLuka" class="control-label">- Sebutkan bagian tubuh yang luka :</label>
                            <input class="form-control" type="text" name="it_bagianTubuhLuka" id="it_bagianTubuhLuka">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-10">
                          <div class="form-group">
                            <label class="control-label">Fasilitas Kesehatan(faskes) yang memberikan pertolongan pertama :</label><br>
                            <label for="it_namafaskes" class="control-label">- Nama Faskes :</label>
                            <input class="form-control" type="text" name="it_namafaskes" id="it_namafaskes">
                            <label class="control-label">- Jenis Faskes :</label><br>
                            <label class="radio-inline"><input type="radio" name="rd_jenisFaskes" id="rsTC">Rumah Sakit Trauma Center</label>
                            <label class="radio-inline"><input type="radio" name="rd_jenisFaskes" id="kTC">Klinik Trauma Center</label>
                            <label class="radio-inline"><input type="radio" name="rd_jenisFaskes" id="bknJejaringTC">Bukan Jejaring TC</label>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label for="it_alamatFaskes" class="control-label">- Alamat Faskes :</label>
                            <input class="form-control" type="text" name="it_alamatFaskes" id="it_alamatFaskes">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                        <div class="form-group">
                            <label class="control-label">Keadaan Penderita Setelah Pemeriksaan Pertama :</label><br>
                              <label class="radio-inline"><input type="radio" name="rd_keadaan" id="rawatJalan">Rawat Jalan</label>
                              <label class="radio-inline"><input type="radio" name="rd_keadaan" id="rawatInap">Rawat Inap</label>
                        </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label for="txtarea_keteranganLain" class="control-label">Keterangan Lainnya Jika Perlu :</label>
                            <textarea class="form-control" name="txtarea_keteranganLain" id="txtarea_keteranganLain" rows="5"></textarea>
                          </div>
                        </div>
                      </div>
                    </div>            
                  </div>                         
            </div>
            <div class="btn-group pull-right">
                <button type="submit" class="btn btn-primary">Submit Di sini</button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </section>
 </body>