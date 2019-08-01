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
                                    <form class="form-horizontal" method="post" action="<?php echo site_url('MasterPresensi/SetupReffJamLembur/update/'.$id); ?>">
                                     <?php foreach($edit as $edit){ ?>
                                        <div class="form-group">
                                             <label for="txtketerangan" class="col-lg-2 control-label">Keterangan</label>
                                              <div class="col-lg-4">
                                              <input type="text" name="txtketerangan" class="form-control" id="txtketerangan" value ="<?php echo $edit['keterangan']; ?>" >
                                              </div>
                                        </div> 
                                         <div class="form-group">
                                             <label for="txtjenishari" class="col-lg-2 control-label">Jenis Hari</label>
                                              <div class="col-lg-4">
                                              <input type="text" name="txtjenishari" class="form-control" id="txtjenishari" value ="<?php echo $edit['jenis_hari']; ?>" >
                                              </div>
                                        </div> 
                                        <div class="form-group">
                                             <label for="txthari" class="col-lg-2 control-label">Hari</label>
                                              <div class="col-lg-4">
                                              <input type="text" name="txthari" class="form-control" id="txthari" value ="<?php echo $edit['hari']; ?>" >
                                              </div>
                                        </div> 
                                        <div class="form-group">
                                             <label for="txturutan" class="col-lg-2 control-label">Urutan</label>
                                              <div class="col-lg-4">
                                              <input type="text" name="txturutan" class="form-control" id="txturutan" value ="<?php echo $edit['urutan']; ?>" >
                                              </div>
                                        </div> 
                                        <div class="form-group">
                                             <label for="txtjumlahjam" class="col-lg-2 control-label">Jumlah Jam</label>
                                              <div class="col-lg-4">
                                              <input type="text" name="txtjumlahjam" class="form-control" id="txtjumlahjam" value ="<?php echo $edit['jml_jam']; ?>" >
                                              </div>
                                        </div> 
                                         <div class="form-group">
                                             <label for="txtpengali" class="col-lg-2 control-label">Pengali</label>
                                              <div class="col-lg-4">
                                              <input type="text" name="txtpengali" class="form-control" id="txtpengali" value ="<?php echo $edit['pengali']; ?>" >
                                              </div>
                                        </div> 
                                                
                                        <?php } ?>
                                        <div class="form-group">
                                            <div class="col-lg-6 text-right">
                                                <a href="javascript:history.back(1);" class="btn btn-primary">Back</a>
                                                <button type="submit" class="btn btn-primary">Save </button>
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
