<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="box box-solid box-primary">
					<div class="box-header with-border">
						<table>
							<tr>
								<td style="width: 15%;text-align: left">Periode</td>
								<td style="width: 2%;text-align: center">:</td>
								<td style="width: 10%;text-align: center"><?php echo $awal ?></td>
								<td style="width: 3%;text-align: center">-</td>
								<td style="width: 10%;text-align: center"><?php echo $akhir ?></td>
							</tr>
							<tr>
								<td>Jenis Presensi</td>
								<td style="text-align: center">:</td>
								<td colspan="3"><?php echo $jenis_presensi ?></td>
							</tr>
							<?php 
								if ($jenis_presensi !== "Lembur") {
									?>
							<tr>
								<td>Jenis Tampilan</td>
								<td style="text-align: center">:</td>
								<td colspan="3"><?php echo $jenis_tampilan ?></td>
							</tr>
									<?php
								}
							?>
							<tr>
								<td>Pekerja Keluar</td>
								<td style="width: 2;text-align: center">:</td>
								<td colspan="3"><?php echo $pekerja_keluar ?></td>
							</tr>
							<?php if ($pekerja_keluar !== "Off") {
								?>
							<tr>
								<td>Periode Keluar</td>
								<td style="text-align: center">:</td>
								<td><?php echo $off_awal ?></td>
								<td style="text-align: center">-</td>
								<td><?php echo $off_akhir ?></td>
							</tr>
								<?php
							} 
							?>
						</table>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-lg-12">
								<?php 
								$range = (strtotime($awal) - strtotime($akhir))/(60*60*24); 
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
								$awal_cutoff = $awal;
								$akhir_cutoff = $akhir;
								$tgl_aw = explode("-", $awal_cutoff);
								$tgl_ak = explode("-", $akhir_cutoff);
								echo "Data Pegawai Periode ".$tgl_aw['2']."/".$tgl_aw['1']."/".$tgl_aw['0']." - ".$tgl_ak['2']."/".$tgl_ak['1']."/".$tgl_ak['0']; 
								?>
							</div>
						</div>
						<table id="hlcm-tbl-detailpresensi" class="table-table-hover table-bordered table-hover table-striped">
							<thead>
								<tr>
									<th rowspan="2" style='text-align: center;vertical-align: middle;width: 80px'>No. Induk</th>
									<th rowspan="2" style='text-align: center;vertical-align: middle;width: 200px;'>Nama</th>
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
										foreach ($data['tanggal'] as $dt_bulan) {
											if($dt_bulan['bulan'].$dt_bulan['tahun'] == $simpan_bulan_tahun){
												$hitung_colspan++;
											}else{
												if ($simpan_bulan !== "") {
													echo "<th colspan='".$hitung_colspan."'>".$bulan[$simpan_bulan]." ".$simpan_tahun."</th>";
													$hitung_colspan = 1;
												}else{
													$tanggal_pertama = $dt_bulan['tanggal'];
												}
											}
											$simpan_bulan_tahun = $dt_bulan['bulan'].$dt_bulan['tahun'];
											$simpan_bulan = $dt_bulan['bulan'];
											$simpan_tahun = $dt_bulan['tahun'];
										}
										echo "<th colspan='".$hitung_colspan."' style='text-align: center'>".$bulan[$simpan_bulan]." ".$simpan_tahun."</th>";
										$tanggal_terakhir = $dt_bulan['tanggal'];
									?>
								</tr>
								<tr>
									<?php  
										foreach ($data['tanggal'] as $dt_tanggal) {
											echo "<th style='text-align: center;width: 30px;'>".$dt_tanggal['hari']."</th>";
										}
									?>
								</tr>
							</thead>
							<tbody>
								<?php 
									foreach ($data['absen'] as $abs) { ?>
										<tr>
											<td style="text-align: center;vertical-align: center">
												<?php echo $abs['noind'] ?>
											</td>
											<td>
												<?php if (strlen(trim($abs['nama'])) > 20) {
													echo substr(trim($abs['nama']), 0,20)."..";
												}else{
													echo trim($abs['nama']);
												} ?>	
											</td>
											<?php 
												foreach ($data['tanggal'] as $dt_tanggal) {
													$keterangan = "-";
													if (isset($abs['data'][$dt_tanggal['index_tanggal']]) and !empty($abs['data'][$dt_tanggal['index_tanggal']])) {
														$keterangan = $abs['data'][$dt_tanggal['index_tanggal']];
													}
													echo "<td style='text-align: center;vertical-align: middle'>$keterangan</td>";
												}
											?>
										</tr> 
									<?php }
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>