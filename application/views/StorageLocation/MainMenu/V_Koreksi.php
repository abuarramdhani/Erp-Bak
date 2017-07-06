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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('StorageLocation/Correction');?>">
                                    <i aria-hidden="true" class="fa fa-2x fa-pencil">
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
                <div class="box box-primary box-solid">
                    <div class="box-header with-border">
                        Find Data Storage Location
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-8 col-md-push-2">
                                <div class="form-group row">
                                    <label class="col-md-4 control-label">
                                        Input Type
                                    </label>
                                    <div class="col-md-8">
                                        <input checked="checked" name="jns_input" onclick="perKopm('<?php echo base_url();?>')" type="radio" value="perKomp">
                                            By Component
                                        </input>
                                        <input name="jns_input" onclick="perSA('<?php echo base_url();?>')" type="radio" value="perSA">
                                            By Sub Assy
                                        </input>
                                    </div>
                                </div>
                                <div class="form-group row"">
                                    <label class="col-md-4 control-label">
                                        Organization ID
                                    </label>
                                    <div class="col-md-8">
                                        <select class="form-control select-2" id="IdOrganization" name="txtOrg" onchange="getSubInvent()" required="">
                                            <option disabled="" selected="" value="">
                                                -- Choose One --
                                            </option>
                                            <option value="102">
                                                ODM
                                            </option>
                                            <option value="101">
                                                OPM
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 control-label">
                                        Sub Inventory
                                    </label>
                                    <div class="col-md-8">
                                        <select class="form-control select-2" disabled="" id="SlcSubInventori" name="SlcSubInventori" onchange="getLocator()" required="">
                                        </select>
                                    </div>
                                </div>
                                <div id="formPerKopm">
                                    <div class="form-group row">
                                        <label class="col-md-4 control-label">
                                            Component Code
                                        </label>
                                        <div class="col-md-8">
                                            <select class="form-control jsComponent" disabled="" id="SlcItem" name="SlcItem" onchange="getKodeAssem()" required="">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 control-label">
                                            Component Name
                                        </label>
                                        <div class="col-md-8">
                                            <input class="form-control" id="txtDesc" name="txtDesc" placeholder="Item Name" readonly="" type="text">
                                            </input>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 control-label">
                                            Locator
                                        </label>
                                        <div class="col-md-8">
                                            <select class="form-control select-2" data-placeholder="Choose Locator" disabled="" id="SlcLocator" name="SlcLocator">
                                                <option value="">
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row pull-right">
                                        <div class="col-md-12">
                                            <button class="btn btn-default" id="clear" onclick="window.location.reload()">
                                                CLEAR
                                            </button>
                                            <button class="btn btn-primary" onclick="searchComponent('<?php echo base_url(); ?>')">
                                                <i class="fa fa-search"></i> FIND
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div hidden="" id="formPerSA">
                                    <div class="form-group row">
                                        <label class="col-md-4 control-label">
                                            Assembly Code
                                        </label>
                                        <div class="col-md-8">
                                            <select class="form-control jsAssembly" id="SlcKodeAssy" name="SlcKodeAssy" onchange="GetDescAssy('<?php echo base_url(); ?>')" style="width: 100%" disabled>
                                                <!-- <option>
                                                </option> -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 control-label">
                                            Assembly Name
                                        </label>
                                        <div class="col-md-8">
                                            <input class="form-control" id="txtNameAssy" name="txtNameAssy" placeholder="Assembly Name" readonly="" type="text">
                                            </input>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 control-label">
                                            Assembly Type
                                        </label>
                                        <div class="col-md-8">
                                            <input class="form-control" id="txtTypeAssy" name="txtTypeAssy" placeholder="Assembly Type" readonly="" type="text">
                                            </input>
                                        </div>
                                    </div>
                                    <div class="row pull-right">
                                        <div class="col-md-12">
                                            <button class="btn btn-default" id="clear" onclick="window.location.reload()">
                                                CLEAR
                                            </button>
                                            <button class="btn btn-primary" onclick="searchAssy('<?php echo base_url(); ?>')">
                                                <i class="fa fa-search"></i> FIND
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                    <div class="box box-primary box-solid">
                        <div class="box-header with-border">
                            Correction Storage Location
                        </div>
                        <div class="box-body">
                            <div class="table-responsive col-md-12 " id="res">
                                <table class=" table table-bordered table-responsive " id="table_a" style="width:100%; font-size: 12px">
                                    <thead class="bg-blue">
                                        <tr>
                                            <th style="vertical-align: middle; text-align:center" width="3%;">
                                                No
                                            </th>
                                            <th style="vertical-align: middle; text-align:center">
                                                Component Code
                                            </th>
                                            <th style="vertical-align: middle; text-align:center">
                                                Description
                                            </th>
                                            <th style="vertical-align: middle; text-align:center">
                                                Assembly Code
                                            </th>
                                            <th style="vertical-align: middle; text-align:center">
                                                Assembly Name
                                            </th>
                                            <th style="vertical-align: middle; text-align:center">
                                                Assembly Type
                                            </th>
                                            <th style="vertical-align: middle; text-align:center">
                                                Subinventory
                                            </th>
                                            <th style="vertical-align: middle; text-align:center">
                                                Storage Location
                                            </th>
                                            <th style="vertical-align: middle; text-align:center" width="5%">
                                                LPPB / MO / KIB
                                            </th>
                                            <th style="vertical-align: middle; text-align:center" width="5%">
                                                Picklist
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="12" style="text-align: center;background-color: white">
                                                <div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </br>
            </div>
        </div>
    </div>
</section>
