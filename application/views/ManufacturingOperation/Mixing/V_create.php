<section class="content">
    <div class="inner">
        <div class="row">
            <form action="<?php echo site_url('ManufacturingOperation/Mixing/create');?>" class="form-horizontal" method="post">
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
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperation/Mixing/');?>">
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
                                                <label class="control-label col-lg-4" for="cmbComponentCodeHeader">
                                                    Component Code
                                                </label>
                                                <div class="col-lg-4">
                                                    <select class=" form-control select select2" data-placeholder="Choose an option" id="cmbComponentCodeHeader" name="cmbComponentCodeHeader" onchange="getCompDescMO(this)">
                                                        <option>
                                                        </option>
                                                        <option value="AA123456MD">AA123456MD</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-lg-4" for="txtComponentDescriptionHeader">
                                                    Component Description
                                                </label>
                                                <div class="col-lg-4">
                                                    <input class="form-control" id="txtComponentDescriptionHeader" name="component_description" placeholder="Component Description" type="text" readonly="" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-lg-4" for="txtProductionDateHeader">
                                                    Production Date
                                                </label>
                                                <div class="col-lg-4">
                                                    <input class="datetime form-control time-form" data-date-format="yyyy-mm-dd hh:ii:ss" id="txtProductionDateHeader" name="txtProductionDateHeader" placeholder="<?php echo date('Y-m-d h:i:s')?>" type="text"/>
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
                                            <div class="form-group">
                                                <label class="control-label col-lg-4" for="txtJobIdHeader">
                                                    Job Id
                                                </label>
                                                <div class="col-lg-4">
                                                    <input class="form-control" id="txtJobIdHeader" name="txtJobIdHeader" placeholder="Job Id" type="text"/>
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