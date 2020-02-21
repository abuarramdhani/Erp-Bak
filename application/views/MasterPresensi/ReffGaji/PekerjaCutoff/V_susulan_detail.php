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
							<div class="box-header with-border text-right">
								<input type="button" value="Back" onclick="window.history.back()" class="btn btn-warning" /> 
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12 text-center">
										<?php 
											$bulan = array (
												1 =>   'Januari',
												'Februari',
												'Maret',
												'April',
												'Mei',
												'Juni',
												'Juli',
												'Agustus',
												'September',
												'Oktober',
												'November',
												'Desember'
											);
										$tgl1 = substr($periode,0,4);
										$tgl2 = substr($periode,4,6);
										echo "<h2>".$bulan[intval($tgl2)].' '.$tgl1."</h2>";
										?>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" method="POST" action="<?php echo site_url('MasterPresensi/ReffGaji/PekerjaCutoffReffGaji/susulan_add_new/'.$periode) ?>">
											<div class="form-group">
												<label class="control-label col-lg-4">Pekerja</label>
												<div class="col-lg-4">
													<select class="slc-pekerjaCutoff" name="txtnoindpekerja" style="width: 100%">
														<option></option>
													</select>
												</div>
												<div class="col-lg-4">
													<button type="submit"class="btn btn-primary">Add</button>
												</div>
											</div>
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<table class="dataTable-pekerjaCutoff table table-bordered table-striped table-hover table-hovered">
											<thead class="bg-primary">
												<tr>
													<th class="text-center">No</th>
													<th class="text-center">No. Induk</th>
													<th class="text-center">Nama</th>
													<th class="text-center">Seksi/Unit</th>
													<th class="text-center">Ditambahkan</th>
													<th class="text-center">Action</th>
												</tr>
											</thead>
											<tbody>
												<?php 
													if(isset($data) and !empty($data)){
														$nomor = 1;
														foreach ($data as $key) { 
															
												?>
															<tr>
																<td class="text-center"><?=$nomor ?></td>
																<td class="text-center"><?php echo $key['noind'] ?></td>
																<td class="text-left"><?php echo $key['nama'] ?></td>
																<td class="text-left"><?php echo $key['seksi'] ?></td>
																<td class="text-left"><?php echo $key['dibuat'] ?></td>
																<td class="text-center">
																	<a href="<?php echo site_url('MasterPresensi/ReffGaji/PekerjaCutoffReffGaji/hapus_susulan/'.$periode.'/'.$key['noind']) ?>" onclick="return confirm('Apakah Anda yakin Menghapus Data Ini ?')">
																		<span class="fa fa-trash" style="color: red;" title="Hapus Data"></span>
																	</a>
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
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>