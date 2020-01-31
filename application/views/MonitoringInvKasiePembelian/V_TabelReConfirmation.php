<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
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
											<th class="text-center">Hasil Konfirmasi (Buyer)</th>
											<th class="text-center">Date Confirmation (Buyer)</th>
											<th class="text-center">Hasil Re-Konfirmasi (Purchasing)</th>
											<th class="text-center">Date Re-Confirmation (Purchasing)</th>
										</tr>
									</thead>
									<tbody>
									<?php $no=1; foreach ($berkas as $k) { ?>
										<tr>
											<td><?php echo $no?></td>
											<td><?php echo $k['DOCUMENT_NAME']?><input type="hidden" id="nama_dokumen" value="<?php echo $k['DOCUMENT_NAME']?>"></td>
											<td style="display: none"><input type="hidden" id="dokumen_id" value="<?php echo $k['DOCUMENT_ID']?>"></td>
											<td>
												<button type="button" class="btn btn-success btn-sm" onclick="btnReApproveBerkas(this)" id="btnApproved" style="margin-right: 5px"><i class="fa fa-check"></i></button>
												<button type="button" onclick="btnReRejectBerkas(this)" class="btn btn-danger btn-sm" id="btnApproved"><i class="fa fa-times"></i></button>
											</td>
											<?php if ($k['STATUS_DOCUMENT_BUYER'] == 'Y') { ?>
											<td><input type="hidden" id="buyer_id">
												<div class="hasil_buyer"><span class="label label-success"><i class="fa fa-check"></i> Diterima<br></span></div>
											</td>
											<?php }else if ($k['STATUS_DOCUMENT_BUYER'] == 'N') {?> 
											<td><input type="hidden" id="buyer_id">
												<div class="hasil_buyer"><span class="label label-danger label-sm"><i class="fa fa-times"></i> Ditolak<br></span></div>
											</td>
											<?php }else{ ?>
											<td><input type="hidden" id="buyer_id">
												<div class="hasil_buyer"></div>
											</td>
											<?php } ?>

											<td><input type="hidden" value="<?php echo $k['DATE_CONFIRMATION_BUYER']?>" id="inputDateBuyer"><div class="date_buyer"><?php echo $k['DATE_CONFIRMATION_BUYER']?></div></td>

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