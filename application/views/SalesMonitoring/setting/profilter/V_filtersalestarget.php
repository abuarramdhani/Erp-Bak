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
							<a style="color:#FFFFFF;" href="<?php echo base_url('setting/salestarget/')?>"> Sales Target</a>
							<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span><abbr> Filter</abbr><br>
							</b>
						</h4>
					</div>
				</div>
				<div class="box-header with-border" style=" background:#FFFFFF; color:#22aadd;">
					<div class="col-md-6">
						<form id="export-filter" method="post" action="<?php echo base_url('setting/salestarget/filter/download/pdf')?>">
						<a class="btn btn-default btn-sm" type="button" onclick="goBack()"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Back</a>
						<a class="btn btn-default btn-sm" type="button" onclick="document.getElementById('export-filter').submit()"><span class="glyphicon glyphicon-save" aria-hidden="true" ></span> Save PDF</a>
					</div>
				</div>
				<div class="box-body">
					<div class="row">
						<form method="post" action="<?php echo base_url('setting/salestarget/filter')?>">
							<div class="col-sm-12">
								<div class="col-sm-3">
									<select class="form-control sales" name="txt_profilter_organization">
										<option value="st.org_id">ANY</option>
										<?php foreach($source_organization as $source_organization_item) { ?>
												<?php $status1 = '';
													if ($source_organization_item['org_id'] == $select_org){
													$status1 = 'selected';
												} ?>
										<?php echo '<option '.$status1.' value="'.$source_organization_item['org_id'].'">'.$source_organization_item['org_name'].'</option>' ?>
										<?php } ?>
									</select>
								</div>
								<div class="col-sm-2">
									<select class="form-control sales" name="txt_profilter_month" required>
										<option value="st.month">ANY</option>
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
								</div>
								<div class="col-sm-2">
									<select class="form-control sales" name="txt_profilter_year" required>
										<option value="st.year">ANY</option>
											<?php foreach($source_year as $source_year_item) {?>
												<?php $status3 = '';
													if ($source_year_item['year'] == $select_yea){
													$status3 = 'selected';
												} ?>
											<?php echo '<option '.$status3.'>'.$source_year_item['year'].'</option>' ?>
											<?php } ?>
									</select>
								</div>
								<div class="col-sm-2">
									<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span> Filter</button>
								</div>
							</div>
						</form>
						</form>
					</div>
					<div class="table-responsive">						
						<fieldset class="row2" style="background:#FFFFFF;">
							</br>
							<table class="table table-hover table-striped table-bordered text-center" id="salestargettab" style="font-size:12px;">
								<thead style="background:#22aadd; color:#FFFFFF;">
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
								<tbody id="name-list">
									<?php $no = 0; foreach($result as $st) { $no++ ?>
									<?php 
											 if($st['month'] == 1){$month = 'Januari';}
										else if($st['month'] == 2){$month = 'Februari';}
										else if($st['month'] == 3){$month = 'Maret';}
										else if($st['month'] == 4){$month = 'April';}
										else if($st['month'] == 5){$month = 'Mei';}
										else if($st['month'] == 6){$month = 'Juni';}
										else if($st['month'] == 7){$month = 'Juli';}
										else if($st['month'] == 8){$month = 'Agustus';}
										else if($st['month'] == 9){$month = 'September';}
										else if($st['month'] == 10){$month = 'Oktober';}
										else if($st['month'] == 11){$month = 'November';}
										else if($st['month'] == 12){$month = 'Desember';}
									?>
										<tr>
											<td><?php echo $no; ?></td>
											<td><?php echo $st['org_name'] ?></td>
											<td><?php echo $st['order_type'] ?></td>
											<td><?php echo $month ?></td>
											<td><?php echo $st['year'] ?></td>
											<td align="right"><?php echo number_format($st['target'], 2 , ',' , '.' );  ?></td>
											<td>
												<a href='<?php echo site_URL() ?>setting/salestarget/update/<?php echo $st['sales_target_id'] ?>'class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>
												<a href='<?php echo site_URL() ?>setting/salestarget/delete/<?php echo $st['sales_target_id'] ?>'class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</a>
											</td>
										</tr>
									<?php } ?>
								</tbody>																			
							</table>
							<div class="clear"></div>
						</fieldset>
					</div>
				</div>
			</div>
		</section>
	</div>
