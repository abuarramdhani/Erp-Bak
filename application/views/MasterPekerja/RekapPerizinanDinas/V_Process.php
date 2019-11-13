<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b>Rekap Perizinan Dinas Keluar</b></h1></div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('PerizinanDinas/AtasanApproval/V_Index');?>">
                                    <i class="icon-wrench icon-2x"></i>
                                    <br/>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
				<div class="row">
                 <form id="" method="post" action="<?php echo site_url('MasterPekerja/RekapPerizinanDinas/rekapbulanan');?>" class="form-horizontal" >
                <div class="col-lg-12">
                    <div class="box box-primary box-solid">
                        <div class="box-header with-border"></div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <label for="txtTanggalCetak" class="col-lg-3 control-label text-left">Periode Rekap</label>
                                                <div class="col-lg-7">
                                                   <input class="form-control periodeRekap"  autocomplete="off" type="text" name="periodeRekap" id="periodeRekap" placeholder="Masukkan Periode" value=""/>
                                                    <!-- <button type="submit" class="btn btn-primary">Cari</button> -->
                                                   <p>*kosongkan kolom periode , untuk menampilkan semua data</p>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-2">
                                                        <button type="submit" class="btn btn-primary">Cari</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             </div>
                        </div>
                     </div>
                     </form>
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                        <div class="box-header with-border text-center"><?php echo $Title; ?></div>
                            <div class="box-body">
                              <div id="izin-ok">
                              <table class="table table-striped table-bordered table-hover tabel_rekap" style="width: 100%">
                                <thead>
                                  <tr>
                                    <th class="text-center" style="white-space: nowrap;">No</th>
                                    <th class="text-center" style="white-space: nowrap;">ID Izin</th>
                                    <th class="text-center" style="white-space: nowrap;">Tanggal Pengajuan</th>
                                    <th class="text-center" style="white-space: nowrap;">Nama Pekerja</th>
                                    <th class="text-center" style="white-space: nowrap;">Jenis Izin</th>
                                    <th class="text-center" style="white-space: nowrap;">Atasan Approved</th>
                                    <th class="text-center" style="white-space: nowrap;">Keterangan</th>
                                    <th class="text-center" style="white-space: nowrap;">Status</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php $no = 1;
                                  foreach ($IzinApprove as $row) { ?>
                                    <tr>
                                      <td style="white-space: nowrap;"><?php echo $no; ?></td>
                                      <td style="white-space: nowrap;"><?php echo $row['izin_id'] ?></td>
                                      <td style="white-space: nowrap;"><?= date("d - M - Y", strtotime($row['created_date'])); ?></td>
                                      <td style="white-space: nowrap;"><?php $noind = explode(', ', $row['noind']); //print_r($noind);die;
                                       foreach ($noind as $kalue) {
                                         foreach ($nama as $kuy) {
                                           if ($kalue == $kuy['noind']) {
                                             echo $kuy['noind'].' - '.$kuy['nama'].'<br>';
                                           }
                                         }
                                       } ?></td>
                                      <td style="text-align: center; white-space: nowrap;"><?php if ( $row['jenis_izin'] == '1') {
                                                                                      echo "DINAS PUSAT";
                                                                                    }elseif ( $row['jenis_izin'] == '2') {
                                                                                      echo "DINAS TUKSONO";
                                                                                    }elseif ( $row['jenis_izin'] == '3') {
                                                                                      echo "DINAS MLATI";
                                                                                    } ?>
                                      </td>
                                      <td style="white-space: nowrap;"><?php foreach ($nama as $key) {
                                        if ($row['atasan_aproval'] == $key['noind']) {
                                          echo $key['noind'].' - '.$key['nama'];
                                        }
                                      } ?></td>
                                      <td style="white-space: nowrap;"><?php echo $row['keterangan'] ?></td>
                                      <td style="text-align: center; white-space: nowrap;"><?php
                                                      if ($row['status'] == 0) { ?>
                                                          <span class="label" style="background-color: #E0E0E0; color: black">Unapproved</span>
                                                      <?php } elseif ($row['status'] == 1) { ?>
                                                           <span class="label label-success">Approved</span>
                                                      <?php } elseif ($row['status'] == 2) { ?>
                                                          <span class="label label-danger">Rejected</span>
                                                      <?php } ?>
                                                </td>
                                    </tr>
                                    <?php
                                    $no++;
                                  }
                                  ?>
                                </tbody>
                              </table>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
