<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b>Pesanan Manual</b></h1></div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('CateringManagement/Extra/PesanManual');?>">
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
                            <div class="box-header with-border"> </div>
                            <div class="box-body">
                               <div style="width: 100%">
                                   <form id="cm_submit" method="POST" action="<?php echo site_url('CateringManagement/Extra/PesananManual/simpan'); ?>">
                                   <div class="row">
                                     <div class="col-lg-6">
                                       <div class="row">
                                           <div class="col-lg-4" style="text-align: right;">
                                               <label>Tanggal :</label>
                                           </div>
                                           <div class="col-lg-7">
                                               <input style="width: 290px; height: 35px;" class="form-control cmsingledate-mycustom" name="tanggal_pesanan" required="">
                                           </div>
                                       </div>
                                       <br>
                                       <div class="row">
                                           <div class="col-lg-4" style="text-align: right;">
                                               <label>Shift :</label>
                                           </div>
                                           <div class="col-lg-7">
                                                <select class="form-control" style="width: 290px; height: 35px;" name="shift_pesanan" required="">
                                                    <option value="1">Shift 1 dan Umum</option>
                                                    <option value="2">Shift 2</option>
                                                    <option value="3">Shift 3</option>
                                                </select>
                                           </div>
                                       </div>
                                     </div>
                                     <div class="col-lg-6">
                                       <div class="row">
                                           <div class="col-lg-4" style="text-align: right;">
                                               <label>Tempat Makan :</label>
                                           </div>
                                           <div class="col-lg-7">
                                                <select id="slc_tempat_makan" style="width: 290px; height: 35px;" class="form-control" name="tempat_makan" required="">
                                                </select>
                                           </div>
                                       </div>
                                       <br>
                                     <div class="row">
                                         <div class="col-lg-4" style="text-align: right;">
                                           <label>Total Jumlah Pesanan:</label>
                                         </div>
                                         <div class="col-lg-4" style="text-align: right;  ">
                                           <input required="" style="width: 290px; height: 35px;" type="text" class="form-control" name="jumlah_pesanan" value="">
                                         </div>
                                       </div>
                                     </div>
                                   </form>
                                   <br>
                                   <div class="col-lg-12" style="text-align: center;">
                                              <button type="submit" style="margin-top: 20px;" class="btn btn-sm btn-primary">TAMBAH</button>
                                           </div>
                               </div>
                            </div>
                        </div>
                    </div>
                </div> 


                 <div class="row" style="margin: 1px;">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                               <h4>Data Pesanan Manual</h4>
                            </div>
                            <div class="box-body">
                              <table class="datatable table table-striped table-bordered table-hover text-left tabel_pesan_manual" style="font-size:12px; width: 100%">
                                <thead>
                                  <tr>
                                    <th>No</th>
                                    <th>Action</th>
                                    <th>Tanggal</th>
                                    <th>Tempat Makan</th>
                                    <th>Shift</th>
                                    <th>Jumlah Pesanan</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    if (empty($simpan)) {
                                      # code...
                                    }else{
                                      $no=1;
                                      foreach ($simpan as $key) {
                                        ?>
                                        <tr>
                                          <td><?php echo $no; ?></td>
                                          <td>
                                              <a href='<?php echo base_url('CateringManagement/Extra/PesananManual/Read/'.$key['id_pesanan']); ?>' data-toggle='tooltip' data-placement='bottom' data-original-title='Lihat Data'><span class='fa fa-list-alt fa-2x'></span></a>
                                              <a href='<?php echo base_url('CateringManagement/Extra/PesananManual/Edit/'.$key['id_pesanan']); ?>' data-toggle='tooltip' data-placement='bottom' data-original-title='Edit Data'><span class='fa fa-pencil-square-o fa-2x'></span></a>
                                              <a href='<?php echo base_url('CateringManagement/Extra/PesananManual/hapus/'.$key['id_pesanan']); ?>' data-toggle='tooltip' data-placement='bottom' data-original-title='Hapus Data' onclick="return modalDelete('<?php echo $key['id_pesanan'];?>')"><span class='fa fa-trash fa-2x'></span>
                                                  </a>
                                            </td>
                                          <td><?php echo substr($key['fd_tanggal'],0,10); ?></td>
                                          <td><?php echo $key['fs_tempat_makan']; ?></td>
                                          <td><?php if ($key['fs_kd_shift'] == 1) {
                                            echo "Shift 1 / Umum";
                                          }elseif ($key['fs_kd_shift'] == 2) {
                                            echo "Shift 2";
                                          }else{
                                            echo "Shift 3";
                                            }; ?></td>
                                          <td><?php echo $key['fn_jumlah_pesan']; ?></td>
                                          
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

