<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
               
                <br/>
          
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                               <h3>List of Order</h3>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            
                                        </div>
                                        <div class="col-lg-8">
                                            <table class="datatable table table-striped table-bordered table-hover text-left" id="tblDataPesanan" style="font-size:12px; width: 100%">
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
                                                   if (empty($lihat_pesanan)) {
                                                       echo "Data belum ditarik. Silahkan pilih tombol refresh untuk menarik data.";
                                                   }else{
                                                        $no = 1;
                                                        foreach ($lihat_pesanan as $key) {
                                                            $tempat_makan = $key['tempat_makan'];
                                                            $jml_shift = $key['jml_shift'];
                                                            $jml_bukan_shift = $key['jml_bukan_shift'];
                                                            $jml_total = $key['jml_total'];
                                                            $id = $key['id'];
                                                            $tgl = $key['tgl_pesanan'];
                                                            $shift = $key['kd_shift'];
                                                            $lokasi_kerja = $key['lokasi_kerja'];
                                                           ?>
                                                           <tr>
                                                               <td style="text-align: center;"><?php echo $no; ?></td>
                                                               <td><?php echo $tempat_makan; ?></td>
                                                               <td><?php echo $jml_shift; ?></td>
                                                               <td><?php echo $jml_bukan_shift; ?></td>
                                                               <td><?php echo $jml_total; ?></td>
                                                               <td>
                                                                <?php 
                                                                  if ($key['status'] == "sudah") {
                                                                    ?>
                                                                    <span class="glyphicon glyphicon-ok" style="font-size: 20px;color: green"></span>
                                                                    <?php
                                                                  }elseif ($key['status'] == "belum") {
                                                                   ?>
                                                                     <a class="btn btn-info btn-xs" data-toggle="modal" data-target="#Tranfer_modal" data-tgl="<?php echo $tgl;?>" data-shift="<?php echo $shift; ?>" data-loker="<?php echo $lokasi_kerja; ?>" data-tempat-makan="<?php echo $tempat_makan;?>" data-jml="<?php echo $jml_total;?>">Kirim</a>
                                                                   <?php
                                                                  }
                                                                ?>
                                                                   
                                                               </td>
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
            </div>    
        </div>
    </div>
</section>

  <div class="modal fade" id="Tranfer_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 250px">
      <div class="modal-content">
        <form method="POST" action="<?php echo site_url('CateringManagement/DataPesanan/transfer'); ?>">
        <div class="modal-header">
          <h3>Transfer</h3>
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
          <button type="submit" class="btn btn-primary">Transfer</button>
        </div>
        </form>
      </div>
    </div>
  </div>