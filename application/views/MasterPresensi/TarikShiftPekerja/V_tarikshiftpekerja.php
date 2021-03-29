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
										<form method="post" action="<?php echo base_url('MasterPresensi/ShiftPekerja/TarikDataShiftPekerja/Cari');?>" class="form-horizontal" enctype="multipart/form-data">
		                                    <div class="panel-body">
		                                        <div class="row">
		                                            <div class="form-group">
		                                                <label for="txtTanggalRekap" class="control-label col-lg-4">Tanggal </label>
		                                                <div class="col-lg-6">
		                                                    <input type="text" name="txtTanggalRekap" class="RekapAbsensi-daterangepicker form-control required" 
		                                                    value="<?php echo isset($_POST['txtTanggalRekap']) ? $_POST['txtTanggalRekap'] : '' ?>" />
		                                                </div>
		                                            </div>
		                                            <div class="form-group">
		                                            	<label class="control-label col-lg-4">Status Hubungan Kerja</label>
														<div class="col-lg-6">
															<select id="er-status" data-placeholder="Status Hubungan Kerja" class="form-control select2" style="width:100%" name ="statushubker[]" required multiple="multiple"
															<?php echo isset($_POST['statusAll']) && $_POST['statusAll'] == "1" ? 'disabled' : '' ?>>
																<option value=""><option>
																	<?php foreach ($status as $status_item){
																		?>
																		<option value="<?php echo $status_item['fs_noind'];?>"
																		<?php echo isset($_POST['statushubker']) && in_array($status_item['fs_noind'] ,$_POST['statushubker']) ? 'selected' : '' ?>>
																			<?php echo $status_item['fs_noind'].' - '.$status_item['fs_ket'];?>
																		</option>
																		<?php } ?>
															</select>
														</div>
														<div class="col-lg-1">
															<label style="margin-top: 5px" class="pull-center">
																<input class="azek" type="checkbox" id="er_all" class="form-control" name="statusAll" value="1"
																<?php echo isset($_POST['statusAll']) && $_POST['statusAll'] == "1" ? 'checked' : '' ?>>
																ALL
															</label>
														</div>
													</div>
													<div class="form-group">
		                                            	<label class="control-label col-lg-4">Lokasi Kerja</label>
														<div class="col-lg-6">
															<select id="adm-lokasi" data-placeholder="Lokasi Kerja" class="form-control select2" style="width:100%" name ="lokasi[]" required multiple="multiple"
															<?php echo isset($_POST['lokasiAll']) && $_POST['lokasiAll'] == "1" ? 'disabled' : '' ?>>
																<option value=""><option>
																	<?php foreach ($lokasi as $status_kerja){
																		?>
																		<option value="<?php echo $status_kerja['id_'];?>"
																		<?php echo isset($_POST['lokasi']) && in_array($status_kerja['id_'], $_POST['lokasi']) ? 'selected' : '' ?>>
																			<?php echo $status_kerja['id_'].' - '.$status_kerja['lokasi_kerja'];?>
																		</option>
																		<?php } ?>
															</select>
														</div>
														<div class="col-lg-1">
															<label style="margin-top: 5px" class="pull-center">
																<input class="azek" type="checkbox" id="a_all" class="form-control" name="lokasiAll" value="1" 
																<?php echo isset($_POST['lokasiAll']) && $_POST['lokasiAll'] == "1" ? 'checked' : '' ?>>
																ALL
															</label>
														</div>
													</div>
		                                            <div class="form-group">
		                                                <label for="cmbDepartemen" class="control-label col-lg-4">Departemen</label>
		                                                <div class="col-lg-6">
		                                                    <select name="cmbDepartemen" data-placeholder="Departement" class="select2 RekapAbsensi-cmbDepartemen" style="width: 100%" required="">
		                                                    	<?php 
		                                                    	if (isset($dept) && !empty($dept)) {
		                                                    		foreach ($dept as $d) {
	                                                    				?>
	                                                    				<option value="<?php echo $d['kode_departemen'] ?>" 
	                                                    				<?php echo $d['kode_departemen'] == $kdept ? 'selected' : '' ?>>
	                                                    					<?php echo $d['nama_departemen'] ?>
	                                                    				</option>
	                                                    				<?php
		                                                    		}
		                                                    	}
		                                                    	?>
		                                                    </select>
		                                                </div>
		                                            </div>
		                                            <br/>
		                                            <div class="form-group">
		                                                <label for="cmbBidang" class="control-label col-lg-4">Bidang</label>
		                                                <div class="col-lg-6">
		                                                    <select name="cmbBidang" data-placeholder="Bidang" class="select2 RekapAbsensi-cmbBidang" style="width: 100%">
		                                                    	<?php 
		                                                    	if (isset($bidang) && !empty($bidang)) {
		                                                    		foreach ($bidang as $d) {
	                                                    				?>
	                                                    				<option value="<?php echo $d['kode_bidang'] ?>" 
	                                                    				<?php echo $d['kode_bidang'] == $kbidang ? 'selected' : '' ?>>
	                                                    					<?php echo $d['nama_bidang'] ?>
	                                                    				</option>
	                                                    				<?php
		                                                    		}
		                                                    	}
		                                                    	?>
		                                                    </select>
		                                                </div>
		                                            </div>
		                                            <br/>
		                                            <div class="form-group">
		                                                <label for="cmbUnit" class="control-label col-lg-4">Unit</label>
		                                                <div class="col-lg-6">
		                                                    <select name="cmbUnit" data-placeholder="Unit" class="select2 RekapAbsensi-cmbUnit" style="width: 100%">
		                                                    	<?php 
		                                                    	if (isset($unit) && !empty($unit)) {
		                                                    		foreach ($unit as $d) {
	                                                    				?>
	                                                    				<option value="<?php echo $d['kode_unit'] ?>" 
	                                                    				<?php echo $d['kode_unit'] == $kunit ? 'selected' : '' ?>>
	                                                    					<?php echo $d['nama_unit'] ?>
	                                                    				</option>
	                                                    				<?php
		                                                    		}
		                                                    	}
		                                                    	?>
		                                                    </select>
		                                                </div>
		                                            </div>
		                                            <br/>
		                                            <div class="form-group">
		                                                <label for="cmbSeksi" class="control-label col-lg-4">Seksi</label>
		                                                <div class="col-lg-6">
		                                                    <select name="cmbSeksi" data-placeholder="Seksi" class="select2 RekapAbsensi-cmbSeksi" style="width: 100%">
		                                                    	<?php 
		                                                    	if (isset($seksi) && !empty($seksi)) {
		                                                    		foreach ($seksi as $d) {
	                                                    				?>
	                                                    				<option value="<?php echo $d['kode_seksi'] ?>"
	                                                    				<?php echo $d['kode_seksi'] == $kseksi ? 'selected' : '' ?>>
	                                                    					<?php echo $d['nama_seksi'] ?>
	                                                    				</option>
	                                                    				<?php
		                                                    		}
		                                                    	}
		                                                    	?>
		                                                    </select>
		                                                </div>
		                                            </div>
																								
		                                        </div>
		                                    </div>
		                                    <div class="panel-footer">
		                                        <div class="row text-right">
		                                        	<?php if (isset($export)) { ?>
		                                        		<a target="_blank" href="<?php echo base_url('MasterPresensi/ShiftPekerja/TarikDataShiftPekerja/ExportPdf/pdf_'.$export) ?>" class="btn btn-danger btn-lg fa fa-file-pdf-o fa-2">Export Pdf</a>
		                                        		<a target="_blank" href="<?php echo base_url('MasterPresensi/ShiftPekerja/TarikDataShiftPekerja/ExportExcel/xls_'.$export) ?>" class="btn btn-success btn-lg fa fa-file-excel-o fa-2">Export Excel</a>
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
												 <table class="table table-striped table-bordered tabl-hover" id="tblMPRTarikShiftPekerja">
													<thead>
														<tr>
														    <th class="bg-primary" rowspan="2" style='text-align: center;vertical-align: middle;'>No</th>
															<th class="bg-primary" rowspan="2" style='text-align: center;vertical-align: middle;'>No. Induk</th>
															<th class="bg-primary" rowspan="2" style='text-align: center;vertical-align: middle;width: 200px;'>Nama</th>
															<th class="bg-primary" rowspan="2" style='text-align: center;vertical-align: middle;width: 200px;'>Seksi</th>
															<th class="bg-primary" rowspan="2" style='text-align: center;vertical-align: middle;width: 200px;'>Jabatan</th>
															<th class="bg-primary" rowspan="2" style='text-align: center;vertical-align: middle;width: 200px;'>Tempat Makan</th>
															<th class="bg-primary" rowspan="2" style='text-align: center;vertical-align: middle;width: 200px;'>Lokasi Kerja</th>
															<?php  
																$simpan_bulan_tahun = "";
																$simpan_bulan = "";
																$simpan_tahun = "";
																$hitung_colspan = 1;
																$tanggal_pertama = "";
																$tanggal_terakhir = "";
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
																foreach ($tanggal as $dt_bulan) {
																	if($dt_bulan['bulan'].$dt_bulan['tahun'] == $simpan_bulan_tahun){
																		$hitung_colspan++;
																	}else{
																		if ($simpan_bulan !== "") {
																			echo "<th class='bg-primary' colspan='".$hitung_colspan."' style='text-align: center'>".$bulan[$simpan_bulan]." ".$simpan_tahun."</th>";
																			$hitung_colspan = 1;
																		}else{
																			$tanggal_pertama = $dt_bulan['tanggal'];
																		}
																	}
																	$simpan_bulan_tahun = $dt_bulan['bulan'].$dt_bulan['tahun'];
																	$simpan_bulan = $dt_bulan['bulan'];
																	$simpan_tahun = $dt_bulan['tahun'];
																}
																echo "<th class='bg-primary' colspan='".$hitung_colspan."' style='text-align: center'>".$bulan[$simpan_bulan]." ".$simpan_tahun."</th>";
																$tanggal_terakhir = $dt_bulan['tanggal'];
															?>
														</tr>
														<tr>
															<?php  
																foreach ($tanggal as $dt_tanggal) {
																	echo "<th class='bg-primary' style='text-align: center'>".$dt_tanggal['hari']."</th>";
																}
															?>
														</tr>
													</thead>
													<tbody>
														<?php foreach ($table as $key) {
															?>
															<tr>
																<td><?php echo $no; ?></td>
																<td><?php echo $key['noind']; ?></td>
																<td><?php echo $key['nama']; ?></td>
																<td><?php echo $key['seksi']; ?></td>
																<td><?php echo $key['jabatan']; ?></td>
																<td><?php echo $key['tempat_makan']; ?></td>
																<td><?php echo $key['lokasi_kerja']; ?></td>
										                       <?php 
										                       foreach ($tanggal as $dt_tanggal) {
																	?>
																	<td><?php echo $key['data'][str_replace("-", "", $dt_tanggal['tanggal'])] ?></td>
																	<?php 
																}
										                       ?>
															</tr>
														<?php $no++; } ?>
													</tbody>
													<?php 
													if (isset($aggr)) {
														?>
													<tfoot>
														<?php 
														foreach ($aggr as $key => $ag) {
															?>
															<tr>
																<th class="bg-primary"></th>
																<th class="bg-primary"></th>
																<th class="bg-primary" style="width: 200px;"><?php echo $key ?></th>
																<th class="bg-primary" style="width: 200px;"></th>
																<th class="bg-primary" style="width: 200px;"></th>
																<th class="bg-primary" style="width: 200px;"></th>
																<th class="bg-primary" style="width: 200px;"></th>
																<?php 
											                       	foreach ($tanggal as $dt_tanggal) {
																		?>
																		<th class="bg-primary"><?php echo isset($ag[$dt_tanggal['index_tanggal']]) ? $ag[$dt_tanggal['index_tanggal']] : '0' ?></th>
																		<?php 
																	}
											                    ?>
															</tr>
															<?php
														}
														?>
													</tfoot>
															<?php
														}
														?>
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
