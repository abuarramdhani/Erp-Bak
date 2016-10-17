<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>
<section class="content">
	<div class="inner">
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Data Oracle</b></h1>
						
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('CobaOracle');?>">
                                <i class="fa fa-bookmark fa-2x"></i>
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
						<a href="<?php echo site_url('BtnTambahDataAssets') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
							<button type="button" class="btn btn-default btn-sm">
							  <i class="fa fa-plus fa-2x"></i>
							</button>
						</a>
						Header
					</div>
					<div class="box-body">
						<div class="table-responsive" style="overflow:hidden;">
							<table class="table">
								<tr>
									<td width="22.5%"><input type="text" class="form-control toupper" placeholder="Search" name="txtbyname" id="txtbyname" /></td>
								</tr>
							</table>
							<div id="loading"></div>
							<div id="res">
							<table class="table table-striped table-bordered table-hover text-left" id="dataTables-customer" style="font-size:12px;">
								<thead>
									<tr class="bg-primary">
										<th width="5%"><center>No</center></th>
										<th width="20%"><center>Invoice ID</center></th>
										<th width="10%"><center>Action</center></th>
									</tr>
								</thead>
								<tbody>
								<?php $num = 0;
								foreach ($data_oracle as $row):
								$num++;
								?>
										<tr>
											<td align="center"><?php echo $num?></td>
											<td><?php echo $row->INVOICE_ID;?></td>
											<td>
												<a href="<?php echo site_url('BtnUpdateDataAssets')."/".$row->INVOICE_ID ?>" style="float:right;margin-right:45%;margin-top:-0.5%;" alt="Update" title="Update" >
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
	</div>
</div>
</div>
</section>