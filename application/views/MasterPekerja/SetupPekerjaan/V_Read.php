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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('MasterPekerja/SetupPekerjaan'); ?>"><span class="icon-wrench icon-2x"></span></a>
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
                                    <form class="form-horizontal" method="post" action="<?php echo site_url('MasterPekerja/SetupPekerjaan/read'); ?>">
                                    <?php foreach($data as $data){ ?>
                                          
                                                   
                                                    <div class="form-group">
                                                        <label for="txtPekerjaan" class="col-lg-2 control-label">Kode Pekerjaan</label>
                                                        <div class="col-lg-6">
                                                             <input class="form-control" value="<?php echo $data['kdpekerjaan'] ?>" 
                                                            readonly >
                                                        </div>
                                                     </div> 
                                                     <div class="form-group">
                                                        <label for="txtPekerjaan" class="col-lg-2 control-label">Pekerjaan</label>
                                                        <div class="col-lg-6">
                                                             <input class="form-control" value="<?php echo $data['pekerjaan'] ?>" 
                                                            readonly >
                                                        </div>
                                                     </div>
                                                     <div class="form-group">
                                                        <label for="txtSeksi" class="col-lg-2 control-label">Seksi</label>
                                                        <div class="col-lg-6">
                                                             <input class="form-control" value="<?php echo $data['seksi'] ?>" 
                                                            readonly >
                                                        </div>
                                                     </div>   
                                                      <div class="form-group">
                                                        <label for="txtSeksi" class="col-lg-2 control-label">Jenis Pekerjaan</label>
                                                        <div class="col-lg-6">
                                                             <input class="form-control" value="<?php echo $data['jenis'] ?>" 
                                                            readonly >
                                                        </div>
                                                     </div>   
                                                     <div class="form-group">
                                                        <label for="txtSeksi" class="col-lg-2 control-label">Jenis Baju</label>
                                                        <div class="col-lg-6">
                                                             <input class="form-control" value="<?php echo $data['jenisbaju'] ?>" 
                                                            readonly >
                                                        </div>
                                                     </div>   
                                                     <div class="form-group">
                                                        <label for="txtSeksi" class="col-lg-2 control-label">Jenis Celana</label>
                                                        <div class="col-lg-6">
                                                             <input class="form-control" value="<?php echo $data['jeniscelana'] ?>" 
                                                            readonly >
                                                        </div>
                                                     </div>   
                                                     <div class="form-group">
                                                        <label for="txtStatus" class="col-lg-2 control-label">Status</label>
                                                        <div class="col-lg-6">
                                                             <input class="form-control" value="<?php echo $data['status'] ?>" 
                                                            readonly >
                                                        </div>
                                                     </div>   
                                                     <div class="form-group">
                                                        <label for="txtLearningPeriode" class="col-lg-2 control-label">Learning Periode</label>
                                                         <div class="form-group">
                                                        <div class="col-lg-1">
                                                             <input class="form-control" value="<?php echo $data['learningperiode'] ?>" 
                                                            readonly >
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <input class="form-control" value="<?php echo $data['waktu'] ?>" 
                                                            readonly >
                                                        </div>
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
