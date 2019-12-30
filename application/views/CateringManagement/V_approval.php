<style media="screen">
  .hover:hover {
    color: red;
  }

  html {
      scroll-behavior: smooth;
      overflow-y: scroll;
  }

  .blinkblink{
		background: linear-gradient(#cf455c, white);
		background-size: 1800% 1800%;
		animation: danger_position 5s ease-in infinite;
	 }
    @-webkit-keyframes danger_position {
		 0%{background-position:10% 70%}
		 50%{background-position:70% 10%}
		 100%{background-position:10% 80%}
	}
</style>
<section class="content <?=$hidden ?>" id="page">
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
                              <a class="btn btn-default btn-lg" href="<?php echo site_url('CateringTambahan');?>">
                                <i class="icon-wrench icon-2x"></i>
                              </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  <div class="row">
                    <div class="col-lg-12">
                     <div class="box box-warning box-solid">
                         <div class="box-header with-border">
                           <ul class="nav nav-pills nav-justified">
                             <li class="active"><a data-toggle="pill" role="tab" href="#today">Tambahan Seksi Hari ini</a></li>
                             <li><a data-toggle="pill" role="tab" href="#yesterday">Tambahan Dinas Hari ini</a></li>
                           </ul>
                         </div>
                         <div class="box-body">
                           <div class="tab-content">
                             <div class="tab-pane fade in active" role="tabpanel" id="today">
                               <div class="col-lg-12 bg-warning text-center" style="font-weight:bold; margin-bottom: 10px;">
                                 <?php if(isset($today)){echo "========================   Tanggal : ".$today." ========================";} ?><br>
                               </div>
                               <table class="datatable approveCatering table table-striped table-bordered table-hover text-left" style="font-size:12px; width: 100%">
                                 <thead class="bg-warning">
                                   <tr>
                                     <th style="width: 30px;">No</th>
                                     <th style="width: 150px; text-align: center;">Action</th>
                                     <th>Waktu Makan</th>
                                     <th>Tempat Makan</th>
                                     <th>Tambahan</th>
                                     <th>Nama Pemesan</th>
                                     <th>Seksi</th>
                                     <th class="text-center">Status</th>
                                   </tr>
                                 </thead>
                                 <tbody>
                                   <?php
                                     if (empty($ambilapprove)) {
                                       # code...
                                     }else{
                                       $no=1;
                                       foreach ($ambilapprove as $key) { ?>
                                         <tr>
                                           <td><?php echo $no; ?></td>
                                           <?php if ($key['status'] == 1): ?>
                                             <td class="text-center"><i class="btn fa fa-hourglass-2 btn-block btn-warning btn-xs " data-toggle="tooltip" title="Request Approve"
                                             style="border-radius:3px; padding:1px 5px; margin-top:5px;"
                                             onclick="detailcatering(<?= $key['id']?>)">  Request Approve</i></td>
                                           <?php elseif ($key['status'] == 2): ?>
                                             <td class="text-center"><i class="btn fa fa-2x fa-file-text-o btn-xs" data-toggle="tooltip" title="Lihat Detail"
                                             style="padding:1px 5px; margin-top:5px;"
                                             onclick="detailcatering(<?= $key['id']?>)"></i></td>
                                             <?php else: ?>
                                               <td class="text-center"><i class="btn fa fa-2x fa-file-text-o btn-xs " data-toggle="tooltip" title="Lihat Detail"
                                               style="padding:1px 5px; margin-top:5px;"
                                               onclick="detailcatering(<?= $key['id']?>)"></i></td>
                                           <?php endif; ?>
                                           <td><?php if ($key['shift_tambahan'] == '1' || $key['shift_tambahan'] == '4') {
                                                 echo "MAKAN SIANG";
                                               }elseif ($key['shift_tambahan'] == '2') {
                                                 echo "MAKAN MALAM";
                                               }else {
                                                 echo "MAKAN DINI HARI";
                                               } ?></td>
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
                                               $seksi = $keyb['seksi'];
                                             }
                                           }; ?>
                                           <td><?php echo $noind." - ".$nama; ?></td>
                                           <td><?php echo $seksi; ?></td>
                                           <?php if ($key['status'] == 1): ?>
                                             <td class="text-center"><i class="fa fa-2x fa-hourglass-2" data-toggle="tooltip" title="Waiting Approve"
                                             style="padding:1px 5px; margin-top:5px;"></i></td>
                                           <?php elseif ($key['status'] == 2): ?>
                                             <td class="text-center"><i class="fa fa-2x fa-check" data-toggle="tooltip" title="Approved"
                                             style="padding:1px 5px; margin-top:5px; color:green;"></i></td>
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
                             <div class="tab-pane fade" role="tabpanel" id="yesterday">
                                 <?php if (empty($BelumProses)){ ?>
                                     <div class="box box-success box-solid col-lg-12 text-center">
                                         <label  style="font-size: 20px;">Data Sudah Terproses :)</label>
                                     </div>
                                 <?php }elseif (!empty($BelumProses)) { ?>
                                 <div class="box box-danger box-solid col-lg-12" style="height: 350px; overflow: auto;">
                                     <div class="text-center" style="font-size: 18px;">
                                         <label>Data Belum Di Proses</label>
                                     </div>
                                         <table class="table table-striped table-bordered table-hover text-left" style="font-size:12px; width: 100%;">
                                             <thead>
                                                 <th>No</th>
                                                 <th>No. Induk</th>
                                                 <th>Nama</th>
                                                 <th>Tujuan</th>
                                                 <th>Jenis Dinas</th>
                                                 <th>Keperluan</th>
                                             </thead>
                                             <tbody>
                                                 <?php $i = 1; foreach ($BelumProses as $key): ?>
                                                 <tr>
                                                     <td><?php echo $i++; ?></td>
                                                     <td><?php echo $key['noind'] ?></td>
                                                     <td><?php echo $key['nama'] ?></td>
                                                     <td><?php echo $key['tujuan'] ?></td>
                                                     <td><?php echo $key['jenis_dinas'] ?></td>
                                                     <td><?php echo $key['keterangan'] ?></td>
                                                 </tr>
                                             <?php endforeach; ?>
                                             </tbody>
                                         </table>
                                         <div class="text-center col-lg-12" style="padding-bottom: 10px">
                                             <button class="btn btn-success" id="prosesTambahanDinas">Proses</button>
                                         </div>
                                 </div>
                             <?php } ?>
                               <br>
                               <center>
                                 <label style="font-size:18px; text-align:center" class="bg-warning">Tambahan Pesanan Makan Pekerja Dinas</label><br>
                                 <label style="font-size:14px; text-align:center">Data Tambahan Catering Untuk Perizinan Dinas Sebelum Jam 09:30:00</label>
                               </center>
                               <br>
                               <table class="datatable approveCatering table table-striped table-bordered table-hover text-left" style="font-size:12px; width: 100%">
                                 <thead class="bg-warning">
                                   <tr>
                                     <th style="width: 5%;">No</th>
                                     <th>Tempat Makan</th>
                                     <th>Tambahan</th>
                                   </tr>
                                 </thead>
                                 <tbody>
                                   <?php
                                     if (empty($dataDinas)) {
                                       # code...
                                     }else{
                                       $no=1;
                                       foreach ($dataDinas as $key) { ?>
                                         <tr title="Click for Detail" type="button" class="detailPekerjaDinasPlus" value="<?php echo $key['0'].'|2019-12-11'; ?>">
                                           <td><?php echo $no; ?></td>
                                           <td><?php echo $key['0']; ?></td>
                                           <td><?php echo count($key); ?></td>
                                         </tr>
                                         <?php
                                         $no++;
                                       } } ?>
                                 </tbody>
                               </table>
                               <br>
                               <hr>
                               <br>
                               <center>
                                   <label style="font-size:18px; text-align:center" class="bg-danger">Pengurangan Pesanan Makan Pekerja Dinas</label><br>
                                   <label style="font-size:14px; text-align:center">Data Pengurangan Catering Untuk Perizinan Dinas Sebelum Jam 09:30:00</label>
                               </center>
                               <br>
                               <table class="datatable approveCatering table table-striped table-bordered table-hover text-left" style="font-size:12px; width: 100%">
                                   <thead class="bg-danger">
                                       <tr>
                                           <th style="width: 5%;">No</th>
                                           <th>Tempat Makan</th>
                                           <th>Pengurangan</th>
                                       </tr>
                                   </thead>
                                   <tbody>
                                       <?php
                                       if (empty($kurang)) {
                                           # code...
                                       }else{
                                           $no=1;
                                           foreach ($kurang as $key) { ?>
                                               <tr title="Click for Detail" type="button" class="detailPekerjaDinasMin" value="<?php echo $key['0'].'|2019-12-11|min'; ?>">
                                                   <td><?php echo $no; ?></td>
                                                   <td><?php echo $key['0']; ?></td>
                                                   <td><?php echo count($key); ?></td>
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
                  </div>
                </div>
              </section>

  <!-- //modal// -->
  <div class="modal fade" id="modal-approve-catering" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 600px">
      <div class="modal-content">
        <form method="POST" action="<?php echo site_url('CateringTambahan/Approve'); ?>">
        <div class="modal-header text-center">
          <button type="button" class="close hover" data-dismiss="modal">&times;</button>
          <h3>Approval Catering</h3>
        </div>
        <div class="modal-body" style="width: 100%; text-align: center;">
          <div class="row">
            <input type="hidden" id="modal-id_Tambahan">
            <div class="col-lg-12">
              <label class="col-lg-4 text-right">Nama Pemesan</label><label class="col-lg-1">:</label>
              <input  class="form-control col-lg-7" name="Pemesan" id="modal-pemesan" readonly  style="width: 55%">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-lg-12">
              <label class="col-lg-4 text-right">Seksi</label><label class="col-lg-1">:</label>
              <input  class="form-control col-lg-7" name="siePesan" id="modal-siePesan" readonly  style="width: 55%">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-lg-12">
              <label class="col-lg-4 text-right">Shift</label><label class="col-lg-1">:</label>
              <input  class="form-control col-lg-7" name="Shift_Tambahan" id="modal-Shift_Tambahan" readonly  style="width: 55%">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-lg-12">
              <label class="col-lg-4 text-right">Lokasi Kerja</label><label class="col-lg-1">:</label>
              <input class="form-control col-lg-7" name="lokasi_kerja" id="modal-lokasi_kerja_Tambahan" readonly  style="width: 55%">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-lg-12">
              <label class="col-lg-4 text-right">Tempat Makan</label><label class="col-lg-1">:</label>
              <input class="form-control col-lg-7" name="tempat_makan" id="modal-tempat_makan_Tambahan" readonly  style="width: 55%">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-lg-12">
              <label class="col-lg-4 text-right">Jumlah Tambahan</label><label class="col-lg-1">:</label>
              <input class="form-control col-lg-7" name="plus" id="modal-jml_plus_Tambahan" readonly  style="width: 55%">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-lg-12">
              <label class="col-lg-4 text-right">Keperluan</label><label class="col-lg-1">:</label>
              <input class="form-control col-lg-7" name="kep" id="modal-Keperluan" readonly  style="width: 55%">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-lg-12">
              <label class="col-lg-4 text-right">Keterangan</label><label class="col-lg-1">:</label>
              <div id="data_keterangan_approv" class="row">
            </div>
          </div>
        </div>
        <div class="modal-footer" style="text-align: center;">
          <div id="appcatering1">
            <button type="button" class="btn btn-success" onclick="ApproveCatering()">Approve</button>&nbsp
            <button type="button" class="btn btn-danger" onclick="RejectCatering()">Reject</button>
          </div>
          <div id="appcatering2">
            <span class="label label-success">Approved</span><br><br>
          </div>
          <div id="appcatering3">
            <span class="label label-danger">Rejected</span>
          </div>
          <div id="appcatering4">
            <span class="label label-danger">Failed</span>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="detailPekerjaDinas" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" style="margin-top: -20px;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div id="Dinas_result"></div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
            </div>
        </div>
    </div>
</div>
<a href="#" id="buttonGoTop" class="fa fa-arrow-up" style="display: none;  position: fixed;  bottom: 48px;  right: 26px;  z-index: 99;  font-size: 18px;  border: none; outline: none; background-color: red;  color: white; cursor: pointer; padding: 15px; border-radius: 4px;" title="Go to top"></a>
<script src="<?php echo base_url('assets/plugins/ckeditor/ckeditor.js');?>"></script>
<script type="text/javascript">
$(document).ready(function(){
  var noind = '<?=$user?>';
  console.log(noind);

  if(noind != 'J1256' && noind != 'F2324' && noind != 'B0720' && noind != 'B0799')
  {
    $('#page').hide();
    Swal.fire({
      title: "WARNING!",
      text: "Anda Tidak Berhak Mengakses Halaman Ini",
      type: 'warning',
      showCancelButton: false,
      showConfirmButton: false
    })
    window.location.href= baseurl+"CateringManagement";
  }

  CKEDITOR.disableAutoInline = true
  window.onscroll = _ => {
      if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
          document.getElementById("buttonGoTop").style.display = "block";
      } else {
          document.getElementById("buttonGoTop").style.display = "none";
      }
  }
})
</script>
