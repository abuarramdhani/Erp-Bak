<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border" style="font-size:20px"><b><i class="fa fa-desktop"></i> <?= $Title?></b></div>
                            <div class="box-body">
                                <div class="col-md-12 text-right">
                                    <label class="control-label"><?php echo gmdate("l, d F Y, H:i:s", time()+60*60*7) ?></label>
                                </div>
                                <br>
                                <div class="panel-body col-md-12">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <label class="control-label">Subinventory</label>
                                            <select class="form-control select2" data-placeholder="Pilih Subinventory Terlebih Dahulu" id="subinv" name="subinv">
                                                <option> </option>
                                                <option>KOM1-DM</option>
                                                <option>PNL-DM</option>
                                                <option>FG-DM</option>
                                                <option>MAT-PM</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Search by :</label>
                                            <select id="search_by_kgp" name="search_by_kgp" class="form-control select2">
                                                <option> </option>
                                                <option value="dokumen">Dokumen</option>
                                                <option value="tanggal">Tanggal</option>
                                                <option value="pic">PIC</option>
                                                <!-- <option value="item">Item</option> -->
                                                <!-- <option value="belumterlayani">Belum Terlayani</option>
                                                <option value="export" id="slcExMGS">Export Excel</option> -->
                                                <!-- <option value="tanpa_surat" id="tanpa_surat">Tanpa Surat</option> -->
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="panel-body">
                                        <div class="col-md-3" style="display:none" id="slcnodoc">
                                            <label >No Dokumen</label>
                                            <input id="no_dokumen" name="no_dokumen" class="form-control" style="width:100%;" placeholder="No Dokumen">
                                        </div>
                                        <div class="col-md-3" style="display:none" id="slcjenis">
                                            <label class="control-label">Jenis Dokumen </label>
                                                <select id="jenis_dokumen" name="jenis_dokumen" class="form-control select2 select2-hidden-accessible" style="width:100%;" data-placeholder="Pilih Jenis Dokumen">
                                                    <option></option>
                                                    <option value="PICKLIST">PICKLIST</option>
                                                    <option value="BON">BON</option>
                                                    <option value="MO">MO</option>
                                                    <option value="DO">DO</option>
                                                    <option value="IO">IO</option>
                                                </select>
                                        </div>
                                    </div>
                                    <div class="panel-body" style="display:none" id="slcTgl">
                                        <div class="col-md-3">
                                            <label class="control-label">Tanggal Awal</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                <input id="tglAwal" name="tglAwal" type="text" class="form-control pull-right dateKGP" style="width:100%;" placeholder="dd/mm/yyyy" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="control-label">Tanggal Akhir</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                <input id="tglAkhir" name="tglAkhir" type="text" class="form-control pull-right dateKGP" style="width:100%;" placeholder="dd/mm/yyyy" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body" style="display:none" id="slcPIC">
                                        <div class="col-md-3">
                                            <label class="control-label">PIC</label>
                                            <select id="pic" name="pic" class="form-control select2 select2-hidden-accessible picKGP" style="width:100%;" required>
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
                                </div>
                                <div class="col-md-12">
                                    <div class="panel-body">
                                        <button type="button" class="btn btn-primary" style="margin-left:25px" onclick="getMonPengeluaran(this)"><i class="fa fa-search"></i> Search</button>                                    
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body" id="tbl_monpengeluaran"></div>
                        </div>
                        <!-- </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>