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
                                    href="<?php echo site_url('MonitoringGdSparepart/Input/');?>">
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
                                <div class="panel-body">
                                    <div class="col-md-4" align="center" style="float:none; margin: 0 auto">
                                        <label class="control-label">Masukan Nomor Dokumen</label>
                                        <input id="noDokumen" name="noDokumen" class="form-control pull-right" placeholder="Masukan Nomor Dokumen" >
                                    </div>
                                </div>
                                    
                                <div class="panel-body">
                                    <div class="col-md-2">
                                        <label class="control-label">Jenis Dokumen </label>
                                        <input id="jenis_dokumen" name="jenis_dokumen" class="form-control" style="width:100%;" readonly>
                                        <!-- <select id="jenis_dokumen" name="jenis_dokumen" class="form-control select2 select2-hidden-accessible" disabled style="width:100%;">
                                            <option></option>
                                            <option value="IO">IO</option>
                                            <option value="KIB">KIB</option>
                                            <option value="LPPB">LPPB</option>
                                            <option value="MO">MO</option>
                                        </select> -->
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-2">
                                        <label class="control-label">No. Dokumen : </label>
                                        <input id="no_document" name="no_document" class="form-control" style="width:100%;" readonly>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-2">
                                        <!-- <label id="jam_input" name="jam_input"class="control-label" >Jam Input  : <?php echo gmdate("H:i", time()+60*60*7); ?></label> -->
                                        <label name="jam_input"class="control-label" >Jam Input  : <a id="jam_input" style="color:black;"></a></label>
                                    </div>
                                </div>
                                
                                <div class="panel-heading text-right">
                                    <button onclick="getMPG(this)" class="btn btn-success" title="input"><i class="fa fa-plus"></i> Input</button>
                                </div>

                                <form id="Saveform" method="post" autocomplete="off" action="<?php echo base_url('MonitoringGdSparepart/Input/getSave')?>">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table id="tb_monitorGudang" class="table table-bordered table-hover table-striped text-center" style="width: 100%; table-layout:fixed;">
                                                <thead>
                                                    <tr class="bg-primary">
                                                        <th width="5%">No</th>
                                                        <th width="15%">Item</th>
                                                        <th width="50%">Deskripsi</th>
                                                        <th>Jumlah</th>
                                                        <th>Satuan</th>
                                                        <th>Status</th>
                                                        <!-- <th>Ket</th> -->
                                                    </tr>
                                                </thead>
                                                <tbody id="tb_GudangSparepart"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-2" align="center" style="float:none; margin: 0 auto">
                                            <label>PIC</label>
                                            <!-- <input id="pic" name="pic" class="form-control" style="width:100%;" required> -->
                                            <select id="pic" name="pic" class="form-control select2 select2-hidden-accessible picGDSP" style="width:100%;" required>
                                            <option></option>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="panel-heading text-right">
                                        <button type="submit" class="btn btn-lg btn-danger" title="save"> Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
window.setTimeout("waktu()",1000); 
function waktu() {
var tanggal = new Date(); 
setTimeout("waktu()",1000); 
document.getElementById("jam_input").innerHTML 
= tanggal.getHours()+":"+tanggal.getMinutes()+":"+tanggal.getSeconds(); 
} 
</script>