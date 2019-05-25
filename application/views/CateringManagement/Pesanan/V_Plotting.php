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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('CateringManagement/Plotting');?>">
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
                               <div style="width: 100%">
                                   <form method="POST" action="<?php echo site_url('CateringManagement/Plotting/lihat'); ?>">
                                       <div class="row">
                                           <div class="col-lg-4" style="text-align: right;">
                                               <label>Tanggal </label>
                                           </div>
                                           <div class="col-lg-3">
                                               <input class="form-control cmsingledate-mycustom" name="tanggal_pesanan" required="">
                                           </div>
                                       </div>
                                       <br>
                                       <div class="row">
                                           <div class="col-lg-4" style="text-align: right;">
                                               <label>Shift </label>
                                           </div>
                                           <div class="col-lg-3">
                                                <select class="form-control" name="shift_pesanan" required="">
                                                    <option value="1">Shift 1 dan Umum</option>
                                                    <option value="2">Shift 2</option>
                                                    <option value="3">Shift 3</option>
                                                </select>
                                           </div>
                                       </div>
                                       <br>
                                       <div class="row">
                                           <div class="col-lg-4" style="text-align: right;">
                                               <label>Lokasi Kerja </label>
                                           </div>
                                           <div class="col-lg-3">
                                                <select class="form-control" name="lokasi_pesanan" required="">
                                                    <option value="01">Yogyakarta (Pusat)</option>
                                                    <option value="02">Tuksono</option>
                                                </select>
                                           </div>
                                       </div>
                                       <br>
                                       <div class="row">
                                           <div class="col-lg-6" style="text-align: right;">
                                              <button class="btn btn-sm btn-primary" type="submit">Lihat</button>
                                           </div>
                                       </div>
                                   </form>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>    
                <br>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                               <h3>Catering</h3>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            
                                        </div>
                                        <div class="col-lg-8">
                                            <?php 
                                              if (empty($jadwal)) {
                                                # code...
                                              }else{
                                                foreach ($jadwal as $row) {
                                                  ?>
                                                    <h3>Nama Katering : <?php echo $row['fs_nama_katering'] ?></h3>
                                                    <table class="datatable table table-striped table-bordered table-hover text-left tblDataPesanan" style="font-size:12px; width: 100%">
                                                        <thead class="bg-primary">
                                                            <tr>
                                                                <th style="text-align:center; width:30px">No</th>
                                                                <th>Tempat Makan</th>
                                                                <th>Jumlah Shift</th>
                                                                <th>Jumlah Bukan Shift</th>
                                                                <th>Jumlah Total</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                           <?php
                                                              $total="";
                                                           if (empty($data)) {
                                                             
                                                           }else{
                                                            $no=1;
                                                              foreach ($data as $key) {
                                                                if ($key['katering'] == $row['fs_nama_katering']) {
                                                                  $katering = $key['katering'];
                                                                  $tempat_makan = $key['tempat_makan'];
                                                                  $tgl = $key['tgl_pesanan'];
                                                                  $shift = $key['kd_shift'];
                                                                  $lokasi_kerja = $key['lokasi_kerja'];
                                                                  $jml_shift = $key['jml_shift'];
                                                                  $jml_bukan_shift = $key['jml_bukan_shift'];
                                                                  $jml_total = $key['jml_total'];
                                                                  $total = $total+$jml_total;
                                                                  ?>
                                                                  <tr>
                                                                    <td><?php echo $no; ?></td>
                                                                    <td><?php echo $key['tempat_makan']; ?></td>
                                                                    <td><?php echo $key['jml_shift']; ?></td>
                                                                    <td><?php echo $key['jml_bukan_shift']; ?></td>
                                                                    <td><?php echo $key['jml_total']; ?></td>
                                                                    <td>
                                                                      <a class="btn btn-info btn-xs" data-toggle="modal" data-target="#Tranfer_modal" data-tgl="<?php echo $tgl;?>" data-shift="<?php echo $shift; ?>" data-loker="<?php echo $lokasi_kerja; ?>" data-tempat-makan="<?php echo $tempat_makan;?>" data-jml="<?php echo $jml_total;?>">Pindah</a>
                                                                    </td>
                                                                  </tr>
                                                                  <?php
                                                                $no++;
                                                                }
                                                                
                                                              }
                                                           }
                                                               
                                                           ?>
                                                        </tbody>                                      
                                                    </table>
                                                    <div class="row">
                                                      <div class="col-lg-12" style="text-align: right;">
                                                        <h4>Jumlah Total <?php ;echo $row['fs_nama_katering']; echo " : ".$total;?></h4>
                                                      </div>
                                                    </div>
                                                  <?php
                                                }
                                              }
                                            ?>
                                            
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

 <div class="modal fade" id="Tranfer_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 250px">
      <div class="modal-content">
        <form method="POST" action="<?php echo site_url('CateringManagement/Plotting/pindah'); ?>">
        <div class="modal-header">
          <h3>Pindah</h3>
        </div>
        <div class="modal-body" style="width: 250px">
         
              <!-- <label>Tanggal</label>
              <br> -->
              <input name="tanggal_katering" id="modal-tanggal_katering" readonly  style="width: 200px"  hidden="hidden">
              <!-- <br>
              <label>Shift</label>
              <br> -->
              <input name="Shift_pesan" id="modal-Shift_pesan" readonly  style="width: 200px" hidden="hidden">
             <!--  <br>
              <label>Lokasi Kerja</label>
              <br> -->
              <input name="lokasi_kerja" id="modal-lokasi_kerja" readonly  style="width: 200px" hidden="hidden">
              <!-- <br> -->
              <label>Tempat Makan</label>
              <br>
              <input class="form-control" name="tempat_makan" id="modal-tempat_makan" readonly  style="width: 200px">
              <br>
              <label>Jumlah Total</label>
              <br>
              <input class="form-control" name="jml_total" id="modal-jml_total" readonly  style="width: 200px">
              <br>
              <label>Tempat Katering</label>
              <br>
              <select id="modal-select2_katering" class="form-control" name="tempat_katering" style="width: 200px"></select>
            
          
        </div>
        <div class="modal-footer" style="text-align: center;">
          <button type="submit" class="btn btn-primary">Pindahkan</button>
        </div>
        </form>
      </div>
    </div>
  </div>