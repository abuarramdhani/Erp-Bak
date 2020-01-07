<style type="text/css">
	.btn-success:hover, .btn-success:active, .btn-success.hover {
		background-color: #008d4c !important;
	}
	table.DTFC_Cloned thead tr {
		background-color: #337ab7;
	}
</style>
<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<h1><?=$Title ?></h1>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-solid box-primary">
							<div class="box-header with-border">
								<a href="<?php echo site_url('MasterPresensi/ReffGaji/PekerjaKhusus/insert') ?>" class="btn btn-success"><span class="fa fa-plus fa-2"></span></a>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<table class="table table-bordered table-striped table-hover" id="tblPekerjaKhusus">
											<thead class="bg-primary">
												<tr>
													<th>No</th>
													<th>Action</th>
													<th>Noind</th>
													<th>Nama</th>
													<th>Noind Baru</th>
													<th>GP</th>
													<th>IP</th>
													<th>IPT</th>
													<th>IK</th>
													<th>IF</th>
													<th>UBT</th>
													<th>UPAMK</th>
													<th>UM</th>
													<th>UMC</th>
													<th>IMS</th>
													<th>IMM</th>
													<th>Lembur</th>
													<th>Cuti</th>
													<th>Info</th>
													<th>Khusus</th>
													<th>Ketentuan</th>
													<th>Satuan</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												if (isset($data) && !empty($data)) {
													$nomor = 1;
													foreach ($data as $dt) {
														$id_encrypted = $this->encrypt->encode($dt['noind_baru'].'-'.$dt['noind']);
 														$id_encrypted = str_replace(array('+', '/', '='), array('-', '_', '~'), $id_encrypted)
														?>
															<tr>
																<td><?php echo $nomor; ?></td>
																<td style="text-align: center">
																	<a href="<?php echo site_url('MasterPresensi/ReffGaji/PekerjaKhusus/edit/'.$id_encrypted) ?>" class="btn btn-warning btn-sm" title="Edit Data"><span class="fa fa-wrench"></span>Edit</a>
																	<a href="<?php echo site_url('MasterPresensi/ReffGaji/PekerjaKhusus/delete/'.$id_encrypted) ?>" class="btn btn-danger btn-sm" title="delete Data"><span class="fa fa-trash"></span>Delete</a>
																</td>
																<td><?php echo $dt['noind']; ?></td>
																<td><?php echo $dt['nama']; ?></td>
																<td><?php echo $dt['noind_baru']; ?></td>
																<td><?php echo $dt['xgp'] == "1" ? "Ya" : "Tidak"; ?></td>
																<td><?php echo $dt['xip'] == "1" ? "Ya" : "Tidak"; ?></td>
																<td><?php echo $dt['ipt'] == "1" ? "Ya" : "Tidak"; ?></td>
																<td><?php echo $dt['xik'] == "1" ? "Ya" : "Tidak"; ?></td>
																<td><?php echo $dt['xif'] == "1" ? "Ya" : "Tidak"; ?></td>
																<td><?php echo $dt['ubt'] == "1" ? "Ya" : "Tidak"; ?></td>
																<td><?php echo $dt['upamk'] == "1" ? "Ya" : "Tidak"; ?></td>
																<td><?php echo $dt['xum'] == "1" ? "Ya" : "Tidak"; ?></td>
																<td><?php echo $dt['umc'] == "1" ? "Ya" : "Tidak"; ?></td>
																<td><?php echo $dt['ims'] == "1" ? "Ya" : "Tidak"; ?></td>
																<td><?php echo $dt['imm'] == "1" ? "Ya" : "Tidak"; ?></td>
																<td><?php echo $dt['lembur'] == "1" ? "Ya" : "Tidak"; ?></td>
																<td><?php echo $dt['cuti'] == "1" ? "Ya" : "Tidak"; ?></td>
																<td><?php echo $dt['khusus'] == "1" ? "Ya" : "Tidak"; ?></td>
																<td><?php echo $dt['info']; ?></td>
																<td><?php echo $dt['ketentuan']; ?></td>
																<td><?php echo $dt['satuan_akhir']; ?></td>
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