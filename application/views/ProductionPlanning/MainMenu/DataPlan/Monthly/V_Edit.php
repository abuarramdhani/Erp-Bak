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
                                        Edit Monthly Plans
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
                                <p class="pull-left">Monthly Plans</p>
                            </div>
                            <div class="panel-body">
                                <?php foreach ($plan as $pl) { ?>
                                <form method="post" class="form-horizontal" action="<?php echo base_url('ProductionPlanning/DataPlanMonthly/Edit/'.$pl['monthly_plan_id']); ?>">
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="control-label col-md-offset-2 col-md-2" for="dp2">Section</label>
                                            <div class="col-lg-6">
                                                <input type="text" name="sectionName" class="form-control" value="<?php echo $pl['section_name'] ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-offset-2 col-md-2">Monthly Plan Quantity</label>
                                            <div class="col-lg-6">
                                                <input type="number" min='1' name="planQTY" class="form-control" value="<?php echo $pl['monthly_plan_quantity'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-offset-2 col-md-2">Monthly Plan Time</label>
                                            <div class="col-lg-6">
                                                <input type="text" min='1' name="planQTY" class="form-control" value="<?php echo date('F Y', strtotime($pl['plan_time'])) ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <button type="submit" class="btn btn-primary">SAVE</button>
                                        </div>
                                    </div>
                                </form>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>