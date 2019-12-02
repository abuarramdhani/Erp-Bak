<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="box-header box-primary">
					<div class="row">
						<div class="col-lg-12">
							<div class="text-left ">
								<span><b></i> Detail PR</b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary">
					  		<div id="tableHolder">
								<div class="box-body">
									<table id="tbpr" class="table table-striped table-bordered table-hover text-center">
									<thead>
										<tr class="bg-primary">
											<th class="text-center">No</th>
											<th class="text-center">No PO</th>
											<th class="text-center">Line PO</th>
											<th class="text-center">Vendor Name</th>
											<th class="text-center">Item Description</th>
											<th class="text-center">Unit Price</th>
										</tr>
									</thead>
									<tbody>
										<?php $no=1; foreach($iniPR as $k) { ?>
										<tr>
											<td><?php echo $no ?> </td>
											<td><?php echo  $k['NOMOR_PO'] ?></td>
											<td><?php echo  $k['LINE_PO'] ?></td>
											<td><?php echo  $k['VENDOR_NAME'] ?></td>
											<td><?php echo  $k['ITEM_DESCRIPTION'] ?></td>
											<td><?php echo 'Rp. '. number_format($k['UNIT_PRICE'],0,'.','.').',00-';
								          	?></td>
								          	<!-- <td><?php echo  $k['UNIT_PRICE'] ?></td> -->
										</tr>
										<?php $no++; } ?>
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