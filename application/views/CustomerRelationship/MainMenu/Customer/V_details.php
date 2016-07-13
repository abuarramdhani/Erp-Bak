<script>
$(document).ready(function() {
    // show active tab on reload
    if (location.hash !== '') $('a[href="' + location.hash + '"]').tab('show');

    // remember the hash in the URL without jumping
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
       if(history.pushState) {
            history.pushState(null, null, '#'+$(e.target).attr('href').substr(1));
       } else {
            location.hash = '#'+$(e.target).attr('href').substr(1);
       }
    });
});

</script>
<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
							<h1><b> Customer Details </b></h1>

						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('CustomerRelationship/Customer');?>">
                                <i class="icon-male icon-2x"></i>
                                <span ><br /></span>
                            </a>
							

                            
						</div>
					</div>
				</div>
			</div>
			<br />
			<div class="box box-primary box-solid">
			<div class="box-header with-border">
			Header
			</div>
			<div class="box-body">
			<div class="row">
			<?php 
			foreach ($Customer as $Customer_item): 
				$tgl2 = $Customer_item['end_date'];
				//echo $tgl2;
				if($tgl2 != '')
				{	$tgl2 = date_format(date_create($Customer_item['end_date']), 'd-M-Y'); 	}
			
				$encrypted_string = $this->encrypt->encode($Customer_item['customer_id']);
				$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
			?>
			<div class="col-lg-12">
				<div class="col-lg-6">
					<div class="row">
						<div class="col-lg-4">
							<label>Cust. Name</label>
						</div>
						<div class="col-lg-8">
							: <?php echo $Customer_item['customer_name'] ?> 
							&nbsp;
							<a href="<?php echo site_url('CustomerRelationship/Customer/Update/'.$encrypted_string) ?>">
								<img src="<?php echo base_url('assets/img/edit.png');?>">
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4">
							<label>ID Number</label>
						</div>
						<div class="col-lg-8">
							: <?php echo $Customer_item['id_number'] ?> 
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4">
							<label>Address</label>
						</div>
						<div class="col-lg-8">
							: <?php echo $Customer_item['address'] ?> 
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4">
							<label>RT</label>
						</div>
						<div class="col-lg-8">
							: <?php echo $Customer_item['rt'] ?> 
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4">
							<label>RW</label>
						</div>
						<div class="col-lg-8">
							: <?php echo $Customer_item['rw'] ?> 
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4">
							<label>District</label>
						</div>
						<div class="col-lg-8">
							: <?php echo strtoupper($Customer_item['district']) ?> 
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4">
							<label>Village</label>
						</div>
						<div class="col-lg-8">
							: <?php echo strtoupper($Customer_item['village']) ?> 
						</div>
					</div>
					
				</div>
				<div class="col-lg-6" style="margin-top: 3%;">
					<div class="row">
						<div class="col-lg-4">
							<label>City / Regency</label>
						</div>
						<div class="col-lg-8">
							: <?php echo strtoupper($Customer_item['city_regency']) ?> 
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4">
							<label>Province</label>
						</div>
						<div class="col-lg-8">
							: <?php echo strtoupper($Customer_item['province']) ?> 
						</div>
					</div>
					
					<div class="row">
						<div class="col-lg-4">
							<label>Start Date</label>
						</div>
						<div class="col-lg-8">
							: <?php echo strtoupper(date_format(date_create($Customer_item['start_date']), 'd-M-Y')) ?>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4">
							<label>End Date</label>
						</div>
						<div class="col-lg-8">
							: <?php echo strtoupper($tgl2) ?>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4">
							<label>Customer Group</label>
						</div>
						<div class="col-lg-8">
							: <?php echo $Customer_item['customer_group_name'] ?> 
						</div>
					</div>
				</div>
			</div>
			<?php 	endforeach ?>	
			</div>
			<br /><br />
			<div class="row">
				<div class="col-lg-12">
				<div class="panel panel-default">
						<div class="panel-heading">
							Lines
						</div>
						<div class="panel-body">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#custcategory" data-toggle="tab">Job</a>
								</li>
								<li><a href="#contact" data-toggle="tab">Contact</a>
								</li>
								<!--<li><a href="#site" data-toggle="tab">Site</a>
								</li>-->
								<li><a href="#driver" data-toggle="tab">Driver</a>
								</li>
								<li><a href="#ownership" data-toggle="tab">Ownership</a>
								</li>
								<li><a href="#job" data-toggle="tab">Additional Information</a>
								</li>
							</ul>

							<div class="tab-content">
								<div class="tab-pane fade in active" id="custcategory">
									<div class="table-responsive">
										&nbsp;
										<a href="<?php echo site_url('CustomerRelationship/Customer/CreateRelation/'.$encrypted_string) ?>">
											
											<img src="<?php echo base_url('assets/img/add.png');?>" style="max-height:25px;margin-bottom:2%;"  alt="Add New" title="Add New">
										</a>
										<table class="table table-striped table-bordered table-hover"  style="font-size:12px;">
											<thead>
												<tr class="bg-primary">
													<th width="5%"><center>No</center></th>
													<th width="20%"><center>Category</center></th>
													<th width="25%"><center>Owner</center></th>
													<th width="15%"><center>Start Date</center></th>
													<th width="15%"><center>End Date</center></th>
													<th width="10%"><center>Action</center></th>
												</tr>
											</thead>
											<tbody>
												<?php 
											$i=1;
											foreach ($CustomerRelation as $CustomerRelation_item): 
											
											$encrypted_string2 = $this->encrypt->encode($CustomerRelation_item['relation_id']);
											$encrypted_string2 = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string2);

											?>

													<tr>
														<td align="center"><?php echo $i;?></td>
														<td><?php echo $CustomerRelation_item['customer_category_name'] ?> </td>
														<td align="left"><?php if ($CustomerRelation_item['owner_name'] != null) {echo $CustomerRelation_item['owner_name'];} else {echo '-';} ?></td>
														<td><?php echo strtoupper(date_format(date_create($CustomerRelation_item['start_date']), 'd-M-Y')) ?></td>
														<td><?php if ($CustomerRelation_item['end_date'] == null) {echo '-';} else {echo strtoupper(date_format(date_create($CustomerRelation_item['end_date']), 'd-M-Y'));} ?></td>
														<td align="center">
															<a href="<?php echo site_url('CustomerRelationship/Customer/UpdateRelation/'.$encrypted_string2) ?>">
																<img src="<?php echo base_url('assets/img/edit.png');?>" style="max-height:16px;">
															</a>
														</td>
													</tr>
											<?php $i++;	endforeach ?>
											</tbody>
										</table>
									</div>
								</div>
								<div class="tab-pane fade" id="contact">
									<div class="table-responsive">
										&nbsp;
										<a href="<?php echo site_url('CustomerRelationship/Customer/CreateContact/'.$encrypted_string) ?>">
											
											<img src="<?php echo base_url('assets/img/add.png');?>" style="max-height:25px;margin-bottom:2%;"  alt="Add New" title="Add New">
										</a>
										<table class="table table-striped table-bordered table-hover"  style="font-size:12px;">
											<thead>
												<tr class="bg-primary">
													<th width="5%"><center>No</center></th>
													<th width="15%"><center>Contact Type</center></th>
													<th width="15%"><center>Data</center></th>
													<th width="45%"><center>Description</center></th>
													<th width="20%"><center>Actions</center></th>
												</tr>
											</thead>
											<tbody>
											<?php 
											$i=1;
											foreach ($CustomerContact as $CustomerContact_item): 
											$encrypted_string2 = $this->encrypt->encode($CustomerContact_item['customer_contact_id']);
											$encrypted_string2 = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string2);
											?>
													<tr>
														<td align="center"><?php echo $i;?></td>
														<td><?php echo $CustomerContact_item['type'] ?></td>
														<td align="left"><?php echo $CustomerContact_item['data'] ?></td>
														<td><?php echo $CustomerContact_item['name'] ?> </td>
														<td align="center">
															<a href="<?php echo site_url('CustomerRelationship/Customer/UpdateContact/'.$encrypted_string2) ?>"><img src="<?php echo base_url('assets/img/edit.png');?>" style="max-height:16px;"></a>
															&nbsp;&nbsp;
															<a onclick="confirm()" href="<?php echo site_url('CustomerRelationship/Customer/DeleteContact/'.$encrypted_string2.'/'.$encrypted_string) ?>"><img src="<?php echo base_url('assets/img/hapus.png');?>" style="max-height:16px;"></a>
														</td>
													</tr>
											<?php $i++;	endforeach ?>
											</tbody>
										</table>
									</div>
						
								</div>
								<div class="tab-pane fade" id="site">
									<div class="table-responsive">
										&nbsp;
										<a href="<?php echo site_url('CustomerRelationship/Customer/CreateSite/'.$encrypted_string) ?>">
											<img src="<?php echo base_url('assets/img/add.png');?>" style="max-height:25px;margin-bottom:2%;"  alt="Add New" title="Add New">
										</a>
										<table class="table table-bordered"  style="font-size:12px;">
											
											<tbody>
												<?php 
													$i =1;
													foreach ($CustomerSite as $CustomerSite_item): 
													
													$encrypted_string2 = $this->encrypt->encode($CustomerSite_item['customer_site_id']);
													$encrypted_string2 = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string2);

												?>

													<tr style="background: #F0F0F0;">
														<td align="center"><?php echo $i;?></td>
														<td colspan=6><b><?php echo $CustomerSite_item['site_name'] ?></b> </td>
														<td align="center">
															<a href="<?php echo site_url('CustomerRelationship/Customer/UpdateSite/'.$encrypted_string2)?>">
																<img src="<?php echo base_url('assets/img/edit.png');?>" style="max-height:16px;">
															</a>
														</td>
													</tr>
													<tr class="bg-primary" style="font-weight:bold;text-align:left;">
														<td width="5%" rowspan=2></td>
														<td width="15%"><center>Address</center></td>
														<td width="10%"><center>RT</center></td>
														<td width="10%"><center>RW</center></td>
														<td width="15%"><center>Village</center></td>
														<td width="15%"><center>District</center></td>
														<td width="15%"><center>City</center></td>
														<td width="15%"<center>>Province</center></td>
													</tr>
													<tr>
														<td><?php echo $CustomerSite_item['address'] ?> </td>
														<td align="center"><?php echo $CustomerSite_item['rt'] ?></td>
														<td align="center"><?php echo $CustomerSite_item['rw'] ?></td>
														<td><?php echo strtoupper($CustomerSite_item['village_name']) ?></td>
														<td><?php echo strtoupper($CustomerSite_item['district_name']) ?></td>
														<td><?php echo strtoupper($CustomerSite_item['regency_name']) ?></td>
														<td><?php echo strtoupper($CustomerSite_item['province_name']) ?></td>
													</tr>
												<?php $i++;	endforeach ?>
											</tbody>
										</table>
									</div>
									
								</div>
								<div class="tab-pane fade" id="driver">
									<div class="table-responsive">
										&nbsp;
										<a href="<?php echo site_url('CustomerRelationship/CustomerDriver/Create/'.$encrypted_string) ?>">
											
											<img src="<?php echo base_url('assets/img/add.png');?>" style="max-height:25px;margin-bottom:2%;"  alt="Add New" title="Add New">
										</a>
										<table class="table table-striped table-bordered table-hover"  style="font-size:12px;">
											<thead>
												<tr class="bg-primary">
													<th width="5%"><center>No</center></th>
													<th width="35%"><center>Driver Name</center></th>
													<th width="20%"><center>Start Date</center></th>
													<th width="20%"><center>End Date</center></th>
													<th width="20%"><center>Action</center></th>
												</tr>
											</thead>
											<tbody>
											<?php $num = 0;
												foreach ($CustomerDriver as $CustomerDriver_item): 
												$num++;
												$encrypted_string3 = $this->encrypt->encode($CustomerDriver_item['relation_id']);
												$encrypted_string3 = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string3);
											?>
													<tr>
														<td><?php echo $num ?></td>
														<td><?php echo strtoupper($CustomerDriver_item['customer_name']) ?></td> 
														<td><?php echo strtoupper(date_format(date_create($CustomerDriver_item['start_date']), 'd-M-Y')) ?></td>
														<td><?php if ($CustomerDriver_item['end_date'] == null) {echo '-';} else {echo date_format(date_create($CustomerDriver_item['end_date']), 'd-M-Y');} ?></td>
														<td align="center">
															<a href="<?php echo site_url('CustomerRelationship/CustomerDriver/Update/'.$encrypted_string3) ?>">
															<img src="<?php echo base_url('assets/img/edit.png');?>" style="max-height:16px;">
															</a>
														</td>
													</tr>
											<?php endforeach ?>
											</tbody>
										</table>
									</div>
									
								</div>
								<div class="tab-pane fade" id="ownership">
									<div class="table-responsive">
										&nbsp;
										<a href="<?php echo site_url('CustomerRelationship/Ownership/Create/'.$encrypted_string) ?>">
											
											<img src="<?php echo base_url('assets/img/add.png');?>" style="max-height:25px;margin-bottom:2%;"  alt="Add New" title="Add New">
										</a>
										<table class="table table-striped table-bordered table-hover"  style="font-size:12px;">
											<thead>
												<tr class="bg-primary">
													<th width="5%"><center>No</center></th>
													<th width="35%"><center>Item Name</center></th>
													<th width="20%"><center>Body Number</center></th>
													<th width="20%"><center>Engine Number</center></th>
													<th width="10%"><center>Buying Type</center></th>
													<th width="10%"><center>Action</center></th>
												</tr>
											</thead>
											<tbody>
											<?php $num = 0;
												foreach ($Ownership as $Ownership_item): 
												$num++;
												$encrypted_string4 = $this->encrypt->encode($Ownership_item['customer_ownership_id']);
												$encrypted_string4 = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string4);

											?>
													<tr>
														<td align="center"><?php echo $num?></td>
														<td><?php echo $Ownership_item['item_name'] ?></td>
														<td><?php echo $Ownership_item['no_body'] ?></td>
														<td><?php echo $Ownership_item['no_engine'] ?></td>
														<td><?php if ($Ownership_item['buying_type_name'] == null) {echo '-';} else {echo $Ownership_item['buying_type_name'];} ?></td>
														<td align="center">
															<a href="<?php echo site_url('CustomerRelationship/Ownership/Update/'.$encrypted_string4) ?>" title="Update Ownership" >
															<img src="<?php echo base_url('assets/img/edit.png');?>" style="max-height:16px;">
															</a>
															&nbsp;
															<a href="<?php echo site_url('CustomerRelationship/Ownership/ChangeOwnership/'.$encrypted_string4) ?>" title="Change Ownership" >
															<img src="<?php echo base_url('assets/img/change.png');?>" style="max-height:16px;">
															</a>
														</td>
													</tr>
											<?php endforeach ?>
											</tbody>
										</table>
									</div>
									
								</div>
								<div class="tab-pane fade" id="job">
									<div class="table-responsive">
										&nbsp;
										<a href="<?php echo site_url('CustomerRelationship/Customer/CreateAdditionalInfo/'.$encrypted_string) ?>">
											<img src="<?php echo base_url('assets/img/add.png');?>" style="max-height:25px;margin-bottom:2%;"  alt="Add New" title="Add New">
										</a>
										<table class="table table-striped table-bordered table-hover"  style="font-size:12px;">
											<thead>
												<tr class="bg-primary">
													<th width="5%"><center>No</center></th>
													<th width="25%"><center>Additional Name</center></th>
													<th width="25%"><center>Additional Description</center></th>
													<th width="15%"><center>Start Date</center></th>
													<th width="15%"><center>End Date</center></th>
													<th width="15%"><center>Actions</center></th>
												</tr>
											</thead>
											<tbody>
											<?php 
											$i=1;
											foreach ($AdditionalInfo as $AdditionalInfo_item): 
											$encrypted_string2 = $this->encrypt->encode($AdditionalInfo_item['cust_additional_id']);
											$encrypted_string2 = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string2);
											?>
													<tr>
														<td align="center"><?php echo $i;?></td>
														<td><?php echo $AdditionalInfo_item['additional_name'] ?> </td>
														<td><?php echo $AdditionalInfo_item['additional_description'] ?></td>
														<td><?php echo strtoupper(date_format(date_create($AdditionalInfo_item['start_date']), 'd-M-Y')) ?></td>
														<td><?php if ($AdditionalInfo_item['end_date'] == null) {echo '-';} else {echo strtoupper(date_format(date_create($CustomerAdditional_item['end_date']), 'd-M-Y'));} ?></td>
														
														<td align="center">
															<a href="<?php echo site_url('CustomerRelationship/Customer/UpdateAdditionalInfo/'.$encrypted_string2) ?>"><img src="<?php echo base_url('assets/img/edit.png');?>" style="max-height:16px;"></a>
															</td>
													</tr>
											<?php $i++;	endforeach ?>
											</tbody>
										</table>
									</div>
						
								</div>
							</div>
						</div>
				</div>
				</div>
			</div>
			<div class="row text-right">
				<a href="<?php echo site_url('CustomerRelationship/Customer');?>" class="btn btn-primary btn-lg btn-rect">Back</a>
				&nbsp;&nbsp;
			</div>
			</div>
			</div>
		</div>
		<div class="col-lg-2"></div>
	
	</div>
	</div>
</section>
