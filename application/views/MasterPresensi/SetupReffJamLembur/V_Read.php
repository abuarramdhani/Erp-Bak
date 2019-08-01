<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1><b><?=$Title ?></b></h1>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('MasterPresensi/SetupReffJamLembur'); ?>"><span class="icon-wrench icon-2x"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">

                            </div>
                            <div class="box-body">
                                <div class="col-lg-12">
                                    <form class="form-horizontal" method="post" action="<?php echo site_url('MasterPresensi/SetupReffJamLembur/read'); ?>">
                                    <?php foreach($data as $data){ ?>
                                          
                                           <div class="form-group">
                                                 <label for="txtketerangan" class="col-lg-2 control-label">Keterangan</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" value="<?php echo $data['keterangan'] ?>"  readonly>
                                                    </div>
                                             </div> 
                                           <div class="form-group">
                                                 <label for="txtjenishari" class="col-lg-2 control-label">Jenis Hari</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" value="<?php echo $data['jenis_hari'] ?>"  readonly>
                                                    </div>
                                             </div> 
                                             <div class="form-group">
                                                 <label for="txthari" class="col-lg-2 control-label">Hari</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" value="<?php echo $data['hari'] ?>"  readonly>
                                                    </div>
                                             </div> 
                                             <div class="form-group">
                                                 <label for="txturutan" class="col-lg-2 control-label">Urutan</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" value="<?php echo $data['urutan'] ?>"  readonly>
                                               </div>
                                             </div> 
                                              <div class="form-group">
                                                 <label for="txtjumlahjam" class="col-lg-2 control-label">Jumlah Jam</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" value="<?php echo $data['jml_jam'] ?>"  readonly>
                                                    </div>
                                             </div> 
                                              <div class="form-group">
                                                 <label for="txtpengali" class="col-lg-2 control-label">Pengali</label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" value="<?php echo $data['pengali'] ?>"  readonly>
                                                    </div>
                                             </div> 



                                                     
                                        <?php } ?>
                                        <div class="form-group">
                                            <div class="col-lg-6 text-right">
                                                <a href="javascript:history.back(1);" class="btn btn-primary">Back</a>
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
