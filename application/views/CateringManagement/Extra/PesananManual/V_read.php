<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b>Baca Data Pesanan Manual</b></h1></div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('CateringManagement/Extra/PesanManual/V_read');?>">
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
                                   <form method="POST" action="<?php echo site_url('CateringManagement/Extra/PesananManual/simpan'); ?>">
                                   <div class="row">
                                     <?php foreach ($read as $key): ?>
                                     <div class="col-lg-6">
                                       <div class="row">
                                           <div class="col-lg-4" style="text-align: right;">
                                               <label>Tanggal :</label>
                                           </div>
                                           <div class="col-lg-7">
                                               <input class="form-control " style="width: 290px; height: 35px;" name="tanggal_pesanan" disabled="" value="<?php echo substr($key['fd_tanggal'],0,10); ?>">
                                           </div>
                                       </div>
                                       <br>
                                        <div class="row">
                                           <div class="col-lg-4" style="text-align: right;">
                                               <label>Shift :</label>
                                           </div>
                                           <div class="col-lg-7">
                                                <select class="form-control" style="width: 290px; height: 35px;" name="shift_pesanan" required disabled="">
                                                    <?php
                                                      $option1 = $option2 = $option3 = '';
                                                      switch($key['fs_kd_shift']) {
                                                        case 2:
                                                          $option2 = 'selected';
                                                          break;
                                                        case 3:
                                                          $option3 = 'selected';
                                                          break;
                                                        default:
                                                          $option1 = 'selected';
                                                          break;
                                                      }
                                                    ?>
                                                    <option value="1" <?= $option1 ?>>Shift 1 dan Umum</option>
                                                    <option value="2" <?= $option2 ?>>Shift 2</option>
                                                    <option value="3" <?= $option3 ?>>Shift 3</option>
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
                                                <input style="width: 290px; height: 35px;" class="form-control" name="tempat_makan" disabled="" value="<?php echo $key['fs_tempat_makan']; ?>">
                                           </div>
                                       </div>
                                       <br>
                                       <div class="row">
                                         <div class="col-lg-4" style="text-align: right;">
                                           <label>Total Jumlah Pesanan :</label>
                                         </div>
                                         <div class="col-lg-4" style="text-align: right;">
                                           <input disabled="" style="width: 290px; height: 35px;" type="text" class="form-control" name="jumlah_pesanan" value="<?php echo $key['fn_jumlah_pesan']; ?>">
                                         </div>
                                       </div>
                                     </div>
                                     <?php endforeach ?>
                                   </form>
                                       <br>
                                           <div class="col-lg-12" style="text-align: center;">
                                              <a href="javascript:history.back(1);" style="margin-top: 30px;" class="btn btn-primary" >Back</a>
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