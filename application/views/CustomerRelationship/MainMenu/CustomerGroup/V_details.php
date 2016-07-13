<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Customer Group</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('CustomerRelationship/CustomerGroup');?>">
                                <i class="icon-group icon-2x"></i>
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
						foreach ($CustomerGroup as $CustomerGroup_item):
							
								$encrypted_string = $this->encrypt->encode($CustomerGroup_item['customer_group_id']);
								$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
								
						?>
						<form method="post" action="<?php echo site_url('/CustomerRelationship/CustomerGroup/Update/')?>" class="form-horizontal">
							<input type="hidden" value="<?php echo $CustomerGroup_item['customer_group_id'] ?>" name="hdnCustomerGroupId" id="hdnCustomerGroupId" />
							<div class="col-lg-12">
								<div class="col-lg-12">
									<div class="row">
										<div class="col-lg-2">
											<label>Group Name</label>
										</div>
										<div class="col-lg-4">
											: <?php echo $CustomerGroup_item['customer_group_name'] ?>
											&nbsp;
											<a href="<?php echo site_url('CustomerRelationship/CustomerGroup/Update/'.$encrypted_string) ?>">
												<img src="<?php echo base_url('assets/img/edit.png');?>">
											</a>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-2">
											<label>Address</label>
										</div>
										<div class="col-lg-8">
											: <?php echo strtoupper($CustomerGroup_item['address']) ?>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-2">
											<label>Village</label>
										</div>
										<div class="col-lg-4">
											: <?php echo strtoupper($CustomerGroup_item['village']) ?>
										</div>
									</div>
								</div>
								<div class="col-lg-6">
									
									<div class="row">
										<div class="col-lg-4">
											<label>District</label>
										</div>
										<div class="col-lg-8">
											: <?php echo strtoupper($CustomerGroup_item['district']) ?>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-4">
											<label>City/Regency</label>
										</div>
										<div class="col-lg-8">
											: <?php echo strtoupper($CustomerGroup_item['city_regency']) ?>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-4">
											<label>Province</label>
										</div>
										<div class="col-lg-8">
											: <?php echo strtoupper($CustomerGroup_item['province']) ?>
										</div>
									</div>
								</div>
							</div>
						</form>
						<?php endforeach ?>
					</div>
					<br />
					<div class="row">
					<form method="post" action="<?php echo site_url('/CustomerRelationship/CustomerGroup/AddMember/'.$encrypted_string)?>" class="form-horizontal">
					<!--<form method="post" action="<?php echo site_url('/CustomerRelationship/CustomerGroup/'.$encrypted_string.'/'.$CustomerGroup_item['customer_group_id'])?>" class="form-horizontal">-->
					<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" id="hdnDate"/>
					<input type="hidden" value="<?php echo $this->session->userid ?>" name="hdnUser" id="hdnUser"/>
							
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">Lines
							</div>
							<div class="panel-body">
								<label for="norm" class="control-label col-lg-2 text-center">Add Member :</label>
								<div class="col-lg-7">
									<!--<input type="text" placeholder="Customer Name" name="txtCustomerName" id="txtCustomerName" onblur="selectCustomer()" onchange="enadisLineOwner()" class="form-control2"/>-->
									<div class="input-group">
										<input type="text" placeholder="Customer" name="txtCustomerName" id="txtCustomerName" onfocus="callModal('<?php echo site_url('ajax/ModalCustomerNoGroup')?>');" class="form-control toupper"/>
										<span class="input-group-btn">
											<a class="btn btn-primary" onclick="callModal('<?php echo site_url('ajax/ModalCustomerNoGroup')?>');"><i class="icon-search"></i></a>
										</span>
										
									</div>
									<input type="hidden" name="hdnCustomerId" id ="hdnCustomerId" />
									<input type="hidden" name="hdnCategoryId" id ="hdnCategoryId"  />
									
								</div>
								<div class="col-lg-2">
									<button type="submit" class="btn btn-primary">Add</button>	
								</div>
							</div>
							<div class="panel-body">
							<table class="table table-striped table-bordered table-hover text-left" id="dataTables-example" style="font-size:12px;">
									<thead>
										<tr class="bg-primary">
											<th width="10%" style="text-align:center;">No</th>
											<th width="80%" style="text-align:center;">Customer Name</th>
											<th width="10%" style="text-align:center;">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php $num = 1;
										foreach ($CustomerGroupMember as $CustomerGroupMember_item): 
										//$encrypted_string = $this->encrypt->encode($CustomerGroupMember_item['customer_group_id']);
										//$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
										
										$encrypted_string2 = $this->encrypt->encode($CustomerGroupMember_item['customer_id']);
										$encrypted_string2 = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string2);
										
										?>
											<tr>
												<td align="center"><?php echo $num ?></td>
												<td align="left"><?php echo $CustomerGroupMember_item['customer_name'] ?></td>
												<td align="center">
													<a href="<?php echo site_url('CustomerRelationship/Customer/Details/')."/".$encrypted_string2 ?>"><img src="<?php echo base_url('assets/img/detail.png');?>" title="Details"></a>
												
													<a onclick="confirm('Apakah anda yakin ingin menghapus data ini?')" href="<?php echo site_url('CustomerRelationship/CustomerGroup/DeleteMember/'.$encrypted_string.'/'.$encrypted_string2) ?>"><img src="<?php echo base_url('assets/img/hapus.png');?>" style="max-height:16px;" title="Delete"></a>
												</td>	
										</td>
											</tr>
											
										  <?php $num++;  endforeach ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					</form>
				</div>
					<div class="row text-right">
						<a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
						&nbsp;&nbsp;
					</div>
				
				</div>
				</div>
		</div>
		<div class="col-lg-2"></div>
	</div>
	</div>

<!-- Modal Start -->
<div class="col-lg-12">
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">

			</div>
		</div>
	</div>
</div>
</section>
<!-- Modal End -->