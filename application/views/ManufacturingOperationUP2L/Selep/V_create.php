<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('ManufacturingOperationUP2L/Selep/create');?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperationUP2L/Selep/');?>">
                                        <i class="icon-wrench icon-2x"></i>
                                        <span ><br /></span>
                                    </a>                             
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">Create Selep</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                         <div class="form-group">
                                            <label for="txtSelepDateHeader" class="control-label col-lg-4">Selep Date</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtSelepDateHeader" class="form-control time-form ajaxOnChange" required="" placeholder="Selep Date">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="txtComponentCodeHeader" class="control-label col-lg-4">Component Code</label>
                                            <div class="col-lg-4">
                                             <select class="form-control jsSlcComp toupper" id="txtComponentCodeHeader" name="txtComponentCodeHeader" required data-placeholder="Component Code" onchange="getCompDescMO(this)">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="txtComponentDescriptionHeader" class="control-label col-lg-4">Component Description</label>
                                        <div class="col-lg-4">
                                            <input type="text" placeholder="Component Description" name="component_description" id="txtComponentDescriptionHeader" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="txtSelepQuantityHeader" class="control-label col-lg-4">Selep Quantity</label>
                                        <div class="col-lg-4">
                                            <input type="text" placeholder="Selep Quantity" name="txtSelepQuantityHeader" id="txtSelepQuantityHeader" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Employee</div>
                                        <div class="panel-body" id="container-employee">
                                            <div class="form-group">
                                                <label for="txtJobIdHeader" class="control-label col-lg-4">Nama</label>
                                                <div class="col-lg-4">
                                                    <select class="form-control jsSlcEmpl toupper" id="txtJobIdHeader" name="txtJobIdHeader" required data-placeholder="Employee Name" >
                                                        <option></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row" style="padding:20px;">
                                                <label for="txtPresensi" class="control-label col-lg-4">Presensi</label>
                                                <div class="col-lg-2">
                                                    <select class="form-control  toupper" id="txtPresensi" name="txt_presensi" >
                                                        <option value="HDR">Hadir</option>
                                                        <option value="ABS">Absen</option>
                                                        <option value="CT">Cuti</option>
                                                        <option value="SK">SK</option>
                                                    </select>
                                                </div>
                                                <label for="txtProduksi" class="control-label col-lg-2">Produksi</label>
                                                <div class="col-lg-2">
                                                    <select class="form-control  toupper" id="txtPresensi" name="txt_produksi" data-placeholder="Employee Name" >
                                                        <option value="Y">Yes</option>
                                                        <option value="N">No</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row" style="padding:17px;">
                                                <label for="txtNilaiOTT" class="control-label col-lg-4">Nilai OTT</label>
                                                <div class="col-lg-2">
                                                    <input class="form-control toupper" id="txtNilaiOTT" name="txt_ott"  placeholder="Nilai OTT" >
                                                </div>
                                                <label for="txtMouldingQuantityHeader" class="control-label col-lg-2">Lembur</label>
                                                <div class="col-lg-2">
                                                    <select class="form-control toupper" id="txtEmployeeHeader" name="txt_lembur"  data-placeholder="Lembur / Tidak" >
                                                        <option>False</option>
                                                        <option>True</option>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <br />
                                    <br />
                                    <div class="row">
                                        <div class="nav-tabs-custom">
                                            <ul class="nav nav-tabs">
                                            </ul>
                                            <div class="tab-content">
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