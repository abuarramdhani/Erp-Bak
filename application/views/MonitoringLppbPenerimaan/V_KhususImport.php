<section class="content">
    <div class="inner">
        <div class="row">
                <div class="col-lg-12">
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
                                        href="<?php echo site_url('MonitoringLppbPenerimaan/KhususImport/');?>">
                                        <i class="icon-wrench icon-2x">
                                        </i>
                                        <span>
                                            <br />
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border"><b>Cari</b></div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="col-md-6">
                                            <label class="control-label">No LPPB Awal</label>
                                            <input type="number" id="noLppbAw" name="noLpAw" class="form-control" autocomplete="off" placeholder="Nomor LPPB Awal"><br />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="control-label">No LPPB Akhir</label>
                                            <input type="number" id="noLppbAk" name="noLpAk" class="form-control" autocomplete="off" placeholder="Nomor LPPB Akhir"> <br />
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-6">
                                            <label class="control-label">Tgl Transaksi</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                    <input type="text" class="form-control pull-right" id="tglAw" name="tglAw" placeholder="Tanggal Transaksi">
                                            </div>
                                            </div>
                                        <div class="col-md-6">
                                            <label class="control-label">Tgl Penerimaan</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                    <input type="text" class="form-control pull-right" id="tglAk" name="tglAk" placeholder="Tanggal Penerimaan">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                        <div class="col-md-12">
                                            <label class="control-label">ID Organization</label>
                                            <select id="io" name="io" class="form-control select2 select2-hidden-accessible io" style="width:100%;" data-placeholder="ID Organization" >
															<option></option>
															<?php foreach ($lppb as $lp) { ?>
															<option name="io" value="<?php echo $lp['ORGANIZATION_ID'] ?>"><?php echo $lp['ORGANIZATION_CODE'] ?></option>
															<?php } ?>
											</select><br />
                                            <br />
                                        </div>
                                    <div class="panel-body">
                                    <div class="col-md-12">

                                    <!-- <button type="button" data-toggle="modal" class="btn btn-danger" data-target="#myModal">Buka modal</button>
                                    <div class="modal fade" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title">Modal title</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>One fine body&hellip;</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                        </div>
                                        </div>
                                    </div>
                                    </div> -->

                                        <center><button class="btn btn-primary" onclick="getMLPD(this)"><i class="fa fa-search"></i> Find </button></center>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="row">
                        <div class="panel-body">
                            <div class="col-md-12" id="ResultLppb"></div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</section>