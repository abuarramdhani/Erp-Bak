<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Setup Sales Target</b></h1>
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
				<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						<a href="<?php echo site_url('SalesMonitoring/salestarget/Create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
							<button type="button" class="btn btn-default btn-sm">
							  <i class="icon-plus icon-2x"></i>
							</button>
						</a>
						Sales Target
					</div>
					<div class="box-body">
						<div class="table-responsive" style="overflow:hidden;">
							<table class="table">
								<tr>
									<td><div class="btn-group">
										<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<span class="glyphicon glyphicon-save" aria-hidden="true"></span> Export <span class="caret"></span>
										</button>
										<ul class="dropdown-menu">
											<li><a href="<?php echo site_URL() ?>SalesMonitoring/salestarget/Download/csv">CSV</a></li>
											<li><a href="<?php echo site_URL() ?>SalesMonitoring/salestarget/Download/xml">XML</a></li>
											<li><a href="<?php echo site_URL() ?>SalesMonitoring/salestarget/Download/pdf">PDF</a></li>
										</ul>
									</div></td>
								</tr>
							</table>
							<table class="table">
								<form method="post" action="<?php echo base_url('SalesMonitoring/salestarget/Filter')?>">
									<tr>
										<td width="30%">
											<select class="form-control select4" name="txt_profilter_organization" required>
												<option value="st.org_id">ANY</option>
												<?php foreach($source_organization as $source_organization_item) { ?>
												<?php echo '<option value="'.$source_organization_item['org_id'].'">'.$source_organization_item['org_name'].'</option>' ?>
												<?php } ?>
											</select>
										</td>
										<td width="20%">
											<select class="form-control select4" name="txt_profilter_month" required>
												<option value="st.month">ANY</option>
												<?php
													$a='';$b='';$c='';$d='';$e='';$f='';$g='';$h='';$i='';$j='';$k='';$l='';$mm=date('m');
														 if($mm == 1){$a 	= 'selected';} else if($mm == 2){$b 	= 'selected';}
													else if($mm == 3){$c 	= 'selected';} else if($mm == 4){$d 	= 'selected';}
													else if($mm == 5){$e 	= 'selected';} else if($mm == 6){$f 	= 'selected';}
													else if($mm == 7){$g 	= 'selected';} else if($mm == 8){$h 	= 'selected';}
													else if($mm == 9){$i 	= 'selected';} else if($mm == 10){$j 	= 'selected';}
													else if($mm == 11){$k 	= 'selected';} else if($mm == 12){$l 	= 'selected';}
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
										</td>
										<td width="20%">
											<select class="form-control select4" name="txt_profilter_year" required>
												<option value="st.year">ANY</option>
												<?php foreach($source_year as $source_year_item) {?>
													<?php 
														$status2='';$yy=date('Y');
														if ($source_year_item['year'] == $yy){
														$status2 = 'selected';
													} ?>
												<?php echo '<option '.$status2.'>'.$source_year_item['year'].'</option>' ?>
												<?php } ?>
											</select>
										</td>
										<td width="10%">
											<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span> Filter</button>
										</td>
									</tr>
								</form>
							</table>
							<table class="table table-striped table-bordered table-hover text-center"  id="dataTables-customer" style="font-size:12px;">
								<thead class="bg-primary">
									<tr>
										<th>NO</th>
										<th>ORGANIZATION NAME</th>
										<th>ORDER TYPE</th>
										<th>MONTH</th>
										<th>YEAR</th>
										<th>TARGET</th>
										<th>ACTION</th>
									</tr>
								</thead>
								<tbody>
									<?php $no = 0; foreach($salestarget as $st) { $no++ ?>
									<?php 
											 if($st['month'] == 1){$month = 'Januari';}	else if($st['month'] == 2){$month = 'Februari';}
										else if($st['month'] == 3){$month = 'Maret';} else if($st['month'] == 4){$month = 'April';}
										else if($st['month'] == 5){$month = 'Mei';} else if($st['month'] == 6){$month = 'Juni';}
										else if($st['month'] == 7){$month = 'Juli';} else if($st['month'] == 8){$month = 'Agustus';}
										else if($st['month'] == 9){$month = 'September';} else if($st['month'] == 10){$month = 'Oktober';}
										else if($st['month'] == 11){$month = 'November';} else if($st['month'] == 12){$month = 'Desember';}
									?>
										<tr>
											<td><?php echo $no; ?></td>
											<td><?php echo $st['org_name'] ?></td>
											<td><?php echo $st['order_type'] ?></td>
											<td><?php echo $month ?></td>
											<td><?php echo $st['year'] ?></td>
											<td align="right"><?php echo number_format($st['target'], 2 , ',' , '.' );  ?></td>
											<td>
												<a href='<?php echo site_URL() ?>SalesMonitoring/salestarget/update/<?php echo $st['sales_target_id'] ?>'class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>
												<a href='<?php echo site_URL() ?>SalesMonitoring/salestarget/delete/<?php echo $st['sales_target_id'] ?>'class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</a>
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
	</div>
</section>