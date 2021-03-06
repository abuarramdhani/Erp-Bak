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
                                        Monthly Data Plans
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
                <?php echo $message; ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <a alt="Add New" href="<?php echo site_url('ProductionPlanning/DataPlanMonthly/Create') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" title="Add New">
                                    <button class="btn btn-default btn-sm" type="button">
                                        <i class="icon-plus icon-2x">
                                        </i>
                                    </button>
                                </a>
                                Monthly List
                            </div>
                            <div class="panel-body">
                                <table class="table table-striped table-bordered table-hover" id="tbitemData">
                                    <thead class="bg-primary">
                                        <tr>
                                            <td>
                                                No
                                            </td>
                                            <td>
                                                Monthly Plan Qty
                                            </td>
                                            <td>
                                                Plan Time
                                            </td>
                                            <td>
                                                Section
                                            </td>
                                            <td>
                                                Action
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($plan as $plm) { ?>
                                        <tr>
                                            <td>
                                                <?php echo $no++; ?>
                                            </td>
                                            <td>
                                                <?php echo $plm['monthly_plan_quantity']; ?>
                                            </td>
                                            <td>
                                                <?php echo date('F Y', strtotime($plm['plan_time'])); ?>
                                            </td>
                                            <td>
                                                <?php echo $plm['section_name']; ?>
                                            </td>
                                            <td>
                                                <a class="btn btn-default" href="<?php echo site_url('ProductionPlanning/DataPlanMonthly/Edit/'.$plm['monthly_plan_id']) ?>">EDIT</a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>