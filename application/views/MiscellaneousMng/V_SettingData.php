<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <!-- <div class="row">
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
                                    href="<?php echo site_url('MiscellaneousCosting/SettingData');?>">
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
                <br /> -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="box ">
                        <div class="box-header text-left" style="font-size:20px">
                            <div class="col-md-6">
                                <h3 style="font-weight:bold"><i class="fa fa-pencil"></i> KLASIFIKASI ALASAN</h3>
                            </div>
                            <div class="col-md-6 text-right">
                                <button class="btn btn-success" data-toggle="modal" data-target="#mdlTambahAlasan" style="margin-top:20px"><i class="fa fa-plus"></i> Tambah</button>
                            </div>
                        </div>
                            <div class="box box-body box-danger">
                                <div class="panel-body">
                                    <div id="tb_setdata_alasan">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br /> 

            </div>
        </div>
    </div>
</section>


<div class="modal fade" id="mdlTambahAlasan" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header text-center" style="background-color:#FF9B4E;font-size:18px">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <label>Tambah Alasan</label>
        </div>
        <div class="modal-body">
            <div class="panel-body">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="input-group">
                    <input id="alasan" name="alasan" class="form-control" >
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-success" onclick="saveAlasan()"><i class="fa fa-check"></i> Save</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>