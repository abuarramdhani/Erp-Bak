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
					url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceBermasalahKasiePurc/List/ambilAlert",
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
		});
		
	</script>
<?php }else if ($alert == '0' ) { ?>
	<script type="text/javascript">
		$(document).ready(function(){
		Swal.fire({
  									type: 'success',
  									title: 'All Catched Up!',
 									text: 'Purchasing : Seluruh invoice bermasalah sudah dikonfirmasi',
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
							<span><b>List Invoice Bermasalah</b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<div style="overflow: auto;">
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
											<th class="text-center">Masalah</th>
											<th class="text-center">Purchasing Date</th>
											<th class="text-center">Feedback Purchasing</th>
											<th class="text-center">Buyer Date</th>
											<th class="text-center">Feedback Buyer</th>
											<th class="text-center">PIC</th>
											<th class="text-center">Forwarded To</th>
										</tr>
									</thead>
									<tbody> 
										<?php $no=1; foreach($bermasalah as $u){?>
											<?php if ($u['JMLH_N'] != 0) { ?>
										<tr style="background-color: #ff7a7a47;">
											
											<?php }else {?> 
										<tr>
											<?php } ?>
											<td><?php echo $no ?></td>
											<td><?php echo $u['INVOICE_ID'] ?></td>
											<td> 
												<a title="Konfirmasi..." style="width:100px;margin-bottom: 5px" onclick="openMdlPurcConf(<?php echo $u['INVOICE_ID'] ?>)" data-target="mdlPurchasing" data-toggle="modal" class="btn btn-info btn-sm"><i class="fa fa-file-text-o"></i> Konfirmasi</a>

												<button title="Submit ke Buyer ..." style="width:100px;" onclick="submitToBuyer(<?php echo $u['INVOICE_ID'] ?>)" data-target="mdlSubmitBuyer" data-toggle="modal" type="button" class="btn btn-success btn-sm" id="submitToBuyer"><i class="fa fa-paper-plane"></i> Submit</button>

												<button title="Feedback ke Akuntansi ..." style="width:100px;margin-top: 5px" onclick="feedbackAkt(<?php echo $u['INVOICE_ID'] ?>)" type="button" class="btn btn-warning btn-sm" id="submitToBuyer"><i class="fa fa-check"></i> Feedback</button>

												<?php if ($u['BUYER_ACTION_BERMASALAH'] !== NULL) { ?>
												<button data-target="mdlPurchasing" data-toggle="modal" title="Konfirmasi Kembali ..." style="width:100px;margin-top: 5px" onclick="konfirmasiKembaliPurc(<?php echo $u['INVOICE_ID'] ?>)" type="button" class="btn btn-primary btn-sm" id="submitToAkt"><i class="fa fa-exchange"></i> Re-Konfirmasi</button>
												<?php } ?>
												
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
											<?php if ($u['NO_INDUK_BUYER'] == NULL && $u['STATUS_BERKAS_BUYER'] == NULL) { ?>
											<td><span class="label label-default"> UNFORWARDED </span></td>
											<?php }else if ($u['NO_INDUK_BUYER'] !== NULL && $u['STATUS_BERKAS_BUYER'] == NULL) { ?>
											<td><span class="label label-primary"> <?php echo $u['NO_INDUK_BUYER']?> - <?php echo $u['NAMA_BUYER']?></span>
												<br> <span class="label label-danger"><i class="fa fa-times" ></i> BELUM DIKONFIRMASI </span> </td>
											<?php } else {?>
											<td><span class="label label-primary"> <?php echo $u['NO_INDUK_BUYER']?> - <?php echo $u['NAMA_BUYER']?></span>
												<br><span class="label label-success"><i class="fa fa-check" ></i> TELAH DIKONFIRMASI </span>
												<br>
												<?php if ($u['JMLH_N'] != 0) { ?>
												<br><span class="label label-danger"> REJECTED BY BUYER   : <b><?php echo $u['JMLH_N']?></b></span><?php }else { ?> 
												<?php } ?>
											</td>
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

<div id="MdlPurchasing" class="modal fade" role="dialog">
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
