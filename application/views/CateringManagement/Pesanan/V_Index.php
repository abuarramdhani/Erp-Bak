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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('CateringManagement/DataPesanan');?>">
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
                                   <form method="POST" id="frm_pesanan">
                                       <div class="row">
                                           <div class="col-lg-4" style="text-align: right;">
                                               <label>Tanggal </label>
                                           </div>
                                           <div class="col-lg-3">
                                               <input class="form-control cmsingledate-mycustom" name="tanggal_pesanan" required=""></input>
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
                                           <div class="col-lg-5" style="text-align: right;">
                                              <button class="btn btn-sm btn-primary" id="btn_pesanan_lihat">Lihat</button>
                                           </div>
                                           <div class="col-lg-1"></div>
                                           <div class="col-lg-6">
                                              <button class="btn btn-sm btn-primary" id="btn_pesanan_refresh">Refresh</button>
                                           </div>
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