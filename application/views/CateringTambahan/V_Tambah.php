<style media="screen">
  .swal-wide{
   width:250px !important;
  }
  .hilang{
    display: none;
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
                              <a class="btn btn-default btn-lg" href="<?php echo site_url('CateringTambahan');?>">
                                  <i class="icon-wrench icon-2x"></i>
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
                            <div class="box-body">
                               <div style="width: 100%">
                                   <div class="row">
                                     <div class="col-lg-12">
                                       <div class="row">
                                         <div class="form-group">
                                           <div class="col-lg-5" style="text-align: right;">
                                             <label>Waktu Makan :</label>
                                           </div>
                                           <div class="col-lg-4">
                                             <select class="form-control" name="shift_pesanan" id="shift_pesanan" required="">
                                               <option value="1">Makan Siang</option>
                                               <option value="2">Makna Malam</option>
                                               <option value="3">Makan Dini Hari</option>
                                             </select>
                                           </div>
                                         </div>
                                       </div>
                                       <br>
                                       <div class="row">
                                         <div class="form-group">
                                           <label class="control-label col-lg-5 text-right"> Keperluan :</label>
                                           <div class="col-lg-4">
                                             <select class="select select2" name="keperluan" id="keperluanCat" onchange="KeperluanSelekted()" data-placeholder="--pilih keperluan--" style="width: 100%" required="true">
                                               <option></option>
                                               <option value="SELEKSI" id="seleksiCatering">Seleksi</option>
                                               <option value="T/V" id="TVCatering">Tamu / Vendor</option>
                                               <option value="LEMBUR_DATANG" id="LemburCatering1">Lembur Datang</option>
                                               <option value="LEMBUR_PULANG" id="LemburCatering2">Lembur Pulang</option>
                                             </select>
                                           </div>
                                         </div>
                                       </div>
                                       <br class="hilang" id="br_plus">
                                       <div class="row hilang" id="tempatMakan_plus">
                                         <div class="form-group">
                                           <div class="col-lg-5" style="text-align: right;">
                                             <label>Tempat Makan :</label>
                                           </div>
                                           <div class="col-lg-4">
                                             <select id="slc_tempat_makan" class="form-control" name="tempat_makan" required="" style="width: 100%">
                                             </select>
                                           </div>
                                         </div>
                                       </div>
                                       <br>
                                       <div class="row">
                                         <div class="form-group">
                                           <label class="control-label col-lg-5 text-right"> Keterangan :</label>
                                           <div id="ketinputdiv" class="col-lg-4">
                                             <select class="select select2" name="ketnoind[]" onchange="keterangan(1)" id="ketnoind" style="width: 100%" multiple="multiple" >
                                               <option></option>
                                               <?php foreach ($getnoindberkas as $row) {
                                                 echo "<option value='".$row['kodelamaran']."'>".$row['kodelamaran']." - ".$row['nama']."</option>";
                                               }
                                               ?>
                                             </select>
                                           </div>
                                           <div id="ketareadiv" class="col-lg-4 hilang">
                                             <select name="TamuVendor[]" class="form-control select2 TamuVendorYa" onchange="keterangan(2)" id="TamuVendor" style="width: 100%; text-transform:uppercase;" multiple="multiple">
                                               <option></option>
                                             </select>
                                           </div>
                                           <div id="ketinput2div" class="col-lg-4 hilang">
                                             <select class="select select2" name="noindpribadi[]" id="noindpribadi" onchange="keterangan(3)" style="width: 100%" multiple="multiple">
                                               <option></option>
                                               <?php foreach ($getnoind as $row) {
                                                 echo "<option value='".$row['noind']."'>".$row['noind']." - ".$row['nama']."</option>";
                                               }
                                               ?>
                                             </select>
                                           </div>
                                         </div>
                                       </div>
                                       <br><br>
                                       <div class="row">
                                         <div class="form-group">
                                           <div class="col-lg-5" style="text-align: right;">
                                             <label>Total Pesanan :</label>
                                           </div>
                                           <div class="col-lg-4" style="text-align: right;">
                                             <input type="text" class="form-control" name="total_pesanan" id="total_pesanan" placeholder="0" onchange="KeperluanSelekted()" readonly>
                                           </div>
                                         </div>
                                       </div>
                                     </div>
                                   </div>
                                   <br>
                                   <hr>
                                   <div class="row">
                                     <div class="col-lg-5 text-right">
                                       <label class="control-label">Approval :</label>
                                     </div>
                                     <div class="col-lg-4" style="text-align:left;">
                                       <input type="text" class="form-control" name="Approval" id="app" readonly value='<?php echo $getkasie ?>'>
                                     </div>
                                   </div>
                                   <br><br>
                                   <div class="row">
                                     <div class="col-lg-12" style="text-align: center;">
                                       <div class="panel-footer">
                                         <button type="submit" class="btn btn-sm btn-primary" onclick="kirimapprove()">KIRIM</button>
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
    </div>
</section>
