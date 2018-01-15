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
                                        Daily Data Plans
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ProductionPlanning/DataPlanDaily');?>">
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
                                <a alt="Add New" href="<?php echo site_url('ProductionPlanning/DataPlanDaily/Create') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" title="Add New">
                                    <button class="btn btn-default btn-sm" type="button">
                                        <i class="icon-plus icon-2x">
                                        </i>
                                    </button>
                                </a>
                                Plan List
                            </div>
                            <div class="panel-body">
                                <div class="row" id="loadingDailyArea"></div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table">
                                            <tr>
                                                <td width="15%">
                                                    <select name="section" id="section" data-placeholder="Section" class="form-control select4">
                                                        <option></option>
                                                        <?php foreach ($section as $sc) { ?>
                                                            <option value="<?php echo $sc['section_id'] ?>"><?php echo $sc['section_name'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                                <td width="30%">
                                                    <input type="text" class="form-control toupper time-form-range" placeholder="Plan Time" name="planTime" id="planTime" />
                                                </td>
                                                <td width="25%">
                                                    <select name="itemCode" id="itemCode" data-placeholder="Item Code" class="form-control select4">
                                                        <option></option>
                                                        <?php foreach ($item as $it) { ?>
                                                            <option value="<?php echo $it['item_code'] ?>"><?php echo $it['item_code'].' | '.$it['item_description']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                                <td width="10%">
                                                    <select name="Status" id="Status" data-placeholder="Status" class="form-control select4">
                                                        <option></option>
                                                        <option value="OK">OK</option>
                                                        <option value="NOT OK">NOT OK</option>
                                                    </select>
                                                </td>
                                                <td width="10%">
                                                    <select name="Action" id="Action" data-placeholder="Action" class="form-control select4">
                                                        <option></option>
                                                        <option value="0" selected>READ</option>
                                                        <option value="1">EDIT</option>
                                                    </select>
                                                </td>
                                                <td width="10%">
                                                    <button onclick="searchDailyPlans(this)" class="btn btn-primary" style="width: 100%;">Search</button>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div id="tableDailyArea" style="overflow-x:auto;">
                                    <table class="table table-striped table-bordered table-hover" id="tbdataplan">
                                        <thead class="bg-primary">
                                            <tr style="font-weight: bold; text-align: center; vertical-align: middle;">
                                                <td style="min-width: 30px">
                                                    No
                                                </td>
                                                <td style="min-width: 100px">
                                                    Item
                                                </td>
                                                <td style="min-width: 220px">
                                                    Description
                                                </td>
                                                <td style="min-width: 50px">
                                                    Priority
                                                </td>
                                                <td style="min-width: 120px">
                                                    Due Time
                                                </td>
                                                <td style="min-width: 100px">
                                                    Section
                                                </td>
                                                <td style="min-width: 50px">
                                                    Need Qty
                                                </td>
                                                <td style="min-width: 50px">
                                                    Achieve Qty
                                                </td>
                                                <td style="min-width: 50px">
                                                    Status
                                                </td>
                                                <!-- <td>
                                                    Action
                                                </td> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($plan as $pl) {
    											if ($pl['status'] == 'OK') {
    												$color  = "class='bg-success'";
    											}else{
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
                                                <td>
                                                    <?php echo $pl['due_time']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $pl['section_name']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $pl['need_qty']; ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($pl['achieve_qty'] == null) {
                                                        echo "0";
                                                    }else{
                                                        echo $pl['achieve_qty'];
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php echo $pl['status']; ?>
                                                </td>
                                                <!-- <td>
                                                    <a class="btn btn-default" href="<?php echo base_url('ProductionPlanning/DataPlanDaily/Edit/'.$pl['daily_plan_id']); ?>">
                                                        EDIT
                                                    </a>
                                                </td> -->
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
    </div>
</section>