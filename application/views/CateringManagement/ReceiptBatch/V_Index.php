<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Catering Receipt</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('CateringManagement/ReceiptBatch');?>">
                                <i class="icon-wrench icon-2x"></i>
                                <span><br/></span>
                            </a>
						</div>
					</div>
				</div>
			</div>
			<br/>

			<div class="row">
				<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						<a href="<?php echo site_url('CateringManagement/ReceiptBatch/Create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
							<button type="button" class="btn btn-default btn-sm">
							  <i class="icon-plus icon-2x"></i>
							</button>
						</a>
						<b>Catering Receipt</b>
					</div>
					<div class="box-body">

						<div class="table-responsive" style="overflow:hidden;">
							<table class="table table-striped table-bordered table-hover text-left dataTable_receipt" style="font-size:14px;">
								<thead class="bg-primary">
									<tr>
										<th width="3%">NO</th>
										<th width="10%">RECEIPT NO.</th>
										<th width="28%">RECEIPT SIGN DETAIL</th>
										<th width="25%">ORDER DESCRIPTION</th>
										<th width="5%">ORDER QTY</th>
										<th width="15%">ORDER PRICE</th>
										<th width="18%">PAYMENT NOMINAL</th>
										<th width="6%">ACTION</th>
									</tr>
								</thead>
								<tbody>
									<?php $no = 0; foreach($Receipt as $rc) { $no++ ?>
										<tr>
											<td><?php echo $no; ?></td>
											<td><?php echo $rc['receipt_no'] ?></td>
											<td><?php echo $rc['receipt_place'].', '.$rc['receipt_date'].' BY '.$rc['receipt_signer'] ?></td>
											<td><?php echo $rc['type_description'].' '.$rc['catering_name'] ?> (<?php echo $rc['order_start_date'] ?> - <?php echo $rc['order_end_date'] ?>)</td>
											<td><?php echo $rc['order_qty'] ?></td>
											<td>Rp <?php echo number_format($rc['order_price'], 2 , ',' , '.' ) ?></td>
											<td>Rp <?php echo number_format($rc['payment'], 2 , ',' , '.' ) ?></td>
											<td align="center"><a data-toggle="tooltip" title="Details" href='<?php echo site_URL() ?>CateringManagement/ReceiptBatch/Details/<?php echo $rc['receipt_id'] ?>' class="btn btn-success btn-sm"><i class="fa fa-newspaper-o"></i></a></td>
										</tr>
									<?php } ?>
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
