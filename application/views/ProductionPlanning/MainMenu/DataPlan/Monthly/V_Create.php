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
                                        Input Monthly Plans
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ProductionPlanning/DataPlanMonthly');?>">
                                    <i aria-hidden="true" class="fa fa-line-chart fa-2x">
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
                                <p class="pull-left">New Monthly Plans</p>
                                <p class="pull-right">Monthly Plan will be implemented for this month</p>
                            </div>
                            <div class="panel-body">
                                <form method="post" class="form-horizontal" action="<?php echo base_url('ProductionPlanning/DataPlanMonthly/Create'); ?>">
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="control-label col-md-offset-2 col-md-2" for="dp2">Section</label>
                                            <div class="col-lg-6">
                                                <select class="form-control select2" name="section">
                                                    <?php foreach ($section as $s) { ?>
                                                        <option value="<?php echo $s['section_id']; ?>"> <?php echo $s['section_name']; ?> </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-offset-2 col-md-2">Monthly Plan Quantity</label>
                                            <div class="col-lg-6">
                                                <input type="number" min='1' name="planQTY" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <button type="submit" class="btn btn-primary">SAVE</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>