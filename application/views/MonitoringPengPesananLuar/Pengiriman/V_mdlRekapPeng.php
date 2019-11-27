<style type="text/css">
tbody.aki_no_table td.blue{
	background-color: #91e2ffd9
}

tbody.aki_no_table td.red{
	background-color: #ff000069
}

</style>

<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="box-header box-primary">
					<div class="row">
						<div class="col-lg-12">
							<div class="text-left ">
								<span><b></i> Detail Rekap Pengiriman Ke- <?php echo $judul[0]['count']?> (PO. <?php echo $judul[0]['no_po']?> )</b></span>
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
											<th class="text-center" title="Delivery QTY">Delivered</th>
											<th class="text-center" title="Delivery QTY">Accumulation</th>
											<th class="text-center" title="Delivery QTY">Outstanding QTY</th>
										</tr>
									</thead>
									<tbody class="aki_no_table">
										<?php $no=1; foreach($detail as $k) { ?>
										<tr>
											<td><?php echo $no ?> </td>
											<td><?php echo  $k['kode_item'] ?></td>
											<td><?php echo  $k['nama_item'] ?></td>
											<td><?php echo  $k['ordered_qty'] ?></td>
											<td><?php echo  $k['uom'] ?></td>
											<?php if ($k['delivered_qty'] == '0') { ?>
											<td class="red"><?php echo  $k['delivered_qty'] ?></td>
											<?php } else { ?>
											<td class="blue"><?php echo  $k['delivered_qty'] ?></td>
											<?php } ?>

											<?php if ($k['accumulation'] == '0') { ?>
											<td class="red"><?php echo  $k['accumulation'] ?></td>
											<?php }else {?>
											<td class="blue"><?php echo  $k['accumulation'] ?></td>
											<?php } ?>

											<?php if ($k['outstanding_qty'] == '0') { ?>
											<td class="red"><?php echo  $k['outstanding_qty'] ?></td>
											<?php }else {?>
											<td class="blue"><?php echo  $k['outstanding_qty'] ?></td>
											<?php } ?>
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