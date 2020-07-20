<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11 text-right">
							<h1><b><?=$Title ?></b></h1>
						</div>
						<div class="col-lg-1 text-right hidden-md hiddem-sm hidden-xs">
							<a href="<?php echo site_url('WasteManagement/LimbahKelola') ?>" class="btn btn-default btn-lg"><span class="fa fa-wrench fa-2x"></span></a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<?php
							$status = $LimbahKirim['0']['status_kirim'];
							$color = 'primary';

							if($status == '1') {
								$color = 'success';
							} else if($status == '2') {
								$color = 'danger';
							}
						?>
						<div class="box box-<?= $color ?> box-solid">
							<div class="box-header with-border">

							</div>
							<div class="box-body">
								<div class="panel-body">
									<?php
									$encrypted_text = $this->encrypt->encode($LimbahKirim['0']['id_kirim']);
									$encrypted_text = str_replace(array('+','/','='), array('-','_','~'), $encrypted_text);
									?>
									<form action="<?php echo site_url('WasteManagement/KirimanMasuk/Approve/'.$encrypted_text) ?>" method="POST" class="form form-horizontal">
										<div class="row">
											<div class="col-lg-4">
												<div class="form-group">
													<label for="txtSeksi" class="form-label col-lg-12">Seksi Pengirim</label>
													<div class="col-lg-12">
														<input type="text" name="txtSeksi" value="<?php echo $LimbahKirim['0']['seksi']; ?>" class="form-control" disabled>
													</div>

												</div>
												<div class="form-group">
													<label for="txtTanggal" class="form-label col-lg-12">tanggal Kirim</label>
													<div class="col-lg-12">
														<input type="text" name="" value="<?php echo $LimbahKirim['0']['tanggal']; ?>" class="form-control" disabled>
													</div>
												</div>
												<div class="form-group">
													<label for="" class="form-label col-lg-12">Waktu Kirim</label>
													<div class="col-lg-12">
														<input type="text" name="txtTanggal" value="<?php echo $LimbahKirim['0']['waktu']; ?>" class="form-control" disabled>
													</div>
												</div>
											</div>
											<div class="col-lg-4">
												<div class="form-group">
													<label for="txtWaktu" class="form-label col-lg-12">Jenis Limbah</label>
													<div class="col-lg-12">
														<input type="text" name="txtWaktu" value="<?php echo $LimbahKirim['0']['jenis_limbah']; ?>" class="form-control" disabled>
													</div>
												</div>
												<div class="form-group">
													<label for="txtJumlah" class="form-label col-lg-12">Jumlah</label>
													<div class="col-lg-12">
														<input type="text" name="txtJumlah" value="<?php if($LimbahKirim['0']['id_satuan'] == NULL){ echo $LimbahKirim['0']['jumlah'];}else{ echo $LimbahKirim['0']['jumlahall'];} ?>" class="form-control" disabled>
													</div>
												</div>
												<div class="form-group">
													<label for="txtKon" class="form-label col-lg-12">Kondisi</label>
													<div class="col-lg-12">
														<input type="text" name="txtKon" value="<?php $bocor = $LimbahKirim['0']['bocor'];if($bocor == '1'){echo "Bocor";}else{echo "Tidak Bocor";}; ?>" class="form-control" disabled>
													</div>
												</div>
											</div>
											<div class="col-lg-4">
												<div class="form-group">
													<label for="txtKon" class="form-label col-lg-12">Pekerja Pengirim</label>
													<div class="col-lg-12">
														<input type="text" name="txtpeng" value="<?php echo $LimbahKirim['0']['pekerja']; ?>" class="form-control" disabled>
													</div>
												</div>
												<div class="form-group">
													<label for="txtLokasi" class="form-label col-lg-12">Lokasi Kerja</label>
													<div class="col-lg-12">
														<input type="text" name="txtlokasi" value="<?php echo $LimbahKirim['0']['noind_location']; ?>" class="form-control" disabled>
													</div>
												</div>
												<div class="form-group">
													<label for="txtberat" class="form-label col-lg-12">Berat (Kg)</label>
													<div class="col-lg-12">
														<input type="text" name="txtberat" value="<?php echo $LimbahKirim['0']['berat_kirim']; ?>" class="form-control" <?php if($LimbahKirim['0']['status_kirim'] !== '4'){echo "disabled";}else{echo "required";} ?>>
													</div>
												</div>
											</div>
										</div>
												<div class="form-group">
													<label for="txtKet" class="form-label col-lg-12">Keterangan</label>
													<div class="col-lg-12">
														<textarea name="txtKet" style="resize: vertical; max-height: 100px; min-height: 50px;" class="form-control" disabled><?php echo $LimbahKirim['0']['ket_kirim']; ?></textarea>
													</div>
												</div>
										<div class="row">
											<div class="col-lg-12 text-<?= $LimbahKirim['0']['status_kirim'] == '4' ? 'right' : 'center' ?>">
												<?php
												$status = $LimbahKirim['0']['status_kirim'];
												$url_reject = site_url('WasteManagement/KirimanMasuk/Reject/'.$encrypted_text);
												if($status == '4'){ ?>
													<button type='submit' onclick='return confirm("Apakah Anda Yakin Ingin Approve data ini ?")' class='btn btn-success'>Approve</button>
													<a href='<?php echo $url_reject;?>' onclick='return confirm("Apakah Anda Yakin Ingin Reject data ini ?")' class='btn btn-danger'>Reject</a>
												<?php }else if($status =='1'){
													echo "<span class='label label-success' style='font-size:18pt;padding-left: 5em; padding-right: 5em; border-radius: 0;'>Approved</span>";
												}else if($status =='2'){
													echo "<span class='label label-danger' style='font-size:18pt;padding-left: 5em; padding-right: 5em; border-radius: 0;'>Rejected</span>";
												}
												?>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
