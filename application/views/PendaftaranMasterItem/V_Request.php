<!-- 
resp. pendaftaran master item = ongoing, finished
resp. master item tim kode barang = action needed, performed
resp. master item akuntansi, pembelian, piea = incoming, needed, performed
-->
<section class="content" id="masteritem<?= $view?>">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <?php if ($view != 'req') { // judul tidak muncul jika resp pendaftaran master item ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                    <h1>
                                        <b>
                                            <?= $Title ?>
                                        </b>
                                    </h1>
                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg"
                                        href="<?php echo site_url('MasterItem'.$view.'/Request');?>">
                                        <i class="icon-cogs icon-2x">
                                        </i>
                                        <span>
                                            <br />
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }?>

                <form method="post">
                <?php if ($view == 'req') { // khusus resp. pendaftaran master item ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                        <div class="box-header text-center" style="font-size:20px">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <strong>ON GOING MASTER ITEM REQUEST</strong>
                            </div>
                            <div class="col-md-2 text-right">
                                <button class="btn btn-success" formaction="<?php echo base_url('PendaftaranMasterItem/Request/tambahrequest') ?>"><i class="fa fa-plus"></i> Tambah</button>
                            </div>
                        </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div id= "tb_ongoing">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br /> 
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-warning">
                        <div class="box-header text-center" style="font-size:20px"><strong>FINISHED MASTER ITEM REQUEST</strong></div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div id="tb_finished">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }?>

                <?php if ($view != 'req' && $view != 'TimKode') { //tampil kecuali resp pendaftaran master item dan master item tim kode barang ?>
                <br /> 
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                        <div class="box-header text-center" style="font-size:20px">
                                <strong>INCOMING MASTER ITEM REQUEST</strong>
                        </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div id= "tb_incoming">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }?>

                <?php if ($view != 'req') { //tampil kecuali resp.pendaftaran master item ?>
                <br /> 
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-warning">
                        <div class="box-header text-center" style="font-size:20px">
                                <strong>ACTION NEEDED MASTER ITEM REQUEST</strong>
                        </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div id= "tb_needed">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <br /> 
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                        <div class="box-header text-center" style="font-size:20px">
                            <strong>ACTION PERFORMED MASTER ITEM REQUEST</strong>
                        </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div id="tb_performed">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }?>
                </form>
            </div>
        </div>
    </div>
</section>


<form method="post">
<div class="modal fade" id="mdlReqMasterItem" role="dialog">
    <div class="modal-dialog" style="width:90%">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div id="datareq"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
</form>