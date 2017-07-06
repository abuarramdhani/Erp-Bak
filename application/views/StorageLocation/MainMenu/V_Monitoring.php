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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('SaveLocation/AddressMonitoring');?>">
                                    <i aria-hidden="true" class="fa fa-2x fa-search">
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
                        Storage Location Monitoring
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table">
                                    <tr>
                                        <td>
                                            <div class="btn-group btn-group-justified" role="group">
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-default active " id="monkomp" onclick="monkompactive('<?php echo base_url() ?>')" type="button">
                                                        MONITORING BY COMPONENT
                                                    </button>
                                                </div>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-default " id="monsa" onclick="monsaactive('<?php echo base_url() ?>')" type="button">
                                                        MONITORING BY SUB ASSY
                                                    </button>
                                                </div>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-default" id="monall" onclick="monallactive('<?php echo base_url() ?>')" type="button">
                                                        MONITORING ALL
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8 col-lg-push-2 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-md-3 control-label">
                                        ORGANIZATION ID
                                    </label>
                                    <div class="col-md-9">
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
                                <div id="findbyKomp">
                                    <div class="form-group row">
                                        <label class="control-label col-lg-3" for="norm">
                                            COMPONENT CODE
                                        </label>
                                        <div class="col-lg-9">
                                            <select class="form-control jsComponent" id="SlcItem" name="SlcItem" onchange="GetDescription(this)" required="" disabled>
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
                                            </input>
                                        </div>
                                    </div>
                                </div>
                                <div hidden="" id="findbySA">
                                    <div class="form-group row">
                                        <label class="control-label col-lg-3" for="norm">
                                            <b>
                                                ASSEMBLY CODE
                                            </b>
                                        </label>
                                        <div class="col-lg-9">
                                            <select class="form-control jsAssembly" id="SlcKodeAssy" name="SlcKodeAssy" onchange="GetDescAssy()" required="" style="width: 100%">
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
                                </div>
                                <div hidden="" id="findbyAll">
                                    <div class="form-group row">
                                        <label class="control-label col-lg-3" for="norm">
                                            STORAGE LOCATION
                                        </label>
                                        <div class="col-lg-9">
                                            <input class="form-control toupper" id="txtAlamat" name="txtAlamat" placeholder="Input Location" type="text"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="button1" style="margin-top: 10px">
                                    <div class="col-lg-12 text-right">
                                        <button class="btn btn-success glyphicon glyphicon-search" onclick="searchByKomp('<?php echo base_url() ?>')">
                                            SEARCH
                                        </button>
                                        <button class="btn glyphicon btn-primary" onclick="window.location.reload()">
                                            CLEAR
                                        </button>
                                    </div>
                                </div>
                                <div class="row" hidden="" id="button2" style="margin-top: 10px">
                                    <div class="col-lg-12 text-right">
                                        <button class="btn btn-success glyphicon glyphicon-search" onclick="searchBySA('<?php echo base_url() ?>')">
                                            SEARCH
                                        </button>
                                        <button class="btn glyphicon btn-primary" onclick="window.location.reload()">
                                            CLEAR
                                        </button>
                                    </div>
                                </div>
                                <div class="row" hidden="" id="button3" style="margin-top: 10px">
                                    <div class="col-lg-12 text-right">
                                        <button class="btn btn-success glyphicon glyphicon-search" onclick="searchByAll('<?php echo base_url() ?>')">
                                            SEARCH
                                        </button>
                                        <button class="btn glyphicon btn-primary" onclick="window.location.reload()">
                                            CLEAR
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box box-primary box-solid">
                    <div class="bod-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive" style="overflow:hidden; padding: 10px;">
                                    <div class="table-responsive">
                                        <div id="loading">
                                        </div>
                                        <div id="result">
                                            <table class="table table-striped table-bordered table-hover text-center" id="myTables" style="font-size:12px;min-width:1500px;table-layout: fixed;">
                                                <thead>
                                                    <tr class="bg-primary">
                                                        <td width="4%">
                                                            NO
                                                        </td>
                                                        <td width="10%">
                                                            COMPONENT
                                                        </td>
                                                        <td width="15%">
                                                            DESCRIPTION
                                                        </td>
                                                        <td width="10%">
                                                            ASSEMBLY CODE
                                                        </td>
                                                        <td width="15%">
                                                            ASSEMBLY NAME
                                                        </td>
                                                        <td width="10%">
                                                            ASSEMBLY TYPE
                                                        </td>
                                                        <td width="10%">
                                                            SUBINVENTORY
                                                        </td>
                                                        <td width="10%">
                                                            ADDRESS
                                                        </td>
                                                        <td width="5%">
                                                            LPPB/MO/KIB
                                                        </td>
                                                        <td width="5%">
                                                            PICKLIST
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                        </td>
                                                        <td>
                                                        </td>
                                                        <td>
                                                        </td>
                                                        <td>
                                                        </td>
                                                        <td>
                                                        </td>
                                                        <td>
                                                        </td>
                                                        <td>
                                                        </td>
                                                        <td>
                                                        </td>
                                                        <td>
                                                        </td>
                                                        <td>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>