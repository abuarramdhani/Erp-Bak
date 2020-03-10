<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>New Sales Target</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('SalesMonitoring/salestarget');?>">
                                <i class="icon-wrench icon-2x"></i>
                                <span ><br /></span>
                            </a>
						</div>
					</div>
				</div>
			</div>
			<br />
			<div class="row">
			<form class="form-horizontal" method="post" action="<?php echo base_url('SalesMonitoring/salestarget/Created')?>">
				<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						Sales Target
					</div>
					<div class="box-body">
						<div class="panel-body">
							<div class="form-group">
								<label class="col-lg-4 control-label">Organization</label>
								<div class="col-lg-5">
									<select id="slcOrgSM" class="form-control select4" onchange="org_selection(this)" name="txt_organization" class="form-control">
										<option value=""></option>
										<?php $no = 0; foreach($source as $src) { $no++ ?>
										<?php echo '<option value="'.$src['org_id'].'">'.$src['org_name'].'</option>' ?>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-4 control-label">Month</label>
								<div class="col-lg-2">
									<select class="form-control select4" onchange="checkingOTMonth(this)" id="slcMonthSMT" placeholder="month" name="txt_month" required>
										<option value=""></option>
										<option value="1">JANUARY</option><option value="2">FEBRUARY</option><option value="3">MARCH</option>
										<option value="4">APRIL</option><option value="5">MAY</option><option value="6">JUNE</option>
										<option value="7">JULY</option><option value="8">AUGUST</option><option value="9">SEPTEMBER</option>
										<option value="10">OCTOBER</option><option value="11">NOVEMBER</option><option value="12">DECEMBER</option>
									</select>
								</div>
								<label class="col-lg-1 control-label">Year</label>
								<div class="col-lg-2">
									<input name="txt_year" onchange="checkingOTYear(this)" id="txt_year_smt" class="form-control" onkeypress="return isNumberKey(event)" placeholder="year">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-4 control-label">Order Type</label>
								<div class="col-lg-5">
									<input type="hidden" id="txtOTID" name="txt_order_type" class="form-control" placeholder="order type">
									<select class="form-control select4" onchange="checkingOT(this)" id="slcOrderTypeSmt" name="txt_order_type_list">
										<option value=""></option>
										<?php $no = 0; foreach($sourceOrderType as $src) { $no++ ?>
										<?php echo '<option value="'.$src['NAME'].'">'.$src['NAME'].'</option>' ?>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-4 control-label">Target</label>
								<div class="col-lg-5">
									<input name="txt_target" id="txt_target_smt" class="form-control" onkeypress="return isNumberKeyAndComma(event)" placeholder="target">
								</div>
							</div>
						</div>
						<div class="panel-footer">
							<div class="row text-right">
								<div class="col-md-12">
									<a href="<?php echo site_url('SalesMonitoring/salestarget');?>" class="btn btn-primary btn-lg btn-rect">Back</a>
									&nbsp;&nbsp;
									<button disabled id="btnSaveSM" type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				</div>
			
				<input type="hidden" class="form-control" name="txt_created_by" value ="<?php echo $this->session->userid; ?>" required></input>
				<input type="hidden" class="form-control" name="txt_start_date" value ="now()"></input>
				<input type="hidden" class="form-control" name="txt_end_date" value ="NULL"></input>
				<input type="hidden" class="form-control" name="txt_last_updated" value ="NULL"></input>					
				<input type="hidden" class="form-control" name="txt_last_update_by" value ="NULL"></input>
				<input type="hidden" class="form-control" name="txt_creation_date" value ="now()"></input>
			</form>
						
					
		</div>
	</div>
	</div>
</section>
<!-- <script>
document.getElementsByName('txt_order_type_list').item(0).onchange = function(){
     document.getElementsByName('txt_order_type').item(0).value = document.getElementsByName('txt_order_type_list').item(0).value;
}



</script> -->