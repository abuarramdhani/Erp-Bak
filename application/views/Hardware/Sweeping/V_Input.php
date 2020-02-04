<style>
	@media only screen and (max-width: 1060px) {
		.hw_hpv{
			overflow-x: scroll;
		}
	}
</style>
<section class="content">
	<div class="box-body">
		<form class="form-horizontal" id="form-update"  enctype="multipart/form-data" method="post" action="<?php echo site_url('hardware/input-data/saveData');?>">
			<div class="row">
				<div class="col-md-12">
					<div class="box box-default color-palette-box">
						<div class="box-header with-border">
							<h3 class="box-title"></h3>
							<div class="box-header">
								<h3><b>CHECK SHEET SWEEPING KOMPUTER ICT</b></h3>
							</div>
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
										<td><input type="text" class="form-control" name="txtNoAsset" placeholder="Masukan No Asset" required onkeyup="this.value = this.value.toUpperCase()"></td>
									</tr>
									<tr>
										<td>No Induk</td>
										<td>:</td>
										<td>
											<select class="select2 noInduk form-control" name="slcNoInduk" style="width: 100%;" required></select>
										</td>
									</tr>
									<tr>
										<td>Nama</td>
										<td>:</td>
										<td><input type="text" class="form-control nama" name="txtNama" readonly required></td>
									</tr>
									<tr>
										<td>Seksi</td>
										<td>:</td>
										<td><input type="text" class="form-control seksi" name="txtSeksi" readonly required></td>
									</tr>
									<tr>
										<td>Email Seksi</td>
										<td>:</td>
										<td><input type="email" class="form-control email_seksi" name="txtEmailSeksi" required></td>
									</tr>
									<tr>
										<td>Email Pekerja</td>
										<td>:</td>
										<td><input type="text" class="form-control Email_Pekerja" name="txtEmailPekerja" readonly required></td>
									</tr>
									<tr>
										<td>Akun Pidgin</td>
										<td>:</td>
										<td><input type="text" class="form-control akun_pidgin" name="txtPidgin" readonly required></td>
									</tr>
									<tr>
										<td>Lokasi</td>
										<td>:</td>
										<td>
											<select class="select2 lokasi" name="slcLokasi" style="width: 100%;" required>
												<option>YOGYAKARTA (PUSAT)</option>
												<option>TUKSONO</option>
												<option>MLATI</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>No Voip</td>
										<td>:</td>
										<td><input type="text" class="form-control voip" name="txtVoip" required></td>
									</tr>
									<tr>
										<td>IP Address</td>
										<td>:</td>
										<td>
											<input type="text" class="form-control input_ip" name="txtIpAddress" placeholder="Masukan IP Address" autocomplete='text' minlength="7" maxlength="15" size="15" pattern="^((\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$" required>
										</td>
									</tr>
									<tr>
										<td>Sistem Operasi</td>
										<td>:</td>
										<td>
											<select class="select2 slcOs form-control"  style="width: 100%;" name="txtOS">
												<option value="WINDOWS XP HOME EDITION SP1">WINDOWS XP HOME EDITION SP1</option>
												<option value="WINDOWS XP HOME EDITION SP2">WINDOWS XP HOME EDITION SP2</option>
												<option value="WINDOWS XP HOME EDITION SP3">WINDOWS XP HOME EDITION SP3</option>
												<option value="WINDOWS XP PROFESSIONAL SP1">WINDOWS XP PROFESSIONAL SP1</option>
												<option value="WINDOWS XP PROFESSIONAL SP2">WINDOWS XP PROFESSIONAL SP2</option>
												<option value="WINDOWS XP PROFESSIONAL SP3">WINDOWS XP PROFESSIONAL SP3</option>
												<option value="WINDOWS VISTA HOME BASIC">WINDOWS VISTA HOME BASIC</option>
												<option value="WINDOWS 7 STARTER 32BIT">WINDOWS 7 STARTER 32BIT</option>
												<option value="WINDOWS 7 STARTER 64BIT">WINDOWS 7 STARTER 64BIT</option>
												<option value="WINDOWS 7 HOME BASIC 32BIT">WINDOWS 7 HOME BASIC 32BIT</option>
												<option value="WINDOWS 7 HOME BASIC 64BIT">WINDOWS 7 HOME BASIC 64BIT</option>
												<option value="WINDOWS 7 HOME PREMIUM 32BIT">WINDOWS 7 HOME PREMIUM 32BIT</option>
												<option value="WINDOWS 7 HOME PREMIUM 64BIT">WINDOWS 7 HOME PREMIUM 64BIT</option>
												<option value="WINDOWS 7 ULTIMATE 32BIT">WINDOWS 7 ULTIMATE 32BIT</option>
												<option value="WINDOWS 7 ULTIMATE 64BIT">WINDOWS 7 ULTIMATE 64BIT</option>
												<option value="WINDOWS 7 PROFESSIONAL 32BIT">WINDOWS 7 PROFESSIONAL 32BIT</option>
												<option value="WINDOWS 7 PROFESSIONAL 64BIT">WINDOWS 7 PROFESSIONAL 64BIT</option>
												<option value="WINDOWS 8.1">WINDOWS 8.1</option>
												<option value="WINDOWS 8.1 K">WINDOWS 8.1 K</option>
												<option value="WINDOWS 8.1 KN">WINDOWS 8.1 KN</option>
												<option value="WINDOWS 8.1 N">WINDOWS 8.1 N</option>
												<option value="WINDOWS 8.1 SINGLE LANGUAGE">WINDOWS 8.1 SINGLE LANGUAGE</option>
												<option value="WINDOWS 10 STANDARD 32BIT">WINDOWS 10 STANDARD 32BIT</option>
												<option value="WINDOWS 10 STANDARD 64BIT">WINDOWS 10 STANDARD 64BIT</option>
												<option value="WINDOWS 10 PROFESSIONAL 32BIT">WINDOWS 10 PROFESSIONAL 32BIT</option>
												<option value="WINDOWS 10 PROFESSIONAL 64BIT">WINDOWS 10 PROFESSIONAL 64BIT</option>
												<option value="LINUX MINT 17.2">LINUX MINT 17.2</option>
												<option value="UBUNTU 12.04">UBUNTU 12.04</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Windows Key</td>
										<td>:</td>
										<td><input type="text" class="form-control" name="txtWindowsKey" placeholder="Masukan Windows Key" required onkeyup="this.value = this.value.toUpperCase()"></td>
									</tr>
								</table>
							</div>

							<div class="col-xs-12 hw_hpv">
								<table class="table" style="min-width: 800px;">
									<tr>
										<th colspan="3" style="background-color: #ffff99"><b>Spesifikasi</b></th>
										<th colspan="3" style="background-color: #ffcce0;"><b>Data Aplikasi Berbayar</b></th>
										<th colspan="3" style="background-color: #7fdde9;"><b>Master Standard</b></th>
									</tr>
									<tr>
										<td>Merk</td>
										<td>:</td>
										<td><input type="text" class="form-control" name="txtMerk" placeholder="Masukan Merk" required onkeyup="this.value = this.value.toUpperCase()"></td>
										<td>Aplikasi 1</td>
										<td>:</td>
										<td><input type="text" class="form-control" name="txtAplikasi1" value="-" placeholder="Masukan Aplikasi" onkeyup="this.value = this.value.toUpperCase()"></td>
										<td>Open Office</td>
										<td>:</td>
										<td>
											<input class="form-control" required="" name="openOfice" placeholder="Masukan Versi Open Office">
										</td>
									</tr>
									<tr>
										<td>MainBoard</td>
										<td>:</td>
										<td><input type="text" class="form-control" name="txtMainboard" placeholder="Masukan Mainboard" required required onkeyup="this.value = this.value.toUpperCase()"></td>
										<td>Aplikasi 2</td>
										<td>:</td>
										<td><input type="text" class="form-control" name="txtAplikasi2" value="-" placeholder="Masukan Aplikasi" onkeyup="this.value = this.value.toUpperCase()"></td>
										<td>WPS</td>
										<td>:</td>
										<td>
											<input class="form-control" required="" name="wps" placeholder="Masukan Versi WPS">
										</td>
									</tr>
									<tr>
										<td>Processor</td>
										<td>:</td>
										<td>
											<select class="slcProcie form-control"  style="width: 100%;" name="txtProcessor" required>
												<option value="PENTIUM 4">PENTIUM 4</option>
												<option value="DUAL CORE">DUAL CORE</option>
												<option value="CORE 2 DUO">CORE 2 DUO</option>
												<option value="CORE I3">CORE I3</option>
												<option value="CORE I5">CORE I5</option>
												<option value="CORE I7">CORE I7</option>
												<option value="INTEL XEON">INTEL XEON</option>
												<option value="INTEL ATOM">INTEL ATOM</option>
												<option value="AMD FX 8320">AMD FX 8320</option>
											</select>
										</td>
										<td>Aplikasi 3</td>
										<td>:</td>
										<td>
											<input type="text" class="form-control" name="txtAplikasi3" value="-" placeholder="Masukan Aplikasi" onkeyup="this.value = this.value.toUpperCase()">
										</td>
										<td>Pidgin</td>
										<td>:</td>
										<td>
											<input class="form-control" required="" name="pidgin" placeholder="Masukan Versi Pidgin">
										</td>
									</tr>
									<tr>
										<td>Harddisk</td>
										<td>:</td>
										<td><input type="number" min="0" class="form-control" name="txtHarddisk" placeholder="Masukan Harddisk" required></td>
										<td>Aplikasi 4</td>
										<td>:</td>
										<td><input type="text" class="form-control" name="txtAplikasi4" value="-" placeholder="Masukan Aplikasi" onkeyup="this.value = this.value.toUpperCase()"></td>
										<td>Thunderbird</td>
										<td>:</td>
										<td>
											<input class="form-control" required="" name="thunderbird" placeholder="Masukan Versi Thunderbird">
										</td>
									</tr>
									<tr>
										<td>Type RAM</td>
										<td>:</td>
										<td>
											<select class="slcTypeRam form-control"  style="width: 100%;" name="txtTypeRam" required>
												<option value="DDR1">DDR1</option>
												<option value="DDR2">DDR2</option>
												<option value="DDR3">DDR3</option>
												<option value="DDR4">DDR4</option>
												<option value="DDR5">DDR5</option>
												<option value="SODIMM">SODIMM</option>
											</select>
										</td>
										<td>Aplikasi 5</td>
										<td>:</td>
										<td><input type="text" class="form-control" name="txtAplikasi5" value="-" placeholder="Masukan Aplikasi" onkeyup="this.value = this.value.toUpperCase()"></td>
										<td>Browser Chrome</td>
										<td>:</td>
										<td>
											<input class="form-control" required="" name="chrome" placeholder="Masukan Versi Chrome">
										</td>
									</tr>
									<tr>
										<td>Size RAM</td>
										<td>:</td>
										<td><input type="number" min="0" class="form-control" name="txtSizeRam" placeholder="Masukan Size RAM" required></td>
										<td>Aplikasi 6</td>
										<td>:</td>
										<td><input type="text" class="form-control" name="txtAplikasi6" value="-" placeholder="Masukan Aplikasi" onkeyup="this.value = this.value.toUpperCase()"></td>
										<td>Browser IE</td>
										<td>:</td>
										<td>
											<input class="form-control" required="" name="ie" placeholder="Masukan Versi IE">
										</td>
									</tr>
									<tr>
										<td>VGA Card</td>
										<td>:</td>
										<td><input type="text" required value="-" class="form-control" name="txtVgaCard" required placeholder="Masukan VGA Card" onkeyup="this.value = this.value.toUpperCase()"></td>

										<td>Aplikasi 7</td>
										<td>:</td>
										<td><input type="text" class="form-control" name="txtAplikasi7" value="-" placeholder="Masukan Aplikasi" onkeyup="this.value = this.value.toUpperCase()"></td>
										<td>Browser Mozzila</td>
										<td>:</td>
										<td>
											<input class="form-control" required="" name="mozzila" placeholder="Masukan Versi Mozzila">
										</td>
									</tr>
									<tr>
										<td>Type Memory VGA</td>
										<td>:</td>
										<td>
											<input type="text" class="form-control nbdEdit" required name="txtTypeMemoryVga" placeholder="Masukan Type Memory VGA" onkeyup="this.value = this.value.toUpperCase()"> 
										</td>
										<td></td>
										<td></td>
										<td></td>
										<td>Teamviewer</td>
										<td>:</td>
										<td>
											<input class="form-control" required="" name="Tviewer" placeholder="Masukan Versi Temviewer">
										</td>
									</tr>
									<tr>
										<td>Size Memory VGA (MB)</td>
										<td>:</td>
										<td><input type="number" min="0" class="form-control" required name="txtSizeMemoryVga" placeholder="Masukan Size Memory VGA"></td>
										<td></td>
										<td></td>
										<td></td>
										<td>VNC Viewer</td>
										<td>:</td>
										<td>
											<input class="form-control" required="" name="Vviewer" placeholder="Masukan versi VNC viewer">
										</td>
									</tr>
									<tr>
										<td>CD/DVD Rom</td>
										<td>:</td>
										<td>
											<select class="slcCdRom form-control"  style="width: 100%;" name="txtCdRom" required>
												<option value="TIDAK">TIDAK</option>
												<option value="ADA">ADA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>LAN Card</td>
										<td>:</td>
										<td><input type="text" class="form-control" name="txtLanCard" required placeholder="Masukan Merk LAN Card" onkeyup="this.value = this.value.toUpperCase()"></td>
									</tr>
								</table>
							</div>
							<div class="col-xs-12 text-right">
								<label>
									<input type="checkbox" value="1" name="verifikasi"> Sudah di Verifikasi
								</label>
							</div>
							<div class="col-xs-12 text-right">
								<button type="submit" id="show_login" class="btn btn-primary">Save</button>
							</div>
						</div>   
					</div>
				</div>
			</div>
		</form>
	</div>
</section>
<?php if ($this->session->userdata('saved_hardware')): ?>
<script>
	window.addEventListener('load', function () {
		notif_save_hardware('save');
	});
</script>
<?php endif ?>