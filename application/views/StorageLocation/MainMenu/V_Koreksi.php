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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('SaveLocation/InputComponent');?>">
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
                        Find Data Save Location
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-8 col-md-push-2">
                                <div class="form-group row">
                                    <label class="col-md-4 control-label">
                                        Jenis Input
                                    </label>
                                    <div class="col-md-8">
                                        <input checked="checked" name="jns_input" onclick="perKopm('<?php echo base_url();?>')" type="radio" value="perKomp">
                                            Per Komponen
                                        </input>
                                        <input name="jns_input" onclick="perSA('<?php echo base_url();?>')" type="radio" value="perSA">
                                            Per Sub Assy
                                        </input>
                                    </div>
                                </div>
                                <div class="form-group row"">
                                    <label class="col-md-4 control-label">
                                        ID Organization
                                    </label>
                                    <div class="col-md-8">
                                        <select class="form-control select-2" id="txtOrgId" name="txtOrg" onchange="getSubInvent()" required="">
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
                                <div id="formPerKopm">
                                    <div class="form-group row">
                                        <label class="col-md-4 control-label">
                                            Sub Inventory
                                        </label>
                                        <div class="col-md-8">
                                            <select class="form-control select-2" disabled="" id="SlcSubInventori" name="SlcSubInventori" onchange="getKodeKomp()" required="">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 control-label">
                                            Item
                                        </label>
                                        <div class="col-md-8">
                                            <select class="form-control select-2" disabled="" id="SlcItem" name="SlcItem" onchange="getKodeAssem()" required="">
                                            </select>
                                            <!-- <select class="form-control jsItem" id="SlcItem" name="SlcItem" onchange="GetDescription('<?php echo base_url(); ?>')">
						<option value=""></option>
						</select> -->
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 control-label">
                                            Nama Item
                                        </label>
                                        <div class="col-md-8">
                                            <input class="form-control" id="txtDesc" name="txtDesc" placeholder="Nama Item" readonly="" type="text">
                                            </input>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 control-label">
                                            Locator
                                        </label>
                                        <div class="col-md-8">
                                            <select class="form-control select-2" data-placeholder="Pilih Locator" disabled="" id="SlcLocator" name="SlcLocator">
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
                                            Sub Inventory
                                        </label>
                                        <div class="col-md-8">
                                            <select class="form-control jsSubinventori" id="SlcSubInventori2" name="SlcSubInventori2" style="width: 100%">
                                                <option value="">
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 control-label">
                                            Kode Assembly
                                        </label>
                                        <div class="col-md-8">
                                            <select class="form-control jsAssembly" id="SlcKodeAssy" name="SlcKodeAssy" onchange="GetDescAssy('<?php echo base_url(); ?>')" style="width: 100%">
                                                <option value="">
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 control-label">
                                            Nama Assembly
                                        </label>
                                        <div class="col-md-8">
                                            <input class="form-control" id="txtNameAssy" name="txtNameAssy" placeholder="Nama Assembly" readonly="" type="text">
                                            </input>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 control-label">
                                            Tipe Assembly
                                        </label>
                                        <div class="col-md-8">
                                            <input class="form-control" id="txtTypeAssy" name="txtTypeAssy" placeholder="Tipe Assembly" readonly="" type="text">
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
                            Correction Save Location
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
                                                Item
                                            </th>
                                            <th style="vertical-align: middle; text-align:center">
                                                Description
                                            </th>
                                            <th style="vertical-align: middle; text-align:center">
                                                Kode Assembly
                                            </th>
                                            <th style="vertical-align: middle; text-align:center">
                                                Nama Assembly
                                            </th>
                                            <th style="vertical-align: middle; text-align:center">
                                                Type Assembly
                                            </th>
                                            <th style="vertical-align: middle; text-align:center">
                                                Subinventory
                                            </th>
                                            <th style="vertical-align: middle; text-align:center">
                                                Alamat
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
