<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
							<h1><b> <?php echo $title;?></b></h1>
							
						
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('CustomerRelationship/ServiceProducts');?>">
									<i class="icon-gears icon-2x"></i>
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
								<a href="<?php echo site_url('CustomerRelationship/ServiceProducts/Create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New Service" title="Add New Service" >
									<button type="button" class="btn btn-default btn-sm">
									  <i class="icon-plus icon-2x"></i>
									</button>
								</a>
								<a href="<?php echo site_url('CustomerRelationship/ServiceProducts/CreateConnect/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New Connect" title="Add New Connect" >
									<button type="button" class="btn btn-default btn-sm">
									  <i class="icon-plus-sign icon-2x"></i>
									</button>
									
								</a>
								Service List
							</div>
							<div class="box-body">
								<div class="table-responsive" style="overflow:hidden;">
									<table class="table">
										<tr>
											<td width="20%"><input type="text" class="form-control toupper" placeholder="Activity number" name="txtbyservicenumber" id="txtbyservicenumber" /></td>
											<td width="20%"><input type="text" class="form-control toupper" placeholder="Customer name" name="txtbyname" id="txtbyname" /></td>
											<td width="20%">
												<select name="txtbyactivity" id="txtbyactivity" data-placeholder="Activity" class="form-control select4">
													<option value="">-- Search by activity --</option>
													<option value="service_keliling">Service Keliling</option>
													<option value="customer_visit">Customer Visit</option>
													<option value="kirim_part" >Kirim Part</option>
													<option value="call_out">Call Out</option>
													<option value="call_out">Call In</option>
													<option value="social">Social Media</option>
													<option value="email">Email</option>
													<option value="visit_us">Visit Us</option>
													<option value="others">Other</option>
													
												</select>
											</td>
											<td width="20%">
												
												<input type="text" class="form-control toupper" placeholder="Method" name="txtbymethod" id="txtbymethod" />
											</td>
											<td width="15%">
												
												<input type="text" class="form-control toupper" placeholder="Contact" name="txtByContact" id="txtByContact" />
											</td>
											<td width="10%"><a href="#" onclick="searchServiceProducts('<?php echo base_url();?>');return false;" class="btn btn-primary btn-md btn-rect">Search</a></td>
										</tr>
									</table>
									<div id="loading"></div>
									<div id="res">
									<table class="table table-striped table-bordered table-hover text-left" id="dataTables-customer" style="font-size:12px;">
										<thead>
											<tr class="bg-primary">
												<th width="5%"><center>No</center></th>
												<th width="15%"><center>Activity Number</center></th>
												<th width="15%"><center>Activity Type</center></th>
												<th width="15%"><center>Customer</center></th>
												<th width="15%"><center>Province/City</center></th>
												<th width="15%"><center>Contact</center></th>
												<th width="15%"><center>Status</center></th>
												<th width="5%"><center>Action</center></th>
											</tr>
										</thead>
										<tbody>
										<?php 
											$num = 0;
											foreach ($Activity as $Activity_item): 
											$num++;
											$encrypted_string = $this->encrypt->encode($Activity_item['service_product_id']);
											$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
											$link_connect = site_url('CustomerRelationship/ServiceProducts/UpdateConnect/')."/".$encrypted_string;
											$link_service = site_url('CustomerRelationship/ServiceProducts/Update/')."/".$encrypted_string;
										?>
											<tr>
												<td align="center"><?php echo $num?>
												</td>
												<td align="left"><?php echo $Activity_item['service_number'] ?>
												</td>
												<td align="left">
												<?php if($Activity_item['service_type'] == 'service_keliling'){
														echo "Service Keliling";
														$link = $link_service;
													}
													elseif($Activity_item['service_type'] == 'customer_visit'){
														echo "Customer Visit";
														$link = $link_service;
													}
													elseif($Activity_item['service_type'] == 'visit_us'){
														echo "Visit Us";
														$link = $link_service;
													}
													elseif($Activity_item['service_type'] == 'kirim_part'){
														echo "Kirim Part";
														$link = $link_service;
													}
													elseif($Activity_item['service_type'] == 'call_in'){
														echo "Call In";
														$link = $link_connect;
													}
													elseif($Activity_item['service_type'] == 'call_out'){
														echo "Call Out";
														$link = $link_connect;
													}
													elseif($Activity_item['service_type'] == 'social'){
														echo "Social Media";
														$link = $link_connect;
													}
													elseif($Activity_item['service_type'] == 'email'){
														echo "Email";
														$link = $link_connect;
													};
												?>
												</td>
												<td align="left"><?php echo $Activity_item['customer_name'] ?></td>
												<td align="left"><?php echo strtoupper($Activity_item['province']).", ".strtoupper($Activity_item['city_regency']) ?></td>
												<td align="left"><?php echo $Activity_item['contact_number'] ?></td>
												<td align="left"><?php echo $Activity_item['service_status'] ?></td>
												<td>
													<a href="<?php echo $link ?>" alt="Update" title="Update">
													<img src="<?php echo base_url('assets/img/edit.png');?>" title="Update">
													</a>
												</td>
											</tr>
										<?php endforeach ?>
										
										</tbody>
									</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-8">
			</div>
		</div>
	</div>
</section>