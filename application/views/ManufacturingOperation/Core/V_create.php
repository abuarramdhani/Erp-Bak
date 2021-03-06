<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('ManufacturingOperation/Core/create');?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperation/Core/');?>">
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
                                                    <input type="text" name="production_date" class="form-control time-form ajaxOnChange" required="" placeholder="Production Date">
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
                                                <label class="control-label col-md-4">Core Quantity</label>
                                                <div class="col-md-6">
                                                    <input type="number" min="0" name="core_quantity" required="" class="form-control" placeholder="Core Quantity">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Employee</label>
                                                <div class="col-md-6">
                                                    <select class="form-control select4" multiple="" name="employee_id[]" required>
                                                        <option></option>
                                                        <?php foreach ($employee as $value) { ?>
                                                            <option value="<?php echo $value['noind'] ?>"><?php echo $value['noind'].' | '.$value['nama'] ?></option>
                                                        <?php } ?>
                                                    </select>
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