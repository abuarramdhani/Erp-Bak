<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Setup Sales Omset</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
							<a class="btn btn-default btn-lg" href="<?php echo site_url('SalesMonitoring/salesomset');?>">
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
						Sales Omset
					</div>
					<div class="box-body">
						<div class="table-responsive">	
							<table class="table">
								<tr>
									<td>
									<form id="export-filter" method="post" action="<?php echo base_url('SalesMonitoring/salesomset/Filter/Download/pdf')?>">
										<input type="hidden" name="txt_pdf_organization" value="<?php echo $select_org ?>"></input>
										<input type="hidden" name="txt_pdf_month" value="<?php echo $select_mon ?>"></input>
										<input type="hidden" name="txt_pdf_year" value="<?php echo $select_yea ?>"></input>
									<a class="btn btn-default btn-sm" type="button" onclick="document.getElementById('export-filter').submit()"><span class="glyphicon glyphicon-save" aria-hidden="true" ></span> Save PDF</a>
									</form>
									</td>
								</tr>
							</table>
							
							<table class="table">
								<form method="post" action="<?php echo base_url('SalesMonitoring/salesomset/Filter')?>">
									<tr>
										<td width="30%">
											<select class="form-control select4" name="txt_profilter_organization" required>
												<option value="so.org_id">ANY</option>
												<?php foreach($source_organization as $source_organization_item) { ?>
													<?php $status1 = '';
															if ($source_organization_item['org_id'] == $select_org){
															$status1 = 'selected';
													} ?>
												<?php echo '<option '.$status1.' value="'.$source_organization_item['org_id'].'">'.$source_organization_item['org_name'].'</option>' ?>
												<?php } ?>
											</select>
										</td>
										<td width="20%">
											<select class="form-control select4" name="txt_profilter_month" required>
												<option value="so.month">ANY</option>
												<?php
													$a='';$b='';$c='';$d='';$e='';$f='';$g='';$h='';$i='';$j='';$k='';$l='';
														 if($select_mon == 1){$a 	= 'selected';} else if($select_mon == 2){$b 	= 'selected';}
													else if($select_mon == 3){$c 	= 'selected';} else if($select_mon == 4){$d 	= 'selected';}
													else if($select_mon == 5){$e 	= 'selected';} else if($select_mon == 6){$f 	= 'selected';}
													else if($select_mon == 7){$g 	= 'selected';} else if($select_mon == 8){$h 	= 'selected';}
													else if($select_mon == 9){$i 	= 'selected';} else if($select_mon == 10){$j 	= 'selected';}
													else if($select_mon == 11){$k 	= 'selected';} else if($select_mon == 12){$l 	= 'selected';}
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
												<option value="so.year">ANY</option>
												<?php foreach($source_year as $source_year_item) {?>
													<?php 
														$status3='';
														if ($source_year_item['year'] == $select_yea){
														$status3 = 'selected';
													} ?>
												<?php echo '<option '.$status3.'>'.$source_year_item['year'].'</option>' ?>
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
										<th  width="5%">NO</th>
										<th  width="12%">ORGANIZATION NAME</th>
										<th  width="17%">ORDER TYPE</th>
										<th  width="13%">ITEM CODE</th>
										<th  width="40%">ITEM DESCRIPTION</th>
										<th  width="3%">QTY FULFILLED</th>
										<th  width="7%">MONTH</th>
										<th  width="3%">YEAR</th>
									</tr>
								</thead>
								<tbody>
									<?php $no = 0; foreach($result as $result_item) { $no++ ?>
										<?php 
												 if($result_item['month'] == 1){$month='Januari';}
											else if($result_item['month'] == 2){$month='Februari';}
											else if($result_item['month'] == 3){$month='Maret';}
											else if($result_item['month'] == 4){$month = 'April';}
											else if($result_item['month'] == 5){$month = 'Mei';}
											else if($result_item['month'] == 6){$month = 'Juni';}
											else if($result_item['month'] == 7){$month = 'Juli';}
											else if($result_item['month'] == 8){$month = 'Agustus';}
											else if($result_item['month'] == 9){$month = 'September';}
											else if($result_item['month'] == 10){$month = 'Oktober';}
											else if($result_item['month'] == 11){$month = 'November';}
											else if($result_item['month'] == 12){$month = 'Desember';}
										?>
											<tr>
												<td><?php echo $no; ?></td>
												<td><?php echo $result_item['org_name'] ?></td>
												<td><?php echo $result_item['order_type'] ?></td>
												<td><?php echo $result_item['item_code'] ?></td>
												<td><?php echo $result_item['item_description'] ?></td>
												<td><?php echo $result_item['qty_fulfilled'] ?></td>
												<td><?php echo $month ?></td>
												<td><?php echo $result_item['year'] ?></td>
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
