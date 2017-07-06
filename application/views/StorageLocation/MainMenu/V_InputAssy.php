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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('SaveLocation/InputSubAssy');?>">
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
                <br>
                    <div class="box box-primary box-solid">
                        <div class="box-header with-border">
                            Input Data Sub Assy
                        </div>
                        <div class="box-body">
                            <div align="center">
                                <?php echo $message; ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <form action="<?php echo base_url('StorageLocation/InputSubAssy/Create'); ?>" method="post">
                                        <div class="row">
                                            <div class="col-lg-8 col-lg-push-2">
                                                <div class="form-group row">
                                                    <label class="col-md-4 control-label">
                                                        Organization ID
                                                    </label>
                                                    <div class="col-md-8">
                                                        <select class="form-control select-2" id="IdOrganization" name="IdOrganization" onchange="getSubInvent()" required="">
                                                            <option></option>
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
                                                        <select class="form-control select-2" disabled="" id="SlcSubInventori" name="SlcSubInventori2" onchange="getLocator()">
                                                        <option></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-4 control-label">
                                                        Assembly Code
                                                    </label>
                                                    <div class="col-md-8">
                                                        <select class="form-control jsAssembly" id="SlcKodeAssy" name="SlcKodeAssy" onchange="GetDescAssy()">
                                                            <option></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-4 control-label">
                                                        Assembly Name
                                                    </label>
                                                    <div class="col-md-8">
                                                        <input class="form-control" id="txtNameAssy" name="txtNameAssy" placeholder="Assembly Name" readonly="">
                                                        </input>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-4 control-label">
                                                        Assembly Type
                                                    </label>
                                                    <div class="col-md-8">
                                                        <input class="form-control" id="txtTypeAssy" name="txtTypeAssy" placeholder="Input Assembly Type" readonly="" type="text">
                                                        </input>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-4 control-label">
                                                        Locator
                                                    </label>
                                                    <div class="col-md-8">
                                                        <select class="form-control select-2" data-placeholder="Choose Locator" disabled="" id="SlcLocator" name="txtLocator">
                                                            <option value="">
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="box box-default box-solid">
                                                    <div class="box-header with-border">
                                                        <div class="pull-left">
                                                            Input Data Component
                                                        </div>
                                                        <div class="pull-right">
                                                            <button class="btn btn-primary fa fa-plus min" onclick="add_row('table_input')" type="button">
                                                            </button>
                                                            <button class="btn btn-primary fa fa-minus" onclick="delete_row('table_input')" type="button">
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="box-body">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <table class="table table-bordered table-striped" id="table_input">
                                                                    <tr class="text-center" style="font-weight: bold;">
                                                                        <td>
                                                                            Component Code
                                                                        </td>
                                                                        <td>
                                                                            Component Name
                                                                        </td>
                                                                        <td>
                                                                            Storage Location
                                                                        </td>
                                                                        <td style="width: 100px;">
                                                                            LPPB/MO/KIB
                                                                        </td>
                                                                        <td style="width: 100px;">
                                                                            PICKLIST
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="tr_clone">
                                                                        <td>
                                                                            <select class="form-control jsCompByAssy select_input" id="SlcItem2" name="SlcItem[]" onchange="GetName(this)" style="width: 100%">
                                                                                <option>
                                                                                </option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <input class="form-control nama_input" id="txtDesc2" name="txtDesc2[]" placeholder="Nama Komponen" readonly="" type="text">
                                                                            </input>
                                                                        </td>
                                                                        <td>
                                                                            <input class="form-control" name="txtAlamat[]" type="text"/>
                                                                        </td>
                                                                        <td>
                                                                            <select class="form-control select-2" id="txtLmk" name="txtLmk[]" required="">
                                                                                <option></option>
                                                                                <option value="1">
                                                                                    YES
                                                                                </option>
                                                                                <option value="0">
                                                                                    NO
                                                                                </option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <select class="form-control select-2" id="txtPicklist" name="txtPicklist[]" required="">
                                                                                <option></option>
                                                                                <option value="1">
                                                                                    YES
                                                                                </option>
                                                                                <option value="0">
                                                                                    NO
                                                                                </option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="text-align: right;">
                                            <button class="btn btn-success glyphicon glyphicon-check " id="save_input" type="submit">
                                                SAVE
                                            </button>
                                            <button class="btn btn-primary glyphicon" id="clear" onclick="window.location.reload()" type="button">
                                                CLEAR
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </br>
            </div>
        </div>
    </div>
</section>