
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
											<th class="text-center">Nama Dokumen</th>
											<th class="text-center">Hasil Konfirmasi (Purchasing)</th>
											<th class="text-center">Date Confirmation (Purchasing)</th>
										</tr>
									</thead>
									<tbody>
									<?php $no=1; foreach ($berkas as $k) { ?>
										<tr>
											<td><?php echo $no?></td>
											<td><?php echo $k['DOCUMENT_NAME']?><input type="hidden" id="nama_dokumen" value="<?php echo $k['DOCUMENT_NAME']?>"></td>
											<?php if ($k['STATUS_DOCUMENT_PURC'] == 'Y') { ?>
											<td><input type="hidden" value="Y" id="pembelian_id">
												<div class="hasil_pembelian"><span class="label label-success"><i class="fa fa-check"></i> Diterima<br></span></div>
											</td>
											<?php }else if ($k['STATUS_DOCUMENT_PURC'] == 'N') {?> 
											<td><input type="hidden" value="N" id="pembelian_id">
												<div class="hasil_pembelian"><span class="label label-danger label-sm"><i class="fa fa-times"></i> Ditolak<br></span></div>
											</td>
											<?php }else{ ?>
											<td><input type="hidden" id="pembelian_id">
												<div class="hasil_pembelian"></div>
											</td>
											<?php } ?>
											<td><input type="hidden" value="<?php echo $k['DATE_CONFIRMATION_PURC']?>" id="inputDatePurc"><div class="date_purc"><?php echo $k['DATE_CONFIRMATION_PURC']?></div></td>
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