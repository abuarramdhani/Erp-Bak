<style media="screen">
  .hover:hover {
    color: red;
  }
</style>
<section class="content" id="page">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b><?php echo $Title; ?></b></h1></div>
                        </div>
                        <div class="col-lg-1">
                          <div class="text-right hidden-md hidden-sm hidden-xs">
                              <a class="btn btn-default btn-lg" href="<?php echo site_url('CateringTambahan/Seksi');?>">
                                <i class="icon-wrench icon-2x"></i>
                              </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  <div class="row">
                    <div class="col-lg-12">
                     <div class="box box-primary box-solid">
                         <div class="box-header with-border">
                           <h4>SEKSI : <?php echo $sesiUser;  ?></h4>
                         </div>
                         <div class="box-body">
                           <div class="tab-content">
                             <table class="datatable approvedCat table table-striped table-bordered table-hover text-left" style="font-size:12px;">
                                 <thead class="bg-primary">
                                   <tr>
                                     <th style="width: 30px;">No</th>
                                     <th style="width: 150px; text-align: center;">Action</th>
                                     <th>Tanggal Pesanan</th>
                                     <th>Tempat Makan</th>
                                     <th>Tambahan</th>
                                     <th>Nama Pemesan</th>
                                     <th class="text-center">Status</th>
                                   </tr>
                                 </thead>
                                 <tbody>
                                   <?php
                                   if (empty($list)) {
                                     # code...
                                   }else{
                                     $no=1;
                                     foreach ($list as $key) { ?>
                                       <tr>
                                         <td><?php echo $no; ?></td>
                                         <td class="text-center"><i class="btn fa fa-list-alt fa-2x btn-xs " data-toggle="tooltip" title="Detail Pesanan"
                                           style="border-radius:3px; padding:1px 5px; margin-top:5px;"
                                           onclick="listdatadetail(<?= $key['id']?>)"></i></td>
                                         <td><?php echo $key['tanggal']; ?></td>
                                         <td><?php echo $key['tempat_makan']; ?></td>
                                         <td><?php if (empty($key['tambahan'])) {
                                             echo "-";
                                           }else {
                                             echo  $key['tambahan'];
                                           }; ?></td>
                                           <?php foreach ($sie as $keyb){
                                             if ($key['user_'] == $keyb['noind']) {
                                               $noind = $keyb['noind'];
                                               $nama = $keyb['nama'];
                                             }
                                           }; ?>
                                           <td><?php echo $noind." - ".$nama; ?></td>
                                         <?php if ($key['status'] == 1): ?>
                                           <td class="text-center"><i class="fa fa-2x fa-hourglass-2" data-toggle="tooltip" title="Waiting Approve"
                                           style="padding:1px 5px; margin-top:5px;"></i></td>
                                           <?php elseif ($key['status'] == 2): ?>
                                             <td class="text-center"><i class="fa fa-2x fa-check" data-toggle="tooltip" title="Approved"
                                               style="padding:1px 5px; margin-top:5px; color:green;"></i></td>
                                             <?php elseif ($key['status'] == 4): ?>
                                               <td class="text-center"><i class="fa fa-2x fa-close" data-toggle="tooltip" title="Failed"
                                                 style="padding:1px 5px; margin-top:5px; color: red;"></i></td>
                                             <?php else: ?>
                                               <td class="text-center"><i class="fa fa-2x fa-close" data-toggle="tooltip" title="Rejected"
                                                 style="padding:1px 5px; margin-top:5px; color: red;"></i></td>
                                         <?php endif; ?>
                                       </tr>
                                       <?php
                                       $no++;
                                     } } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>

  <!-- //modal// -->
  <div class="modal fade" id="modal_ListPesanan-catering" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 600px">
      <div class="modal-content">
        <div class="modal-header text-center">
          <button type="button" class="close hover" data-dismiss="modal">&times;</button>
          <h3>Detail Pesanan</h3>
        </div>
        <div class="modal-body" style="width: 100%; text-align: center;">
          <div class="row">
            <input type="hidden" id="id_list">
            <div class="col-lg-12">
              <label class="col-lg-4 text-right">Nama Pemesan</label><label class="col-lg-1">:</label>
              <input  class="form-control col-lg-7" name="Pemesan1" id="pemesan_List" readonly  style="width: 55%">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-lg-12">
              <label class="col-lg-4 text-right">Seksi</label><label class="col-lg-1">:</label>
              <input  class="form-control col-lg-7" name="siePesan1" id="siePesan_List" readonly  style="width: 55%">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-lg-12">
              <label class="col-lg-4 text-right">Shift</label><label class="col-lg-1">:</label>
              <input  class="form-control col-lg-7" name="Shift_Tambahan1" id="Shift_Tambahan_List" readonly  style="width: 55%">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-lg-12">
              <label class="col-lg-4 text-right">Lokasi Kerja</label><label class="col-lg-1">:</label>
              <input class="form-control col-lg-7" name="lokasi_kerja1" id="lokasi_kerja_Tambahan_List" readonly  style="width: 55%">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-lg-12">
              <label class="col-lg-4 text-right">Tempat Makan</label><label class="col-lg-1">:</label>
              <input class="form-control col-lg-7" name="tempat_makan1" id="tempat_makan_Tambahan_List" readonly  style="width: 55%">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-lg-12">
              <label class="col-lg-4 text-right">Jumlah Tambahan</label><label class="col-lg-1">:</label>
              <input class="form-control col-lg-7" name="plus1" id="jml_plus_Tambahan_List" readonly  style="width: 55%">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-lg-12">
              <label class="col-lg-4 text-right">Keperluan</label><label class="col-lg-1">:</label>
              <input class="form-control col-lg-7" name="kep1" id="Keperluan_List" readonly  style="width: 55%">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-lg-12">
              <label class="col-lg-4 text-right">Keterangan</label><label class="col-lg-1">:</label>
              <div id="data_ket_list" class="row">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="text-align: center;">
          <div id="listcatering1">
            <span class="label label-warning">Waiting Approved</span><br><br>
          </div>
          <div id="listcatering2">
            <span class="label label-success">Approved</span><br><br>
          </div>
          <div id="listcatering3">
            <span class="label label-danger">Rejected</span>
          </div>
          <div id="listcatering4">
            <span class="label label-danger">Failed</span>
          </div>
        </div>
      </div>
    </div>
  </div>
