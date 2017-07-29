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
							<abbr> Update</abbr></b><br>
						</h4>
					</div>
				</div>
				<div class="box-body"></br>
					
				<!--NEW FORM-->
					<div class="row-fluid">
						<div class="col-md-12">
							<form class="form-horizontal" method="post" action="<?php echo base_url('setting/salestarget/updated')?>">
								<?php foreach($selected as $selected_item){ ?><input type="hidden" name="txt_sales_target_id" value="<?php echo $selected_item['sales_target_id'] ?>"></input>
								
								<div class="box-body">
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-sm-3 control-label">Organization</label>
											<div class="col-sm-9">
												<select class="form-control sales" name="txt_organization" class="form-control">
													<?php $no = 0; foreach($source as $src) { $no++ ?>
													<?php $status = '';
														  if ($selected_item['org_id'] == $src['org_id']){
																$status = 'selected';
													} ?>
													<?php echo '<option '.$status.' value="'.$src['org_id'].'">'.$src['org_name'].'</option>' ?>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Order Type</label>
											<div class="col-sm-9">
												<input name="txt_order_type" class="form-control" placeholder="Order type" value="<?php echo $selected_item['order_type'] ?>">
											</div>
										</div>
												
										<div class="form-group">
											<label class="col-sm-3 control-label">Target</label>
											<div class="col-sm-9">
												<input name="txt_target" class="form-control" placeholder="Target" value="<?php echo $selected_item['target'] ?>">
											</div>
										</div>
									</div>
									
									<div class="col-md-6">									
										<div class="form-group">
											<label class="col-sm-3 control-label">Month</label>
											<div class="col-sm-9">
												<select class="form-control sales" placeholder="month" name="txt_month" required>
													<?php
													$a='';$b='';$c='';$d='';$e='';$f='';$g='';$h='';$i='';$j='';$k='';$l='';
														 if($selected_item['month'] == 1){$a = 'selected';}
													else if($selected_item['month'] == 2){$b = 'selected';}
													else if($selected_item['month'] == 3){$c = 'selected';}
													else if($selected_item['month'] == 4){$d = 'selected';}
													else if($selected_item['month'] == 5){$e = 'selected';}
													else if($selected_item['month'] == 6){$f = 'selected';}
													else if($selected_item['month'] == 7){$g = 'selected';}
													else if($selected_item['month'] == 8){$h = 'selected';}
													else if($selected_item['month'] == 9){$i = 'selected';}
													else if($selected_item['month'] == 10){$j = 'selected';}
													else if($selected_item['month'] == 11){$k = 'selected';}
													else if($selected_item['month'] == 12){$l = 'selected';}
													?>
													<?php echo '<option '.$a.' value="1">JANUARI</option>' ?>
													<?php echo '<option '.$b.' value="2">FEBRUARI</option>' ?>
													<?php echo '<option '.$c.' value="3">MARET</option>' ?>
													<?php echo '<option '.$d.' value="4">APRIL</option>' ?>
													<?php echo '<option '.$e.' value="5">MEI</option>' ?>
													<?php echo '<option '.$f.' value="6">JUNI</option>' ?>
													<?php echo '<option '.$g.' value="7">JULI</option>' ?>
													<?php echo '<option '.$h.' value="8">AGUSTUS</option>' ?>
													<?php echo '<option '.$i.' value="9">SEPTEMBER</option>' ?>
													<?php echo '<option '.$j.' value="10">OKTOBER</option>' ?>
													<?php echo '<option '.$k.' value="11">NOVEMBER</option>' ?>
													<?php echo '<option '.$l.' value="12">DESEMBER</option>' ?>
												</select>
											</div>
										</div>
												
										<div class="form-group">
											<label class="col-sm-3 control-label">Year</label>
											<div class="col-sm-9">
												<input name="txt_year" class="form-control" placeholder="year" value="<?php echo $selected_item['year'] ?>">
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
								<?php } ?>
							</form>			
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
  