<section class="content">
  <div class="inner" >
      <div class="row">
          <div class="col-lg-12">
              <div class="row">
                  <div class="col-lg-12">
                      <div class="col-lg-11">
                          <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                      </div>
                      <div class="col-lg-1">
                          <div class="text-right hidden-md hidden-sm hidden-xs">
                              <a class="btn btn-default btn-lg" href="<?php echo site_url('MasterPresensi/Lelayu');?>">
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
      						<div class="box-header with-border"></div>
                        <div class="row" style="margin-top: 20px; margin-right: 10px;">
                          <div class="col-lg-12 text-right">
                            <a href="<?php echo base_url('MasterPresensi/Lelayu/ListData/exportExcel'); ?>" class="btn btn-success fa fa-file-excel-o" style="text-align: right !important;">Export Excel</a>
                          </div>
                        </div>
                        <div class="box-body box-primary">
                            <table class="datatable dataTable-List-Lelayu table table-bordered text-left" style="font-size:12px; width: 100%">
                            <div class="row"></div>
                              <thead class="bg-primary">
                                <th class="text-center" style="width: 1px;">No</th>
                                <th class="text-center">Action</th>
                                <th>Tanggal Lelayu</th>
                                <th>No induk</th>
                                <th>Nama</th>
                                <th>Keterangan</th>
                                <th>Uang Duka Perusahaan</th>
                                <th>Uang Duka SPSI</th>
                              </thead>
                              <tbody>
                                <?php
                                if (empty($data)) {
                                  // code...
                                }else {
                                  $no = 1;
                                  foreach ($data as $key) {
                                    ?>
                                  <tr>
                                    <td><?php echo $no ?></td>
                                    <td class="text-center"><a href="<?php echo base_url('MasterPresensi/Lelayu/ListData/hapus/'.$key['lelayu_id']); ?>"
                                          data-toggle="tooltip" data-placement="bottom" title="Delete Data"><span class="fa fa-trash-o fa-2x"
                                          onclick="return MP_LelayuDelete('<?php echo $key['lelayu_id'];?>')"></span></a>&nbsp&nbsp
                                        <a style="cursor: pointer;" class="fa fa-list-alt fa-2x" onclick="detailLelayu(<?= $key['lelayu_id']?>)"
                                          data-toggle='tooltip' data-placement='bottom' data-original-title='Lihat Detail'></a>&nbsp&nbsp
                                        <a href="<?php echo base_url('MasterPresensi/Lelayu/ListData/exportPDF/'.$key['lelayu_id']); ?>"
                                          data-toggle="tooltip" data-placement="bottom" title="Export PDF SPSI" class="fa fa-file-pdf-o fa-2x" ></a>&nbsp&nbsp
                                        <a href="<?php echo base_url('MasterPresensi/Lelayu/ListData/exportExcelSPSI/'.$key['lelayu_id']); ?>"
                                          data-toggle="tooltip" data-placement="bottom" title="Export Excel SPSI" class="fa fa-file-excel-o fa-2x" ></a>&nbsp&nbsp
                                          <?php $id = $key['lelayu_id']; ?>
                                        <a onclick="ApproveLelayu(<?=$id?>)" data-toggle="modal" style="cursor: pointer;"
                                          data-toggle="tooltip" data-placement="bottom" title="Print Kas Bon" class="fa fa-print fa-2x"></a>
                                    </td>
                                    <td><?php echo $key['tgl_lelayu'] ?></td>
                                    <td><?php echo $key['noind'] ?></td>
                                    <?php
                                    foreach ($namaPekerja as $val) {
                                      if ($key['noind'] == $val['noind']) {
                                        $nama = $val['nama'];
                                      }
                                    }
                                    $perusahaan = $key['kain_kafan_perusahaan']+$key['uang_duka_perusahaan'];
                                    $spsi = $key['spsi_askanit_nominal']+$key['spsi_kasie_nominal']+$key['spsi_spv_nominal']+$key['spsi_nonmanajerial_nominal'];
                                    ?>
                                    <td><?php echo $nama ?></td>
                                    <td><?php echo $key['keterangan'] ?></td>
                                    <td><?php echo "Rp ".number_format($perusahaan,2,',','.'); ?></td>
                                    <td><?php echo "Rp ".number_format($spsi,2,',','.'); ?></td>
                                  </tr>
                                <?php
                                  $no++;
                                  }
                                } ?>
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

