<section class="content">
	<div class="box-body">
		<form class="form-horizontal" id="form-update"  enctype="multipart/form-data" method="post" action="<?php echo site_url('saveData');?>">
			<div class="row">
				<div class="col-md-12">
					<div class="box box-default color-palette-box">
						<div class="box-header with-border">
							<h3 class="box-title"></h3>
							<div class="box-header">
								<h3><b>CHECK SHEET SWEEPING KOMPUTER ICT</b></h3>
							</div>
							<?php foreach ($detailData as $data): ?>
								<div class="col-md-6">
									<table class="table">
										<tr>
											<th style="background-color: #99ddff;"><b>Data Umum</b></th>
											<th style="background-color: #99ddff;"></th>
											<th style="background-color: #99ddff;"></th>
										</tr>
										<tr>
											<td>No. Asset</td>
											<td>:</td>
											<td><?php echo $data['no_asset']; ?></td>
										</tr>
										<tr>
											<td>No Induk</td>
											<td>:</td>
											<td><?php echo $data['no_ind']; ?></td>
										</tr>
										<tr>
											<td>Nama</td>
											<td>:</td>
											<td><?php echo $data['nama']; ?></td>
										</tr>
										<tr>
											<td>Seksi</td>
											<td>:</td>
											<td><?php echo $data['seksi']; ?></td>
										</tr>
										<tr>
											<td>Email Seksi</td>
											<td>:</td>
											<td><?php echo $data['email_seksi']; ?></td>
										</tr>
										<tr>
											<td>Email Pekerja</td>
											<td>:</td>
											<td><?php echo $data['email_pekerja']; ?></td>
										</tr>
										<tr>
											<td>Akun Pidgin</td>
											<td>:</td>
											<td><?php echo $data['pidgin_akun']; ?></td>
										</tr>
										<tr>
											<td>Lokasi</td>
											<td>:</td>
											<td><?php echo $data['lokasi']; ?></td>
										</tr>
										<tr>
											<td>Voip</td>
											<td>:</td>
											<td><?php echo $data['voip']; ?></td>
										</tr>
										<tr>
											<td>IP Address</td>
											<td>:</td>
											<td><?php echo $data['ip_address']; ?></td>
										</tr>
										<tr>
											<td>Sistem Operasi</td>
											<td>:</td>
											<td><?php echo $data['sistem_operasi']; ?></td>
										</tr>
										<tr>
											<td>Windows Key</td>
											<td>:</td>
											<td><?php echo $data['windows_key']; ?></td>
										</tr>
									</table>
								</div>

								<div class="col-xs-12">
									<table class="table">
										<tr>
											<th colspan="3" style="background-color: #ffff99; width: 170px"><b>Spesifikasi</b></th>
											<th colspan="3" style="background-color: #ffcce0; width: 170px"><b>Data Aplikasi Berbayar</b></th>
											<th colspan="3" style="background-color: #7fdde9;"><b>Master Standard</b></th>
										</tr>
										<tr>
											<td>Merk</td>
											<td>:</td>
											<td><?php echo $data['merk']; ?></td>
											<!-- history -->
											<td>Aplikasi 1</td>
											<td>:</td>
											<td><?php echo $data['aplikasi_1']; ?></td>
											<td>Open Office</td>
											<td>:</td>
											<td>
												<?= $data['open_office'] ?>
											</td>
										</tr>
										<tr>
											<td>MainBoard</td>
											<td>:</td>
											<td><?php echo $data['mainboard']; ?></td>
											<!-- history -->
											<td>Aplikasi 2</td>
											<td>:</td>
											<td><?php echo $data['aplikasi_2']; ?></td>
											<td>WPS</td>
											<td>:</td>
											<td>
												<?= $data['wps'] ?>	
											</td>
										</tr>
										<tr>
											<td>Processor</td>
											<td>:</td>
											<td><?php echo $data['processor']; ?></td>
											<!-- history -->
											<td>Aplikasi 3</td>
											<td>:</td>
											<td><?php echo $data['aplikasi_3']; ?></td>
											<td>Pidgin</td>
											<td>:</td>
											<td>
												<?= $data['pidgin'] ?>
											</td>
										</tr>
										<tr>
											<td>Harddisk</td>
											<td>:</td>
											<td><?php echo $data['harddisk']; ?></td>
											<!-- history -->
											<td>Aplikasi 4</td>
											<td>:</td>
											<td><?php echo $data['aplikasi_4']; ?></td>
											<td>Thunderbird</td>
											<td>:</td>
											<td>
												<?= $data['thunderbird'] ?>
											</td>
										</tr>
										<tr>
											<td>Type RAM</td>
											<td>:</td>
											<td><?php echo $data['type_ram']; ?></td>
											<!-- history -->
											<td>Aplikasi 5</td>
											<td>:</td>
											<td><?php echo $data['aplikasi_5']; ?></td>
											<td>Browser Chrome</td>
											<td>:</td>
											<td>
												<?= $data['browser_chrome'] ?>
											</td>
										</tr>
										<tr>
											<td>Size RAM</td>
											<td>:</td>
											<td><?php echo $data['size_ram']; ?></td>
											<!-- history -->
											<td>Aplikasi 6</td>
											<td>:</td>
											<td><?php echo $data['aplikasi_6']; ?></td>
											<td>Browser IE</td>
											<td>:</td>
											<td>
												<?= $data['browser_ie'] ?>
											</td>
										</tr>
										<tr>
											<td>VGA Card</td>
											<td>:</td>
											<td><?php echo $data['vga_card']; ?></td>

											<td>Aplikasi 7</td>
											<td>:</td>
											<td><?php echo $data['aplikasi_7']; ?></td>
											<td>Browser Mozzila</td>
											<td>:</td>
											<td>
												<?= $data['browser_mozilla'] ?>
											</td>
										</tr>
										<tr>
											<td>Type Memory VGA</td>
											<td>:</td>
											<td><?php echo $data['type_vga']; ?></td>
											<td></td>
											<td></td>
											<td></td>
											<td>Teamviewer</td>
											<td>:</td>
											<td>
												<?= $data['team_viewer'] ?>
											</td>
										</tr>
										<tr>
											<td>Size Memory VGA</td>
											<td>:</td>
											<td><?php echo $data['size_vga']; ?></td>
											<td></td>
											<td></td>
											<td></td>
											<td>VNC viewer</td>
											<td>:</td>
											<td>
												<?= $data['vnc_viewer'] ?>
											</td>
										</tr>
										<tr>
											<td>CD/DVD Rom</td>
											<td>:</td>
											<td><?php echo $data['cd_rom']; ?></td>
										</tr>
										<tr>
											<td>LAN Card</td>
											<td>:</td>
											<td><?php echo $data['lan_card']; ?></td>
										</tr>
									</table>
								</div>
								<div class="col-xs-12">
									<table class="table">
										<tr>
											<th style="background-color: #ffff99; width: 170px"><b>Windows Bajakan</b></th>
											<th style="background-color: #ffff99"></th>
											<th style="background-color: #ffff99"></th>
											<th style="background-color: #ffcce0; width: 170px"><b>Data Aplikasi Bajakan</b></th>
											<th style="background-color: #ffcce0;"></th>
											<th style="background-color: #ffcce0;"></th>
											<th style="background-color: #ffcce0;"></th>
											<th style="background-color: #ffcce0;"></th>
											<th style="background-color: #ffcce0;"></th>
										</tr>
										<tr>
											<td>Bajakan</td>
											<td>:</td>
											<td><?php echo $data['windows_bajakan'] == '1' ? '<b>YA</b>' : '<b>TIDAK</b>'; ?></td>
											<!-- history -->
											<td>Aplikasi 1</td>
											<td>:</td>
											<td><?php echo $data['bajakan_1']; ?></td>
											<td>Alasan </td>
											<td>:</td>
											<td><?php echo $data['bajakan_1_alasan']; ?></td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
											<!-- history -->
											<td>Aplikasi 2</td>
											<td>:</td>
											<td><?php echo $data['bajakan_2']; ?></td>
											<td>Alasan </td>
											<td>:</td>
											<td><?php echo $data['bajakan_2_alasan']; ?></td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
											<!-- history -->
											<td>Aplikasi 3</td>
											<<td>:</td>
											<td><?php echo $data['bajakan_3']; ?></td>
											<td>Alasan </td>
											<td>:</td>
											<td><?php echo $data['bajakan_3_alasan']; ?></td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
											<!-- history -->
											<td>Aplikasi 4</td>
											<td>:</td>
											<td><?php echo $data['bajakan_4']; ?></td>
											<td>Alasan </td>
											<td>:</td>
											<td><?php echo $data['bajakan_4_alasan']; ?></td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
											<!-- history -->
											<td>Aplikasi 5</td>
											<td>:</td>
											<td><?php echo $data['bajakan_5']; ?></td>
											<td>Alasan </td>
											<td>:</td>
											<td><?php echo $data['bajakan_5_alasan']; ?></td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
											<!-- history -->
											<td>Aplikasi 6</td>
											<td>:</td>
											<td><?php echo $data['bajakan_6']; ?></td>
											<td>Alasan </td>
											<td>:</td>
											<td><?php echo $data['bajakan_6_alasan']; ?></td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>

											<td>Aplikasi 7</td>
											<td>:</td>
											<td><?php echo $data['bajakan_7']; ?></td>
											<td>Alasan </td>
											<td>:</td>
											<td><?php echo $data['bajakan_7_alasan']; ?></td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
											<td>Aplikasi 8</td>
											<td>:</td>
											<td><?php echo $data['bajakan_8']; ?></td>
											<td>Alasan </td>
											<td>:</td>
											<td><?php echo $data['bajakan_8_alasan']; ?></td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
											<td>Aplikasi 9</td>
											<td>:</td>
											<td><?php echo $data['bajakan_9']; ?></td>
											<td>Alasan </td>
											<td>:</td>
											<td><?php echo $data['bajakan_9_alasan']; ?></td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
											<td>Aplikasi 10</td>
											<td>:</td>
											<td><?php echo $data['bajakan_10']; ?></td>
											<td>Alasan </td>
											<td>:</td>
											<td><?php echo $data['bajakan_9_alasan']; ?></td>
										</tr>
									</table>
								</div>
								<div class="col-md-12 text-center">
								<?php if ($data['remark'] == 1): ?>
									<label style="color: #00a65a"><i class="fa fa-check"></i> Data Sudah di Verifikasi oleh :<br>
									<?= $data['verifikasi_oleh'] ?>
									</label>
								<?php else: ?>
									<label style="color: #da251d"><i class="fa fa-remove"></i> Data Belum di Verifikasi</label>
								<?php endif ?>
								</div>
							<?php endforeach ;?>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</section>