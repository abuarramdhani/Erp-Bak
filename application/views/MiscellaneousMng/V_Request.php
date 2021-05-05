<section class="content" id="miscellaneous<?= $view?>">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <br />
                <form method="post">
                <?php 
                    if ($view != 'inputCosting' && $view != 'seksi_lain') { // tidak muncul di Misc Kelapa Seksi dan Misc Costing menu Request Siap Input
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-danger">
                        <div class="box-header text-left" style="font-size:20px">
                            <div class="col-md-10">
                                <strong><span style="color:#CC3E3B" id="jml_approve">REQUEST</span> MEMBUTUHKAN APPROVAL ANDA</strong>
                            </div>
                            <div class="col-md-2 text-right" <?= $view == 'Kasie' ? '' : 'style="display:none"' ?>>
                                <button type="button" class="btn btn-success" onclick="mdlTambahRequest(this)" ><i class="fa fa-plus"></i> Tambah</button> 
                            </div>
                        </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div id= "tb_approve">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br /> 
                <?php }?>
                
                <?php 
                    if ($view == 'Costing') { //khusus untuk resp. Miscellaneous Costing menu request miscellaneous 
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-warning">
                        <div class="box-header text-left" style="font-size:20px">
                                <strong>REQUEST APPROVAL Waka / Ka. Department (DOKUMEN MANUAL APPROVE)</strong>
                        </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div id= "tb_approvemanual">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br /> 
                <?php }?>
                
                <?php 
                    if ($view == 'inputCosting') { //khusus untuk resp. Miscellaneous Costing menu siap input miscellaneous 
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-success">
                        <div class="box-header text-left" style="font-size:20px">
                                <strong><span style="color:#CC3E3B" id="jml_approve">REQUEST</span> SIAP INPUT</strong>
                        </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div id= "tb_siapinput">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br /> 
                <?php }?>

                <?php 
                    if ($view == 'Costing' || $view == 'Kasie' || $view == 'seksi_lain') { // selain resp. Miscellaneous Kepala Seksi dan Miscellaneous Costing tidak muncul 
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-success">
                        <div class="box-header text-center" style="font-size:20px">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <strong>ONPROCESS MISCELLANEOUS TRANSACTION REQUEST</strong>
                            </div>
                            <div class="col-md-2 text-right" <?= $view == 'seksi_lain' ? '' : 'style="display:none"' ?>>
                                <button type="button" class="btn btn-success" onclick="mdlTambahRequest2(this)" ><i class="fa fa-plus"></i> Tambah</button> 
                            </div>
                        </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div id="tb_onprocess">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }?>
                <br /> 
                <?php 
                    if ($view == 'inputCosting' || $view == 'Kasie' || $view == 'seksi_lain') { // selain resp. Miscellaneous Kepala Seksi dan Miscellaneous Costing tidak muncul 
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                        <div class="box-header text-center" style="font-size:20px">
                            <strong>FINISHED MISCELLANEOUS TRANSACTION REQUEST</strong>
                        </div>
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

                </form>

            </div>
        </div>
    </div>
</section>


<form method="post" enctype="multipart/form-data">
<div class="modal fade" id="mdlReqMis" role="dialog">
    <div class="modal-dialog" style="padding-left:5px">
      <div class="modal-content">
        <div id="datareq"></div>
        <!-- <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> -->
      </div>
    </div>
</div>
</form>