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
                                        Edit Data Plans
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
                                Edit Plan
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                	<?php foreach ($plan as $pl) { ?>
	                                <form method="post" action="<?php echo base_url('ProductionPlanning/DataPlan/Edit/'.$pl['daily_plan_id']); ?>" class="form-horizontal">
	                                	<div class="col-md-12">
	                                    	<div class="col-md-6">
		                                        <div class="form-group">
		                                            <label class="control-label col-md-4" for="dp2">Section</label>
		                                            <div class="col-lg-8">
		                                                <select class="form-control select2" name="section">
		                                                    <?php foreach ($section as $s) { ?>
		                                                        <option value="<?php echo $s['section_id']; ?>" <?php if ($pl['section_id'] == $s['section_id']) { echo "selected"; } ?>> <?php echo $s['section_name']; ?> </option>
		                                                    <?php } ?>
		                                                </select>
		                                            </div>
		                                        </div>
		                                        <div class="form-group">
		                                            <label class="control-label col-md-4" for="dp2">Item Code</label>
		                                            <div class="col-lg-8">
		                                                <input type="text" name="item" class="form-control" placeholder="Item Code" required value="<?php echo $pl['item_code']; ?>">
		                                            </div>
		                                        </div>
		                                        <div class="form-group">
		                                            <label class="control-label col-md-4" for="dp2">Item Description</label>
		                                            <div class="col-lg-8">
		                                                <input type="text" name="desc" class="form-control" placeholder="Item Description" required value="<?php echo $pl['item_description']; ?>">
		                                            </div>
		                                        </div>
	                                    	</div>
	                                    	<div class="col-md-6">
		                                        <div class="form-group">
		                                            <label class="control-label col-md-4" for="dp2">Priority</label>
		                                            <div class="col-lg-8">
		                                                <select name="priority" class="form-control select4">
		                                                	<option></option>
		                                                	<option value="1" <?php if ($pl['priority'] == 1) { echo "selected"; } ?>>1</option>
		                                                	<option value="NORMAL" <?php if ($pl['priority'] == 'NORMAL') { echo "selected"; } ?>>NORMAL</option>
		                                                </select>
		                                            </div>
		                                        </div>
		                                        <div class="form-group">
		                                            <label class="control-label col-md-4" for="dp2">Need Quantity</label>
		                                            <div class="col-lg-8">
		                                                <input type="number" name="needQty" class="form-control" placeholder="Need Quantity" required value="<?php echo $pl['need_qty']; ?>">
		                                            </div>
		                                        </div>
		                                        <div class="form-group">
		                                            <label class="control-label col-md-4" for="dp2">Due Time</label>
		                                            <div class="col-lg-8">
		                                                <input type="text" name="dueTime" class="form-control time-form" placeholder="Due Time" required value="<?php echo $pl['due_time']; ?>">
		                                            </div>
		                                        </div>
	                                    	</div>
	                                    	<div class="col-md-12 text-right">
	                                    		<a href="<?php echo base_url('ProductionPlanning/DataPlan'); ?>" class="btn btn-default">
	                                    			CANCEL
	                                    		</a>
		                                        <button type="submit" class="btn btn-primary">
		                                            SAVE
		                                        </button>
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
    </div>
</section>