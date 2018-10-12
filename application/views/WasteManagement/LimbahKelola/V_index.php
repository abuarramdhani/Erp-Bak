<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11  text-right">
							<h1><b><?=$Title ?></b></h1>
						</div>
						<div class="col-lg-1 text-right hidden-md hiddem-sm hidden-xs">
							<a href="<?php echo site_url('WasteManagement/LimbahKelola') ?>" class="btn btn-default btn-lg"><span class="fa fa-wrench fa-2x"></span></a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								
							</div>
							<div class="box-body">
								<div class="table-responsive">
									<table class="datatable table table-striped table-bordered table-hover text-left dataTable-limbah" style="font-size:12px;">
										<thead class="bg-primary">
											<tr>
												<th>No</th>
												<th>Action</th>
												<th>Seksi Asal Limbah</th>
												<th>Pekerja Pengirim</th>
												<th>Tanggal Kirim</th>
												<th>Waktu Kirim</th>
												<th>jenis Limbah</th>
												<th>Jumlah</th>
												<th>Berat (Kg)</th>
												<th>Status</th>
											</tr>
										</thead>
										<tbody>
											<?php 
												$a = 1;
												foreach ($Kiriman as $key) {
													$status = "";
													if ($key['status_kirim'] == "1") {
														$status = "<span class='label label-success'>Approved</span>";
													}else if ($key['status_kirim'] == "2") {
														$status = "<span class='label label-danger'>Rejected</span>";
													}else if ($key['status_kirim'] == "3") {
														$status = "<span class='label label-warning'>Pending</span>";
													}

													$encrypted_string = $this->encrypt->encode($key['id_kirim']);
													$encrypted_string = str_replace(array('+','/','='),array('-','_','~'),$encrypted_string);

													$read 	= base_url("WasteManagement/KirimanMasuk/Read/".$encrypted_string);
													$delete = base_url("WasteManagement/KirimanMasuk/Delete/".$encrypted_string);
													$pending = base_url("WasteManagement/KirimanMasuk/Pending/".$encrypted_string);

													echo "<tr>
														<td>".$a."</td>
														<td>
															<a href='".$read."' data-toggle='tooltip' data-placement='bottom' data-original-title='Lihat Data'>
																<span class='fa fa-list-alt fa-2x'></span>
															</a>"; 
											?>

															<a href='<?php echo $delete; ?>' data-toggle='tooltip' data-placement='bottom' data-original-title='Hapus Data' onclick='return confirm("Apakah Anda Yakin Ingin Menghapus data ini ?")'>
																<span class='fa fa-trash fa-2x'></span>
															</a>
														</td>
											<?php
												echo	"<td>".$key['seksi']."</td>
														<td>".$key['pekerja']."</td>
														<td>".$key['tanggal']."</td>
														<td>".$key['waktu']."</td>
														<td>".$key['jenis_limbah']."</td>
														<td>".$key['jumlah']."</td>
														<td>".$key['berat_kirim']."</td>";

														if ($key['status_kirim'] !== "3") { ?>
															<td>
																<?php echo $status; ?>
																<a href='<?php echo $pending; ?>' data-toggle='tooltip' data-placement='bottom' data-original-title='Ubah Status' onclick='return confirm("Apakah Anda Yakin Ingin Mengubah Status data ini ?")'>
																<span class='icon-wrench icon-2x'></span>
															</a>
															</td>
														<?php }else{
															echo "<td>".$status."</td>";
														} 
														
													 echo "</tr>";
													$a++;
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