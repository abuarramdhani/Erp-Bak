<section class="content">
    <div class="inner">
        <div class="row">
            <form autocomplete="off" method="post" action="<?php echo site_url('ManufacturingOperationUP2L/Selep/create'); ?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                    <h1><b><?= $Title ?></b></h1>
                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperationUP2L/Selep/'); ?>">
                                        <i class="icon-wrench icon-2x"></i>
                                        <span><br /></span> </a>
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
                                            <div class="col-lg-6">
                                            <input type="text" name="txtSelepDateHeader" class="form-control time-form1 ajaxOnChange" placeholder="Production Date">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="txtShift" class="control-label col-lg-4">Shift</label>
                                            <div class="col-lg-6">
                                                <select class="form-control slcShift" id="txtShift" name="txtShift">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="box box-default box-solid">
                                                <div class="box-header with-border"><div class="col-lg-12">
                                                <div class="col-lg-10">
                                                    <b>Employee</b>
                                                </div>
                                                <div class="col-lg-2">
                                                        <button class="btn btn-info" onclick="add_emp_selep()"><i class="fa fa-plus"></i></button>
                                                        <button class="btn btn-danger" onclick="remove_emp_selep()"><i class="fa fa-close"></i></button>
                                                </div>
                                                </div></div>
                                                <div class="panel-body" id="container-employee">
                                                    <div class="form-group employee">
                                                        <label for="txtSelepQuantityHeader" class="control-label col-lg-4">Nama</label>
                                                        <div class="col-lg-6">
                                                            <select class="form-control jsSlcEmpl toupper" id="txtEmployeeHeader" name="txt_employee[]" required data-placeholder="Employee Name">
                                                                <option></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="box box-default box-solid">
                                                <div class="box-header with-border">
                                                    <div class="col-lg-12">
                                                        <div class="col-lg-10"><b>Component</b></div>
                                                        <div class="col-lg-2" style="float:right;">
                                                            <button onclick="addcompSelep()" class="btn btn-info"> <i class="fa fa-plus"></i></button>
                                                            <button onclick="delcompSelep()" class="btn btn-danger"> <i class="fa fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel-body" id="container-component">
                                                    <div class="form-group">
                                                        <label for="txtComponentCodeHeader" class="control-label col-lg-4">Component</label>
                                                        <div class="col-lg-6">
                                                            <select class="form-control jsSlcComp toupper" id="txtComponentCodeHeader" name="component_code[]" required data-placeholder="Component Code">
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="txtSelepQuantityHeader" class="control-label col-lg-4">Selep Quantity</label>
                                                        <div class="col-lg-6">
                                                            <input type="number" placeholder="Selep Quantity" name="txtSelepQuantityHeader[]" id="txtSelepQuantityHeader" class="form-control" />
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="txtKeterangan" class="control-label col-lg-4">Keterangan</label>
                                                        <div class="col-lg-6">
                                                            <select name="txtKeterangan[]" class="form-control">
                                                                <option value="">null</option>
                                                                <option value="RE">RE</option>
                                                            </select>
                                                        </div>
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
                                                            <input type="text" placeholder="Keterangan Pemotongan Target" name="txtKeteranganPemotonganTarget" id="txtKeteranganPemotonganTarget" class="form-control" />
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="txtJamPemotonganTarget" class="control-label col-lg-4">Jam</label>
                                                        <div class="col-lg-6">
                                                            <input type="text" name="txtJamPemotonganTarget" id="txtJamPemotonganTarget" class="txtJamPemotonganTarget form-control" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="panel-footer text-right">
                                        <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i></i>  Save</button>
                                        <a href="<?php echo site_url('ManufacturingOperationUP2L/Selep'); ?>" class="btn btn-danger btn-lg"><i class="fa fa-arrow-left"></i></i>  Back</a>
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