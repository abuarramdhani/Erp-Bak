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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('CateringManagement/PesananTambahan');?>">
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
                                   <form method="POST" action="<?php echo site_url('CateringManagement/PesananTambahan/simpan'); ?>">
                                   <div class="row">
                                     <div class="col-lg-6">
                                      <!--  <div class="row">
                                           <div class="col-lg-4" style="text-align: right;">
                                               <label>Tanggal </label>
                                           </div>
                                           <div class="col-lg-7">
                                               <input class="form-control cmsingledate-mycustom" name="tanggal_pesanan" required="">
                                           </div>
                                       </div>
                                       <br> -->
                                       <div class="row">
                                           <div class="col-lg-4" style="text-align: right;">
                                               <label>Shift </label>
                                           </div>
                                           <div class="col-lg-7">
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
                                           <div class="col-lg-7">
                                                <select class="form-control" name="lokasi_pesanan" required="">
                                                    <option value="01">Yogyakarta (Pusat)</option>
                                                    <option value="02">Tuksono</option>
                                                </select>
                                           </div>
                                       </div>
                                       <br>
                                       <div class="row">
                                           <div class="col-lg-4" style="text-align: right;">
                                               <label>Tempat Makan</label>
                                           </div>
                                           <div class="col-lg-7">
                                                <select id="slc_tempat_makan" class="form-control" name="tempat_makan" required="">
                                                </select>
                                           </div>
                                       </div>
                                     </div>
                                     <div class="col-lg-6">
                                       <div class="row">
                                         <div class="col-lg-4" style="text-align: right;">
                                           <label>Tambahan Catering</label>
                                         </div>
                                         <div class="col-lg-4" style="text-align: right;">
                                           <input type="text" class="form-control" name="tambahan_pesanan" value="0">
                                         </div>
                                       </div>
                                       <br>
                                       <div class="row">
                                         <div class="col-lg-4" style="text-align: right;">
                                           <label>Pengurangan Catering</label>
                                         </div>
                                         <div class="col-lg-4" style="text-align: right;">
                                           <input type="text" class="form-control" name="pengurangan_pesanan" value="0">
                                         </div>
                                       </div>
                                     </div>
                                   </div>
                                       
                                       <br>
                                       <div class="row">
                                           <div class="col-lg-12" style="text-align: center;">
                                              <button type="submit" class="btn btn-sm btn-primary">SIMPAN</button>
                                           </div>
                                       </div>
                                   </form>
                               </div>
                            </div>
                        </div>
                    </div>
                </div> 


                 <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                               <h4>Data Tambahan / Pengurangan Katering Hari ini</h4>
                            </div>
                            <div class="box-body">
                              <table class="datatable table table-striped table-bordered table-hover text-left" style="font-size:12px; width: 100%">
                                <thead>
                                  <tr>
                                    <th>No</th>
                                    <th>Tempat Makan</th>
                                    <th>Shift</th>
                                    <th>Lokasi Kerja</th>
                                    <th>Tambahan</th>
                                    <th>Pengurangan</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    if (empty($tambahan)) {
                                      # code...
                                    }else{
                                      $no=1;
                                      foreach ($tambahan as $key) {
                                        ?>
                                        <tr>
                                          <td><?php echo $no; ?></td>
                                          <td><?php echo $key['tempat_makan']; ?></td>
                                          <td><?php if ($key['kd_shift'] == 1) {
                                            echo "Shift 1 / Umum";
                                          }elseif ($key['kd_shift'] == 2) {
                                            echo "Shift 2";
                                          }else{
                                            echo "Shift 3";
                                            }; ?></td>
                                          <td><?php if ($key['lokasi_kerja'] == 01) {
                                           echo "Yogyakarta (Pusat)";
                                          }elseif ($key['lokasi_kerja'] == 02) {
                                           echo "Tuksono";
                                          }; ?></td>
                                          <td><?php echo $key['tambahan']; ?></td>
                                          <td><?php echo $key['pengurangan']; ?></td>
                                        </tr>
                                        <?php
                                        $no++;
                                      }
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