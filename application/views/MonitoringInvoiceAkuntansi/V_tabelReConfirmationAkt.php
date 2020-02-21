
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<!-- <table>
							<tr>
								<td style="padding-right: 10px">
									<span><label>Invoice ID</label></span>
								</td>
								<td style="padding-bottom:10px">
									<input type="text" class="form-control" value="<?php echo $invoice ?>" disabled>
								</td>
							</tr>
							<tr>
								<td style="padding-right:10px">
									<span><label>Feedback Purchasing</label></span>
								</td>
								<td>
									<textarea id="txaFbPurc" class="form-control" style="width:300px; margin-bottom:10px"><?php echo $feedback[0]['FEEDBACK_PURCHASING']?></textarea>
								</td>
							</tr>
						</table> -->
						<br/>
					  		<div id="tableHolder">
						<div class="box box-primary">
								<div class="box-body">
									<table id="tbpr" class="table table-striped table-bordered table-hover text-center">
									<thead>
										<tr class="bg-primary">
											<th class="text-center">No</th>
											<th class="text-center" style="display: none">Nomor Dokumen</th>
											<th class="text-center">Nama Dokumen</th>
											<th class="text-center" style="width: 20%">Action</th>
											<th class="text-center">Hasil Re-Konfirmasi (Purchasing)</th>
											<th class="text-center">Date Re-Confirmation (Purchasing)</th>
											<th class="text-center">Hasil Re-Konfirmasi (Akuntansi)</th>
											<th class="text-center">Date Re-Confirmation (Akuntansi)</th>
										</tr>
									</thead>
									<tbody>
									<?php $no=1; foreach ($berkas as $k) { ?>
										<tr>
											<td><?php echo $no?></td>
											<td><?php echo $k['DOCUMENT_NAME']?><input type="hidden" id="nama_dokumen" value="<?php echo $k['DOCUMENT_NAME']?>"></td>
											<td style="display: none"><input type="hidden" id="dokumen_id" value="<?php echo $k['DOCUMENT_ID']?>"></td>
											<td>
												<button type="button" class="btn btn-success btn-sm" onclick="btnReApproveBerkasAkt(this)" id="btnApproved" style="margin-right: 5px"><i class="fa fa-check"></i></button>
												<button type="button" onclick="btnReRejectBerkasAkt(this)" class="btn btn-danger btn-sm" id="btnApproved"><i class="fa fa-times"></i></button>
											</td>
											<?php if ($k['RESTATUS_DOCUMENT_PURC'] == 'Y') { ?>
											<td><input type="hidden" id="repurc_id">
												<div class="hasil_buyer"><span class="label label-success"><i class="fa fa-check"></i> Diterima<br></span></div>
											</td>
											<?php }else if ($k['RESTATUS_DOCUMENT_PURC'] == 'N') {?> 
											<td><input type="hidden" id="repurc_id">
												<div class="hasil_buyer"><span class="label label-danger label-sm"><i class="fa fa-times"></i> Ditolak<br></span></div>
											</td>
											<?php }else{ ?>
											<td><input type="hidden" id="repurc_id">
												<div class="hasil_repurc"></div>
											</td>
											<?php } ?>

											<td><input type="hidden" value="<?php echo $k['REDATE_CONFIRMATION_PURC']?>" id="inputDateRePurc"><div class="date_repurc"><?php echo $k['REDATE_CONFIRMATION_PURC']?></div></td>

											<?php if ($k['RESTATUS_DOCUMENT_AKT'] == 'Y') { ?>
											<td><input type="hidden" id="reakt_id">
												<div class="hasil_akt"><span class="label label-success"><i class="fa fa-check"></i> Diterima<br></span></div>
											</td>
											<?php }else if ($k['RESTATUS_DOCUMENT_AKT'] == 'N') {?> 
											<td><input type="hidden" id="reakt_id">
												<div class="hasil_akt"><span class="label label-danger label-sm"><i class="fa fa-times"></i> Ditolak<br></span></div>
											</td>
											<?php }else{ ?>
											<td><input type="hidden" id="reakt_id">
												<div class="hasil_akt"></div>
											</td>
											<?php } ?>

											<td><input type="hidden" value="<?php echo $k['REDATE_CONFIRMATION_AKT']?>" id="inputDateReAkt"><div class="date_reakt"><?php echo $k['REDATE_CONFIRMATION_AKT']?></div></td>
										</tr>
									<?php $no++; }  ?>
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