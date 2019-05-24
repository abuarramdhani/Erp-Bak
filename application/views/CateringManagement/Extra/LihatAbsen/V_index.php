<style>
.dataTables_wrapper .dt-buttons{
  float: right;
  height:50px;
}
</style>
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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('CateringManagement/Extra/LihatAbsen');?>">
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
                                   <form method="POST" action="<?php echo site_url('CateringManagement/Extra/LihatAbsen/cari'); ?>">
                                   <div class="row">
                                     <div class="col-lg-12">
                                       <div class="row">
                                           <div class="col-lg-4" style="text-align: right;">
                                               <label>Tanggal </label>
                                           </div>
                                           <div class="col-lg-4">
                                               <input class="form-control cmsingledate-mycustom" name="tanggal" required=""></input>
                                           </div>
                                       </div>
                                       <br>
                                       <div class="row">
                                           <div class="col-lg-4" style="text-align: right;">
                                               <label>Shift </label>
                                           </div>
                                           <div class="col-lg-4">
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
                                               <label>Tempat Makan</label>
                                           </div>
                                           <div class="col-lg-4">
                                                <select id="slc_tempat_makan" class="form-control" name="tempat_makan">
                                                </select><sup style="color: red">*</sup><i>: kosongi untuk menampilkan semua seksi</i>
                                           </div>
                                       </div>
                                     </div>
                                   </div>
                                       <br>
                                       <div class="col-lg-12 text-center" >
                                              <button type="submit" class="btn btn-sm btn-primary" style="font: Arial; font-size: 14px; width: 70px; height: 33px">Cari</button>
                                        </div>
                                      </div>
                                   </form>
                               </div>
                            </div>
                        </div>
                    </div>
                </div> 
                 <div class="row" style="margin: 1px;">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                               <h4>Data Pekerja Absen Berdasarkan Tempat Makan</h4>
                            </div>
                            <div class="box-body">
                              <table class="datatable table dataTable-Tmp table-bordered text-left" style="font-size:12px; width: 100%">
                              <div class="row"></div>
                              </div>
                                <thead>
                                  <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>No. Induk</th>
                                    <th>Nama</th>
                                    <th>Waktu 1</th>
                                    <th>Waktu 2</th>
                                    <th>Waktu 3</th>
                                    <th>Waktu 4</th>
                                    <th>Tempat Makan</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    if (empty($data)) {
                                      # code...
                                    }else{
                                      $no=1;
                                      foreach ($data as $key) {
                                        ?>
                                        <tr>
                                          <td><?php echo $no; ?></td>
                                          <td><?php echo $tanggalm ?></td>
                                          <td><?php echo $key['noind']; ?></td>
                                          <td><?php echo $key['nama']; ?></td>
                                          <td><?php echo $key['wkt1']; ?></td>
                                          <td><?php echo $key['wkt2']; ?></td>
                                          <td><?php echo $key['wkt3']; ?></td>
                                          <td><?php echo $key['wkt4']; ?></td>
                                          <td><?php echo $key['tempat_makan'] ?></td>
                                        </tr>
                                        <?php
                                        $no++;
                                      }
                                    }
                                  ?>
                                </tbody> 
                              </table>
                              <br>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>