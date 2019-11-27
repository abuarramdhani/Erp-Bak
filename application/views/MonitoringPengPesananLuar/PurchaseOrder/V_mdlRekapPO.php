<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="box-header box-primary">
					<div class="row">
						<div class="col-lg-12">
							<div class="text-left ">
								<span><b></i> Detail Rekap PO No. <?php echo $mdl[0]['id_rekap_po']?></b></span>
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
											<th class="text-center">Kode Item</th>
											<th class="text-center">Nama Item</th>
											<th class="text-center">Qty Order</th>
											<th class="text-center">UOM</th>
										</tr>
									</thead>
									<tbody>
										<?php $no=1; foreach($mdl as $k) { ?>
										<tr>
											<td><?php echo $no ?> </td>
											<td><?php echo  $k['kode_item'] ?></td>
											<td><?php echo  $k['nama_item'] ?></td>
											<td><?php echo  $k['ordered_qty'] ?></td>
											<td><?php echo  $k['uom'] ?></td>
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