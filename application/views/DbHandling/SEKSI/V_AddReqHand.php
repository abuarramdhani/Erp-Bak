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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('DbHandlingSeksi/MonitoringHandling/AddreqHand'); ?>">
                                    <i class="fa fa-plus fa-2x">
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
                        <div class="box box-warning">
                            <div class="box-header with-border" style="font-weight: bold;"></div>
                            <div class="box-body">
                                <form name="Orderform" class="form-horizontal" enctype="multipart/form-data" onsubmit="return validasi();window.location.reload();" method="post">
                                    <div class="panel-body">
                                        <div class="col-md-3" style="text-align: right;"><label>Komponen</label></div>
                                        <div class="col-md-8" style="text-align: left;">
                                            <select class="form-control select2" id="komponen_Seksi" name="komponen_Seksi" data-placeholder="Select">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" id="nam_komp_seksi" name="nam_komp_seksi">
                                    <div class="panel-body">
                                        <div class="col-md-3" style="text-align: right;"><label>Status Komponen</label></div>
                                        <div class="col-md-8" style="text-align: left;">
                                            <select class="form-control select2 Stat_Komp_seksi" id="Stat_Komp_seksi" name="Stat_Komp_seksi" data-placeholder="Select">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-3" style="text-align: right;"><label>Produk</label></div>
                                        <div class="col-md-8" style="text-align: left;">
                                            <select class="form-control select2 produk_seksi" id="produk_seksi" name="produk_seksi" data-placeholder="Select">
                                                <option></option>
                                            </select></div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-3" style="text-align: right;"><label>Sarana Handling</label></div>
                                        <div class="col-md-8" style="text-align: left;">
                                            <select class="form-control select2 Sar_Hand_Seksi" id="Sar_Hand_Seksi" name="Sar_Hand_Seksi" data-placeholder="Select">
                                                <option></option>
                                            </select></div>
                                    </div>

                                    <div class="panel-body">
                                        <div class="col-md-3" style="text-align: right;"><label>Qty / Handling</label></div>
                                        <div class="col-md-8" style="text-align: left;"><input id="Qty_seksi" name="Qty_seksi" onkeypress="return angkaaa(event, false)" type="text" class="form-control" /></div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-3" style="text-align: right;"><label>Berat</label></div>
                                        <div class="col-md-8" style="text-align: left;"><input id="Berat_Seksi" name="Berat_Seksi" onkeypress="return angkaaa(event, false)" type="text" class="form-control" /></div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-3" style="text-align: right;"><label>Seksi</label></div>
                                        <div class="col-md-8" style="text-align: left;"><input id="Seksi_Hand" name="Seksi_Hand" type="text" class="form-control" /></div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-3" style="text-align: right;"><label>Proses</label></div>
                                        <div class="col-md-8" style="text-align: left;">
                                            <!-- <select class="form-control select2 prosesss" id="prosesss" name="prosesss" data-placeholder="Select"> -->
                                            <select class="form-control select2 Pro_seksi" id="Pro_seksi" name="Pro_seksi" data-placeholder="Select">
                                                <option></option>
                                                <option value="Linear">Linear</option>
                                                <option value="Non Linear">Non Linear</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div id="iflinier" style="display: none;">
                                        <div class="panel-body">
                                            <div class="col-md-3" style="text-align: right;color:white"><label>Proses</label></div>
                                            <div class="col-md-8" style="text-align: left;">
                                                <!-- <div class="col-md-2"><input type="text" class="form-control" name="nomorproses[]" readonly="readonly" value="1" /></div> -->
                                                <div class="col-md-2"><input type="text" class="form-control" name="u_proses[]" readonly="readonly" value="1" /></div>
                                                <div class="col-md-4">
                                                    <!-- <select style="width: 100%;" class="form-control select2 id_Seksi" id="id_Seksi" name="id_Seksi[]" data-placeholder="Identitas Seksi"> -->
                                                    <select style="width: 100%;" class="form-control select2 Id_S_eksi" id="Id_S_eksi" name="Id_S_eksi[]" data-placeholder="Identitas Seksi">
                                                        <option></option>
                                                        <option value="UPPL">UPPL</option>
                                                        <option value="Sheet Metal">Sheet Metal</option>
                                                        <option value="Machining">Machining</option>
                                                        <option value="Perakitan">Perakitan</option>
                                                        <option value="PnP">PnP</option>
                                                        <option value="Gudang">Gudang</option>
                                                        <option value="Subkon">Subkon</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-1">
                                                    <div id="warnaea" style="background-color: white;color:white;font-size:14pt;padding:2px;">A</div>
                                                </div>
                                                <div class="col-md-4">
                                                    <!-- <select style="width: 100%;" class="form-control select2 prosesseksi" name="prosesseksi[]" disabled id="prosesseksi" data-placeholder="Proses Seksi"> -->
                                                    <select style="width: 100%;" class="form-control select2 pros_s_eksi" name="pros_s_eksi[]" disabled id="pros_s_eksi" data-placeholder="Proses Seksi">
                                                        <option></option>
                                                    </select>
                                                </div>
                                                <!-- <div class="col-md-1"><a class="btn btn-default btnplus" onclick="appendproseslinear()"><i class="fa fa-plus"></i></a></div> -->
                                                <div class="col-md-1"><a class="btn btn-default btnnplus" onclick="iflinear()"><i class="fa fa-plus"></i></a></div>
                                            </div>
                                        </div>
                                        <div id="addhere"></div>
                                        <div class="panel-body">
                                            <div class="col-md-3" style="text-align: right;"><label>Preview Proses</label></div>
                                            <div class="col-md-8" id="prevPros" style="border: 1px solid black; border-collapse: collapse">
                                                <div style="display: inline-block;">
                                                    <div id="kotak_proses" style="border: 1px solid black;margin:10px;text-align:center;padding: 10px 0;">
                                                        <p style="margin:10px" id="textt"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="col-md-3" style="text-align: right;"><label>Foto</label></div>
                                            <!-- <div class="col-md-1" style="text-align: right;"><input class="form-control" readonly name="fotoproseslinear[]" value="1" /></div> -->
                                            <div class="col-md-1" style="text-align: right;"><input class="form-control" readonly name="u_fotohandlinglinier[]" value="1" /></div>
                                            <!-- <div class="col-md-5"><input type="file" class="form-control" id="gambarproses" accept=".jpg, .png, ,jpeg" name="gambarproses[]" onchange="readURL1(this)" /></div> -->
                                            <div class="col-md-5"><input type="file" class="form-control" id="fotohandlinglinier" accept=".jpg, .png, ,jpeg" name="fotohandlinglinier[]" /></div>
                                            <!-- <div class="col-md-1" style="text-align: right;"><a class="btn btn-default btn_input_gambarr" onclick="appendinputgambar()"><i class="fa fa-plus"></i></a></div> -->
                                            <div class="col-md-1" style="text-align: right;"><a class="btn btn-default inp_Foto" onclick="appendfoto()"><i class="fa fa-plus"></i></a></div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="col-md-3" style="text-align: right;color:white"><label>Foto</label></div>
                                            <div class="col-md-1" style="text-align: right;"></div>
                                            <!-- <div class="col-md-5"><img style="width:100%" id="previewgambwar"></div> -->
                                            <div class="col-md-5"><img style="width:100%" id="prevFoto"></div>
                                        </div>
                                        <!-- <div id="appendinputgambar"></div> -->
                                        <div id="inputgambarnew"></div>

                                    </div>
                                    <div id="ifnonlinier" style="display: none;">
                                        <div class="panel-body">
                                            <div class="col-md-3" style="text-align: right; color:white"><label>Foto</label></div>
                                            <!-- <div class="col-md-8"><input type="file" class="form-control" accept=".jpg, .png, ,jpeg" id="prosesnonlinear" onchange="tampilprosesnonlinear(this)" name="prosesnonlinear[]" /></div> -->
                                            <div class="col-md-8"><input type="file" class="form-control" accept=".jpg, .png, ,jpeg" id="pros_n_linear" onchange="viewprosnonlinier(this)" name="pros_n_linear[]" /></div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="col-md-3" style="text-align: right; color:white"><label>Foto</label></div>
                                            <!-- <div class="col-md-8"><img style="width:100%" id="prosesnonlinearimg"></div> -->
                                            <div class="col-md-8"><img style="width:100%" id="prev_proses_n_linear"></div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="col-md-3" style="text-align: right;"><label>Foto</label></div>
                                            <!-- <div class="col-md-1" style="text-align: right;"><input class="form-control" readonly name="fotoprosesnonlinear[]" value="1" /></div> -->
                                            <div class="col-md-1" style="text-align: right;"><input class="form-control" readonly name="u_fotohandlingnonlinier[]" value="1" /></div>
                                            <!-- <div class="col-md-5"><input type="file" class="form-control" accept=".jpg, .png, ,jpeg" id="gambarprosesnonlinear" onchange=" tampilgambarprosesnonlinear(this)" name="gambarprosesnonlinear[]" /></div> -->
                                            <div class="col-md-5"><input type="file" class="form-control" accept=".jpg, .png, ,jpeg" id="fotohandlingnonlinier" onchange=" tampilfotohandlingnonlinier(this)" name="fotohandlingnonlinier[]" /></div>
                                            <!-- <div class="col-md-1" style="text-align: right;"><a class="btn btn-default btn_input_gambar" onclick="appendinputgambar2()"><i class="fa fa-plus"></i></a></div> -->
                                            <div class="col-md-1" style="text-align: right;"><a class="btn btn-default inp_foto_non_linear" onclick="append_foto_non_linear()"><i class="fa fa-plus"></i></a></div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="col-md-3" style="text-align: right;color:white"><label>Foto</label></div>
                                            <div class="col-md-1" style="text-align: right;"></div>
                                            <!-- <div class="col-md-5"><img style="width:100%" id="gambarprosesnonlinearimg"></div> -->
                                            <div class="col-md-5"><img style="width:100%" id="prevFotoNonLinear"></div>
                                        </div>
                                        <div id="appendinputgambar2"></div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-3" style="text-align: right;"><label>Keterangan</label></div>

                                        <div class="col-md-8" style="text-align: left;"><textarea id="ket_hand" maxlength="300" name="ket_hand" class="form-control" placeholder="Enter ..."></textarea></div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-6" style="text-align: left;">
                                            <button formaction="<?php echo base_url('DbHandlingSeksi/MonitoringHandling'); ?>" class="btn btn-danger">Back</button>
                                        </div>
                                        <div class="col-md-6" style="text-align: right;">
                                            <button formaction="<?php echo base_url('DbHandlingSeksi/MonitoringHandling/adddatahandling'); ?>" class="btn btn-success">Save</button>
                                        </div>
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