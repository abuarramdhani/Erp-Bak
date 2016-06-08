<div class="wrapper">

	<div class="content-wrapper">
		<section class="content">
			<div class="box box-info">
				<div class="box-header with-border"  style="background:#22aadd; color:#FFFFFF;">
					<div class="col-md-6">
						<h4 style="color:white;">
							<b>
							<i class="fa fa-wrench"></i><abbr> Setting</abbr>
							<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
							<a style="color:#FFFFFF;" href="<?php echo base_url('setting/salestarget/')?>"> Sales Target </a>
							<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
							<abbr> Create</abbr></b><br>
						</h4>
					</div>
				</div>
				<div class="box-body"></br>
				
				<!--NEW FORM-->
					<div class="row-fluid">
						<div class="col-md-12">
							<form class="form-horizontal" method="post" action="<?php echo base_url('setting/salestarget/created')?>">
								<div class="box-body">
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-sm-3 control-label">Organization</label>
											<div class="col-sm-9">
												<select class="form-control sales" name="txt_organization" class="form-control">
													<option value=""></option>
													<?php $no = 0; foreach($source as $src) { $no++ ?>
													<?php echo '<option value="'.$src['org_id'].'">'.$src['org_name'].'</option>' ?>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Order Type</label>
											<div class="col-sm-9">
												<input name="txt_order_type" class="form-control" placeholder="order type">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Target</label>
											<div class="col-sm-9">
												<input name="txt_target" class="form-control" placeholder="Target">
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-sm-3 control-label">Month</label>
											<div class="col-sm-9">
												<select class="form-control sales" placeholder="month" name="txt_month" required>
													<option value=""></option>
													<option value="1">JANUARY</option><option value="2">FEBRUARY</option><option value="3">MARCH</option>
													<option value="4">APRIL</option><option value="5">MAY</option><option value="6">JUNE</option>
													<option value="7">JULY</option><option value="8">AUGUST</option><option value="9">SEPTEMBER</option>
													<option value="10">OCTOBER</option><option value="11">NOVEMBER</option><option value="12">DECEMBER</option>
												</select>
											</div>
										</div>	
										<div class="form-group">
											<label class="col-sm-3 control-label">Year</label>
											<div class="col-sm-9">
												<input name="txt_year" class="form-control" placeholder="year">
											</div>
										</div>
									</div>
								</div>
								<div class="box-footer pull-right">
									<div class="col-md-12">
										<a class="btn btn-default" type="button" onclick="goBack()"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Back</a>
										<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Save Changes</button>
									</div>
								</div>
								<input type="hidden" class="form-control" name="txt_created_by" value = 0 required></input>
								<input type="hidden" class="form-control" name="txt_start_date" value ="now()"></input>
								<input type="hidden" class="form-control" name="txt_end_date" value ="NULL"></input>
								<input type="hidden" class="form-control" name="txt_last_updated" value ="NULL"></input>					
								<input type="hidden" class="form-control" name="txt_last_update_by" value ="NULL"></input>
								<input type="hidden" class="form-control" name="txt_creation_date" value ="now()"></input>
							</form>
						</div>
					</div>	
									
					
				</div>
			</div>
		</section>
	</div>
  