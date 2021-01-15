<section class="content" id="wadawdawadqawd">
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
									<div class="col-md-12">
										<ul class="nav nav-tabs" id="myTab" role="tablist">
											<li class="nav-item active">
												<a class="nav-link active" id="home-tab" data-toggle="tab" href="#cvd_monhome" role="tab" aria-controls="cvd_monhome" aria-selected="true">Monitoring</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" id="profile-tab" data-toggle="tab" href="#cvd_montas" role="tab" aria-controls="cvd_montas" aria-selected="false">Terdapat Point (<?= count($tim) ?>)</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" id="profile-tab" data-toggle="tab" href="#cvd_montl" role="tab" aria-controls="cvd_montas" aria-selected="false">Timeline Isolasi</a>
											</li>
										</ul>
									</div>
									<div class="tab-content" id="myTabContent">
										<div class="tab-pane fade active in" id="cvd_monhome" role="tabpanel">
											<div class="col-lg-12" style="margin-top: 20px;">
												<form class="form-horizontal" method="GET" action="<?php echo base_url('Covid/MonitoringCovid') ?>">
													<div class="form-group">
														<label class="control-label col-lg-2">Status Kondisi</label>
														<div class="col-lg-3">
															<select class="select2" name="status" style="width: 100%">
																<?php 
																$total = 0;
																$option = "";
																if (isset($status) && !empty($status)) {
																	foreach ($status as $st) {
																		if ($st['status_kondisi_id'] == $status_kondisi) {
																			$selected = "selected";
																		}else{
																			$selected = "";
																		}
																		$option .= "<option value='".$st['status_kondisi_id']."' ".$selected.">".$st['status_kondisi']." ( ".$st['jumlah']." )</option>";
																		$total += $st['jumlah'];
																	}
																}
																?>
																<option value="0">All ( <?php echo $total; ?> ) </option>
																<?php 
																echo $option;
																?>
															</select>
														</div>
														<div class="col-lg-3">
															<button type="submit" class="btn btn-primary" id="asdasdasd"><span class="fa fa-search"></span> Search</button>
														</div>
														<div class="col-lg-4 text-right">
															<a href="<?php echo base_url('Covid/MonitoringCovid/tambah') ?>" class="btn btn-primary"><span class="fa fa-plus"></span> Tambah</a>
														</div>
													</div>
												</form>
											</div>
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
													/*td:not(:nth-child(2)) {
														text-overflow: ellipsis;
														overflow: hidden;
														white-space: nowrap;
														max-width: 200px;
													}*/
												</style>
												<table id="tbl-CVD-MonitoringCovid" class="table table-bordered table-hover table-striped">
													<thead>
														<th class="bg-primary" style="text-align: center;vertical-align: middle;">No.</th>
														<th class="bg-primary" style="text-align: center;vertical-align: middle;">Action</th>
														<th class="bg-primary" style="text-align: center;vertical-align: middle;">No. Induk</th>
														<th class="bg-primary" style="text-align: center;vertical-align: middle;">Nama</th>
														<th class="bg-primary" style="text-align: center;vertical-align: middle;">Seksi</th>
														<th class="bg-primary" style="text-align: center;vertical-align: middle;">Departemen</th>
														<th class="bg-primary" style="text-align: center;vertical-align: middle;">Status Kondisi</th>
														<th class="bg-primary" style="text-align: center;vertical-align: middle;">Tanggal Interaksi</th>
														<th class="bg-primary" style="text-align: center;vertical-align: middle;">Kasus</th>
														<th class="bg-primary" style="text-align: center;vertical-align: middle;">Keterangan</th>
														<th class="bg-primary" style="text-align: center;vertical-align: middle;">Mulai Isolasi</th>
														<th class="bg-primary" style="text-align: center;vertical-align: middle;">Selesai Isolasi</th>
														<th class="bg-primary" style="text-align: center;vertical-align: middle;">Lama Isolasi</th>
														<th class="bg-primary" style="text-align: center;vertical-align: middle;">PIC</th>
														<th class="bg-primary" style="text-align: center;vertical-align: middle; width: 180px;">Hasil Tes</th>
													</thead>
													<tbody>
														<?php 
														if (isset($data) && !empty($data)) {
															$nomor = 1;
															foreach ($data as $key => $value) {
																$encrypted_string = $this->encrypt->encode($value['cvd_pekerja_id']);
																$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
																if (!empty($value['isolasi_id'])) {
																	$encrypted_isolasi_id = $this->encrypt->encode($value['isolasi_id']);
																	$encrypted_isolasi_id = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_isolasi_id);
																}else{
																	$encrypted_isolasi_id = "";
																}
																$stat = "not found";
																if (isset($status) && !empty($status)) {
																	foreach ($status as $st) {
																		if ($st['status_kondisi_id'] == $value['status_kondisi_id']) {
																			$stat = "<button class='btn btn-CVD-MonitoringCovid-Status' data-id='".$encrypted_string."' style='background-color: ".$st['background_color'].";color: ".$st['text_color']."'>".$st['status_kondisi']."</button>";
																			$status_kondisi_pekerja = $st['status_kondisi'];
																		}
																	}
																	
																}
																?>
																<tr>
																	<td><?php echo $nomor ?></td>
																	<td>
																		<div class="btn-group">
																			<button type="button" class="btn btn-primary dropdown-toggle cvd_btntriggerdrop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																				Action <span class="caret"></span>
																			</button>
																			<ul class="dropdown-menu">
																				<li>
																					<a href="<?php echo base_url('Covid/MonitoringCovid/edit/'.$encrypted_string) ?>" style="cursor: pointer;">edit</a>
																				</li>
																				<li>
																					<a data-href="<?php echo $encrypted_string ?>" data-status="<?php echo isset($status_kondisi) ? $status_kondisi : '0'; ?>" class="btn-CVD-MonitoringCovid-Hapus" style="cursor: pointer;">Hapus</a>
																				</li>
																				<?php 
																				if (isset($encrypted_isolasi_id) && !empty($encrypted_isolasi_id)) {
																					?>
																					<li>
																						<a href="<?php echo base_url('MasterPekerja/Surat/SuratIsolasiMandiri/Ubah/'.$encrypted_isolasi_id.'/'.$encrypted_string) ?>" style="cursor: pointer;">Ubah Memo Isolasi Mandiri</a>
																					</li>
																					<?php
																				}else{
																					?>
																					<li>
																						<a href="<?php echo base_url('MasterPekerja/Surat/SuratIsolasiMandiri/Tambah/'.$encrypted_string) ?>" style="cursor: pointer;">Buat Memo Isolasi Mandiri</a>
																					</li>
																					<?php
																				}
																				?>
																				<li>
																					<a href="<?php echo base_url('Covid/MonitoringCovid/InputHasilTest/'.$encrypted_string) ?>" style="cursor: pointer;">Input Hasil Test</a>
																				</li>
																				<li>
																					<a href="<?php echo base_url('Covid/MonitoringCovid/TidakIsolasi/'.$encrypted_string) ?>" style="cursor: pointer;">Tidak Isolasi</a>
																				</li>
																				<li>
																					<a data-href="<?php echo base_url('Covid/MonitoringCovid/FollowUp/'.$encrypted_string) ?>" data-status="<?php echo isset($status_kondisi_pekerja) ? $status_kondisi_pekerja : '0'; ?>" class="btn-CVD-MonitoringCovid-FollowUp" style="cursor: pointer;">Follow Up Pekerja</a>
																				</li>
																			</ul>
																		</div>
																		
																		<div class="btn-group">
																			<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																				Cetak <span class="caret"></span>
																			</button>
																			<ul class="dropdown-menu">
																				<li>
																					<a target='_blank' href="<?php echo base_url('Covid/MonitoringCovid/WawancaraIsolasi/'.$encrypted_string) ?>" style="cursor: pointer;">Wawancara Isolasi</a>
																				</li>
																				<li>
																					<a target='_blank' href="<?php echo base_url('Covid/MonitoringCovid/MemoIsolasi/'.$encrypted_string) ?>" style="cursor: pointer;">Memo Isolasi Mandiri</a>
																				</li>
																				<li>
																					<a target="_blank" href="<?php echo base_url('Covid/MonitoringCovid/WawancaraMasuk/'.$encrypted_string) ?>" style="cursor: pointer;">Wawancara Masuk</a>
																				</li>
																			</ul>
																		</div>
																	</td>
																	<td><?php echo $value['noind'] ?></td>
																	<td><?php echo $value['nama'] ?></td>
																	<td><?php echo $value['seksi'] ?></td>
																	<td><?php echo $value['dept'] ?></td>
																	<td style="text-align: center;"><?php echo $stat ?></td>
																	<td data-order="<?= date('Y-m-d', strtotime($value['tgl_interaksi'])) ?>"><?php echo strftime('%d %h %Y',strtotime($value['tgl_interaksi'])) ?></td>
																	<td><?php echo $value['kasus'] ?></td>
																	<td><?php echo $value['keterangan'] ?></td>
																	<td><?php echo !empty($value['mulai_isolasi']) ? strftime('%d %h %Y',strtotime($value['mulai_isolasi'])) : '-' ?></td>
																	<td><?php echo !empty($value['mulai_isolasi']) ? strftime('%d %h %Y',strtotime($value['selesai_isolasi'])) : '' ?></td>
																	<td><?php echo !empty($value['lama_isolasi']) ? $value['lama_isolasi'].' hari' : '-' ?></td>
																	<?php if ($value['created_by'] == '' || empty(trim($value['created_by']))): ?>
																		<td><?php echo $value['pic_followup'].' - '.$value['nama_pic'] ?></td>
																	<?php else: ?>
																		<td><?php echo $value['created_by'] ?></td>
																	<?php endif ?>
																	<td>
																		<?php
																		$arrjns = $value['jns'];
																		$arrhsl = $value['hsl'];
																		if (!empty($arrjns)) {
																			$st = ['-','Negatif', 'Non Reaktif', 'Reaktif', 'Positif'];
																			$arrjns = explode(',', $arrjns);
																			$arrhsl = explode(',', $arrhsl);
																			for ($i=0; $i < count($arrjns); $i++) {
																				if ($arrhsl[$i] == '') {
																					$arrhsl[$i] = 0;
																				}
																				echo ($i+1).'. '.$arrjns[$i].' ('.$st[$arrhsl[$i]].')';
																				echo "<br>";
																			}
																		}
																		?>
																	</td>
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
										<div class="tab-pane fade" id="cvd_montas" role="tabpanel">
											<div class="col-md-12">
												<div class="col-md-12 text-center">
													<h2>Pekerja Isolasi Ada Poin</h2>
												</div>
												<table class="table table-bordered table-striped table-hover cvd_tabledatatable">
													<thead class="bg-primary">
														<tr>
															<th style="text-align: center;" width="10%">No</th>
															<th style="text-align: center;" width="10%">Action</th>
															<th style="text-align: center;" width="10%">Noind</th>
															<th style="text-align: center;" width="30%">Nama</th>
															<th style="text-align: center;" width="20%">Tanggal</th>
															<th style="text-align: center;" width="10%">Poin</th>
															<th style="text-align: center;" width="10%">Keterangan</th>
														</tr>
													</thead>
													<tbody>
														<?php $x=1; foreach ($tim as $t): 
														$encrypted_string = $this->encrypt->encode($t['id_isolasi_mandiri']);
														$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
														$encrypted_string2 = $this->encrypt->encode($t['cvd_pekerja_id']);
														$encrypted_string2 = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string2);
														?>
															<tr>
																<td style="text-align: center;"><?= $x++ ?></td>
																<td style="text-align: center;">
																	<a href="<?= base_url('MasterPekerja/Surat/SuratIsolasiMandiri/Ubah/'.$encrypted_string.'/'.$encrypted_string2) ?>" class="btn btn-primary">
																		<i class="fa fa-edit"></i>
																	</a>
																</td>
																<td><?= $t['noind'] ?></td>
																<td><?= $t['nama'] ?></td>
																<td data-order="<?= $t['tanggal'] ?>"><?= date('d M Y', strtotime($t['tanggal'])) ?></td>
																<td><?= $t['point'] ?></td>
																<td><?= $t['kd_ket'] ?></td>
															</tr>
														<?php endforeach ?>
													</tbody>
												</table>
											</div>
										</div>
										<div class="tab-pane fade" id="cvd_montl" role="tabpanel">
											<div class="col-md-12">
												<h3>Untuk melihat Timeline Isolasi Klik Tombol di bawah!</h3>
												<br>
												<a class="btn btn-primary" href="<?= base_url('Covid/PelaporanPekerja/Monitoring') ?>" target="_blank">
													Timeline Isolasi
												</a>
												<br><br>
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
	</div>
</section>