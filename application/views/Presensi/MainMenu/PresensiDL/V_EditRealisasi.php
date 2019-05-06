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
                                <a class="btn btn-default btn-lg" href="<?php echo base_url('MasterPekerja/Other');?>">
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
                                <span style="font-size: 20px;">Halaman Edit Realisasi Dinas Luar</span>
                            </div>
                            <div class="box-body">
                            <div class="row" style="margin: 10px 10px">
                                <div class="form-group">
                                  <div class="col-sm-3">
                                      <?php echo "<b style='font-size:16px;'>".$item_pekerja->nama." <br>(".$item_pekerja->noind.")</b>"; ?>
                                  </div>
                                </div>
                            </div>
                            <br>
                            <form action="<?php echo site_url('Presensi/PresensiDL/actEditTanggalRealisasi/'.$spdl.'?id='.$id) ?>" method="post">
                            <?php 
                              $no = 0;
                              foreach($item_spdl as $is){ 
                              $no++;  
                                if(($no % 2) == 1){
                                  $des = "Berangkat";
                                }else{
                                  $des = "Pulang";
                                }
                              ?>
                                <div class="row" style="margin: 10px 10px">
                                    <div class="form-group">
                                      <div class="col-sm-2">
                                        Realisasi <?php echo $des; ?>
                                      </div>
                                      <div class="col-sm-2">
                                        <input type="input" name="tglRealisasi[]" value="<?php echo date("Y-m-d",strtotime($is['tgl_realisasi'])) ?>" class="form-control">
                                      </div>
                                      <div class="col-sm-2">
                                        <input type="input" name="wktRealisasi[]" value="<?php echo date("H:i:s",strtotime($is['wkt_realisasi'])) ?>" class="form-control">
                                      </div>
                                    </div> 
                                </div>
                            <?php } ?>
                                <div class="row" style="margin: 10px 10px">
                                    <div class="form-group">
                                      <div class="col-sm-3">
                                       </div>
                                    </div> 
                                </div>
                                 <div class="row" style="margin: 10px 10px">
                                    <div class="form-group">
                                      <div class="col-sm-2">
                                      </div>
                                      <div class="col-sm-2">
                                        <input type="submit" class="btn btn-primary" id="idSubmit_prs" value="Update" style="width: 100%"></input>
                                      </div>
                                      <div class="col-sm-2">
                                        <a class="btn btn-warning" target="blank_" href="http://personalia.quick.com/cronjob/postgres_database.quick.com_mysql_dl.quick.com_dl.online.realisasi.manual.php?spdl=<?php echo $spdl; ?>&id=<?php echo $item_pekerja->noind; ?>" style="width: 100%">Transfer</a>
                                      </div>
                                    </div> 
                                </div>
                            </div> 
                            </form>
                        </div>
                    </div>
                </div>  
            </div>    
        </div>
    </div>
</section>
