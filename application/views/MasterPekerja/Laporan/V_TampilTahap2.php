<body class="hold-transition login-page">
  <section class="content">
    <div class="panel-group">
      <div class="panel panel-primary">
          <div class="panel-heading text-center"><b>LAPORAN KASUS KECELAKAAN KERJA</b></div>
        <div class="panel-body">
          <form name="frm_inputKecelakaan" method="post" action="<?php echo base_url('MasterPekerja/KecelakaanKerja/updateTahap2'.'/'.$data[0]['id_lkk_2']); ?>">
            <h3 class="text-primary text-center">TAHAP II</h3>
               
                
            <div class="panel-group"> 
              <div class="panel panel-primary"> 
                <div class="panel-heading">
                  
                </div>
                <div class="panel-body">
                  <div class="row">
                      <div class="col-lg-3">
                        <div class="form-group has-feedback">
                          <label>No Induk Pekerja :</label> 
                            <input class="form-control" type="text" name="txt_noindPekerja" value="<?php echo $data[0]['noind'] ?>" readonly="">
                        </div> 
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group has-feedback">
                          <label>Kode Mitra Perusahaan :</label>
                            <input class="form-control" type="text" name="txt_kodemitraPerusahaan" value="<?php echo $data1[0]['kode_mitra'] ?>"  readonly="">
                        </div> 
                      </div>
                      <div class="col-lg-3"> 
                        <div class="form-group">
                          <label class="control-label" for="KecelakaanKerja-txt_tgl_kecelakaan">Tanggal Kecelakaan :</label>
                            <input type="text" name="txt_tgl_kecelakaan" class="form-control" id="KecelakaanKerja-txt_tgl_kecelakaan" value="<?php echo $data1[0]['tgl_kk'] ?>" readonly="">
                        </div>
                      </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                        <label class="control-label">Laporan kasus kecelakaan kerja Tahap I telah disampaikan kepada BPJS Ketenagakerjaan dan Kantor Dinas Tenaga Kerja :</label>
                        <div>
                          <div class="form-group">
                          <?php
                          if ($data[0]['status_lkk_1'] == "Belum disampaikan") {
                            ?>
                            <label class="radio-inline"><input id="radio1" type="radio" name="rd_disampaikan" value="Belum disampaikan" checked="checked">Belum disampaikan</label>
                            <label class="radio-inline"><input id="radio2" type="radio" name="rd_disampaikan" value="Sudah disampaikan">Sudah disampaikan pada </label>
                            <?php
                           }else {
                            ?>
                            <label class="radio-inline"><input id="radio1" type="radio" name="rd_disampaikan" value="Belum disampaikan" >Belum disampaikan</label>
                            <label class="radio-inline"><input id="radio2" type="radio" name="rd_disampaikan" value="Sudah disampaikan" checked="checked">Sudah disampaikan pada </label>
                            <?php
                           } 
                          ?>                            
                            
                            <?php
                            if ($data[0]['status_lkk_1'] == "Belum disampaikan") {
                            ?>
                               <input type="text" name="txt_tgl_kirim_tahap1" class="KecelakaanKerja-daterangepickersingledatewithtime" id="txt_tgl_kirim_tahap1">
                            <?php
                             }else {
                            ?>
                              <input type="text" name="txt_tgl_kirim_tahap1" class="KecelakaanKerja-daterangepickersingledatewithtime" id="txt_tgl_kirim_tahap1" value="<?php echo $data[0]['tgl_lkk_1'] ?>">
                            <?php
                             } 
                            ?>                             
                          </div>
                        </div>  
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3">
                      <label class="control-label">Pengajuan Pembiayaan oleh :</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <?php
                        if ($data[0]['pengajuan_pembiayaan'] == "Perusahaan") {
                          ?>
                          <label class="radio-inline"><input type="radio" name="rd_pengajuan" value="Perusahaan" checked="checked">Perusahaan</label>
                          <label class="radio-inline"><input type="radio" name="rd_pengajuan" value="Peserta">Peserta</label>
                          <label class="radio-inline"><input type="radio" name="rd_pengajuan" value="Faskes Trauma Center">Faskes Trauma Center</label>
                           <label class="radio-inline"><input type="radio" name="rd_pengajuan" value="Ahli Waris">Ahli Waris</label>
                          <?php
                         }else if ($data[0]['pengajuan_pembiayaan'] == "Peserta") {
                            ?>
                          <label class="radio-inline"><input type="radio" name="rd_pengajuan" value="Perusahaan" >Perusahaan</label>
                          <label class="radio-inline"><input type="radio" name="rd_pengajuan" value="Peserta" checked="checked">Peserta</label>
                          <label class="radio-inline"><input type="radio" name="rd_pengajuan" value="Faskes Trauma Center">Faskes Trauma Center</label>
                           <label class="radio-inline"><input type="radio" name="rd_pengajuan" value="Ahli Waris">Ahli Waris</label>
                          <?php
                         }else if ($data[0]['pengajuan_pembiayaan'] == "Faskes Trauma Center") {
                            ?>
                          <label class="radio-inline"><input type="radio" name="rd_pengajuan" value="Perusahaan" >Perusahaan</label>
                          <label class="radio-inline"><input type="radio" name="rd_pengajuan" value="Peserta">Peserta</label>
                          <label class="radio-inline"><input type="radio" name="rd_pengajuan" value="Faskes Trauma Center" checked="checked">Faskes Trauma Center</label>
                           <label class="radio-inline"><input type="radio" name="rd_pengajuan" value="Ahli Waris">Ahli Waris</label>
                          <?php
                         }else if ($data[0]['pengajuan_pembiayaan'] == "Ahli Waris") {
                            ?>
                          <label class="radio-inline"><input type="radio" name="rd_pengajuan" value="Perusahaan" >Perusahaan</label>
                          <label class="radio-inline"><input type="radio" name="rd_pengajuan" value="Peserta">Peserta</label>
                          <label class="radio-inline"><input type="radio" name="rd_pengajuan" value="Faskes Trauma Center">Faskes Trauma Center</label>
                           <label class="radio-inline"><input type="radio" name="rd_pengajuan" value="Ahli Waris" checked="checked">Ahli Waris</label>
                          <?php
                         }
                        ?>
                          
                      </div>
                    </div>
                  </div>
                  <?php
                  $b = 0;
                  foreach ($biaya as $op) {
                  
                  ?>
                  <div class="row">
                    <div class="col-lg-3">
                      <label class="radio-inline"><?php echo $biaya[$b]['keterangan']; ?></label>
                    </div>
                    <div class="col-lg-3">
                      <input type="text" name="txt_biaya<?= $b ?>" value="<?php echo $kbiaya[$b]['nominal'] ?>" placeholder="Rp..." class="form-control">
                    </div>
                  </div>
                  <?php
                  $b++;
                   } 
                  ?>

                  <!-- <div class="row">
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="radio-inline">a) biaya pengangkutan</label>
                      </div>
                    </div>
                    <div class="col-lg-1">
                      <label class="radio-inline">: Rp</label>
                    </div>
                    <div class="col-lg-3">
                      <input type="text" name="txt_pengangkutan" class="form-control">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="radio-inline">b) biaya pengobatan dan perawatan</label>
                      </div>
                    </div>
                    <div class="col-lg-1">
                      <label class="radio-inline">: Rp</label>
                    </div>
                    <div class="col-lg-3">
                      <input type="text" name="txt_pengobatan" class="form-control">
                    </div>
                  </div> 
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="radio-inline">c) biaya Rehabilitasi</label>
                      </div>
                    </div>
                    <div class="col-lg-1">
                      <label class="radio-inline">: Rp</label>
                    </div>
                    <div class="col-lg-3">
                      <input type="text" name="txt_rehabilitasi" class="form-control">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="radio-inline">d) biaya prothesa/orthesa</label>
                      </div>
                    </div>
                    <div class="col-lg-1">
                      <label class="radio-inline">: Rp</label>
                    </div>
                    <div class="col-lg-3">
                      <input type="text" name="txt_proor" class="form-control">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="radio-inline">e) biaya Pemakaman</label>
                      </div>
                    </div>
                    <div class="col-lg-1">
                      <label class="radio-inline">: Rp</label>
                    </div>
                    <div class="col-lg-3">
                      <input type="text" name="txt_pemakaman" class="form-control">
                    </div>
                  </div> -->
                  <div class="row">
                    <div class="col-lg-12">
                      <label>Penerima manfaat pembiayaan :</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <?php
                        if ($data[0]['penerima_pembiayaan'] == "Perusahaan") {
                           ?>
                            <label class="radio-inline"><input type="radio" name="rd_penerima" value="Perusahaan" checked="checked"> Perusahaan</label>
                            <label class="radio-inline"><input type="radio" name="rd_penerima" value="Peserta"> Peserta</label>
                            <label class="radio-inline"><input type="radio" name="rd_penerima" value="Faskes Trauma Center"> Faskes Trauma Center</label>
                            <label class="radio-inline"><input type="radio" name="rd_penerima" value="Ahli Waris"> Ahli Waris</label>
                           <?php
                         }else if ($data[0]['penerima_pembiayaan'] == "Peserta") {
                           ?>
                            <label class="radio-inline"><input type="radio" name="rd_penerima" value="Perusahaan"> Perusahaan</label>
                            <label class="radio-inline"><input type="radio" name="rd_penerima" value="Peserta" checked="checked"> Peserta</label>
                            <label class="radio-inline"><input type="radio" name="rd_penerima" value="Faskes Trauma Center"> Faskes Trauma Center</label>
                            <label class="radio-inline"><input type="radio" name="rd_penerima" value="Ahli Waris"> Ahli Waris</label>
                           <?php
                         }else if ($data[0]['penerima_pembiayaan'] == "Faskes Trauma Center") {
                           ?>
                            <label class="radio-inline"><input type="radio" name="rd_penerima" value="Perusahaan"> Perusahaan</label>
                            <label class="radio-inline"><input type="radio" name="rd_penerima" value="Peserta"> Peserta</label>
                            <label class="radio-inline"><input type="radio" name="rd_penerima" value="Faskes Trauma Center"  checked="checked"> Faskes Trauma Center</label>
                            <label class="radio-inline"><input type="radio" name="rd_penerima" value="Ahli Waris"> Ahli Waris</label>
                           <?php
                         }else if ($data[0]['penerima_pembiayaan'] == "Ahli Waris") {
                           ?>
                            <label class="radio-inline"><input type="radio" name="rd_penerima" value="Perusahaan"> Perusahaan</label>
                            <label class="radio-inline"><input type="radio" name="rd_penerima" value="Peserta"> Peserta</label>
                            <label class="radio-inline"><input type="radio" name="rd_penerima" value="Faskes Trauma Center"  > Faskes Trauma Center</label>
                            <label class="radio-inline"><input type="radio" name="rd_penerima" value="Ahli Waris" checked="checked"> Ahli Waris</label>
                           <?php
                         }
                        ?>
                        
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <label>Pengajuan Santunan Sementara Tidak Mampu Bekerja(STMB) :</label>
                    </div>
                  </div>
                  <?php
                  $z = 0;
                  $c_stmb = count($stmb);
                  for ($c=1; $c < 3; $c++) { 
                   
                  ?>
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label>Periode Awal</label>
                        <?php
                        if ($c_stmb == 0) {
                          ?>
                          <input type="text" name="txt_periode_awal<?= $c ?>" class="KecelakaanKerja-daterangepickersingledate form-control" value="">
                          <?php
                        }
                         if ($c_stmb == 1 and $c == 1) {
                        ?>
                         <input type="text" name="txt_periode_awal<?= $c ?>" class="KecelakaanKerja-daterangepickersingledate form-control" value="<?php echo $stmb[0]['periode_awal'] ?>">
                        <?php
                          } 
                          if ($c_stmb == 1 and $c == 2) {
                          ?>
                            <input type="text" name="txt_periode_awal<?= $c ?>" class="KecelakaanKerja-daterangepickersingledate form-control">
                          <?php
                          }
                          if ($c_stmb == 2) {
                          ?>
                          <input type="text" name="txt_periode_awal<?= $c ?>" class="KecelakaanKerja-daterangepickersingledate form-control" value="<?php echo $stmb[$z]['periode_awal'] ?>">
                          <?php
                          }
                        ?>
                        
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label>Periode Berakhir</label>
                        <?php
                        if ($c_stmb == 0) {
                          ?>
                          <input type="text" name="txt_periode_akhir<?= $c ?>" class="KecelakaanKerja-daterangepickersingledate form-control" value="">
                          <?php
                        }
                         if ($c_stmb == 1 and $c == 1) {
                        ?>
                        <input type="text" name="txt_periode_akhir<?= $c ?>" class="KecelakaanKerja-daterangepickersingledate form-control" value="<?php echo $stmb[0]['periode_akhir'] ?>">
                        <?php
                          } 
                          if ($c_stmb == 1 and $c == 2) {
                          ?>
                            <input type="text" name="txt_periode_akhir<?= $c ?>" class="KecelakaanKerja-daterangepickersingledate form-control" >
                          <?php
                          }
                          if ($c_stmb == 2) {
                          ?>
                          <input type="text" name="txt_periode_akhir<?= $c ?>" class="KecelakaanKerja-daterangepickersingledate form-control" value="<?php echo $stmb[$z]['periode_akhir'] ?>">
                          <?php
                          }
                        ?>
                        
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label>Jumlah besarnya STMB</label>
                        <?php
                        if ($c_stmb == 0) {
                          ?>
                          <input type="text" name="txt_jml_stmb<?= $c ?>" class="form-control" value="" placeholder="Rp ...">
                          <?php
                        }
                         if ($c_stmb == 1 and $c == 1) {
                        ?>
                          <input type="text" name="txt_jml_stmb<?= $c ?>" class="form-control" placeholder="Rp ..." value="<?php echo $stmb[0]['nominal'] ?>">
                        <?php
                          } 
                          if ($c_stmb == 1 and $c == 2) {
                          ?>
                           <input type="text" name="txt_jml_stmb<?= $c ?>" class="form-control" placeholder="Rp ...">
                          <?php
                          }
                          if ($c_stmb == 2) {
                          ?>
                          <input type="text" name="txt_jml_stmb<?= $c ?>" class="form-control" placeholder="Rp ..." value="<?php echo $stmb[$z]['nominal'] ?>">
                          <?php
                          }
                        ?>
                        
                      </div>
                    </div>
                  </div>
                  <?php
                  $z++;
                   } 
                  ?>
                  <!-- <div class="row">
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label for="KK_txt_periode_a">a) Periode</label>
                        <input type="text" name="txt_periode_a" id="KK_txt_periode_a" class="KecelakaanKerja-daterangepicker form-control">
                      </div>                      
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label for="KK_txt_jml_stmb_a">Jumlah besarnya STMB </label>
                        <input type="text" name="txt_jml_stmb_a" id="KK_txt_jml_stmb_a" class="form-control" placeholder="Rp ....">
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label for="KK_txt_periode_b">b) Periode</label>
                        <input type="text" name="txt_periode_b" id="KK_txt_periode_b" class="KecelakaanKerja-daterangepicker form-control">
                      </div>                      
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label for="KK_txt_jml_stmb_b">Jumlah besarnya STMB </label>
                        <input type="text" name="txt_jml_stmb_b" id="KK_txt_jml_stmb_b" class="form-control" placeholder="Rp ....">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label for="KK_txt_periode_c">c) Periode</label>
                        <input type="text" name="txt_periode_c" id="KK_txt_periode_c" class="KecelakaanKerja-daterangepicker form-control">
                      </div>                      
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label for="KK_txt_jml_stmb_c">Jumlah besarnya STMB </label>
                        <input type="text" name="txt_jml_stmb_c" id="KK_txt_jml_stmb_c" class="form-control" placeholder="Rp ....">
                      </div>
                    </div> -->
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label>Uraian keterangan dokter tentang kondisi fisik/mental peserta pasca kecelakaan kerja</label>
                        <?php
                        if ($data[0]['keterangan_dokter'] == "Terlampir") {
                           ?>
                            <label class="radio-inline"><input type="radio" name="rd_terlampir" value="Terlampir" checked="checked">Terlampir</label>
                            <label class="radio-inline"><input type="radio" name="rd_terlampir" value="Tidak Terlampir">Tidak Terlampir</label>
                           <?php
                         } else {
                           ?>
                           <label class="radio-inline"><input type="radio" name="rd_terlampir" value="Terlampir">Terlampir</label>
                            <label class="radio-inline"><input type="radio" name="rd_terlampir" value="Tidak Terlampir" checked="checked">Tidak Terlampir</label>
                           <?php
                         }
                        ?>                        
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                          <label>Berdasarkan Surat Keterangan dokter bentuk KK4 atau KK5 ditetapkan terlampir :</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-4">
                      <div class="col-lg-5">
                        <label class="radio-inline">Pada tanggal </label>
                      </div>
                      <div class="col-lg-7">
                        <input type="text" name="txt_tgl_kk4" class="form-control KecelakaanKerja-daterangepickersingledate" value="<?php echo $data[0]['tgl_kk4'] ?>">
                      </div>
                    </div>                    
                    <div class="col-lg-2">
                      <label class="radio-inline">peserta ditetapkan </label>
                    </div>
                  </div>
                  <div class="row">
                    <!-- <?php
                    foreach ($ukk4 as $key => $value) {
                      $ukk[] = $value['id_ket_kk4'];
                    }
                      // echo "<pre>";
                      // print_r($ukk);

                    foreach ($kk4 as $row ) {
                      ?>
                          <div class="checkbox">
                              <label class="control-label">
                              <input <?= (in_array($row['id_ket_kk4'],$ukk)) ? 'checked' : '' ?> type="checkbox" value="<?php echo $row['id_ket_kk4'] ?>" name="ket[]; ?>" > <?php echo $row['keterangan'] ?></input>
                              </label>
                          </div>
                    <?php
                    }
                    ?> -->

                    <?php
                    foreach ($ukk4 as $key => $value) {
                      $ukk[] = $value['id_ket_kk4'];
                    }
                    $indeks = 1;
                    foreach ($kk4 as $row) {
                    
                    if ( $indeks % 4 == 1 ) {
                    ?>
                    <div class="col-lg-6">
                    <?php
                    }
                    ?> 
                         <div class="checkbox">
                              <label class="control-label">
                              <input <?= (in_array($row['id_ket_kk4'],$ukk)) ? 'checked' : '' ?> type="checkbox" value="<?php echo $row['id_ket_kk4'] ?>" name="ket[]; ?>" > <?php echo $row['keterangan'] ?></input>
                              </label>
                          </div>
                        <?php      
                   
                    if ($indeks % 4 == 0) {
                     
                    ?>
                    </div>
                    <?php
                    } 
                    ?>
                    <?php
                    $indeks++;
                     } 
                    ?>
                  </div>
                </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label>Besarnya pembiayaan dan santunan yang telah diberikan kepada peserta atau ahli waris pasca kecelakaan kerja :</label>
                        <div class="col-lg-6">
                          <input type="text" name="txt_santunan" class="form-control" placeholder="Rp ....." value="<?php echo $data[0]['santunan'] ?>">
                        </div>                      
                      </div>                      
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-lg-6">
                      <label>Penerima manfaat santunan (ahli waris) :</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3">
                      <label class="radio-inline">Nama Peserta</label>
                    </div>
                    <div class="col-lg-1">
                      <label class="radio-inline">:</label>
                    </div>
                    <div class="col-lg-6">
                      <input type="text" name="txt_pnama" class="form-control" value="<?php echo $data[0]['penerima_nama'] ?>">
                    </div>
                  </div> 
                  <div class="row">
                    <div class="col-lg-3">
                      <label class="radio-inline">Nomor Identitas Kependudukan</label>
                    </div>
                    <div class="col-lg-1">
                      <label class="radio-inline">:</label>
                    </div>
                    <div class="col-lg-4">
                      <input type="text" name="txt_pnik" class="form-control" value="<?php echo $data[0]['penerima_nik'] ?>"> 
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3">
                      <label class="radio-inline">Hubungan ahli waris dengan peserta</label>
                    </div>
                    <div class="col-lg-1">
                      <label class="radio-inline">:</label>
                    </div>
                    <div class="col-lg-8">
                      
                        <?php
                        if ($data[0]['penerima_status_hubungan'] == null) {
                          ?>
                           <div class="row">
                            <div class="col-lg-12">
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Janda/Duda"> Janda/duda</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Anak"> Anak</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Ayah/Ibu"> Ayah/Ibu</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Kakek/Nenek"> Kakek/Nenek</label>
                            </div>                      
                          </div>
                          <div class="row">
                            <div class="col-lg-12">
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Saudara Kandung"> Saudara Kandung</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Cucu"> Cucu</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Mertua"> Mertua</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Pihak yang ditunjuk dalam wasiat"> Pihak yang ditunjuk dalam wasiat</label>
                            </div>
                          </div> 
                          <?php
                        }
                        if ($data[0]['penerima_status_hubungan'] == "Janda/Duda") {
                          ?>
                          <div class="row">
                            <div class="col-lg-12">
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Janda/Duda" checked="checked"> Janda/duda</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Anak"> Anak</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Ayah/Ibu"> Ayah/Ibu</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Kakek/Nenek"> Kakek/Nenek</label>
                            </div>                      
                          </div>
                          <div class="row">
                            <div class="col-lg-12">
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Saudara Kandung"> Saudara Kandung</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Cucu"> Cucu</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Mertua"> Mertua</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Pihak yang ditunjuk dalam wasiat"> Pihak yang ditunjuk dalam wasiat</label>
                            </div>
                          </div> 
                          <?php
                        }else if ($data[0]['penerima_status_hubungan'] == "Anak") {
                          ?>
                          <div class="row">
                            <div class="col-lg-12">
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Janda/Duda"> Janda/duda</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Anak" checked="checked"> Anak</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Ayah/Ibu"> Ayah/Ibu</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Kakek/Nenek"> Kakek/Nenek</label>
                            </div>                      
                          </div>
                          <div class="row">
                            <div class="col-lg-12">
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Saudara Kandung"> Saudara Kandung</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Cucu"> Cucu</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Mertua"> Mertua</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Pihak yang ditunjuk dalam wasiat"> Pihak yang ditunjuk dalam wasiat</label>
                            </div>
                          </div> 
                          <?php
                        }else if ($data[0]['penerima_status_hubungan'] == "Ayah/Ibu") {
                          ?>
                          <div class="row">
                            <div class="col-lg-12">
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Janda/Duda"> Janda/duda</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Anak"> Anak</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Ayah/Ibu" checked="checked"> Ayah/Ibu</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Kakek/Nenek"> Kakek/Nenek</label>
                            </div>                      
                          </div>
                          <div class="row">
                            <div class="col-lg-12">
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Saudara Kandung"> Saudara Kandung</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Cucu"> Cucu</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Mertua"> Mertua</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Pihak yang ditunjuk dalam wasiat"> Pihak yang ditunjuk dalam wasiat</label>
                            </div>
                          </div> 
                          <?php
                        }else if ($data[0]['penerima_status_hubungan'] == "Kakek/Nenek") {
                          ?>
                          <div class="row">
                            <div class="col-lg-12">
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Janda/Duda"> Janda/duda</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Anak"> Anak</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Ayah/Ibu"> Ayah/Ibu</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Kakek/Nenek" checked="checked"> Kakek/Nenek</label>
                            </div>                      
                          </div>
                          <div class="row">
                            <div class="col-lg-12">
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Saudara Kandung"> Saudara Kandung</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Cucu"> Cucu</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Mertua"> Mertua</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Pihak yang ditunjuk dalam wasiat"> Pihak yang ditunjuk dalam wasiat</label>
                            </div>
                          </div> 
                          <?php
                        }else if ($data[0]['penerima_status_hubungan'] == "Saudara Kandung") {
                          ?>
                          <div class="row">
                            <div class="col-lg-12">
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Janda/Duda"> Janda/duda</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Anak"> Anak</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Ayah/Ibu"> Ayah/Ibu</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Kakek/Nenek"> Kakek/Nenek</label>
                            </div>                      
                          </div>
                          <div class="row">
                            <div class="col-lg-12">
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Saudara Kandung" checked="checked"> Saudara Kandung</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Cucu"> Cucu</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Mertua"> Mertua</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Pihak yang ditunjuk dalam wasiat"> Pihak yang ditunjuk dalam wasiat</label>
                            </div>
                          </div> 
                          <?php
                        }else if ($data[0]['penerima_status_hubungan'] == "Cucu") {
                          ?>
                          <div class="row">
                            <div class="col-lg-12">
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Janda/Duda"> Janda/duda</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Anak"> Anak</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Ayah/Ibu"> Ayah/Ibu</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Kakek/Nenek"> Kakek/Nenek</label>
                            </div>                      
                          </div>
                          <div class="row">
                            <div class="col-lg-12">
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Saudara Kandung"> Saudara Kandung</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Cucu" checked="checked"> Cucu</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Mertua"> Mertua</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Pihak yang ditunjuk dalam wasiat"> Pihak yang ditunjuk dalam wasiat</label>
                            </div>
                          </div> 
                          <?php
                        }else if ($data[0]['penerima_status_hubungan'] == "Mertua") {
                          ?>
                          <div class="row">
                            <div class="col-lg-12">
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Janda/Duda"> Janda/duda</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Anak"> Anak</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Ayah/Ibu"> Ayah/Ibu</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Kakek/Nenek"> Kakek/Nenek</label>
                            </div>                      
                          </div>
                          <div class="row">
                            <div class="col-lg-12">
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Saudara Kandung"> Saudara Kandung</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Cucu" > Cucu</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Mertua" checked="checked"> Mertua</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Pihak yang ditunjuk dalam wasiat"> Pihak yang ditunjuk dalam wasiat</label>
                            </div>
                          </div> 
                          <?php
                        }else if ($data[0]['penerima_status_hubungan'] == "Pihak yang ditunjuk dalam wasiat") {
                          ?>
                          <div class="row">
                            <div class="col-lg-12">
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Janda/Duda"> Janda/duda</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Anak"> Anak</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Ayah/Ibu"> Ayah/Ibu</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Kakek/Nenek"> Kakek/Nenek</label>
                            </div>                      
                          </div>
                          <div class="row">
                            <div class="col-lg-12">
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Saudara Kandung"> Saudara Kandung</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Cucu" > Cucu</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Mertua"> Mertua</label>
                              <label class="radio-inline"><input type="radio" name="rd_hubungan" value="Pihak yang ditunjuk dalam wasiat"  checked="checked"> Pihak yang ditunjuk dalam wasiat</label>
                            </div>
                          </div> 
                          <?php
                        }
                        ?>

                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3">
                      <label class="radio-inline">Alamat/ no telp</label>
                    </div>
                    <div class="col-lg-1">
                      <label class="radio-inline">:</label>
                    </div>
                    <div class="col-lg-8">
                      <input type="text" name="txt_palamat" class="form-control" value="<?php echo $data[0]['alamat'] ?>">
                      <div class="row">
                        <div class="col-lg-4">
                          <input type="text" name="txt_pdesa" placeholder="Desa/Kel" class="form-control" value="<?php echo $data[0]['desa'] ?>">
                        </div>
                        <div class="col-lg-4">
                          <input type="text" name="txt_pkec" placeholder="Kecamatan" class="form-control" value="<?php echo $data[0]['kecamatan'] ?>">
                        </div>
                        <div class="col-lg-4">
                          <input type="text" name="txt_pkab" placeholder="Kabupaten/Kota" class="form-control" value="<?php echo $data[0]['kota'] ?>">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-4">
                          <input type="text" name="txt_pkodepos" placeholder="Kode Pos" class="form-control" value="<?php echo $data[0]['kode_pos'] ?>">
                        </div>
                        <div class="col-lg-5">
                          <input type="text" name="txt_pnotelp" placeholder="No Telp/hp" class="form-control" value="<?php echo $data[0]['no_telp'] ?>">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3">
                      <label class="radio-inline">Nomor Rekening</label>
                    </div>
                    <div class="col-lg-1">
                      <label class="radio-inline">:</label>
                    </div>
                    <div class="col-lg-6">
                      <input type="text" name="txt_prekening" class="form-control" value="<?php echo $data[0]['no_rekening'] ?>">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3">
                      <label class="radio-inline">Nama Bank</label>
                    </div>
                    <div class="col-lg-1">
                      <label class="radio-inline">:</label>
                    </div>
                    <div class="col-lg-8">
                      <input type="text" name="txt_pnamabank" class="form-control" value="<?php echo $data[0]['nama_bank'] ?>">
                    </div>
                  </div>
                  <br>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label class="control-label">Keterangan Lainnya jika perlu :</label>
                      <textarea name="txtarea_keteranganlain" class="form-control" style="width: 1026px; height: 100px;"><?php echo $data[0]['keterangan_lain'] ?></textarea>
                    </div>                     
                  </div>
                </div>                          
              </div>                                        
            </div>
            <br>
            <div class="btn-group pull-right">
                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </section>
 </body>