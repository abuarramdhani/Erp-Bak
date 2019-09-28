<section class="content">
    <div class="inner" >
        <div class="row">
            <form autocomplete="off" method="post" action="<?php echo site_url('ManufacturingOperationUP2L/Core/create');?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperationUP2L/Core/');?>">
                                        <i class="icon-wrench icon-2x"></i>
                                    </a>                             
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">Create Core</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Component Code</label>
                                                <div class="col-md-6">
                                                    <select class="form-control jsSlcComp toupper" name="component_code" required="" data-placeholder="Component Code" onchange="getCompDescMO(this)">
                                                        <option></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Component Description</label>
                                                <div class="col-md-6">
                                                    <input type="text" name="component_description" class="form-control" readonly="" placeholder="Component Description">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Production Date</label>
                                                <div class="col-md-6">
                                                    <input type="text" name="production_date" class="form-control time-form1 ajaxOnChange" required="" placeholder="Production Date">
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
                                                <select class="form-control slcShift" id="txtShift" name="txtShift">
                                                        <!-- <option value=""></option> -->
                                                </select>    
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Core Quantity</label>
                                                <div class="col-md-6">
                                                    <input type="number" min="0" name="core_quantity" required="" class="form-control" placeholder="Core Quantity">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                            <label for="ottKodeP" class="control-label col-lg-4">Kode Kelompok</label>
                                                <div class="col-lg-6">
                                                    <select class="form-control" id="ottKodeP" name="ottKodeP">
                                                        <option name="ottKodeP" selected value="">--- Kode Kelompok ---</option>
                                                        <option name="ottKodeP" value="A">A</option>
                                                        <option name="ottKodeP" value="B">B</option>
                                                        <option name="ottKodeP" value="C">C</option>
                                                        <option name="ottKodeP" value="D">D</option>
                                                        <option name="ottKodeP" value="E">E</option>
                                                        <option name="ottKodeP" value="F">F</option>
                                                        <option name="ottKodeP" value="G">G</option>
                                                        <option name="ottKodeP" value="H">H</option>
                                                        <option name="ottKodeP" value="I">I</option>
                                                        <option name="ottKodeP" value="J">J</option>
                                                        <option name="ottKodeP" value="K">K</option>
                                                        <option name="ottKodeP" value="L">L</option>
                                                        <option name="ottKodeP" value="M">M</option>
                                                        <option name="ottKodeP" value="N">N</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                         <div class="panel panel-default">
                                            <div class="panel-heading">Employee</div>
                                            <div class="panel-body" id="container-employee">
                                                <div class="form-group employee">
                                                    <label for="txtMouldingQuantityHeader" class="control-label col-lg-4">Nama</label>
                                                    <div class="col-lg-6">
                                                        <select class="form-control jsSlcEmpl toupper" id="txtEmployeeHeader" name="txt_employee[]" required data-placeholder="Employee Name" >
                                                            <option></option>
                                                        </select>
                                                    </div>

                                                    <button class="btn btn-info add_emp"><i class="fa fa-plus"></i></button>

                                                    <button class="btn btn-danger remove_emp" style="display: none"><i class="fa fa-close"></i></button>
                                                    
                                                    <div class="row" style="padding:20px;">
                                                        <label for="txtPresensi" class="control-label col-lg-4">Presensi</label>
                                                        <div class="col-lg-2">
                                                            <select class="form-control  toupper" id="txtPresensi" name="txt_presensi[]" >
                                                                <option value="HDR">Hadir</option>
                                                                <option value="ABS">Absen</option>
                                                                <option value="CT">Cuti</option>
                                                                <option value="SK">SK</option>
                                                            </select>
                                                        </div>
                                                        <label for="txtProduksi" class="control-label col-lg-2">Produksi</label>
                                                        <div class="col-lg-2">
                                                            <select class="form-control  toupper" id="txtPresensi" name="txt_produksi[]" data-placeholder="Employee Name" >
                                                                <option value="Y">Yes</option>
                                                                <option value="N">No</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row" style="padding:17px;">
                                                        <label for="txtNilaiOTT" class="control-label col-lg-4">Nilai OTT</label>
                                                        <div class="col-lg-2">
                                                            <input class="form-control toupper" id="txtNilaiOTT" name="txt_ott[]" placeholder="Nilai OTT" >
                                                        </div>
                                                        <label for="txtMouldingQuantityHeader" class="control-label col-lg-2">Lembur</label>
                                                        <div class="col-lg-2">
                                                            <select class="form-control toupper" id="txtEmployeeHeader" name="txt_lembur[]"  data-placeholder="Lembur / Tidak" >
                                                                <option value="false">False</option>
                                                                <option value="true">True</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                            
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="row text-right">
                                            <a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
                                            &nbsp;&nbsp;
                                            <button type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
                                        </div>
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