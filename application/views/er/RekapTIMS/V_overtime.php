<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12 ">
						<h2><b><?=$Title ?></b></h2>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form method="post" action="<?php echo base_url('RekapTIMSPromosiPekerja/Overtime/Cari');?>" class="form-horizontal" enctype="multipart/form-data">
		                                    <div class="panel-body">
		                                        <div class="row">
		                                            <div class="form-group">
		                                                <label for="txtTanggalRekap" class="control-label col-lg-4">Tanggal Rekap</label>
		                                                <div class="col-lg-6">
		                                                    <input type="text" name="txtTanggalRekap" class="RekapAbsensi-daterangepicker form-control" />
		                                                </div>
		                                            </div>
		                                            <div class="form-group">
		                                            	<label class="control-label col-lg-4">Status Hubungan Kerja</label>
														<div class="col-lg-6">
															<select id="er-status" data-placeholder="Status Hubungan Kerja" class="form-control select2" style="width:100%" name ="statushubker[]" required multiple="multiple">
																<option value=""><option>
																	<!-- <option value="All">ALL</option> -->
																	<?php foreach ($status as $status_item){
																		?>
																		<option value="<?php echo $status_item['fs_noind'];?>"><?php echo $status_item['fs_noind'].' - '.$status_item['fs_ket'];?></option>
																		<?php } ?>
															</select>
														</div>
														<div class="col-lg-1">
															<label style="margin-top: 5px" class="pull-center">
																<input class="azek" type="checkbox" id="er_all" class="form-control" name="statusAll" value="1">
																ALL
															</label>
														</div>
													</div>
		                                            <div class="form-group">
		                                                <label for="cmbDepartemen" class="control-label col-lg-4">Departemen</label>
		                                                <div class="col-lg-6">
		                                                    <select name="cmbDepartemen" data-placeholder="Departement" class="select2 RekapAbsensi-cmbDepartemen" style="width: 100%" required="">
		                                                    </select>
		                                                </div>
		                                            </div>
		                                            <br/>
		                                            <div class="form-group">
		                                                <label for="cmbBidang" class="control-label col-lg-4">Bidang</label>
		                                                <div class="col-lg-6">
		                                                    <select name="cmbBidang" data-placeholder="Bidang" class="select2 RekapAbsensi-cmbBidang" style="width: 100%">
		                                                    </select>
		                                                </div>
		                                            </div>
		                                            <br/>
		                                            <div class="form-group">
		                                                <label for="cmbUnit" class="control-label col-lg-4">Unit</label>
		                                                <div class="col-lg-6">
		                                                    <select name="cmbUnit" data-placeholder="Unit" class="select2 RekapAbsensi-cmbUnit" style="width: 100%">
		                                                    </select>
		                                                </div>
		                                            </div>
		                                            <br/>
		                                            <div class="form-group">
		                                                <label for="cmbSeksi" class="control-label col-lg-4">Seksi</label>
		                                                <div class="col-lg-6">
		                                                    <select name="cmbSeksi" data-placeholder="Seksi" class="select2 RekapAbsensi-cmbSeksi" style="width: 100%">
		                                                    </select>
		                                                </div>
		                                            </div>
																								<div class="row" style="margin: 10px 10px;vertical-align: middle">
																									<div class="col-md-7"></div>
																										<div class="col-md-3">
																											<div class="form-group" style="vertical-align: middle">
																												<div class="checkbox">
																													<label>
																														<input id="toggle_button" name="detail" type="checkbox" value="1">
																														Tampilkan Detail Data Overtime
																													</label>
																												</div>
																											</div>
																										</div>
																								</div>
		                                        </div>
		                                    </div>
		                                    <div class="panel-footer">
		                                        <div class="row text-right">
		                                        	<?php if (isset($export)) { ?>
		                                        		<a target="_blank" href="<?php echo base_url('RekapTIMSPromosiPekerja/Overtime/ExportPdf/pdf_'.$export) ?>" class="btn btn-danger btn-lg fa fa-file-pdf-o fa-2">Export Pdf</a>
		                                        		<a target="_blank" href="<?php echo base_url('RekapTIMSPromosiPekerja/Overtime/ExportExcel/xls_'.$export) ?>" class="btn btn-success btn-lg fa fa-file-excel-o fa-2">Export Excel</a>
		                                        	<?php } ?>
		                                            <button class="btn btn-info btn-md" type="submit">
		                                                Proses
		                                            </button>
		                                        </div>
		                                    </div>
		                                </form>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<?php if (isset($table) and !empty($table)) { $no = 1; ?>
											<div class="table-responsive">
												<table class="table table-striped table-bordered tabl-hover datatable-overtime">
													<thead class="bg-primary">
														<tr>
															<th>No</th>
															<th>Periode</th>
															<th>Nama</th>
															<th>Seksi</th>
															<th>Total Jam kerja</th>
															<th>Total Hari kerja</th>
															<th>Overtime</th>
															<th>NET</th>
															<th>Rerata Net/Hari</th>
														</tr>
													</thead>
													<tbody>
														<?php foreach ($table as $key) {
															?>
															<tr>
																<td><?php echo $no; ?></td>
																<td><?php if ($detail == 0) {
																	echo $periodeM;}
																	else {
																		echo ucfirst($key['periode']);
																	} ?></td>
																<td><?php echo $key['noind'].' - '.$key['nama']; ?></td>
																<td><?php echo $key['seksi']; ?></td>
																<td><?php echo number_format($key['jam_kerja'],'2',',','.') ?></td>
																<td><?php echo number_format($key['hari_kerja'],'0',',','.') ?></td>
																<td><?php echo number_format($key['overtime'],'2',',','.') ?></td>
																<td><?php echo number_format($key['net'],'2',',','.') ?></td>
																<td><?php echo number_format($key['rerata_net'],'2',',','.') ?></td>
															</tr>
														<?php $no++; } ?>
													</tbody>
												</table>
											</div>
										<?php } ?>
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
