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
                                   <!-- <form method="POST" id="formapprove" action="<?php echo site_url('CateringTambahan/simpan'); ?>"> -->
                                   <div class="row">
                                     <div class="col-lg-6">
                                       <div class="row">
                                         <div class="form-group">
                                           <div class="col-lg-4" style="text-align: right;">
                                             <label>Shift :</label>
                                           </div>
                                           <div class="col-lg-7">
                                             <select class="form-control" name="shift_pesanan" id="shift_pesanan" required="">
                                               <option value="1">Shift 1 dan Umum</option>
                                               <option value="2">Shift 2</option>
                                               <option value="3">Shift 3</option>
                                             </select>
                                           </div>
                                         </div>
                                       </div>
                                       <br>
                                       <div class="row">
                                         <div class="form-group">
                                           <div class="col-lg-4" style="text-align: right;">
                                             <label>Lokasi Kerja :</label>
                                           </div>
                                           <div class="col-lg-7">
                                             <select class="form-control" name="lokasi_pesanan" id="lokasi_pesanan" required="">
                                               <option value="01">Yogyakarta (Pusat)</option>
                                               <option value="02">Tuksono</option>
                                             </select>
                                           </div>
                                         </div>
                                       </div>
                                       <br>
                                       <div class="row">
                                         <div class="form-group">
                                           <div class="col-lg-4" style="text-align: right;">
                                             <label>Tempat Makan :</label>
                                           </div>
                                           <div class="col-lg-7">
                                             <select id="slc_tempat_makan" class="form-control" name="tempat_makan" required="" style="width: 100%">
                                             </select>
                                           </div>
                                         </div>
                                       </div>
                                     </div>
                                     <div class="col-lg-6">
                                       <div class="row">
                                         <div class="form-group">
                                           <div class="col-lg-4" style="text-align: right;">
                                             <label>Tambahan Catering :</label>
                                           </div>
                                           <div class="col-lg-4" style="text-align: right;">
                                             <input type="text" class="form-control" name="tambahan_pesanan" id="tambahan_pesanan" placeholder="0" onchange="disableinput()">
                                           </div>
                                         </div>
                                       </div>
                                       <br>
                                       <div class="row">
                                         <div class="form-group">
                                           <div class="col-lg-4" style="text-align: right;">
                                             <label>Pengurangan Catering :</label>
                                           </div>
                                           <div class="col-lg-4" style="text-align: right;">
                                             <input type="text" class="form-control" name="pengurangan_pesanan" id="pengurangan_pesanan" placeholder="0" onchange="disableinput()">
                                           </div>
                                         </div>
                                       </div>
                                       <br>
                                       <div class="row">
                                         <div class="form-group">
                                           <label class="control-label col-lg-4 text-right"> Keperluan :</label>
                                           <div class="col-lg-7">
                                             <select class="select select2" name="keperluan" id="keperluanCat" onchange="KeperluanSelekted()" data-placeholder="--pilih keperluan--" style="width: 100%" required="true">
                                               <option></option>
                                               <option value="SELEKSI" id="seleksiCatering">Seleksi</option>
                                               <option value="T/V" id="TVCatering">Tamu / Vendor</option>
                                               <option value="LEMBUR" id="LemburCatering">Lembur</option>
                                             </select>
                                           </div>
                                         </div>
                                       </div>
                                       <br>
                                       <div class="row">
                                         <div class="form-group">
                                           <label class="control-label col-lg-4 text-right"> Keterangan :</label>
                                           <div id="ketinputdiv" class="col-lg-7">
                                             <select class="select select2" name="ketnoind[]" id="ketnoind" style="width: 100%" multiple="multiple" >
                                               <option></option>
                                               <?php foreach ($getnoindberkas as $row) {
                                                 echo "<option value='".$row['kodelamaran']."'>".$row['kodelamaran']." - ".$row['nama']."</option>";
                                               }
                                               ?>
                                             </select>
                                           </div>
                                           <div id="ketareadiv" class="col-lg-7 hilang">
                                             <textarea name="TamuVendor" class="form-control" id="TamuVendor" style="width: 100%; height: 20%;text-transform:uppercase;"></textarea>
                                           </div>
                                           <div id="ketinput2div" class="col-lg-7 hilang">
                                             <select class="select select2" name="noindpribadi[]" id="noindpribadi" style="width: 100%" multiple="multiple">
                                               <option></option>
                                               <?php foreach ($getnoind as $row) {
                                                 echo "<option value='".$row['noind']."'>".$row['noind']." - ".$row['nama']."</option>";
                                               }
                                               ?>
                                             </select>
                                           </div>
                                         </div>
                                       </div>
                                     </div>
                                   </div>
                                   <br>
                                   <hr>
                                   <div class="row">
                                     <div class="col-lg-6 text-right">
                                       <label class="control-label">Approval :</label>
                                     </div>
                                     <div class="col-lg-6" style="text-align:left;">
                                       <div class="col-lg-6">
                                         <select class="select select2 text-left" name="Approval" id="app" style="width: 100%;" data-placeholder="Approval" required="true">
                                           <option></option>
                                           <?php foreach ($getkasie as $key) {
                                             echo "<option selected value='".$key['noind']."'>".$key['noind']." - ".$key['nama']."</option>";
                                           }
                                           ?>
                                         </select>
                                       </div>
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
                                 <!-- </form> -->
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
