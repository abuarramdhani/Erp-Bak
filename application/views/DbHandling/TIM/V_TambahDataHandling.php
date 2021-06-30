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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('DbHandling/MonitoringHandling/tambahdatahandling'); ?>">
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
                                        <div class="col-md-6" style="text-align: left;">
                                            <select required style="width: 100%;" class="form-control select2" id="kodekompp" data-placeholder="Select">
                                                <option></option>
                                            </select>
                                            <span id="validationkomp" style="color:red;display:none">*Komponen sudah terdaftar</span>
                                        </div>
                                        <div class="col-md-2" id="appendtomboldisini" style="text-align: center;">
                                            <i class="fa fa-check fa-2x showkalaukompbelomada" style="color:green;display:none"></i>
                                            <a class="btn btn-warning" id="btnrev" style="display: none;width:60%">Revisi</a>
                                        </div>
                                    </div>
                                    <input type="hidden" id="namakomp" name="namakomp">
                                    <input type="hidden" id="kodekompp2" name="kodekompp">
                                    <div class="hideajakalaukompudahada" style="display:none">
                                        <div class="panel-body">
                                            <div class="col-md-3" style="text-align: right;"><label>Status Komponen</label></div>
                                            <div class="col-md-8" style="text-align: left;">
                                                <select required style="width: 100%;" class="form-control select2 status_komp" id="status_komp" name="status_komp" data-placeholder="Select">
                                                    <option></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="col-md-3" style="text-align: right;"><label>Produk</label></div>
                                            <div class="col-md-8" style="text-align: left;">
                                                <select required style="width: 100%;" class="form-control select2 produkk" id="produkk" name="produkk" data-placeholder="Select">
                                                    <option></option>
                                                </select></div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="col-md-3" style="text-align: right;"><label>Sarana Handling</label></div>
                                            <div class="col-md-8" style="text-align: left;">
                                                <select required style="width: 100%;" class="form-control select2 saranahand" id="saranahand" name="saranahand" data-placeholder="Select">
                                                    <option></option>
                                                </select></div>
                                        </div>

                                        <div class="panel-body">
                                            <div class="col-md-3" style="text-align: right;"><label>Qty / Handling</label></div>
                                            <div class="col-md-8" style="text-align: left;"><input id="qtyhand" name="qtyhand" onkeypress="return angkaaa(event, false)" type="text" required class="form-control" /></div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="col-md-3" style="text-align: right;"><label>Berat</label></div>
                                            <div class="col-md-8" style="text-align: left;"><input id="weighthand" name="weighthand" onkeypress="return angkaaa(event, false)" type="text" required class="form-control" /></div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="col-md-3" style="text-align: right;"><label>Seksi</label></div>
                                            <div class="col-md-8" style="text-align: left;">
                                                <select style="width: 100%;" id="seksihand" class="form-control select2" name="seksihand" data-placeholder="Select">
                                                    <option></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="col-md-3" style="text-align: right;"><label>Proses</label></div>
                                            <div class="col-md-8" style="text-align: left;">
                                                <input  required style="width: 100%;" class="form-control" id="prosesss" name="prosesss" value="Linear" readonly>
                                                <!-- <select required style="width: 100%;" class="form-control select2 prosesss" id="prosesss" name="prosesss" data-placeholder="Select">
                                                    <option></option>
                                                    <option value="Linear">Linear</option>
                                                    <option value="Non Linear">Non Linear</option>
                                                </select> -->
                                            </div>
                                        </div>
                                        <div id="afterprosesslinier">
                                            <div class="panel-body">
                                                <div class="col-md-3" style="text-align: right;color:white"><label>Proses</label></div>
                                                <div class="col-md-8" style="text-align: left;">
                                                    <div class="col-md-2"><input type="text" required class="form-control" name="nomorproses[]" readonly="readonly" value="1" /></div>
                                                    <div class="col-md-4">
                                                        <select required style="width: 100%;" class="form-control select2 id_Seksi" id="id_Seksi" name="id_Seksi[]" data-placeholder="Identitas Seksi">
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
                                                        <div id="warnanyadisini" style="background-color: white;color:white;font-size:14pt;padding:2px;">A</div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <select required style="width: 100%;" class="form-control select2 prosesseksi" name="prosesseksi[]" id="prosesseksi" data-placeholder="Proses Seksi">
                                                            <option></option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-1"><a class="btn btn-default btnplus" onclick="appendproseslinear()"><i class="fa fa-plus"></i></a></div>
                                                </div>
                                            </div>
                                            <div id="appendd"></div>
                                            <div class="panel-body">
                                                <div class="col-md-3" style="text-align: right;"><label>Preview Proses</label></div>
                                                <div class="col-md-8" id="previewproses" style="border: 1px solid black; border-collapse: collapse">
                                                    <div style="display: inline-block;">
                                                        <div id="previewkotakproses" style="border: 1px solid black;margin:10px;text-align:center;padding: 10px 0;">
                                                            <p style="margin:10px" id="tulisann"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <div class="col-md-3" style="text-align: right;"><label>Foto</label></div>
                                                <div class="col-md-1" style="text-align: right;"><input class="form-control" readonly name="fotoproseslinear[]" value="1" /></div>
                                                <div class="col-md-5"><input type="file" required class="form-control" id="gambarproses" accept=".jpg, .png, ,jpeg" name="gambarproses[]" onchange="readURL1(this)" /></div>
                                                <div class="col-md-1" style="text-align: right;"><a class="btn btn-default btn_input_gambarr" onclick="appendinputgambar()"><i class="fa fa-plus"></i></a></div>
                                            </div>
                                            <div class="panel-body">
                                                <div class="col-md-3" style="text-align: right;color:white"><label>Foto</label></div>
                                                <div class="col-md-1" style="text-align: right;"></div>
                                                <div class="col-md-5"><img style="width:100%" id="previewgambwar"></div>
                                            </div>
                                            <div id="appendinputgambar"></div>

                                        </div>
                                        <!-- <div id="afterprosesnonlinier" style="display: none;">
                                            <div class="panel-body">
                                                <div class="col-md-3" style="text-align: right; color:white"><label>Foto</label></div>
                                                <div class="col-md-8"><input type="file" required class="form-control" accept=".jpg, .png, ,jpeg" id="prosesnonlinear" onchange="tampilprosesnonlinear(this)" name="prosesnonlinear[]" /></div>
                                            </div>
                                            <div class="panel-body">
                                                <div class="col-md-3" style="text-align: right; color:white"><label>Foto</label></div>
                                                <div class="col-md-8"><img style="width:100%" id="prosesnonlinearimg"></div>
                                            </div>
                                            <div class="panel-body">
                                                <div class="col-md-3" style="text-align: right;"><label>Foto</label></div>
                                                <div class="col-md-1" style="text-align: right;"><input class="form-control" readonly name="fotoprosesnonlinear[]" value="1" /></div>
                                                <div class="col-md-5"><input type="file" required class="form-control" accept=".jpg, .png, ,jpeg" id="gambarprosesnonlinear" onchange=" tampilgambarprosesnonlinear(this)" name="gambarprosesnonlinear[]" /></div>
                                                <div class="col-md-1" style="text-align: right;"><a class="btn btn-default btn_input_gambar" onclick="appendinputgambar2()"><i class="fa fa-plus"></i></a></div>
                                            </div>
                                            <div class="panel-body">
                                                <div class="col-md-3" style="text-align: right;color:white"><label>Foto</label></div>
                                                <div class="col-md-1" style="text-align: right;"></div>
                                                <div class="col-md-5"><img style="width:100%" id="gambarprosesnonlinearimg"></div>
                                            </div>
                                            <div id="appendinputgambar2"></div>
                                        </div> -->
                                        <div class="panel-body">
                                            <div class="col-md-3" style="text-align: right;"><label>Keterangan</label></div>

                                            <div class="col-md-8" style="text-align: left;"><textarea id="kethand" maxlength="300" name="kethand" class="form-control" placeholder="Enter ..."></textarea></div>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-6" style="text-align: left;">
                                            <a href="<?php echo base_url('DbHandling/MonitoringHandling'); ?>" class="btn btn-danger">Back</a>
                                        </div>
                                        <div class="col-md-6" style="text-align: right;">
                                            <button disabled="disabled" formaction="<?php echo base_url('DbHandling/MonitoringHandling/adddatahandling'); ?>" class="btn btn-success savehand">Save</button>
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
<div class="modal fade" id="modalrevhand" role="dialog">
    <div class="modal-dialog" style="width:60%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center>
                    <h3 class="modal-title">Revisi Data Handling</h3>
                </center>
            </div>
            <div class="modal-body">
                <div id="revhand"></div>
            </div>
        </div>

    </div>
</div>