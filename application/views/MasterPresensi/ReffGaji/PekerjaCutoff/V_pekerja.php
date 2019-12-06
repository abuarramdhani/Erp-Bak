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
								<a class="btn btn-success" href="<?php echo base_url('MasterPresensi/ReffGaji/PekerjaCutoffReffGaji') ?>">Cari Periode</a>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal">
											<div class="form-group">
												<label class="control-label col-lg-4">Pekerja</label>
												<div class="col-lg-4">
													<select class="slc-pekerjaCutoff" style="width: 100%">
														<option></option>
													</select>
												</div>
												<div class="col-lg-4">
													<button type="button" id="btn-PekerjaCutoff-search" class="btn btn-primary">Search</button>
												</div>
											</div>
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-10">
										<table>
											<tr>
												<td style="padding-left: 20px;padding-right: 20px">No. Induk</td>
												<td>:</td>
												<td id="td-pekerjaCutoff-noind" style="padding-left: 20px"><?php echo (isset($pekerja) and !empty($pekerja)) ? $pekerja['0']['noind'] : "-"; ?></td>
											</tr>
											<tr>
												<td style="padding-left: 20px;padding-right: 20px">Nama</td>
												<td>:</td>
												<td id="td-pekerjaCutoff-nama" style="padding-left: 20px"><?php echo (isset($pekerja) and !empty($pekerja)) ? $pekerja['0']['nama'] : "-"; ?></td>
											</tr>
											<tr>
												<td style="padding-left: 20px;padding-right: 20px">Seksi / Unit</td>
												<td>:</td>
												<td id="td-pekerjaCutoff-seksi" style="padding-left: 20px"><?php echo (isset($pekerja) and !empty($pekerja)) ? $pekerja['0']['seksi'] : "-"; ?></td>
											</tr>
										</table>
									</div>
									<div class="col-lg-2">
										<button type="button" class="btn btn-danger" id="btn-pekerjaCutoff-pekerja-pdf" data-noind="<?php echo (isset($pekerja) and !empty($pekerja)) ? $pekerja['0']['noind'] : "-"; ?>" ><span class="fa fa-file-pdf-o"></span> Pdf</button>
										<button type="button" class="btn btn-success" id="btn-pekerjaCutoff-pekerja-xls" data-noind="<?php echo (isset($pekerja) and !empty($pekerja)) ? $pekerja['0']['noind'] : "-"; ?>" ><span class="fa fa-file-excel-o"></span> Pdf</button>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<table class="table table-bordered table-striped table-hover table-hovered">
											<thead class="bg-primary">
												<tr>
													<th class="text-center" style="width: 10%">No</th>
													<th class="text-center">Periode</th>
												</tr>
											</thead>
											<tbody id="tbodyPekerjaCutoff">
												<?php 
												if(isset($data) and !empty($data)){ 
													$nomor = 1;
													foreach ($data as $key) {?>
														<tr>
															<td style="text-align: center"><?=$nomor ?></td>
															<td style="text-align: center">
																<a href="<?php echo base_url('MasterPresensi/ReffGaji/PekerjaCutoffReffGaji/d/'.$key['tanggal_proses']) ?>"><?php echo $key['periode'] ?></a>
															</td>
														</tr>
												<?php 
														$nomor++;
													}
												}else{ ?>
													<tr>
														<td colspan="2" class="text-center">
															<i>Tidak Ditemukan Data <?php isset($noind) ? $noind : ''; ?> di Data Pekerja Cut Off</i>
														</td>
													</tr>
												<?php 
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
	</div>
</section>