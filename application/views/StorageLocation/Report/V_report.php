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
                                        <?php echo $title;?>
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('StorageLocation/Report');?>">
                                    <i aria-hidden="true" class="fa fa-2x fa-file-text-o">
                                    </i>
                                    <span>
                                        <br/>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="box box-primary box-solid">
                    <div class="box-header with-border">
                        <h5>Input Report Parameter</h5>
                    </div>
                    <div class="box-body">
                        <form method="post" action="<?php echo base_url('StorageLocation/Report/CreateReport'); ?>" target="_blank">
                            <div class="row">
                                <div class="col-lg-8 col-lg-push-2 col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-md-3 control-label">
                                            ORGANIZATION ID
                                        </label>
                                        <div class="col-md-9">
                                            <select class="form-control select-2" id="IdOrganization" name="IdOrganization" onchange="getSubInvent()" >
                                                <option></option>
                                                <option value="102">
                                                    ODM
                                                </option>
                                                <!-- <option value="101">
                                                    OPM
                                                </option> -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-lg-3">
                                            SUB INVENTORY
                                        </label>
                                        <div class="col-lg-9">
                                            <select class="form-control select-2" id="SlcSubInventori" name="SlcSubInventori" onchange="getLocator()" disabled="">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-lg-3">
                                            LOCATOR
                                        </label>
                                        <div class="col-lg-9">
                                            <select class="form-control select-2" data-placeholder="Choose Locator" disabled="" id="SlcLocator" name="SlcLocator">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-lg-3" for="norm">
                                            <b>
                                                ASSEMBLY CODE
                                            </b>
                                        </label>
                                        <div class="col-lg-9">
                                            <select class="form-control jsAssembly" id="SlcKodeAssy" name="SlcKodeAssy" onchange="GetDescAssy()" style="width: 100%" disabled="">
                                                <option>
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-lg-3" for="norm">
                                            <b>
                                                ASSEMBLY NAME
                                            </b>
                                        </label>
                                        <div class="col-lg-9">
                                            <input class="form-control" id="txtNameAssy" name="txtNameAssy" placeholder="Assembly Name" readonly="">
                                            </input>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-lg-3" for="norm">
                                            COMPONENT CODE
                                        </label>
                                        <div class="col-lg-9">
                                            <select class="form-control jsComponent" id="SlcItem" name="SlcItem" onchange="GetDescription(this)"  disabled>
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-lg-3" for="norm">
                                            COMPONENT NAME
                                        </label>
                                        <div class="col-lg-9">
                                            <input class="form-control" id="txtDesc" name="txtDesc" placeholder="Component Name" readonly="" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-lg-3" for="norm">
                                            SORTING
                                        </label>
                                        <div class="col-lg-9">
                                            <select class="form-control select-2" name="reportSorting">
                                                <option></option>
                                                <option value="ALC">Assembly Code + Storage Location + Component Code</option>
                                                <option value="ACL">Assembly Code + Component Code + Storage Location</option>
                                                <option value="CL">Component Code + Storage Location</option>
                                                <option value="DCL">Description + Component Code + Storage Location</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <button type="submit" class="btn btn-primary pull-right">SUBMIT</button>
                                            <a href="window.history.go(-1)" class="btn btn-default pull-right">BACK</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>