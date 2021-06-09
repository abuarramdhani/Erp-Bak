<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
     <script>
            $(document).ready(function () {
            $('#myTable').dataTable({
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
                                    href="<?php echo site_url('MonitoringPelayananSPB/Input/');?>">
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
                            <div class="box-header with-border"><b>Input</b></div>
                            <div class="box-body">
                                <div class="col-md-12 text-left">
                                    <label class="control-label"><?php echo gmdate("l, d F Y, H:i:s", time()+60*60*7) ?></label>
                                </div>
                                <br>
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <label class="control-label">No. SPB / DOSP</label>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="input-group input-group-sm">
                                            <input id="noSpb1" name="no_spb[]" class="form-control pull-right" placeholder="Masukan Nomor" >
                                            <span class="input-group-btn">
                                                <input type="button" class="btn btn-xs btn-warning" id="btn1" name="btn_urgent[]" value="Urgent" style="color:black" onclick="btnUrgent(1)">
                                                <input type="button" class="btn btn-xs btn-default" id="btnbon1" name="btn_bon[]" value="Bon" style="color:black;margin-left:10px;width:50px" onclick="btnBonKgs(1)">
                                                <input type="button" class="btn btn-xs btn-info" id="btnlangsung1" name="btn_langsung[]" value="Langsung" style="color:black;margin-left:10px;width:70px" onclick="btnLangsungKgs(1)">
                                                <input type="button" class="btn btn-xs btn-success" id="btnbesc1" name="btn_besc[]" value="Best" style="color:black;margin-left:10px;width:70px" onclick="btnBescKgs(1)">
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            
                                        </div>
                                        <div class="col-md-5">
                                            <div class="input-group input-group-sm">
                                            <input id="noSpb2" name="no_spb[]" class="form-control pull-right" placeholder="Masukan Nomor" >
                                            <span class="input-group-btn">
                                                <input type="button" class="btn btn-xs btn-warning" id="btn2" name="btn_urgent[]" value="Urgent" style="color:black" onclick="btnUrgent(2)">
                                                <input type="button" class="btn btn-xs btn-default" id="btnbon2" name="btn_bon[]" value="Bon" style="color:black;margin-left:10px;width:50px" onclick="btnBonKgs(2)">
                                                <input type="button" class="btn btn-xs btn-info" id="btnlangsung2" name="btn_langsung[]" value="Langsung" style="color:black;margin-left:10px;width:70px" onclick="btnLangsungKgs(2)">
                                                <input type="button" class="btn btn-xs btn-success" id="btnbesc2" name="btn_besc[]" value="Best" style="color:black;margin-left:10px;width:70px" onclick="btnBescKgs(2)">
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            
                                        </div>
                                        <div class="col-md-5">
                                            <div class="input-group input-group-sm">
                                            <input id="noSpb3" name="no_spb[]" class="form-control pull-right" placeholder="Masukan Nomor" >
                                            <span class="input-group-btn">
                                                <input type="button" class="btn btn-xs btn-warning" id="btn3" name="btn_urgent[]" value="Urgent" style="color:black" onclick="btnUrgent(3)">
                                                <input type="button" class="btn btn-xs btn-default" id="btnbon3" name="btn_bon[]" value="Bon" style="color:black;margin-left:10px;width:50px" onclick="btnBonKgs(3)">
                                                <input type="button" class="btn btn-xs btn-info" id="btnlangsung3" name="btn_langsung[]" value="Langsung" style="color:black;margin-left:10px;width:70px" onclick="btnLangsungKgs(3)">
                                                <input type="button" class="btn btn-xs btn-success" id="btnbesc3" name="btn_besc[]" value="Best" style="color:black;margin-left:10px;width:70px" onclick="btnBescKgs(3)">
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            
                                        </div>
                                        <div class="col-md-5">
                                            <div class="input-group input-group-sm">
                                            <input id="noSpb4" name="no_spb[]" class="form-control pull-right" placeholder="Masukan Nomor" >
                                            <span class="input-group-btn">
                                                <input type="button" class="btn btn-xs btn-warning" id="btn4" name="btn_urgent[]" value="Urgent" style="color:black" onclick="btnUrgent(4)">
                                                <input type="button" class="btn btn-xs btn-default" id="btnbon4" name="btn_bon[]" value="Bon" style="color:black;margin-left:10px;width:50px" onclick="btnBonKgs(4)">
                                                <input type="button" class="btn btn-xs btn-info" id="btnlangsung4" name="btn_langsung[]" value="Langsung" style="color:black;margin-left:10px;width:70px" onclick="btnLangsungKgs(4)">
                                                <input type="button" class="btn btn-xs btn-success" id="btnbesc4" name="btn_besc[]" value="Best" style="color:black;margin-left:10px;width:70px" onclick="btnBescKgs(4)">
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            
                                        </div>
                                        <div class="col-md-5">
                                            <div class="input-group input-group-sm">
                                            <input id="noSpb5" name="no_spb[]" class="form-control pull-right" placeholder="Masukan Nomor" >
                                            <span class="input-group-btn">
                                                <input type="button" class="btn btn-xs btn-warning" id="btn5" name="btn_urgent[]" value="Urgent" style="color:black" onclick="btnUrgent(5)">
                                                <input type="button" class="btn btn-xs btn-default" id="btnbon5" name="btn_bon[]" value="Bon" style="color:black;margin-left:10px;width:50px" onclick="btnBonKgs(5)">
                                                <input type="button" class="btn btn-xs btn-info" id="btnlangsung5" name="btn_langsung[]" value="Langsung" style="color:black;margin-left:10px;width:70px" onclick="btnLangsungKgs(5)">
                                                <input type="button" class="btn btn-xs btn-success" id="btnbesc5" name="btn_besc[]" value="Best" style="color:black;margin-left:10px;width:70px" onclick="btnBescKgs(5)">
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            
                                        </div>
                                        <div class="col-md-5">
                                            <div class="input-group input-group-sm">
                                            <input id="noSpb6" name="no_spb[]" class="form-control pull-right" placeholder="Masukan Nomor" >
                                            <span class="input-group-btn">
                                                <input type="button" class="btn btn-xs btn-warning" id="btn6" name="btn_urgent[]" value="Urgent" style="color:black" onclick="btnUrgent(6)">
                                                <input type="button" class="btn btn-xs btn-default" id="btnbon6" name="btn_bon[]" value="Bon" style="color:black;margin-left:10px;width:50px" onclick="btnBonKgs(6)">
                                                <input type="button" class="btn btn-xs btn-info" id="btnlangsung6" name="btn_langsung[]" value="Langsung" style="color:black;margin-left:10px;width:70px" onclick="btnLangsungKgs(6)">
                                                <input type="button" class="btn btn-xs btn-success" id="btnbesc6" name="btn_besc[]" value="Best" style="color:black;margin-left:10px;width:70px" onclick="btnBescKgs(6)">
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            
                                        </div>
                                        <div class="col-md-5">
                                            <div class="input-group input-group-sm">
                                            <input id="noSpb7" name="no_spb[]" class="form-control pull-right" placeholder="Masukan Nomor" >
                                            <span class="input-group-btn">
                                                <input type="button" class="btn btn-xs btn-warning" id="btn7" name="btn_urgent[]" value="Urgent" style="color:black" onclick="btnUrgent(7)">
                                                <input type="button" class="btn btn-xs btn-default" id="btnbon7" name="btn_bon[]" value="Bon" style="color:black;margin-left:10px;width:50px" onclick="btnBonKgs(7)">
                                                <input type="button" class="btn btn-xs btn-info" id="btnlangsung7" name="btn_langsung[]" value="Langsung" style="color:black;margin-left:10px;width:70px" onclick="btnLangsungKgs(7)">
                                                <input type="button" class="btn btn-xs btn-success" id="btnbesc7" name="btn_besc[]" value="Best" style="color:black;margin-left:10px;width:70px" onclick="btnBescKgs(7)">
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            
                                        </div>
                                        <div class="col-md-5">
                                            <div class="input-group input-group-sm">
                                            <input id="noSpb8" name="no_spb[]" class="form-control pull-right" placeholder="Masukan Nomor" >
                                            <span class="input-group-btn">
                                                <input type="button" class="btn btn-xs btn-warning" id="btn8" name="btn_urgent[]" value="Urgent" style="color:black" onclick="btnUrgent(8)">
                                                <input type="button" class="btn btn-xs btn-default" id="btnbon8" name="btn_bon[]" value="Bon" style="color:black;margin-left:10px;width:50px" onclick="btnBonKgs(8)">
                                                <input type="button" class="btn btn-xs btn-info" id="btnlangsung8" name="btn_langsung[]" value="Langsung" style="color:black;margin-left:10px;width:70px" onclick="btnLangsungKgs(8)">
                                                <input type="button" class="btn btn-xs btn-success" id="btnbesc8" name="btn_besc[]" value="Best" style="color:black;margin-left:10px;width:70px" onclick="btnBescKgs(8)">
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            
                                        </div>
                                        <div class="col-md-5">
                                            <div class="input-group input-group-sm">
                                            <input id="noSpb9" name="no_spb[]" class="form-control pull-right" placeholder="Masukan Nomor" >
                                            <span class="input-group-btn">
                                                <input type="button" class="btn btn-xs btn-warning" id="btn9" name="btn_urgent[]" value="Urgent" style="color:black" onclick="btnUrgent(9)">
                                                <input type="button" class="btn btn-xs btn-default" id="btnbon9" name="btn_bon[]" value="Bon" style="color:black;margin-left:10px;width:50px" onclick="btnBonKgs(9)">
                                                <input type="button" class="btn btn-xs btn-info" id="btnlangsung9" name="btn_langsung[]" value="Langsung" style="color:black;margin-left:10px;width:70px" onclick="btnLangsungKgs(9)">
                                                <input type="button" class="btn btn-xs btn-success" id="btnbesc9" name="btn_besc[]" value="Best" style="color:black;margin-left:10px;width:70px" onclick="btnBescKgs(9)">
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            
                                        </div>
                                        <div class="col-md-5">
                                            <div class="input-group input-group-sm">
                                            <input id="noSpb10" name="no_spb[]" class="form-control pull-right" placeholder="Masukan Nomor" >
                                            <span class="input-group-btn">
                                                <input type="button" class="btn btn-xs btn-warning" id="btn10" name="btn_urgent[]" value="Urgent"  style="color:black"onclick="btnUrgent(10)">
                                                <input type="button" class="btn btn-xs btn-default" id="btnbon10" name="btn_bon[]" value="Bon" style="color:black;margin-left:10px;width:50px" onclick="btnBonKgs(10)">
                                                <input type="button" class="btn btn-xs btn-info" id="btnlangsung10" name="btn_langsung[]" value="Langsung" style="color:black;margin-left:10px;width:70px" onclick="btnLangsungKgs(10)">
                                                <input type="button" class="btn btn-xs btn-success" id="btnbesc10" name="btn_besc[]" value="Best" style="color:black;margin-left:10px;width:70px" onclick="btnBescKgs(10)">
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12 text-center">
                                        <button type="button" onclick="inputPSPB(this)" class="btn btn-info" style="color:black">Input <i class="fa fa-arrow-circle-right" ></i></button>    
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <div class="table-responsive" id="tb_inputSPB">
                                        <table class="datatable table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%;">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal</th>
                                                    <th>Jenis Dokumen</th>
                                                    <th>No Dokumen</th>
                                                    <th>Jumlah Item</th>
                                                    <th>Jumlah Pcs</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no=1; foreach($value as $val){ 
                                                    if ($val['URGENT'] != '') {
                                                        $td = 'bg-danger';
                                                    }else{
                                                        $td = '';
                                                    }
                                                    ?>
                                                <tr id="baris<?= $no?>">
                                                    <td class="<?= $td?>" style="width: 5px"><?= $no; ?></td>
                                                    <td class="<?= $td?>"><input type="hidden" name="jam[]" value="<?= $val['TGL_DIBUAT']?>"><?= $val['TGL_DIBUAT']?></td>
                                                    <td class="<?= $td?>"><input type="hidden" id="jenis<?= $no; ?>" name="jenis_doc[]" value="<?= $val['JENIS_DOKUMEN']?>"><?= $val['JENIS_DOKUMEN']?></td>
                                                    <td class="<?= $td?>" style="font-size:17px; font-weight: bold" ><input type="hidden" id="nodoc<?= $no; ?>" name="no_doc[]" value="<?= $val['NO_DOKUMEN']?>"><?= $val['NO_DOKUMEN']?></td>
                                                    <td class="<?= $td?>"><input type="hidden" name="jml_item[]" value="<?= $val['JUMLAH_ITEM']?>"><?= $val['JUMLAH_ITEM']?></td>
                                                    <td class="<?= $td?>"><input type="hidden" name="jml_pcs[]" value="<?= $val['JUMLAH_PCS']?>"><?= $val['JUMLAH_PCS']?></td>
                                                    <td class="<?= $td?>" style="width: 15px"><input type="hidden" name="ket[]" value="<?= $val['URGENT']?>"><?= $val['URGENT']?> <?= $val['BON']?></td>
                                                </tr>
                                                <?php $no++; } ?>
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
			<div class="modal-header">
				<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
				<!-- <h3 class="modal-title" style="text-align:center;"><b>Konfirmasi Penerimaan Komponen</b></h3> -->
			</div>
			<div class="modal-body">
            <h3 class="modal-title" style="text-align:center;"><b>Mohon Tunggu Sebentar...</b></h3>
		    </div>
		</div>
	</div>
</div>