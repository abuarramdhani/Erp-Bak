<input type="hidden" value="ok" id="monmpg">
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
                                    href="<?php echo site_url('MonitoringGdSparepart/Monitoring/');?>">
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
                            <div class="box-header with-border"><b>Monitoring</b></div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-12 text-left">
                                      <label class="control-label"><?php echo date("l, d F Y") ?></label>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-3">
                                        <label class="control-label">Subinventory</label>
                                        <input id="subinventory" name="subinventory" class="form-control pull-right" placeholder="Subinventory" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="control-label">Search by </label>
                                            <select id="search_by" name="search_by" class="form-control select2 select2-hidden-accessible" style="width:100%;" data-placeholder="Cari berdasarkan">
                                            <option></option>
                                            <option value="dokumen">Dokumen</option>
                                            <option value="tanggal">Tanggal</option>
                                            <option value="pic">PIC</option>
                                            <option value="item">Item</option>
                                            <option value="belumterlayani">Belum Terlayani</option>
                                            <option value="export" id="slcExMGS">Export Excel</option>
                                            <option value="tanpa_surat" id="tanpa_surat">Tanpa Surat</option>
                                            </select>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-3" style="display:none" id="slcnodoc">
                                        <label >No Dokumen</label>
                                            <input id="no_document" name="no_document" class="form-control" style="width:100%;" placeholder="No Dokumen">
                                    </div>
                                    <div class="col-md-3" style="display:none" id="slcjenis">
                                        <label class="control-label">Jenis Dokumen </label>
                                            <select id="jenis_dokumen" name="jenis_dokumen" class="form-control select2 select2-hidden-accessible" style="width:100%;" data-placeholder="Pilih Jenis Dokumen">
                                            <option></option>
                                            <option value="IO">IO</option>
                                            <option value="KIB">KIB</option>
                                            <option value="LPPB">LPPB</option>
                                            <option value="MO">MO</option>
                                            <!-- <option value="FPB">FPB</option> -->
                                            <option value="SPBSPI">SPBSPI</option>
                                            </select>
                                    </div>
                                </div>
                                <div class="panel-body" style="display:none" id="slcTgl">
                                    <div class="col-md-3">
                                        <label class="control-label">Tanggal Awal</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                            <input id="tglAwal" name="tglAwal" type="text" class="form-control pull-right" style="width:100%;" placeholder="dd/mm/yyyy" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="control-label">Tanggal Akhir</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                            <input id="tglAkhir" name="tglAkhir" type="text" class="form-control pull-right" style="width:100%;" placeholder="dd/mm/yyyy" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body" style="display:none" id="slcPIC">
                                    <div class="col-md-3">
                                        <label class="control-label">PIC</label>
                                        <select id="pic" name="pic" class="form-control select2 select2-hidden-accessible picGDSP" style="width:100%;" required>
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="panel-body" style="display:none" id="slcItem">
                                    <div class="col-md-3">
                                        <label class="control-label">Item</label>
                                        <input id="item" name="item" class="form-control" autocomplete="off" style="width:100%;" placeholder="Item">
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <button onclick="getMGS(this)" class="btn btn-success" id="btnfind" title="search"><i class="fa fa-search"></i> Find</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="TblMon"></div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>