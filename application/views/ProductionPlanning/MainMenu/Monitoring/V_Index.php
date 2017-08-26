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
                                        Fabrication Monitoring
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ProductionPlanning/Monitoring');?>">
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
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary box-solid">
            	<div class="box-header with-border">
            		Specific Monitoring
            	</div>
                <div class="panel-body">
                	<form method="post" action="<?php echo base_url('ProductionPlanning/Monitoring/Open'); ?>" target="_blank">
                		<div class="row">
                			<div class="col-md-8 col-md-offset-2">
	                			<div class="form-group">
	                				<label class="control-label col-lg-4" for="dp2">SECTION</label>
	                				<div class="col-lg-8">
	                					<select class="form-control select4" multiple="" name="section[]">
	                						<option></option>
	                						<?php foreach ($section as $s) { ?>
	                							<option value="<?php echo $s['section_id']; ?>"> <?php echo $s['section_name']; ?> </option>
	                						<?php } ?>
	                					</select>
	                				</div>
	                			</div>
                			</div>
                		</div>
                		<div class="row">
                			<div class="col-md-8 col-md-offset-2">
                				<button type="submit" class="btn btn-primary pull-right">
                					SUBMIT
                				</button>
                			</div>
                		</div>
                	</form><!-- 
                    <a class="btn btn-primary btn-lg" href="<?php echo base_url('ProductionPlanning/Monitoring/Open'); ?>" target="_blank">
                        MONITOR
                    </a> -->
                </div>
            </div>
        </div>
    </div>
</section>