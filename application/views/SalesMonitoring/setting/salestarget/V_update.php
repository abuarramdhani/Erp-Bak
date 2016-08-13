<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Edit Sales Target</b></h1>
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
			<form class="form-horizontal" method="post" action="<?php echo base_url('SalesMonitoring/salestarget/updated')?>">
			<?php foreach($selected as $selected_item){ ?>
				<input type="hidden" name="txt_sales_target_id" value="<?php echo $selected_item['sales_target_id'] ?>"></input>
				<input type="hidden" name="txt_last_update_by" value="<?php echo $this->session->userid; ?>"></input>
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
									<select class="form-control select4" name="txt_organization" class="form-control">
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
								<label class="col-lg-4 control-label">Order Type</label>
								<div class="col-lg-5">
									<input name="txt_order_type" class="form-control" placeholder="Order type" value="<?php echo $selected_item['order_type'] ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-4 control-label">Target</label>
								<div class="col-lg-5">
									<input name="txt_target" class="form-control" onkeypress="return isNumberKeyAndComma(event)" placeholder="Target" value="<?php echo $selected_item['target'] ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-4 control-label">Month</label>
								<div class="col-lg-2">
									<select class="form-control select4" placeholder="month" name="txt_month" required>
										<?php
										$a='';$b='';$c='';$d='';$e='';$f='';$g='';$h='';$i='';$j='';$k='';$l='';
											 if($selected_item['month'] == 1){$a = 'selected';} else if($selected_item['month'] == 2){$b = 'selected';}
										else if($selected_item['month'] == 3){$c = 'selected';} else if($selected_item['month'] == 4){$d = 'selected';}
										else if($selected_item['month'] == 5){$e = 'selected';} else if($selected_item['month'] == 6){$f = 'selected';}
										else if($selected_item['month'] == 7){$g = 'selected';} else if($selected_item['month'] == 8){$h = 'selected';}
										else if($selected_item['month'] == 9){$i = 'selected';} else if($selected_item['month'] == 10){$j = 'selected';}
										else if($selected_item['month'] == 11){$k = 'selected';} else if($selected_item['month'] == 12){$l = 'selected';}
										?>
										<?php echo '<option '.$a.' value="1">JANUARI</option>' ?> <?php echo '<option '.$b.' value="2">FEBRUARI</option>' ?>
										<?php echo '<option '.$c.' value="3">MARET</option>' ?> <?php echo '<option '.$d.' value="4">APRIL</option>' ?>
										<?php echo '<option '.$e.' value="5">MEI</option>' ?> <?php echo '<option '.$f.' value="6">JUNI</option>' ?>
										<?php echo '<option '.$g.' value="7">JULI</option>' ?> <?php echo '<option '.$h.' value="8">AGUSTUS</option>' ?>
										<?php echo '<option '.$i.' value="9">SEPTEMBER</option>' ?> <?php echo '<option '.$j.' value="10">OKTOBER</option>' ?>
										<?php echo '<option '.$k.' value="11">NOVEMBER</option>' ?> <?php echo '<option '.$l.' value="12">DESEMBER</option>' ?>
									</select>
								</div>
								<label class="col-lg-1 control-label">Year</label>
								<div class="col-lg-2">
									<input name="txt_year" class="form-control" onkeypress="return isNumberKey(event)" placeholder="year" value="<?php echo $selected_item['year'] ?>">
								</div>
							</div>							
						</div>
						<div class="panel-footer">
							<div class="row text-right">
								<div class="col-md-12">
									<a href="<?php echo site_url('SalesMonitoring/salestarget');?>" class="btn btn-primary btn-lg btn-rect">Back</a>
									&nbsp;&nbsp;
									<button type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				</div>
			<?php } ?>
			</form>			
			</div>
		</div>
	</div>
	</div>
</section>
  