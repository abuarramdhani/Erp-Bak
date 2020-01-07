<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}
</style>
<!-- Notifikasi saat masuk menu Invoice Bermasalah Kasie -->
<?php 
$alert = $status[0]['SATU'];

	if ($alert !== '0' ) { ?>
	<script type="text/javascript">
		$(document).ready(function(){
		$.ajax({
					type: "POST",
					url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceBermasalahBuyer/List/ambilAlert2",
					dataType: 'JSON',
					success: function(response) {
						console.log(response)
					Swal.fire({
  									type: 'error',
  									title: 'Please Re-Check!',
 									text: 'Outstanding Check : Sejumlah '+response+' Invoice bermasalah belum dikonfirmasi!',
									}) 
								}
			 				})
		})
	</script>
<?php }else if ($alert == '0' ) { ?>
	<script type="text/javascript">
		$(document).ready(function(){
		Swal.fire({
  									type: 'success',
  									title: 'All Catched Up!',
 									text: 'Buyer : Seluruh invoice bermasalah sudah dikonfirmasi',
									}) 
								})
	</script>
<?php } ?>

<!-- until here -->
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span><b>List Invoice Bermasalah Buyer</b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<table id="unprocessTabel" class="table table-striped table-bordered table-hover text-center tblMI">
									<thead>
										<tr class="bg-primary">
											<th class="text-center">No</th>
											<th class="text-center">Invoice ID</th>
											<th class="text-center" style="width: 10%">Action</th>
											<th class="text-center">Vendor Name</th>
											<th class="text-center">Invoice Number</th>
											<th class="text-center">PO Number</th>
											<th class="text-center">Creation Date</th>
											<th class="text-left">Masalah</th>
											<th class="text-center">Purchasing Date</th>
											<th class="text-center">Feedback Purchasing</th>
											<th class="text-center">Buyer Date</th>
											<th class="text-center">Feedback Buyer</th>
											<th class="text-center">PIC</th>
										</tr>
									</thead>
									<tbody>
										<?php $no=1; foreach($bermasalah as $u){?>
										<tr>
											<td><?php echo $no ?></td>
											<td><?php echo $u['INVOICE_ID'] ?></td>
											<td> 
												<a title="Konfirmasi..." style="width:100px;margin-bottom: 5px" onclick="KonfirmasiBuyer(<?php echo $u['INVOICE_ID'];?>)" data-target="MdlBuyer" data-toggle="modal" class="btn btn-info btn-sm"><i class="fa fa-file-text-o"></i> Konfirmasi
												</a>

												<a title="Feedback..." style="width:100px;" onclick="FeedbackBuyer(<?php echo $u['INVOICE_ID'];?>)" data-target="MdlBuyer" data-toggle="modal" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Feedback
												</a>

											</td>
											<td><?php echo $u['VENDOR_NAME']?></td>
											<td><strong><?php echo $u['INVOICE_NUMBER']?></strong></td>
											<td><?php echo $u['PO_NUMBER']?></td>
											<td><?php echo $u['AKT_DATE']?></td>
											<td><b>KATEGORI : </b><?php echo $u['KATEGORI_INV_BERMASALAH']?> <br>
												<b>KELENGKAPAN DOKUMEN : </b><?php echo $u['KELENGKAPAN_DOC_INV_BERMASALAH']?> <br>
												<b>KETERANGAN AKUNTANSI : </b><?php echo $u['KETERANGAN_INV_BERMASALAH']?>	
											</td>
											<?php if ($u['PURC_ACTION_BERMASALAH'] == NULL) { ?>
											<td  style="background-color: #ff7a7a47;"><i>Not Yet Set</i></td>
											<?php }else{ ?> 
											<td><?php echo $u['PURC_ACTION_BERMASALAH']?></td>
											<?php } ?>

											<?php if ($u['FEEDBACK_PURCHASING'] == NULL) { ?>
											<td  style="background-color: #ff7a7a47;"><i>Not Yet Confirmed</i></td>
											<?php }else{ ?> 
											<td><b>Purchasing</b> : <?php echo $u['FEEDBACK_PURCHASING']?></td>
											<?php } ?>

											<?php if ($u['BUYER_ACTION_BERMASALAH'] == NULL) { ?>
											<td  style="background-color: #ff7a7a47;"><i>Not Yet Set</i></td>
											<?php }else{ ?> 
											<td><?php echo $u['BUYER_ACTION_BERMASALAH']?></td>
											<?php } ?>

											<?php if ($u['FEEDBACK_BUYER'] == NULL) { ?>
											<td  style="background-color: #ff7a7a47;"><i>Not Yet Confirmed</i></td>
											<?php }else{ ?> 
											<td><b>Buyer</b> : <?php echo $u['FEEDBACK_BUYER']?></td>
											<?php } ?>

											<td><?php echo $u['SOURCE_BERMASALAH']?></td>
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



<div id="MdlBuyer" class="modal fade" role="dialog">
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
		    
		  </div>
		</div>
 	</div>
</div>