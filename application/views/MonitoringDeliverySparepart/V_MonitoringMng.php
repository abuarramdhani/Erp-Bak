<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
    <script>
         $(document).ready(function () {
            $('.datepickbln').datepicker({
                format: 'M yyyy',
                todayHighlight: true,
                viewMode: "months",
                minViewMode: "months",
                autoClose: true
            });
            $('.dateMonMng').datepicker({
                format: 'dd M yyyy',
                todayHighlight: true,
                autoClose: true
            });
            $('.tbl_Monitoring').dataTable({
                "scrollX": true,
            });
         });
    </script>
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
                                    href="<?php echo site_url('MonitoringDeliverySparepart/MonitoringManagement/');?>">
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
                            <div class="box-body">
                                <div class="panel-body">
                                <!-- <form action="<?php echo base_url('MonitoringDeliverySparepart/MonitoringManagement/saveMonMng'); ?>" method="post" class="formBom"> -->
                                    <div class="col-md-12">
                                        <div class="col-md-2 text-right">
                                            <label class="control-label">Component Code</label>
                                        </div>
                                        <div class="col-md-3">
                                            <select id="compCode" name="compCode" onchange="getCompCode(this)" class="form-control select2" autocomplete="off">
                                                <option></option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 text-right">
                                            <label class="control-label">BoM Version</label>
                                        </div>
                                        <div class="col-md-3">
                                            <select id="bomVer" name="bomVer" class="form-control select2" data-placeholder="BoM Version" autocomplete="off">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="col-md-12">
                                        <div class="col-md-2 text-right">
                                            <label class="control-label">Component Description</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input id="comDesc" name="comDesc" class="form-control pull-right" placeholder="deskripsi komponen" readonly>
                                        </div>
                                        <div class="col-md-3 text-right">
                                            <label class="control-label">Periode Monitoring</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input id="periodeMon" name="periodeMon" class="form-control pull-right datepickbln" placeholder="periode" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            <div>
                                    <!-- <br><br> -->
                            <div class="box-footer box box-primary">
                                <div class="panel-body">
                                    <div class="col-md-12" id="tambahTarget">
                                        <div class="col-md-2 text-right">
                                            <label class="control-label">Tanggal Target</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input id="tglTarget1" name="tglTarget[]" class="form-control pull-right dateMonMng" placeholder="tanggal traget" onchange="cekTarget(1)" autocomplete="off">
                                            <span id="alert1" style="font-size:11px; color:red"></span>
                                        </div>
                                        <div class="col-md-3 text-right">
                                            <label class="control-label">QTY Target</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input id="qty" name="qty[]" class="form-control pull-right" placeholder="qty" autocomplete="off">
                                        </div>
                                        <div class="col-md-1">
                                            <a href="javascript:void(0);" id="addQtyTarget" onclick="addTargetMon()" class="btn btn-default"><i class="fa fa-plus"></i></a>
                                        </div>
                                    </div>
                                    <br><br>
                                <!-- </div> -->
                                <!-- <div class="panel-body"> -->
                                    <div class="col-md-12 text-center">
                                        <button type="button" onclick="saveMonMng(this)" class="btn btn-primary">SAVE</button>    
                                    </div>
                                </div>
                                <!-- </form> -->
                                <br>
                                <div class="panel-body">
                                <div class="table-responsive" >
                                    <table class="table table-striped table-bordered table-responsive table-hover text-center tbl_Monitoring" style="font-size:14px;width:100%">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th>No</th>
                                                <th>Kode Komponen </th>
                                                <th width="20%">Deskripsi Komponen</th>
                                                <th>BoM Version</th>
                                                <th>Periode Monitoring</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $no=1; foreach($data as $val){
                                            ?>
                                                <tr>
                                                    <td><?= $no ?></td>
                                                    <td><?= $val['component_code']?></td>
                                                    <td><?= $val['component_desc']?></td>
                                                    <td><?= $val['identitas_bom']?></td>
                                                    <td><?= $val['periode_monitoring']?></td>
                                                    <td>
                                                        <a href="<?php echo base_url('MonitoringDeliverySparepart/MonitoringManagement/detailMonitoringMng/'.$val['component_code'].'/'.$val['periode_monitoring']) ?>" type="button" class="btn btn-xs btn-success"><i class="fa fa-search"></i> Detail</a>
                                                        <a href="<?php echo base_url('MonitoringDeliverySparepart/MonitoringManagement/deleteData/'.$val['component_code'].'/'.$val['id']) ?> " type="button" class="btn btn-xs btn-danger" ><i class="fa fa-trash-o"></i> Delete</a>
                                                    </td>
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
</section>

<div class="modal fade" id="mdlloading" tabindex="-1" role="dialog" aria-labelledby="myModalLoading">
	<div class="modal-dialog" role="document" style="padding-top:200px;width:20%">
		<div class="modal-content">
			<div class="modal-body">
            <h3 class="modal-title" style="text-align:center;"><b>Mohon Tunggu Sebentar...</b></h3>
		    </div>
		</div>
	</div>
</div>