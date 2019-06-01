<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b>Edit Pesanan Manual</b></h1></div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('CateringManagement/Extra/PesanManual/V_edit');?>">
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
                                   <form method="POST" action="<?php echo site_url('CateringManagement/Extra/PesananManual/update'); ?>">
                                   <div class="row">
                                   <?php foreach ($edit as $key): ?>
                                     <div class="col-lg-6">
                                       <div class="row">
                                           <div class="col-lg-4" style="text-align: right;">
                                               <label>Tanggal :</label>
                                           </div>
                                           <div class="col-lg-7">
                                               <input class="form-control" style="width: 290px; height: 35px;" name="tanggal_pesanan" value="<?php echo substr($key['fd_tanggal'],0,10); ?>" readonly>
                                           </div>
                                       </div>
                                       <br>
                                       <div class="row">
                                           <div class="col-lg-4" style="text-align: right;">
                                               <label>Shift :</label>
                                           </div>
                                           <div class="col-lg-7">
                                                <input class="form-control" style="width: 290px; height: 35px;" name="shift_pesanan" value="<?php echo $key['fs_kd_shift']; ?>" readonly>
                                           </div>
                                       </div>
                                     </div>
                                     <div class="col-lg-6">
                                      <div class="row">
                                           <div class="col-lg-4" style="text-align: right;">
                                               <label>Tempat Makan :</label>
                                           </div>
                                           <div class="col-lg-7">
                                                <input style="width: 290px; height: 35px;" class="form-control" name="tempat_makan" readonly="" value="<?php echo $key['fs_tempat_makan']; ?>">
                                           </div>
                                       </div>
                                      <br>
                                     <div class="row">
                                         <div class="col-lg-4" style="text-align: right;">
                                           <label>Total Jumlah Pesanan :</label>
                                         </div>
                                         <div class="col-lg-4" style="text-align: right; w">
                                           <input required="" style="width: 290px; height: 35px;" type="text" id="input3" class="form-control" name="jumlah_pesanan" value="<?php echo $key['fn_jumlah_pesan']; ?>">
                                         </div>
                                      </div>
                                    </div>
                                    <?php endforeach ?>
                                   <br>
                                   <div class="col-lg-12" style="text-align: left;">
                                     <a href="javascript:history.back(1);" style="margin-top: 20px; font-size: 12px;" class="btn btn-primary" >BACK</a>
                                        <button type="submit" hidden="" id="cm_btn_submit2" name="submit" style="text-align: center; height: 31px; font-size: 12px; margin-top: 20px;" 
                                        value="<?php echo $key['id_pesanan']; ?>">SUBMIT</button>
                                        <button type="button" id="cm_btn_submit" name="submit" style="text-align: center; height: 31px; font-size: 12px; margin-top: 20px;" 
                                        value="<?php echo $key['id_pesanan']; ?>" class="btn btn-sm btn-primary">SUBMIT</button>
                                    </div>
                                   </form>
                               </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</section>