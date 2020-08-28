<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<h1><b><?=$Title ?></b></h1>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" method="GET" action="<?php echo base_url('Covid/MonitoringCovid') ?>">
											<div class="form-group">
												<label class="control-label col-lg-2">Status Kondisi</label>
												<div class="col-lg-3">
													<select class="select2" name="status" style="width: 100%">
														<option value="0">All</option>
														<?php 
														if (isset($status) && !empty($status)) {
															foreach ($status as $st) {
																if ($st['status_kondisi_id'] == $status_kondisi) {
																	$selected = "selected";
																}else{
																	$selected = "";
																}
																echo "<option value='".$st['status_kondisi_id']."' ".$selected.">".$st['status_kondisi']."</option>";
															}
														}
														?>
													</select>
												</div>
												<div class="col-lg-3">
													<button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> Search</button>
												</div>
												<div class="col-lg-4 text-right">
													<a href="<?php echo base_url('Covid/MonitoringCovid/tambah') ?>" class="btn btn-primary"><span class="fa fa-plus"></span> Tambah</a>
												</div>
											</div>
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<style type="text/css">
											.dt-buttons {
												float: left;
											}
											.dataTables_filter {
												float: right;
											}

											.dataTables_info {
												float: left
											}
											td:not(:nth-child(2)) {
												text-overflow: ellipsis;
												overflow: hidden;
												white-space: nowrap;
												max-width: 200px;
											}
										</style>
										<table id="tbl-CVD-MonitoringCovid" class="table table-bordered table-hover table-striped">
											<thead>
												<th class="bg-primary" style="text-align: center;vertical-align: middle;">No.</th>
												<th class="bg-primary" style="text-align: center;vertical-align: middle;width: 200px;">Action</th>
												<th class="bg-primary" style="text-align: center;vertical-align: middle;">No. Induk</th>
												<th class="bg-primary" style="text-align: center;vertical-align: middle;width: 100px;">Nama</th>
												<th class="bg-primary" style="text-align: center;vertical-align: middle;width: 100px;">Seksi</th>
												<th class="bg-primary" style="text-align: center;vertical-align: middle;">Departemen</th>
												<th class="bg-primary" style="text-align: center;vertical-align: middle;">Status Kondisi</th>
												<th class="bg-primary" style="text-align: center;vertical-align: middle;">Tanggal Interaksi</th>
												<th class="bg-primary" style="text-align: center;vertical-align: middle;">Kasus</th>
												<th class="bg-primary" style="text-align: center;vertical-align: middle;">Keterangan</th>
												<th class="bg-primary" style="text-align: center;vertical-align: middle;">Mulai Isolasi</th>
												<th class="bg-primary" style="text-align: center;vertical-align: middle;">Selesai Isolasi</th>
												<th class="bg-primary" style="text-align: center;vertical-align: middle;">Lama Isolasi</th>
												<th class="bg-primary" style="text-align: center;vertical-align: middle;">PIC</th>
											</thead>
											<tbody>
												<?php 
												if (isset($data) && !empty($data)) {
													$nomor = 1;
													foreach ($data as $key => $value) {
														$stat = "not found";
														if (isset($status) && !empty($status)) {
															$encrypted_string = $this->encrypt->encode($value['cvd_pekerja_id']);
															$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
															foreach ($status as $st) {
																if ($st['status_kondisi_id'] == $value['status_kondisi_id']) {
																		$stat = "<button class='btn btn-CVD-MonitoringCovid-Status' data-id='".$encrypted_string."' style='background-color: ".$st['background_color'].";color: ".$st['text_color']."'>".$st['status_kondisi']."</button>";
																}
															}
															
														}
														?>
														<tr>
															<td><?php echo $nomor ?></td>
															<td>
																<a href="<?php echo base_url('Covid/MonitoringCovid/edit/'.$encrypted_string) ?>" class="btn btn-xs btn-info"><span class="fa fa-edit"></span>&nbsp;&nbsp;edit</a>
																<button data-href="<?php echo $encrypted_string ?>" data-status="<?php echo isset($status_kondisi) ? $status_kondisi : '0'; ?>" class="btn btn-xs btn-danger btn-CVD-MonitoringCovid-Hapus"><span class="fa fa-trash"></span>&nbsp;&nbsp;Hapus</button>
																<a href="<?php echo base_url('Covid/MonitoringCovid/wawancara/'.$encrypted_string) ?>" class="btn btn-xs btn-primary"><span class="fa fa-file-pdf-o"></span>&nbsp;&nbsp;Wawancara</a>
																<a target="_blank" href="<?php echo base_url('MasterPekerja/Surat/SuratIsolasiMandiri') ?>" class="btn btn-xs btn-success"><span class="fa fa-file-pdf-o"></span>&nbsp;&nbsp;Surat Isolasi</a>
																<a target="_blank" href="<?php echo base_url('Covid/MonitoringCovid/beritaAcaraCetak/'.$encrypted_string) ?>" class="btn btn-xs btn-warning"><span class="fa fa-file-pdf-o"></span>&nbsp;&nbsp;Cetak Berita Acara</a>
																<!-- <a target="_blank" href="<?php echo base_url('Covid/MonitoringCovid/beritaAcara/'.$encrypted_string) ?>" class="btn btn-xs btn-warning"><span class="fa fa-file-pdf-o"></span>&nbsp;&nbsp;Update Berita Acara</a> -->
															</td>
															<td><?php echo $value['noind'] ?></td>
															<td><?php echo $value['nama'] ?></td>
															<td><?php echo $value['seksi'] ?></td>
															<td><?php echo $value['dept'] ?></td>
															<td><?php echo $stat ?></td>
															<td><?php echo strftime('%d %B %Y',strtotime($value['tgl_interaksi'])) ?></td>
															<td><?php echo $value['kasus'] ?></td>
															<td><?php echo $value['keterangan'] ?></td>
															<td><?php echo strftime('%d %B %Y',strtotime($value['mulai_isolasi'])) ?></td>
															<td><?php echo strftime('%d %B %Y',strtotime($value['selesai_isolasi'])) ?></td>
															<td><?php echo $value['lama_isolasi'] ?> hari</td>
															<td><?php echo $value['created_by'] ?></td>
														</tr>
														<?php
														$nomor++;
													}
												}
												?>
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
</section>