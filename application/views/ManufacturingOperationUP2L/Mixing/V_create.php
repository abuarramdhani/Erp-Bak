<section class="content">
    <div class="inner">
        <div class="row">
            <form action="<?php echo site_url('ManufacturingOperationUP2L/Mixing/create');?>" class="form-horizontal" method="post">
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
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperationUP2L/Mixing/');?>">
                                        <i class="icon-wrench icon-2x">
                                        </i>
                                        <span>
                                            <br/>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">
                                    Create Mixing
                                </div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Component Code</label>
                                                <div class="col-md-4">
                                                    <select class="form-control jsSlcComp toupper" name="cmbComponentCodeHeader" required="" data-placeholder="Component Code" onchange="getCompDescMO(this)">
                                                        <option></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-lg-4" for="txtComponentDescriptionHeader">
                                                    Component Description
                                                </label>
                                                <div class="col-lg-4">
                                                    <input class="form-control" id="txtComponentDescriptionHeader" name="component_description" placeholder="Component Description" type="text"     />
                                                </div>
                                            </div>
                                            <!-- <div class="form-group">
                                                <label class="control-label col-lg-4" for="txtProductionDateHeader">
                                                    Production Date
                                                </label>
                                                <div class="col-lg-4">
                                                    <input class="datetime form-control time-form" data-date-format="yyyy-mm-dd hh:ii:ss" id="txtProductionDateHeader" name="txtProductionDateHeader" placeholder="<?php echo date('Y-m-d h:i:s')?>" type="text"/>
                                                </div>
                                            </div> -->
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Production Date</label>
                                                <div class="col-md-4">
                                                    <input type="text" id="txtProductionDateHeader" name="txtProductionDateHeader" class="form-control time-form1 ajaxOnChange" required="" placeholder="Production Date">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="txtShift" class="control-label col-lg-4">Shift</label>
                                                <div class="col-lg-4">
                                                <select class="form-control slcShift" id="txtShift" name="txtShift">
                                                        <!-- <option value=""></option> -->
                                                </select>    
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-lg-4" for="txtMixingQuantityHeader">
                                                    Mixing Quantity
                                                </label>
                                                <div class="col-lg-4">
                                                    <input class="form-control" id="txtMixingQuantityHeader" name="txtMixingQuantityHeader" placeholder="Mixing Quantity" type="text"/>
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
                                                            <input class="form-control toupper" id="txtNilaiOTT" name="txt_ott" placeholder="Nilai OTT" >
                                                        </div>
                                                        <label for="txtMouldingQuantityHeader" class="control-label col-lg-2">Lembur</label>
                                                        <div class="col-lg-2">
                                                            <select class="form-control toupper" id="txtEmployeeHeader" name="txt_lembur"  data-placeholder="Lembur / Tidak" >
                                                               <option value="false">False</option>
                                                               <option value="true">True</option>
                                                           </select>
                                                       </div>

                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                                   <div class="panel-footer">
                                    <div class="row text-right">
                                        <a class="btn btn-primary btn-lg btn-rect" href="javascript:history.back(1)">
                                            Back
                                        </a>
                                        <button class="btn btn-primary btn-lg btn-rect" type="submit">
                                            Save Data
                                        </button>
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