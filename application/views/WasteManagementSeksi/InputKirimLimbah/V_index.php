<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right"><h1><b><?=$Menu; ?></b></h1></div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('WasteManagementSeksi/InputKirimLimbah') ?>">
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
								<a href="<?php echo site_url('WasteManagementSeksi/InputKirimLimbah/Create') ?>" class="btn btn-default icon-plus icon-2x" alt='Add New' title="Add New" style="float: right;"></a>
							</div>
							<div class="box-body">
								<div class="table-responsive">
								<div style="float: left !important;">
									<span style="font-style: normal;">Lokasi Kerja:
									<select id="select-location" style="width: 339px; height:28px ; margin-right: 8px ; background-color: white; border: normal;">
										<?php 
											if(!isset($_GET["location"])) {
												$_GET["location"] = '';
											}
										?>
										
										<option value="all"
										<?= ($_GET["location"] == 'all') ? 'selected' : '' ?>>Pilih Semua</option>
										<option value="yogyakarta"
										<?= ($_GET["location"] == 'yogyakarta') ? 'selected' : '' ?>>01 - YOGYAKARTA (PUSAT)</option>
										<option value="tuksono"
										<?= ($_GET["location"] == 'tuksono') ? 'selected' : '' ?>>02 - TUKSONO</option>
									</select>
									<button id='btn-search' class="btn btn-primary" style="width: 50px; height:27px ; padding: 3px !important;">Cari</button>
									</span>
									</div>
									<table class="datatable table table-striped table-bordered table-hover text-left dataTable-limbah" style="font-size: 12px;">
										<thead class="bg-primary">
											<tr>
												<td>No</td>
												<td>Limbah</td>
												<td>Tanggal Kirim</td>
												<td>Waktu Kirim</td>
												<td>Pengirim</td>
												<td>Seksi Asal Limbah</td>
												<td>Lokasi Kerja</td>
												<td>Bocor</td>
												<td>Jumlah</td>
												<td>Berat (Kg)</td>
												<td>Action</td>
											</tr>
										</thead>
										<tbody>
											<?php 
												$a = 1;
												foreach ($LimbahKirim as $key) {
													if(isset($_GET['location'])) {
														switch($_GET['location']) {
															case 'yogyakarta':
																if($key['noind_location'] == '01 - YOGYAKARTA (PUSAT)') {
																	$status = "";
													$encrypted_string = $this->encrypt->encode($key['id_kirim']);
                                                	$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);

													$bocor = 'Tidak';
													if ($key['bocor']=='1') {
														$bocor = 'Ya';
													}else{
														$bocor = 'Tidak';
													}
													$edit = base_url('WasteManagementSeksi/InputKirimLimbah/EditKirim/'.$encrypted_string);
													$delete = base_url('WasteManagementSeksi/InputKirimLimbah/DelKirim/'.$encrypted_string); ?>
														<tr>
															<td><?php echo $a; ?></td>
															<td><?php echo $key['jenis_limbah']; ?></td>
															<td><?php echo $key['tanggal']; ?></td>
															<td><?php echo $key['waktu']; ?></td>
															<td><?php echo $key['noind_pengirim']; ?></td>
															<td><?php echo $key['section_name']; ?></td>
															<td><?php echo $key['noind_location']; ?></td>
															<td><?php echo $bocor; ?></td>
															<td><?php echo $key['jumlah_kirim']." ".$key['satuan']; ?></td>
															<td><?php echo $key['berat_kirim']; ?></td>
															<td>
													<?php if($key['status_kirim'] == '3'){ ?>
																<a href='<?php echo $edit; ?>' data-toggle='tooltip' data-placement='bottom' data-original-title='Edit Data'><span class='fa fa-pencil-square-o fa-2x'></span></a>
																<a href='<?php echo $delete; ?>' data-toggle='tooltip' data-placement='bottom' data-original-title='Delete Data' onclick="return confirm('Anda Yakin Ingin Menghapus Data Ini ?')"><span class='fa fa-trash fa-2x' title='Hapus'></span></a>
															</td>
													</tr>
												<?php 		}elseif ($key['status_kirim'] == '1') {
																echo "<span class='label label-success'>Approved</span>";
															}elseif ($key['status_kirim'] == '2') {
																echo "<span class='label label-danger'>Rejected</span>";
															}

													$a++;
												}
												break;
													case 'tuksono':
														if($key['noind_location'] == '02 - TUKSONO') {
															$status = "";
													$encrypted_string = $this->encrypt->encode($key['id_kirim']);
                                                	$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);

													$bocor = 'Tidak';
													if ($key['bocor']=='1') {
														$bocor = 'Ya';
													}else{
														$bocor = 'Tidak';
													}
													$edit = base_url('WasteManagementSeksi/InputKirimLimbah/EditKirim/'.$encrypted_string);
													$delete = base_url('WasteManagementSeksi/InputKirimLimbah/DelKirim/'.$encrypted_string); ?>
														<tr>
															<td><?php echo $a; ?></td>
															<td><?php echo $key['jenis_limbah']; ?></td>
															<td><?php echo $key['tanggal']; ?></td>
															<td><?php echo $key['waktu']; ?></td>
															<td><?php echo $key['noind_pengirim']; ?></td>
															<td><?php echo $key['section_name']; ?></td>
															<td><?php echo $key['noind_location']; ?></td>
															<td><?php echo $bocor; ?></td>
															<td><?php echo $key['jumlah_kirim']." ".$key['satuan']; ?></td>
															<td><?php echo $key['berat_kirim']; ?></td>
															<td>
													<?php if($key['status_kirim'] == '3'){ ?>
																<a href='<?php echo $edit; ?>' data-toggle='tooltip' data-placement='bottom' data-original-title='Edit Data'><span class='fa fa-pencil-square-o fa-2x'></span></a>
																<a href='<?php echo $delete; ?>' data-toggle='tooltip' data-placement='bottom' data-original-title='Delete Data' onclick="return confirm('Anda Yakin Ingin Menghapus Data Ini ?')"><span class='fa fa-trash fa-2x' title='Hapus'></span></a>
															</td>
													</tr>
												<?php 		}elseif ($key['status_kirim'] == '1') {
																echo "<span class='label label-success'>Approved</span>";
															}elseif ($key['status_kirim'] == '2') {
																echo "<span class='label label-danger'>Rejected</span>";
															}

													$a++;
												}
												break;
													default:
														$status = "";
													$encrypted_string = $this->encrypt->encode($key['id_kirim']);
                                                	$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);

													$bocor = 'Tidak';
													if ($key['bocor']=='1') {
														$bocor = 'Ya';
													}else{
														$bocor = 'Tidak';
													}
													$edit = base_url('WasteManagementSeksi/InputKirimLimbah/EditKirim/'.$encrypted_string);
													$delete = base_url('WasteManagementSeksi/InputKirimLimbah/DelKirim/'.$encrypted_string); ?>
														<tr>
															<td><?php echo $a; ?></td>
															<td><?php echo $key['jenis_limbah']; ?></td>
															<td><?php echo $key['tanggal']; ?></td>
															<td><?php echo $key['waktu']; ?></td>
															<td><?php echo $key['noind_pengirim']; ?></td>
															<td><?php echo $key['section_name']; ?></td>
															<td><?php echo $key['noind_location']; ?></td>
															<td><?php echo $bocor; ?></td>
															<td><?php echo $key['jumlah_kirim']." ".$key['satuan']; ?></td>
															<td><?php echo $key['berat_kirim']; ?></td>
															<td>
													<?php if($key['status_kirim'] == '3'){ ?>
																<a href='<?php echo $edit; ?>' data-toggle='tooltip' data-placement='bottom' data-original-title='Edit Data'><span class='fa fa-pencil-square-o fa-2x'></span></a>
																<a href='<?php echo $delete; ?>' data-toggle='tooltip' data-placement='bottom' data-original-title='Delete Data' onclick="return confirm('Anda Yakin Ingin Menghapus Data Ini ?')"><span class='fa fa-trash fa-2x' title='Hapus'></span></a>
															</td>
													</tr>
												<?php 		}elseif ($key['status_kirim'] == '1') {
																echo "<span class='label label-success'>Approved</span>";
															}elseif ($key['status_kirim'] == '2') {
																echo "<span class='label label-danger'>Rejected</span>";
															}

													$a++;
													break;
														}
													} else {
														$status = "";
													$encrypted_string = $this->encrypt->encode($key['id_kirim']);
                                                	$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);

													$bocor = 'Tidak';
													if ($key['bocor']=='1') {
														$bocor = 'Ya';
													}else{
														$bocor = 'Tidak';
													}
													$edit = base_url('WasteManagementSeksi/InputKirimLimbah/EditKirim/'.$encrypted_string);
													$delete = base_url('WasteManagementSeksi/InputKirimLimbah/DelKirim/'.$encrypted_string); ?>
														<tr>
															<td><?php echo $a; ?></td>
															<td><?php echo $key['jenis_limbah']; ?></td>
															<td><?php echo $key['tanggal']; ?></td>
															<td><?php echo $key['waktu']; ?></td>
															<td><?php echo $key['noind_pengirim']; ?></td>
															<td><?php echo $key['section_name']; ?></td>
															<td><?php echo $key['noind_location']; ?></td>
															<td><?php echo $bocor; ?></td>
															<td><?php echo $key['jumlah_kirim']." ".$key['satuan']; ?></td>
															<td><?php echo $key['berat_kirim']; ?></td>
															<td>
													<?php if($key['status_kirim'] == '3'){ ?>
																<a href='<?php echo $edit; ?>' data-toggle='tooltip' data-placement='bottom' data-original-title='Edit Data'><span class='fa fa-pencil-square-o fa-2x'></span></a>
																<a href='<?php echo $delete; ?>' data-toggle='tooltip' data-placement='bottom' data-original-title='Delete Data' onclick="return confirm('Anda Yakin Ingin Menghapus Data Ini ?')"><span class='fa fa-trash fa-2x' title='Hapus'></span></a>
															</td>
													</tr>
												<?php 		}elseif ($key['status_kirim'] == '1') {
																echo "<span class='label label-success'>Approved</span>";
															}elseif ($key['status_kirim'] == '2') {
																echo "<span class='label label-danger'>Rejected</span>";
															}

													$a++;
												
													}
											} ?>
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
	$('#btn-search').off('click').click(function() {
		window.location.href = '<?= base_url('WasteManagementSeksi/InputKirimLimbah?location=') ?>' + $('#select-location').val();
	});
</script>