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
	                                <form method="post" action="<?php echo base_url('ProductionPlanning/DataPlan/CreateSubmit'); ?>" class="form-horizontal">
	                                	<div class="col-md-12">
	                                    	<div class="col-md-6">
		                                        <div class="form-group">
		                                            <label class="control-label col-md-4" for="dp2">Section</label>
		                                            <div class="col-lg-8">
		                                                <select class="form-control select2" name="section">
		                                                    <?php foreach ($section as $s) { ?>
		                                                        <option value="<?php echo $s['section_id']; ?>"> <?php echo $s['section_name']; ?> </option>
		                                                    <?php } ?>
		                                                </select>
		                                            </div>
		                                        </div>
		                                        <div class="form-group">
		                                            <label class="control-label col-md-4" for="dp2">Item Code</label>
		                                            <div class="col-lg-8">
		                                                <input type="text" name="item" class="form-control" placeholder="Item Code" required>
		                                            </div>
		                                        </div>
		                                        <div class="form-group">
		                                            <label class="control-label col-md-4" for="dp2">Item Description</label>
		                                            <div class="col-lg-8">
		                                                <input type="text" name="desc" class="form-control" placeholder="Item Description" required>
		                                            </div>
		                                        </div>
	                                    	</div>
	                                    	<div class="col-md-6">
		                                        <div class="form-group">
		                                            <label class="control-label col-md-4" for="dp2">Priority</label>
		                                            <div class="col-lg-8">
		                                                <select name="priority" class="form-control select2">
		                                                	<option></option>
		                                                	<option value="1">1</option>
		                                                	<option value="NORMAL">NORMAL</option>
		                                                </select>
		                                            </div>
		                                        </div>
		                                        <div class="form-group">
		                                            <label class="control-label col-md-4" for="dp2">Need Quantity</label>
		                                            <div class="col-lg-8">
		                                                <input type="number" name="needQty" class="form-control" placeholder="Need Quantity" required>
		                                            </div>
		                                        </div>
		                                        <div class="form-group">
		                                            <label class="control-label col-md-4" for="dp2">Due Time</label>
		                                            <div class="col-lg-8">
		                                                <input type="text" name="dueTime" class="form-control" placeholder="Due Time" required>
		                                            </div>
		                                        </div>
	                                    	</div>
	                                    	<div class="col-md-12 text-right">
		                                        <button type="submit" class="btn btn-primary">
		                                            SAVE
		                                        </button>
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
    </div>
</section>