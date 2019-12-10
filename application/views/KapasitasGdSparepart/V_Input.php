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
                                        <div class="col-md-3">
                                            <div class="input-group input-group-sm">
                                            <input id="noSpb1" class="form-control pull-right" placeholder="Masukan Nomor" >
                                            <span class="input-group-btn">
                                                <input type="button" class="btn btn-xs btn-warning" id="btn1" value="Urgent" style="color:black" onclick="btnUrgent(1)">
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-sm">
                                            <input id="noSpb2" class="form-control pull-right" placeholder="Masukan Nomor" >
                                            <span class="input-group-btn">
                                                <input type="button" class="btn btn-xs btn-warning" id="btn2" value="Urgent" style="color:black" onclick="btnUrgent(2)">
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-sm">
                                            <input id="noSpb3" class="form-control pull-right" placeholder="Masukan Nomor" >
                                            <span class="input-group-btn">
                                                <input type="button" class="btn btn-xs btn-warning" id="btn3" value="Urgent" style="color:black" onclick="btnUrgent(3)">
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-sm">
                                            <input id="noSpb4" class="form-control pull-right" placeholder="Masukan Nomor" >
                                            <span class="input-group-btn">
                                                <input type="button" class="btn btn-xs btn-warning" id="btn4" value="Urgent" style="color:black" onclick="btnUrgent(4)">
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-sm">
                                            <input id="noSpb5" class="form-control pull-right" placeholder="Masukan Nomor" >
                                            <span class="input-group-btn">
                                                <input type="button" class="btn btn-xs btn-warning" id="btn5" value="Urgent" style="color:black" onclick="btnUrgent(5)">
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-sm">
                                            <input id="noSpb6" class="form-control pull-right" placeholder="Masukan Nomor" >
                                            <span class="input-group-btn">
                                                <input type="button" class="btn btn-xs btn-warning" id="btn6" value="Urgent" style="color:black" onclick="btnUrgent(6)">
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-sm">
                                            <input id="noSpb7" class="form-control pull-right" placeholder="Masukan Nomor" >
                                            <span class="input-group-btn">
                                                <input type="button" class="btn btn-xs btn-warning" id="btn7" value="Urgent" style="color:black" onclick="btnUrgent(7)">
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-sm">
                                            <input id="noSpb8" class="form-control pull-right" placeholder="Masukan Nomor" >
                                            <span class="input-group-btn">
                                                <input type="button" class="btn btn-xs btn-warning" id="btn8" value="Urgent" style="color:black" onclick="btnUrgent(8)">
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-sm">
                                            <input id="noSpb9" class="form-control pull-right" placeholder="Masukan Nomor" >
                                            <span class="input-group-btn">
                                                <input type="button" class="btn btn-xs btn-warning" id="btn9" value="Urgent" style="color:black" onclick="btnUrgent(9)">
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-sm">
                                            <input id="noSpb10" class="form-control pull-right" placeholder="Masukan Nomor" >
                                            <span class="input-group-btn">
                                                <input type="button" class="btn btn-xs btn-warning" id="btn10" value="Urgent"  style="color:black"onclick="btnUrgent(10)">
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="panel-body">
                                        <div class="col-md-2" align="center" style="float:none; margin: 0 auto">
                                            <label>PIC</label>
                                            <select id="pic" name="pic" class="form-control select2 select2-hidden-accessible" style="width:100%;" required>
                                            <option></option>
                                            <option value="MUJIMAN">MUJIMAN</option>
                                            <option value="JOKO">JOKO</option>
                                            <option value="SANDY">SANDI</option>
                                            <option value="MUSLIH">MUSLIH</option>
                                        </select>
                                        </div>
                                    </div> -->
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
                                                <?php $no=1; foreach($value as $val){ ?>
                                                <tr>
                                                    <td style="width: 5px"><?= $no; ?></td>
                                                    <td><input type="hidden" name="jam[]" value="<?= $val['TGL_DIBUAT']?>"><?= $val['TGL_DIBUAT']?></td>
                                                    <td><input type="hidden" name="jenis_doc[]" value="<?= $val['JENIS_DOKUMEN']?>"><?= $val['JENIS_DOKUMEN']?></td>
                                                    <td style="font-size:17px; font-weight: bold" ><input type="hidden" name="no_doc[]" value="<?= $val['NO_DOKUMEN']?>"><?= $val['NO_DOKUMEN']?></td>
                                                    <td><input type="hidden" name="jml_item[]" value="<?= $val['JUMLAH_ITEM']?>"><?= $val['JUMLAH_ITEM']?></td>
                                                    <td><input type="hidden" name="jml_pcs[]" value="<?= $val['JUMLAH_PCS']?>"><?= $val['JUMLAH_PCS']?></td>
                                                    <td style="width: 15px"><input type="hidden" name="ket[]" value="<?= $val['URGENT']?>"><?= $val['URGENT']?></td>
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