<div class="modal fade" id="Modal_Lelayu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document" style="width: 600px">
     <div class="modal-content">
       <form method="POST" action="<?php echo site_url('MasterPresensi/Lelayu/ListData/'); ?>">
       <div class="modal-header text-center">
         <h3>Detail Lelayu</h3>
       </div>
       <div class="modal-body" style="width: 100%; text-align: center;">
          <div class="row">
            <div class="col-lg-12">
              <label class="col-lg-4 text-right">Tanggal Lelayu</label><label class="col-lg-1">:</label>
              <input  class="form-control col-lg-7" name="tgl_lelayu" id="tanggal_lelayu_id" readonly  style="width: 55%">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-lg-12">
              <label class="col-lg-4 text-right">Nama Pekerja</label><label class="col-lg-1">:</label>
              <input  class="form-control col-lg-7" name="lelayuPekerja" id="lelayu_pekerja_id" readonly  style="width: 55%">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-lg-12">
              <label class="col-lg-4 text-right">Keterangan</label><label class="col-lg-1">:</label>
              <input  class="form-control col-lg-7" name="keterangan_lelayu" id="keterangan_lelayu_id" readonly  style="width: 55%">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-lg-12">
              <label class="col-lg-4 text-right">Uang Duka Perusahaan</label><label class="col-lg-1">:</label>
              <input class="form-control col-lg-7" name="uang_perusahaan" id="uang_perusahaan_id" readonly  style="width: 55%">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-lg-12">
              <label class="col-lg-4 text-right">Uang Duka SPSI</label><label class="col-lg-1">:</label>
              <input class="form-control col-lg-7" name="uang_spsi" id="uang_spsi_id" readonly  style="width: 55%">
            </div>
          </div>
        </div>
       <div class="modal-footer" style="text-align: center;">
         <button data-dismiss="modal" class="btn btn-danger">Close</button>
       </div>
       </form>
     </div>
   </div>
 </div>

<div class="modal fade" id="Modal_Approv_kasBon" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document" style="width: 600px">
     <div class="modal-content">
       <form method="POST" id="form-kanban" target="_blank">
       <div class="modal-header text-center">
         <button type="button" class="close hover" data-dismiss="modal">&times;</button>
         <h3>Pilih Tertanda Untuk Kas Bon Lelayu</h3>
       </div>
       <div class="modal-body" style="width: 100%; text-align: center;">
          <div class="row">
            <div class="col-lg-12">
              <label class="col-lg-12 text-center">Penerima</label><br>
              <select  class=" col-lg-8 select select2 text-center" name="Penerima_kasbon" id="Penerima_kasbon"  style="width: 55%">
              <option></option>
              <?php foreach ($tertanda as $key) { ?>
                <option <?php if($key['noind'] == 'B0697'){echo "selected";} ?> value="<?php echo $key['nama'] ?>"><?php echo $key['noind']." - ".$key['nama'] ?></option>
              <?php } ?>
              </select>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-lg-12">
              <label class="col-lg-12 text-center">Menyetujui</label><br>
              <select  class="form-control col-lg-8 select select2 text-center" name="Menyetujui_kasbon" id="Menyetujui_kasbon"  style="width: 55%">
              <option></option>
              <?php foreach ($tertanda as $key) { ?>
                <option <?php if($key['noind'] == 'B0307'){echo "selected";} ?> value="<?php echo $key['nama'] ?>"><?php echo $key['noind']." - ".$key['nama'] ?></option>
              <?php } ?>
              </select>
            </div>
          </div>
        </div>
       <div class="modal-footer" style="text-align: center;">
         <button type="submit" class="btn btn-success">Kirim</button>
       </div>
       <!-- </form> -->
     </div>
   </div>
 </div>
