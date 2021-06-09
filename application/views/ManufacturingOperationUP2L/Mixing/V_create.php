<?php echo validation_errors(); ?>
<section class="content">
    <div class="inner">
        <div class="row">
            <form autocomplete="off" action="<?php echo site_url('ManufacturingOperationUP2L/Mixing/create'); ?>" class="form-horizontal" method="post">
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
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperationUP2L/Mixing/'); ?>">
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
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">Create Mixing</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Production Date</label>
                                            <div class="col-md-6">
                                                <input type="text" name="production_date" class="form-control time-form1 ajaxOnChange" placeholder="Production Date">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Print Code</label>
                                            <div id="print_code_area">
                                                <div class="col-md-6">
                                                    <small>-- Select production date to generate print code --</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="txtShift" class="control-label col-lg-4">Shift</label>
                                            <div class="col-lg-6">
                                                <select class="form-control slcShift select2" id="txtShift" name="txtShift">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                        <label for="kode_kel" class="control-label col-lg-4">Kode Kelompok</label>
                                            <div class="col-lg-6">
                                                <select class="form-control" id="kode_kel" name="kode_kel">
                                                    <option name="kode_kel" selected value="">--- Kode Kelompok ---</option>
                                                    <option name="kode_kel" value="A">A</option>
                                                    <option name="kode_kel" value="B">B</option>
                                                    <option name="kode_kel" value="C">C</option>
                                                    <option name="kode_kel" value="D">D</option>
                                                    <option name="kode_kel" value="E">E</option>
                                                    <option name="kode_kel" value="F">F</option>
                                                    <option name="kode_kel" value="G">G</option>
                                                    <option name="kode_kel" value="H">H</option>
                                                    <option name="kode_kel" value="I">I</option>
                                                    <option name="kode_kel" value="J">J</option>
                                                    <option name="kode_kel" value="K">K</option>
                                                    <option name="kode_kel" value="L">L</option>
                                                    <option name="kode_kel" value="M">M</option>
                                                    <option name="kode_kel" value="N">N</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="box box-default box-solid">
                                                <div class="box-header with-border"><div class="col-lg-12"><b>Employee</b></div></div>
                                                <div class="panel-body" id="container-employee">
                                                    <div class="form-group employee">
                                                        <label for="txtMixingQuantityHeader" class="control-label col-lg-4">Nama</label>
                                                        <div class="col-lg-6">
                                                            <select class="form-control jsSlcEmpl toupper" id="txtEmployeeHeader" name="txt_employee[]" required data-placeholder="Employee Name">
                                                                <option></option>
                                                            </select>
                                                        </div>
                                                        <button type="button" class="btn btn-info add_emp"><i class="fa fa-plus"></i></button>
                                                        <button type="button" class="btn btn-danger remove_emp" style="display: none"><i class="fa fa-close"></i></button>

                                                        <div class="row" style="padding:20px;">
                                                            <label for="txtPresensi" class="control-label col-lg-4">Presensi</label>
                                                            <div class="col-lg-2">
                                                                <select class="form-control  toupper" id="txtPresensi" name="txt_presensi[]">
                                                                    <option value="HDR">Hadir</option>
                                                                    <option value="ABS">Absen</option>
                                                                    <option value="CT">Cuti</option>
                                                                    <option value="SK">SK</option>
                                                                </select>
                                                            </div>
                                                            <label for="txtProduksi" class="control-label col-lg-2">Produksi</label>
                                                            <div class="col-lg-2">
                                                                <select class="form-control  toupper" id="txtPresensi" name="txt_produksi[]" data-placeholder="Employee Name">
                                                                    <option value="Y">Yes</option>
                                                                    <option value="N">No</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="row" style="padding:17px;">
                                                            <label for="txtNilaiOTT" class="control-label col-lg-4">Nilai OTT</label>
                                                            <div class="col-lg-2">
                                                                <input class="form-control toupper" id="txtNilaiOTT" name="txt_ott[]" placeholder="Nilai OTT">
                                                            </div>
                                                            <label for="txtMixingQuantityHeader" class="control-label col-lg-2">Lembur</label>
                                                            <div class="col-lg-2">
                                                                <select class="form-control toupper" id="txtEmployeeHeader" name="txt_lembur[]" data-placeholder="Lembur / Tidak">
                                                                    <option value="false">False</option>
                                                                    <option value="true">True</option>
                                                                </select>
                                                            </div>

                                                            <div class="row" style="padding-left:384px;margin-right:-305px;">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="box box-default box-solid">
                                                <div class="box-header with-border">
                                                    <div class="col-lg-12">
                                                        <div><b>Component</b></div>
                                                    </div>
                                                </div>
                                                <div class="panel-body" id="container-compmix">
                                                    <div class="form-group">
                                                        <label for="txtComponentCodeHeader" class="control-label col-lg-4">Component</label>
                                                        <div class="col-lg-6">
                                                            <select class="form-control jsSlcComp toupper" id="txtComponentCodeHeader" name="component_code[]" required data-placeholder="Component Code" onchange="getCompDescMO(this)">
                                                            </select>
                                                        </div>
                                                        <button type="button" class="btn btn-info addCompMixing"> <i class="fa fa-plus"></i></button>
                                                        <button type="button" class="btn btn-danger delcompMixing" style="display:none"> <i class="fa fa-times"></i></button>

                                                        <div class="row" style="padding:18px">
                                                          <label for="txtMixingQuantityHeader" class="control-label col-lg-4">Mixing Quantity</label>
                                                          <div class="col-lg-6">
                                                              <input type="number" placeholder="Mixing Quantity" name="txtMixingQuantityHeader[]" id="txtMixingQuantityHeader" class="form-control" />
                                                          </div>

                                                          <div class="row" style="padding-left:384px;margin-right:-305px;"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="box box-default box-solid">
                                                    <div class="box-header with-border">
                                                        <div class="col-lg-12">
                                                            <div class="col-lg-10"><b>Pemotongan Target</b></div>
                                                        </div>
                                                    </div>
                                                    <div class="panel-body" id="container-component">
                                                        <div class="form-group">
                                                            <label for="txtKeteranganPemotonganTarget" class="control-label col-lg-4">Keterangan</label>
                                                            <div class="col-lg-6">
                                                                <input type="text" placeholder="Keterangan Pemotongan Target" name="txtKeteranganPemotonganTarget" id="txtKeteranganPemotonganTarget" maxlength="29" class="form-control" />
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="txtJamPemotonganTarget" class="control-label col-lg-4">Jam</label>
                                                            <div class="col-lg-6">
                                                                <input type="text" name="txtJamPemotonganTarget" id="txtJamPemotonganTarget" class="txtJamPemotonganTarget form-control" disabled="disabled" />
                                                            </div>
                                                            <span class="btn btn-info onBtn" >ON</span>
                                                            <span class="btn btn-danger offBtn" style="display: none">OFF</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="box-footer text-right">
                                        <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i></i>  Save</button>
                                        <a href="<?php echo site_url('ManufacturingOperationUP2L/Mixing'); ?>" class="btn btn-danger btn-lg"><i class="fa fa-arrow-left"></i></i>  Back</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
