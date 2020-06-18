<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-left">
								<h1><b>Laporan Data Asset Oracle</b>(<?php echo $cabang; ?>)</h1>
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" onclick="window.location.reload()">
									<i class="icon-refresh icon-2x"></i>
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
							<div style="padding-top: 20px" class="box-header with-border">
							</div>
							<div class="box-body">
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover" id="tblACLDAO" style="font-size:12px;">
										<thead>
											<tr style="background-color: #3c8dbc;" class="bg-primary">
												<th width="5%" class="text-center"><center>No</center></th>
												<th width="10%"><center>Cabang</center></th>
												<th width="20%"><center>Location</center></th>
												<th width="10%"><center>Category</center></th>
												<!-- <th width="5%"><center>Asset Number</center></th> -->
												<th width="15%"><center>Description</center></th>
												<th width="15%"><center>Tag Number</center></th>
												<th width="10%"><center>Date Placed In Service</center></th>
												<th width="10%"><center>Invoice Number</center></th>
												<!-- <th width="10%"><center>Book Type Code</center></th> -->
											</tr>
										</thead>
										<tbody>
										<?php $no =1; foreach ($oracle as $k) { ?> 
										<tr>
											<td class="text-center"><?php echo $no;?></td>
											<td class="text-center"><?php echo $k['BRANCH']?></td>											
											<td class="text-left"><?php echo $k['LOCATION_DESCRIPTION2']?></td>
											<td class="text-center"><?php echo $k['ATTRIBUTE_CATEGORY_CODE']?></td>
											<!-- <td class="text-center"><?php echo $k['ASSET_NUMBER']?></td> -->
											<td ><?php echo $k['DESCRIPTION']?></td>
											<td class="text-center"><?php echo $k['TAG_NUMBER']?></td>
											<td class="text-center"><?php echo $k['DATE_PLACED_IN_SERVICE']?></td>
											<td class="text-center"><?php echo $k['INVOICE_NUMBER']?></td>
											<!-- <td><?php echo $k['BOOK_TYPE_CODE']?></td> -->
										</tr>
										<?php $no++;} ?>
										</tbody>
													</td>
												</tr>
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
<script type="text/javascript">
	$( document ).ready(function() {
	$('#tblACLDAO').DataTable({
		"pageLength": 50
	});
})
</script>
