<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}

</style>

<?php 
$alert = $status[0]['ENAM'];

	if ($alert !== '0' ) { ?>

	<script type="text/javascript">
		$(document).ready(function(){

			$.ajax({
					type: "POST",
					url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceBermasalahAkt/ambilAlertEnam",
					dataType: 'JSON',
					success: function(response) {
						console.log(response)
					Swal.fire({
  									type: 'info',
  									title: 'Reminder!',
 									text: 'Outstanding Check : Sejumlah '+response+' Invoice dikembalikan ke Purchasing!',
									}) 
								}
			 				})
		});
		
	</script>
<?php }else if ($alert == '0' ) { ?>
	<script type="text/javascript">
		$(document).ready(function(){
					Swal.fire({
  									type: 'success',
  									title: 'All Catched Up!',
 									text: 'Akuntansi : Tidak ada Invoice yang dikembalikan ke Purchasing',
									}) 
								})
	</script>
<?php } ?>
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<!-- <div class="text-right ">
					<a class="btn btn-info btn-lg" target="_blank" href="<?php echo site_url('AccountPayables/MonitoringInvoice/InvoiceBermasalahAkt/newInvBermasalah');?>">
						<i class="icon-plus icon-2x"></i>
							<span ><br /></span>
					</a>
				</div> -->
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span><b>Invoice Returned to Purchasing</b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<div style="overflow: auto;">
								<table id="unprocessTabel" style="min-width:110%" class="table table-striped table-bordered table-hover text-center tblMI">
									<thead>
										<tr class="bg-primary">
											<th class="text-center">No</th>
											<th class="text-center">Invoice ID</th>
											<th class="text-center" style="width: 10%">Action</th>
											<th class="text-center">Vendor Name</th>
											<th class="text-center">Invoice Number</th>
											<th class="text-center">Invoice Date</th>
											<th class="text-center">PPN</th>
											<th class="text-center">PO Number</th>
											<th class="text-center">Creation Date </th>
											<th class="text-left" style="width: 30%">Masalah </th>
											<th class="text-left" style="width: 30%">Feedback Purchasing</th>
											<th class="text-center">Purchasing Date</th>
											<th class="text-center">Tracking</th>
											<th class="text-center">Returned Date AKT</th>
											<th class="text-center">Returned Date PURC</th>
											<th class="text-center">PIC</th>
										</tr>
									</thead>
									<tbody>
										<?php $no=1; foreach($bermasalah as $u){?>
											<?php if ($u['JMLH_N'] != 0) { ?>
										<tr style="background-color: #ff7a7a47">
											<?php }else { ?>
										<tr>
											<?php }?>
											<td><?php echo $no ?></td>
											<td><?php echo $u['INVOICE_ID'] ?></td>
											<td data-id="<?= $u['INVOICE_ID'] ?>" batch_number="<?= $u['BATCH_NUMBER'] ?>" class="ganti_<?= $u['INVOICE_ID'] ?>">

												<!-- DETAIL INVOICE -->
													<a title="Detail..." style="width:100px;margin-bottom: 5px" target="_blank" href="<?php echo base_url('AccountPayables/MonitoringInvoice/Unprocess/DetailInvBermasalah/'.$u['INVOICE_ID']);?>" class="btn btn-info btn-sm"><i class="fa fa-file-text-o"></i> Detail
													</a>

													<!-- HASIL KONFIRMASI -->
													<a title="Hasil Konfirmasi..." style="width:100px;margin-bottom: 5px" onclick="bukaHasilConf(<?php echo $u['INVOICE_ID']?>)" class="btn btn-warning btn-sm" data-target="MdlAkuntansi" data-toggle="modal"><i class="fa fa-external-link"></i> Checklist
													</a>

													<a title="Selesaikan Invoice..." style="width:100px;margin-bottom: 5px" onclick="selesaikanInvoice(<?php echo $u['INVOICE_ID']?>)" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Selesaikan
													</a>

													<a title="Kembalikan Invoice..." style="width:100px;margin-bottom: 5px" onclick="returnedInvoice(<?php echo $u['INVOICE_ID']?>)" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Kembalikan
													</a>

											</td>

											<td><?php echo $u['VENDOR_NAME']?></td>
											<td><strong><?php echo $u['INVOICE_NUMBER']?></strong></td>
											<td data-order="<?php echo date('Y-m-d', strtotime($u['INVOICE_DATE']))?>"><?php echo date('d-M-Y',strtotime($u['INVOICE_DATE']))?></td>
											<td><?php echo $u['PPN'] ?></td>
											<td><?php echo $u['PO_NUMBER']?></td>
											<td data-order="<?php echo date('Y-m-d', strtotime($u['AKT_DATE']))?>"><b><?php echo $u['AKT_DATE']?></b></td>
											<td><b>KATEGORI : </b><?php echo $u['KATEGORI_INV_BERMASALAH']?> <br>
												<b>KELENGKAPAN DOKUMEN : </b><?php echo $u['KELENGKAPAN_DOC_INV_BERMASALAH']?> <br>
												<b>KETERANGAN : </b><?php echo $u['KETERANGAN_INV_BERMASALAH']?>	
											</td>

											<?php if ($u['FEEDBACK_PURCHASING'] !== NULL) { ?>
											<td><b>Purchasing</b> : <?php echo $u['FEEDBACK_PURCHASING']?></td>
											<?php }else { ?>
											<td><i>Not Yet Confirmed</i></td>
											<?php } ?>

											<?php if ($u['PURC_DATE'] == NULL) { ?>
											<td><i>Not Yet Confirmed</i></b></td>
											<?php }else{ ?>
											<td data-order="<?php echo date('Y-m-d', strtotime($u['PURC_DATE']))?>"><b><?php echo $u['PURC_DATE']?></b></td>
											<?php } ?>

											<!-- STATUS INVOICE BERMASALAG 1, 2, 3, 4, 5, 6 -->
											<?php if ($u['STATUS_INV_BERMASALAH'] == 1) { ?>
											<td><span class="label label-default"><i class="fa fa-paper-plane"></i> Send to Purchasing &nbsp;</span></td>
											<?php } else if ($u['STATUS_INV_BERMASALAH'] == 2  ) { ?>
											<td><span class="label label-primary" style="padding-bottom: 5px;"><i class="fa fa-check"></i> Checked by Purchasing &nbsp;</span>
												<?php if ($u['JMLH_N'] != 0) {?>
												 	<br><br><span class="label label-danger" style="padding-bottom: 5px;"> Document Rejected   : <b><?php echo $u['JMLH_N']?></b></span>
												<?php } ?>
											</td>

											<?php } else if ($u['STATUS_INV_BERMASALAH'] == 3) {?> 
											<td><span class="label label-warning"><i class="fa fa-paper-plane"></i> Purchasing Send to Buyer &nbsp;</span>
												
												 <?php if ($u['JMLH_N'] != 0) {?>
												 	<br><br><span class="label label-danger" style="padding-bottom: 5px;"> Document Rejected   : <b><?php echo $u['JMLH_N']?></b></span>
												<?php } ?>
											</td>

											<?php } else if ($u['STATUS_INV_BERMASALAH'] == 4) {?>
											<td><span class="label label-success"><i class="fa fa-check"></i> Checked by Purchasing &nbsp;</span>
												 
												 <?php if ($u['JMLH_N'] != 0) {?>
												 	<br><br><span class="label label-danger" style="padding-bottom: 5px;"> Document Rejected   : <b><?php echo $u['JMLH_N']?></b></span>
												<?php } ?>
											</td>

											<?php } else if ($u['STATUS_INV_BERMASALAH'] == 5) {?>
											<td><span class="label label-success"><i class="fa fa-check"></i> Approved by Akuntansi &nbsp;</span>
												
												<?php if ($u['JMLH_N'] != 0) {?>
												 	<br><br><span class="label label-danger" style="padding-bottom: 5px;"> Document Rejected   : <b><?php echo $u['JMLH_N']?></b></span>
												<?php } ?>
											</td>
											<?php } else if ($u['RETURNED_FLAG'] == 'Y'){ ?>
												<td><span class="label label-primary"><i class="fa fa-paper-plane"></i> Returned to Purchasing &nbsp;</span>
												
												<?php if ($u['JMLH_N'] != 0) {?>
												 	<br><br><span class="label label-danger" style="padding-bottom: 5px;"> Document Rejected   : <b><?php echo $u['JMLH_N']?></b></span>
												<?php } ?>
											</td>
											<?php } ?>
											<td><?php echo $u['RETURNED_DATE_AKT']?></td>
											<td><?php echo $u['RETURNED_DATE_PURC']?></td>

											<?php if ($u['SOURCE_BERMASALAH'] !== 'BUYER') { ?>  
											<td><?php echo $u['SOURCE_BERMASALAH']?></td>
											<?php }else { ?>
											<td>PURCHASING</td>
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
</section>	

<div id="MdlAkuntansi" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width:800px" role="document">
		<div class="modal-content"  id="content1" >
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		    <h5 class="modal-title"></h5>
		  </div>
		  <div class="modal-body">
		    <div class="row">
		      <div class="col-md-12">
		      	<center>
		      		
		      	</select>
		      	<center>
		      </div>
		    </div>
		  </div>
		  <div class="modal-footer">
		  	<h5 class="modal-title-footer pull-left"></h5>
		  </div>
		</div>
 	</div>
</div>