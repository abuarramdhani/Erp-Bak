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
                                        Input Data Plans
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ProductionPlanning/DataPlan');?>">
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
                                <a alt="Add New" href="<?php echo site_url('ProductionPlanning/DataPlan/Create') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" title="Add New">
                                    <button class="btn btn-default btn-sm" type="button">
                                        <i class="icon-plus icon-2x">
                                        </i>
                                    </button>
                                </a>
                                Employee List
                            </div>
                            <div class="panel-body">
                                <table class="table table-striped table-bordered table-hover" id="tbdataplan">
                                    <thead class="bg-primary">
                                        <tr>
                                            <td>
                                                No
                                            </td>
                                            <td>
                                                Item
                                            </td>
                                            <td>
                                                Description
                                            </td>
                                            <td>
                                                Priority
                                            </td>
                                            <td>
                                                Status
                                            </td>
                                            <td>
                                                Action
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($plan as $pl) {
											if ($pl['achieve_qty'] >= $pl['need_qty']) {
												$status = "OK";
												$color  = "class='bg-success'";
											}else{
												$status = "NOT OK";
												$color  = "class='bg-warning'";
											}
										?>
                                        <tr>
                                            <td>
                                                <?php echo $no++; ?>
                                            </td>
                                            <td>
                                                <?php echo $pl['item_code']; ?>
                                            </td>
                                            <td>
                                                <?php echo $pl['item_description']; ?>
                                            </td>
                                            <td>
                                                <?php echo $pl['priority']; ?>
                                            </td>
                                            <td <?php echo $color; ?>>
                                                <?php echo $status; ?>
                                            </td>
                                            <td>
                                                <a class="btn btn-default" href="<?php echo base_url('ProductionPlanning/DataPlan/Edit/'.$pl['daily_plan_id']); ?>">
                                                    EDIT
                                                </a>
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