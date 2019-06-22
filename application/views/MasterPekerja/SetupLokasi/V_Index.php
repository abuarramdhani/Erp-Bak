<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b><?php echo $Title;?></b></h1></div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('MasterPekerja/SetupLokasi');?>">
                                    <i class="icon-wrench icon-2x"></i>
                                    <br/>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">
                                    <a href="<?php echo site_url('MasterPekerja/SetupLokasi/create') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                                        <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                    </a>
                                </div>
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table <table id="dataTable-MasterLokasi" class="table table-striped table-bordered table-hover text-left" id="formMasterLokasi" style="font-size:12px;">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th style="text-align:center;">No</th>
                                                    <th style="text-align:center;">Action</th>
                                                    <th style="text-align:center;">Kode</th>
                                                    <th style="text-align:center;">Lokasi Kerja</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              <?php $no=1;
                                                foreach ($MasterIndex as $key) {
    													                        $encrypted_string = $this->encrypt->encode($key['id_']);
                                                    	$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
                                              ?>
                                                <tr>
                                                    <td><?php echo $no;?></td>
                                                    <td>
                                                      <a href="<?php echo base_url('MasterPekerja/SetupLokasi/edit/'.$encrypted_string) ?>" class="fa fa-edit fa-2x" data-toggle='tooltip' data-placement='bottom' data-original-title='Edit Data'></a>
                                                    </td>
                                                    <td><?php echo $key['id_'];?></td>
                                                    <td><?php echo $key['lokasi_kerja'];?></td>
                                                </tr>
                                                <?php $no++; }?>
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
