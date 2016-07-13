<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>
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
			<div class="row">
				<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						Customer List
						<a href="<?php echo site_url('CustomerRelationship/Customer/Create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
							<button type="button" class="btn btn-default btn-sm">
							  <i class="icon-plus icon-2x"></i>
							</button>
						</a>
						
						
					</div>
					<div class="box-body">
						<div class="table-responsive" style="overflow:hidden;">
							<table class="table">
								<tr>
									<td width="22.5%"><input type="text" class="form-control toupper" placeholder="Search by name" name="txtbyname" id="txtbyname" /></td>
									<td width="22.5%"><input type="text" class="form-control toupper" placeholder="Search by village" name="txtbyvillage" id="txtbyvillage" /></td>
									<td width="22.5%"><input type="text" class="form-control toupper" placeholder="Search by city" name="txtbycity" id="txtbycity" /></td>
									<td width="22.5%">
										<select name="txtbycategory" id="txtbycategory" data-placeholder="Search by category" class="form-control select4">
											<option value=""></option>
											<?php
											foreach($categories as $ct){
											?>
											<option value="<?php echo $ct->customer_category_id;?>"><?php echo $ct->customer_category_name;?></option>
											<?php
											}
											?>
										</select>
									</td>
									<td width="10%"><a href="#" onclick="searchCustomer('<?php echo base_url();?>');return false;" class="btn btn-primary btn-md btn-rect">Search</a></td>
								</tr>
							</table>
							<div id="loading"></div>
							<div id="res">
								<table class="table table-striped table-bordered table-hover text-left" id="dataTables-customer" style="font-size:12px;">
									<thead>
										<tr class="bg-primary">
											<th width="5%"><center>No</center></th>
											<th width="20%"><center>Name</center></th>
											<th width="20%%"><center>Address</center></th>
											<th width="20%"><center>City/Regency/Province</center></th>
											<th width="13%"><center>Contact</center></th>
											<th width="17%"><center>Cust. Category</center></th>
											<th width="5%"><center>Action</center></th>
										</tr>
									</thead>
									<tbody>
									<?php $num = 0;
												foreach ($Customer as $Customer_item): 
												$num++;
												$encrypted_string = $this->encrypt->encode($Customer_item['customer_id']);
												$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
									?>
											<tr>
												<td align="center"><?php echo $num?></td>
												<td><?php echo strtoupper($Customer_item['customer_name']) ?></td>
												<td><?php echo strtoupper($Customer_item['address']) ?></td> 
												<td><?php echo strtoupper($Customer_item['city_regency']).", ".strtoupper($Customer_item['province']) ?></td>
												<td><?php echo strtoupper($Customer_item['contact']) ?></td>
												<td><?php echo strtoupper($Customer_item['customer_category_name']) ?></td>
												<td align="center">
												<a href="<?php echo site_url('CustomerRelationship/Customer/Details')."/".$encrypted_string ?>"><img src="<?php echo base_url('assets/img/detail.png');?>" title="Details"></a>
												
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
	</div>
	</div>
</section>
