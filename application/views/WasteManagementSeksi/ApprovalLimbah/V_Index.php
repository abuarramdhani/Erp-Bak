<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
                                <h1><b>Approval Limbah</b></h1>
                            </div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('WasteManagementSeksi/ApprovalLimbah') ?>">
									<i class="icon-wrench icon-2x"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
							</div>
							<div class="box-body">
								<div class="table-responsive">
									<table class="datatable table table-striped table-bordered table-hover text-left dataTable-limbah" style="font-size: 12px;">
										<thead class="bg-primary">
											<tr>
												<td>No</td>
												<td>Action</td>
												<td>Seksi Asal Limbah</td>
												<td>Pekerja Pengirim</td>
												<td>Tanggal Kirim</td>
												<td>Waktu Kirim</td>
												<td>Jenis limbah</td>
												<td>Jumlah</td>
											</tr>
										</thead>
										<tbody>
											<?php $no = 1; foreach ($LimbahKirim as $key):														
													$status = "";
													$encrypted_string = $this->encrypt->encode($key['id_kirim']);
                                                	$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);

													$bocor = 'Tidak';

													if ($key['bocor']=='1') {
														$bocor = 'Ya';
													}else{
														$bocor = 'Tidak';
													}

													$approve = base_url('WasteManagementSeksi/ApprovalLimbah/Approve/'.$encrypted_string);
													$reject = base_url('WasteManagementSeksi/ApprovalLimbah/Reject/'.$encrypted_string);
											?>
													
											<tr>
												<td style="text-align: center;"><?php echo $no; ?></td>
												<td>
													<a data-href="<?= $approve ?>" class="btn btn-success btn-sm approveLimbah">Approve</a>
													<a data-href="<?= $reject ?>" class="btn btn-danger btn-sm rejectLimbah">Reject</a>
												</td>
												<td><?php echo $key['section_name']; ?></td>
												<td><?php echo $key['noind_pengirim']; ?></td>
												<td><?php echo $key['tanggal']; ?></td>
												<td><?php echo $key['waktu']; ?></td>
												<td><?php echo $key['jenis_limbah']; ?></td>
												<?php
													$satuan = ($key['id_satuan'] == NULL) ? $key['limbah_satuan'] : $key['satuan'];
												?>
												<td><?php echo $key['jumlah_kirim']." ".$satuan ; ?></td>
											</tr>
											<?php $no++; endforeach ?>
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
<script type="text/javascript">
	$('.approveLimbah, .rejectLimbah').on('click', function(e){
		e.preventDefault()
		const url = $(this).data('href')
		
		swal.fire({
			title: 'Yakin melakukan approval ?',
			text: '',
			showCancelButton: true,
			type: 'question'
		}).then(e => {
			if(e.value) {
				window.location.href = url
			}
		})

	})
</script>
