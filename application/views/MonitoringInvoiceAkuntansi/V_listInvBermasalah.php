<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}

</style>

<?php 
$alert = $status[0]['SATU'];

	if ($alert !== '0' ) { ?>

	<script type="text/javascript">
		$(document).ready(function(){

			$.ajax({
					type: "POST",
					url: baseurl+"AccountPayables/MonitoringInvoice/InvoiceBermasalahAkt/ambilAlert",
					dataType: 'JSON',
					success: function(response) {
						console.log(response)
					Swal.fire({
  									type: 'info',
  									title: 'Please Re-Check!',
 									text: 'Outstanding Check : Sejumlah '+response+' Invoice perlu direkonfirmasi dan diselesaikan!',
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
 									text: 'Akuntansi : Seluruh invoice bermasalah sudah dikonfirmasi',
									}) 
								})
	</script>
<?php } ?>
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="text-right ">
					<a class="btn btn-info btn-lg" target="_blank" href="<?php echo site_url('AccountPayables/MonitoringInvoice/InvoiceBermasalahAkt/newInvBermasalah');?>">
						<i class="icon-plus icon-2x"></i>
							<span ><br /></span>
					</a>
				</div>
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
								<table id="unprocessTabel" style="min-width:130%" class="table table-striped table-bordered table-hover  tblMI">
									<thead>
										<tr class="bg-primary">
											<th class="text-center">No</th>
											<th class="text-center" style="display: none">Parameter</th>
											<th class="text-center">Invoice ID</th>
											<th class="text-center" style="width: 10%">Action</th>
											<th class="text-center">Vendor Name</th>
											<th class="text-center">Invoice Number</th>
											<th class="text-center">Invoice Date</th>
											<th class="text-center">PPN</th>
											<th class="text-center">PO Number</th>
											<th class="text-center">Creation Date </th>
											<th class="text-center" style="width: 30%">Masalah </th>
											<th class="text-center" style="width: 30%">Feedback Purchasing</th>
											<th class="text-center">Purchasing Date</th>
											<th class="text-center">Tracking</th>
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
											<td class="text-center"><?php echo $no ?></td>
											<td class="text-center" style="display: none"><input type="hidden" id="hdnRestatus" value="<?php echo $u['RESTATUS_BERKAS_AKT'] ?>"></td>
											<td class="text-center"><b><?php echo $u['INVOICE_ID'] ?></b></td>
											<td class="text-center" data-id="<?= $u['INVOICE_ID'] ?>" batch_number="<?= $u['BATCH_NUMBER'] ?>" class="ganti_<?= $u['INVOICE_ID'] ?>">

												<!-- DETAIL INVOICE -->
												<a title="Detail..." style="width:100px;margin-bottom: 5px" target="_blank" href="<?php echo base_url('AccountPayables/MonitoringInvoice/Unprocess/DetailInvBermasalah/'.$u['INVOICE_ID']);?>" class="btn btn-info btn-sm"><i class="fa fa-file-text-o"></i> Detail
												</a>
												<?php if ($u['SOURCE_BERMASALAH'] == 'AKUNTANSI'){ ?>
												<a title="Delete..." style="width:100px;margin-bottom: 5px" onclick="resetInvBermasalah(<?php echo $u['INVOICE_ID']?>)" class="btn btn-default btn-sm"><i class="fa fa-trash"></i> Delete
												</a>
												<?php } ?>

												<!-- HASIL KONFIRMASI -->
												<?php if ($u['STATUS_INV_BERMASALAH'] != 1) { ?>
												<a title="Hasil Konfirmasi..." style="width:100px;margin-bottom: 5px" onclick="bukaHasilConf(<?php echo $u['INVOICE_ID']?>)" class="btn btn-warning btn-sm" data-target="MdlAkuntansi" data-toggle="modal"><i class="fa fa-external-link"></i> Checklist
												</a>
												<?php } ?>

												<!-- REKONFIRMASI -->
												<?php if ($u['RESTATUS_BERKAS_AKT'] == NULL && $u['NO_INDUK_BUYER'] !== '' ) { ?>

													<?php if ($u['RESTATUS_BERKAS_PURC'] == NULL ) { ?>
													<!-- JIKA PURCHASING TIDAK MEMBERI RESTATUS -->
												
													<?php }else {?>
													<button data-target="MdlAkuntansi" data-toggle="modal" title="Konfirmasi Kembali ..." style="width:100px;margin-bottom: 5px" onclick="konfirmasiKembaliAkt(<?php echo $u['INVOICE_ID'] ?>)" type="button" class="btn btn-primary btn-sm" id="submitToAkt"><i class="fa fa-exchange"></i> Re-Konfirmasi</button>
													<?php } ?>

												<?php } ?>

												<!-- SELESAIKAN DAN KEMBALIKAN INVOICE -->
												<?php if ($u['STATUS_INV_BERMASALAH'] == 4 || $u['STATUS_INV_BERMASALAH'] == 2 ) { ?>

													<?php if ($u['FEEDBACK_PURCHASING'] == '' || $u['FEEDBACK_PURCHASING'] == NULL ) { ?>
														<a disabled title="Selesaikan Invoice..." style="width:100px;margin-bottom: 5px" onclick="selesaikanInvoice(<?php echo $u['INVOICE_ID']?>)" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Selesaikan
														</a>

														<a data-target="MdlAkuntansi" data-toggle="modal" disabled title="Kembalikan Invoice..." style="width:100px;margin-bottom: 5px" onclick="openReturnedInv(<?php echo $u['INVOICE_ID']?>)" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Kembalikan
													</a>
													<?php } else {?>
														<a title="Selesaikan Invoice..." style="width:100px;margin-bottom: 5px" onclick="selesaikanInvoice(<?php echo $u['INVOICE_ID']?>)" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Selesaikan
														</a>

														<a data-target="MdlAkuntansi" data-toggle="modal" title="Kembalikan Invoice..." style="width:100px;margin-bottom: 5px" onclick="openReturnedInv(<?php echo $u['INVOICE_ID']?>)" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Kembalikan
													</a>
													<?php } ?>

													

												<?php } ?>
											</td>

											<td class="text-center"><?php echo $u['VENDOR_NAME']?></td>
											<td class="text-center"><strong><?php echo $u['INVOICE_NUMBER']?></strong></td>
											<td class="text-center" data-order="<?php echo date('Y-m-d', strtotime($u['INVOICE_DATE']))?>"><?php echo date('d-M-Y',strtotime($u['INVOICE_DATE']))?></td>
											<td class="text-center"><?php echo $u['PPN'] ?></td>
											<td class="text-center"><?php echo $u['PO_NUMBER']?></td>
											<td class="text-center" data-order="<?php echo date('Y-m-d', strtotime($u['AKT_DATE']))?>"><b><?php echo $u['AKT_DATE']?></b></td>
											<td class="text-left"><b>KATEGORI : </b><?php echo $u['KATEGORI_INV_BERMASALAH']?> <br>
												<b>KELENGKAPAN DOKUMEN : </b><?php echo $u['KELENGKAPAN_DOC_INV_BERMASALAH']?> <br>
												<b>KETERANGAN : </b><?php echo $u['KETERANGAN_INV_BERMASALAH']?> 
											</td>

											<?php if ($u['FEEDBACK_PURCHASING'] !== NULL) { ?>
											<td class="text-left"><b>Purchasing</b> : <?php echo $u['FEEDBACK_PURCHASING']?></td>
											<?php }else { ?>
											<td class="text-center"><i>Not Yet Confirmed</i></td>
											<?php } ?>

											<?php if ($u['PURC_DATE'] == NULL) { ?>
											<td class="text-center" ><i>Not Yet Confirmed</i></b></td>
											<?php }else{ ?>
											<td class="text-center" data-order="<?php echo date('Y-m-d', strtotime($u['PURC_DATE']))?>"><b><?php echo $u['PURC_DATE']?></b></td>
											<?php } ?>

											<!-- STATUS INVOICE BERMASALAG 1, 2, 3, 4, 5, 6 -->
											<?php if ($u['STATUS_INV_BERMASALAH'] == 1) { ?>
											<td class="text-center"><span class="label label-default"><i class="fa fa-paper-plane"></i> Send to Purchasing &nbsp;</span></td>
											<?php } else if ($u['STATUS_INV_BERMASALAH'] == 2  ) { ?>
											<td class="text-center"><span class="label label-primary" style="padding-bottom: 5px;"><i class="fa fa-check"></i> Checked by Purchasing &nbsp;</span>
												<?php if ($u['JMLH_N'] != 0) {?>
												 	<br><br><span class="label label-danger" style="padding-bottom: 5px;"> Document Rejected   : <b><?php echo $u['JMLH_N']?></b></span>
												<?php } ?>
												<?php if ($u['RESTATUS_BERKAS_AKT'] !== NULL){ ?>
													<br><br><span class="label label-default" style="padding-bottom: 5px;"> Akuntansi sudah rekonfirmasi berkas </b></span>
												<?php } ?>
											</td>

											<?php } else if ($u['STATUS_INV_BERMASALAH'] == 3) {?> 
											<td class="text-center"><span class="label label-warning"><i class="fa fa-paper-plane"></i> Purchasing Send to Buyer &nbsp;</span>
												
												 <?php if ($u['JMLH_N'] != 0) {?>
												 	<br><br><span class="label label-danger" style="padding-bottom: 5px;"> Document Rejected   : <b><?php echo $u['JMLH_N']?></b></span>
												<?php } ?>
												<?php if ($u['RESTATUS_BERKAS_AKT'] !== NULL){ ?>
													<br><br><span class="label label-default" style="padding-bottom: 5px;"> Akuntansi sudah rekonfirmasi berkas </b></span>
												<?php } ?>
											</td>

											<?php } else if ($u['STATUS_INV_BERMASALAH'] == 4) {?>
											<td class="text-center"><span class="label label-primary"><i class="fa fa-check"></i> Checked by Purchasing &nbsp;</span>
												 
												 <?php if ($u['JMLH_N'] != 0) {?>
												 	<br><br><span class="label label-danger" style="padding-bottom: 5px;"> Document Rejected   : <b><?php echo $u['JMLH_N']?></b></span>
												<?php } ?>
												<?php if ($u['RESTATUS_BERKAS_AKT'] !== NULL){ ?>
													<br><br><span class="label label-default" style="padding-bottom: 5px;"> Akuntansi sudah rekonfirmasi berkas </b></span>
												<?php } ?>

											</td>

											<?php } else if ($u['STATUS_INV_BERMASALAH'] == 5) {?>
											<td class="text-center"><span class="label label-success"><i class="fa fa-check"></i> Approved by Akuntansi &nbsp;</span>
												
												<?php if ($u['JMLH_N'] != 0) {?>
												 	<br><br><span class="label label-danger" style="padding-bottom: 5px;"> Document Rejected   : <b><?php echo $u['JMLH_N']?></b></span>
												<?php } ?>
												<?php if ($u['RESTATUS_BERKAS_AKT'] !== NULL){ ?>
													<br><br><span class="label label-default" style="padding-bottom: 5px;"> Akuntansi sudah rekonfirmasi berkas </b></span>
												<?php } ?>

											</td>
											<?php } else if ($u['STATUS_INV_BERMASALAH'] == 6){ ?>
												<td class="text-center"><span class="label label-success"><i class="fa fa-check"></i> Returned to Purchasing &nbsp;</span>
												
												<?php if ($u['JMLH_N'] != 0) {?>
												 	<br><br><span class="label label-danger" style="padding-bottom: 5px;"> Document Rejected   : <b><?php echo $u['JMLH_N']?></b></span>
												<?php } ?>
												<?php if ($u['RESTATUS_BERKAS_AKT'] !== NULL){ ?>
													<br><br><span class="label label-default" style="padding-bottom: 5px;"> Akuntansi sudah rekonfirmasi berkas </b></span>
												<?php } ?>

											</td>
											<?php } ?>


											<?php if ($u['SOURCE_BERMASALAH'] !== 'BUYER') { ?>  
											<td class="text-center"><?php echo $u['SOURCE_BERMASALAH']?></td>
											<?php }else { ?>
											<td class="text-center">PURCHASING</td>
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
		  	<div class="pull-right btnDiv"></div>
		  </div>
		</div>
 	</div>
</div>