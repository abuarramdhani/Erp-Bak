<style>
	@media only screen and (max-width: 1060px) {
		.hw_hpv{
			overflow-x: scroll;
		}
	}
</style>
<section class="content">
	<div class="box-body">
		<form class="form-horizontal" id="form-update"  enctype="multipart/form-data" method="post" action="<?php echo site_url('hardware/view-data/updateData');?>">
			<div class="row">
				<div class="col-md-12">
					<div class="box box-default color-palette-box">
						<div class="box-header with-border">
							<h3 class="box-title"></h3>
							<div class="box-header">
								<h3><b>EDIT DATA SWEEPING KOMPUTER ICT</b></h3>
							</div>
							<?php foreach ($detailData as $key => $data): ?>
								<div class="col-md-6">
									<table class="table">
										<input type="hidden" name="hdnCheckId" value="<?php echo $data['check_id'] ?>">
										<tr>
											<th style="background-color: #99ddff;"><b>Data Umum</b></th>
											<th style="background-color: #99ddff;"></th>
											<th style="background-color: #99ddff;"></th>
										</tr>
										<tr>
											<td>No. Asset</td>
											<td>:</td>
											<td><input type="text" class="form-control" name="txtNoAsset" placeholder="Masukan No Asset" value="<?php echo $data['no_asset']; ?>" disabled required onkeyup="this.value = this.value.toUpperCase()"></td>
										</tr>
										<tr>
											<td>No Induk</td>
											<td>:</td>
											<td><!-- <input type="text" class="form-control" name="txtNoInduk" required> --><input type="text" class="form-control" name="slcNoInduk" value="<?php echo $data['no_ind']; ?>" style="width: 250px;" disabled required></td>
										</tr>
										<tr>
											<td>Nama</td>
											<td>:</td>
											<td><input type="text" class="form-control nama" name="txtNama" value="<?php echo $data['nama']; ?>" readonly required></td>
										</tr>
										<tr>
											<td>Seksi</td>
											<td>:</td>
											<td><input type="text" class="form-control seksi" name="txtSeksi" value="<?php echo $data['seksi']; ?>" readonly required></td>
										</tr>
										<tr>
											<td>Email Seksi</td>
											<td>:</td>
											<td><input type="email" class="form-control email_seksi" name="txtEmailSeksi" required value="<?= $data['email_seksi'] ?>"></td>
										</tr>
										<tr>
											<td>Email Pekerja</td>
											<td>:</td>
											<td><input type="text" class="form-control Email_Pekerja" name="txtEmailPekerja" readonly required value="<?= $data['email_pekerja'] ?>"></td>
										</tr>
										<tr>
											<td>Akun Pidgin</td>
											<td>:</td>
											<td><input type="text" class="form-control akun_pidgin" name="txtPidgin" readonly required value="<?= $data['pidgin_akun'] ?>"></td>
										</tr>
										<tr>
											<td>No Voip</td>
											<td>:</td>
											<td><input type="text" class="form-control voip" name="txtVoip" required value="<?= $data['voip'] ?>"></td>
										</tr>
										<tr>
											<td>IP Address</td>
											<td>:</td>
											<td><!-- <input type="text" class="form-control" name="txtIpAddress" required> --><input type="text" class="form-control" name="txtIpAddress" value="<?php echo $data['ip_address']; ?>" pattern="^((\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$" placeholder="Masukan IP Address" required></td>
										</tr>
										<tr>
											<td>Windows Key</td>
											<td>:</td>
											<td><input type="text" class="form-control" name="txtWindowsKey" value="<?php echo $data['windows_key']; ?>" placeholder="Masukan Windows Key" required onkeyup="this.value = this.value.toUpperCase()"></td>
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
											<td><input type="text" class="form-control" name="txtMerk" placeholder="Masukan Merk" value="<?php echo $data['merk']; ?>" required onkeyup="this.value = this.value.toUpperCase()"></td>
											<!-- history -->
											<td>Aplikasi 1</td>
											<td>:</td>
											<td><input type="text" class="form-control" name="txtAplikasi1" default-value="" value="<?php echo $data['aplikasi_1'] ? $data['aplikasi_1'] : '-'; ?>" placeholder="Masukan Aplikasi" onkeyup="this.value = this.value.toUpperCase()"></td>
											<td>Open Office</td>
											<td>:</td>
											<td>
												<input class="form-control" required="" name="openOfice" placeholder="Masukan Versi Open Office" value="<?= $data['open_office'] ?>">
											</td>
										</tr>
										<tr>
											<td>MainBoard</td>
											<td>:</td>
											<td><input type="text" class="form-control" name="txtMainboard" value="<?php echo $data['mainboard']; ?>" placeholder="Masukan Mainboard" required required onkeyup="this.value = this.value.toUpperCase()"></td>
											<!-- history -->
											<td>Aplikasi 2</td>
											<td>:</td>
											<td><input type="text" class="form-control" name="txtAplikasi2" default-value="" value="<?php echo $data['aplikasi_2'] ? $data['aplikasi_2'] : '-'; ?>" placeholder="Masukan Aplikasi" onkeyup="this.value = this.value.toUpperCase()"></td>
											<td>WPS</td>
											<td>:</td>
											<td>
												<input class="form-control" required="" name="wps" placeholder="Masukan Versi WPS" value="<?= $data['wps'] ?>">
											</td>
										</tr>
										<tr>
											<td>Processor</td>
											<td>:</td>
											<td>
												<input type="text" class="form-control" name="txtProcessor" value="<?php echo $data['processor']; ?>" disabled placeholder="Masukan Processor" required>
											</td>
											<td>Aplikasi 3</td>
											<td>:</td>
											<td>
												<input type="text" class="form-control" name="txtAplikasi3" default-value="" value="<?php echo $data['aplikasi_3'] ? $data['aplikasi_3'] : '-'; ?>" placeholder="Masukan Aplikasi" onkeyup="this.value = this.value.toUpperCase()">
											</td>
											<td>Pidgin</td>
											<td>:</td>
											<td>
												<input class="form-control" required="" name="pidgin" placeholder="Masukan Versi Pidgin" value="<?= $data['pidgin'] ?>">
											</td>
										</tr>
										<tr>
											<td>Harddisk</td>
											<td>:</td>
											<td><input type="number" min="0" class="form-control" name="txtHarddisk" value="<?php echo $data['harddisk']; ?>" placeholder="Masukan Harddisk" required></td>
											<!-- history -->
											<td>Aplikasi 4</td>
											<td>:</td>
											<td><input type="text" class="form-control" name="txtAplikasi4" default-value="" value="<?php echo $data['aplikasi_4'] ? $data['aplikasi_4'] : '-'; ?>" placeholder="Masukan Aplikasi" onkeyup="this.value = this.value.toUpperCase()"></td>
											<td>Thunderbird</td>
											<td>:</td>
											<td>
												<input class="form-control" required="" name="thunderbird" placeholder="Masukan Versi Thunderbird" value="<?= $data['thunderbird'] ?>">
											</td>
										</tr>
										<tr>
											<td>Type RAM</td>
											<td>:</td>
											<td>
												<input type="text" class="form-control" value="<?php echo $data['type_ram']; ?>" disabled required>
											</td>
											<!-- <input type="text" class="form-control" name="txtTypeRam" placeholder="Masukan Type RAM" required> -->
											<!-- history -->
											<td>Aplikasi 5</td>
											<td>:</td>
											<td><input type="text" class="form-control" name="txtAplikasi5" default-value="" value="<?php echo $data['aplikasi_5'] ? $data['aplikasi_5'] : '-'; ?>" placeholder="Masukan Aplikasi" onkeyup="this.value = this.value.toUpperCase()"></td>
											<td>Browser Chrome</td>
											<td>:</td>
											<td>
												<input class="form-control" required="" name="chrome" placeholder="Masukan Versi Chrome" value="<?= $data['browser_chrome'] ?>">
											</td>
										</tr>
										<tr>
											<td>Size RAM</td>
											<td>:</td>
											<td><input type="number" min="0" class="form-control" name="txtSizeRam" value="<?php echo $data['size_ram']; ?>" placeholder="Masukan Size RAM" required></td>
											<!-- history -->
											<td>Aplikasi 6</td>
											<td>:</td>
											<td><input type="text" class="form-control" name="txtAplikasi6" default-value="" value="<?php echo $data['aplikasi_6'] ? $data['aplikasi_6'] : '-'; ?>" placeholder="Masukan Aplikasi" onkeyup="this.value = this.value.toUpperCase()"></td>
											<td>Browser IE</td>
											<td>:</td>
											<td>
												<input class="form-control" required="" name="ie" placeholder="Masukan Versi IE" value="<?= $data['browser_ie'] ?>">
											</td>
										</tr>
										<tr>
											<td>VGA Card</td>
											<td>:</td>
											<td><input type="text" class="form-control" name="txtVgaCard" value="<?php echo $data['vga_card']; ?>" placeholder="Masukan VGA Card" onkeyup="this.value = this.value.toUpperCase()"></td>

											<td>Aplikasi 7</td>
											<td>:</td>
											<td><input type="text" class="form-control" name="txtAplikasi7" default-value="" value="<?php echo $data['aplikasi_7'] ? $data['aplikasi_7'] : '-'; ?>" placeholder="Masukan Aplikasi" onkeyup="this.value = this.value.toUpperCase()"></td>
											<td>Browser Mozzila</td>
											<td>:</td>
											<td>
												<input class="form-control" required="" name="mozzila" placeholder="Masukan Versi Mozzila" value="<?= $data['browser_mozilla'] ?>">
											</td>
										</tr>
										<tr>
											<td>Type Memory VGA</td>
											<td>:</td>
											<td>
												<input type="text" class="form-control nbdEdit" name="txtTypeMemoryVga" value="<?php echo $data['type_vga']; ?>" placeholder="Masukan Type Memory VGA" onkeyup="this.value = this.value.toUpperCase()"> 
											</td>
											<td></td>
											<td></td>
											<td></td>
											<td>Teamviewer</td>
											<td>:</td>
											<td>
												<input class="form-control" required="" name="Tviewer" placeholder="Contoh: Teamviewer versi 10" value="<?= $data['team_viewer'] ?>">
											</td>
										</tr>
										<tr>
											<td>Size Memory VGA (MB)</td>
											<td>:</td>
											<td><input type="number" min="0" class="form-control" name="txtSizeMemoryVga" value="<?php echo $data['size_vga']; ?>" placeholder="Masukan Size Memory VGA"></td>
											<td></td>
											<td></td>
											<td></td>
											<td>VNC viewer</td>
											<td>:</td>
											<td>
												<input class="form-control" required="" name="Vviewer" placeholder="Contoh: Teamviewer versi 10" value="<?= $data['vnc_viewer'] ?>">
											</td>
										</tr>
										<tr>
											<td>CD/DVD Rom</td>
											<td>:</td>
											<td>
												<?php $arr = array('TIDAK','ADA'); ?>
												<select class="slcCdRom"  style="width: 100%;" name="txtCdRom">
													<?php foreach ($arr as $a): ?>
														<option value="<?= $a ?>" <?= ($a==$data['cd_rom']) ? 'selected':'' ?>><?= $a ?></option>	
													<?php endforeach ?>
												</select>
											</td>
											<!-- <input type="text" class="form-control" name="txtCdRom" placeholder="Masukan CD/DVD Rom"> -->

										</tr>
										<tr>
											<td>LAN Card</td>
											<td>:</td>
											<td><input type="text" class="form-control" name="txtLanCard" value="<?php echo $data['lan_card']; ?>" placeholder="Masukan Merk LAN Card" onkeyup="this.value = this.value.toUpperCase()"></td>
										</tr>
									</table>
								</div>
								<!--  -->

								<div class="col-xs-12 hw_hpv">
									<table class="table" style="min-width: 800px;">
										<tr>
											<th colspan="3" style="background-color: #ffff99"><b>Windows Bajakan</b></th>
											<th colspan="5" style="background-color: #ffcce0;"><b>Data Aplikasi Bajakan</b></th>
										</tr>
										<tr>
											<td>Bajakan </td>
											<td>:</td>
											<td>
												<input type="radio" <?php echo  $data['windows_bajakan'] == '1' ? 'checked' : '' ; ?> value="1" name="bajakan"> Ya
												<input type="radio" <?php echo  $data['windows_bajakan'] == '0' ? 'checked' : '' ; ?> value="0"  name="bajakan"> Tidak
											</td>
											<!-- history -->
											<td style="width: 80px;">Aplikasi 1</td>
											<td>:</td>
											<td style="width: 200px;">
												<select style="width:100%" class="form-control apk_bjk" name="txtBajakan1" >
													<?php 
													foreach ($slc as $key => $value) {?>
													<option <?php echo $data['bajakan_1'] == $value ? 'selected' : '' ?> value="<?= $value ?>" ><?= $value ?></option>
													<?php 	}?>
												</select>
											</td>
											<td></td>
											<td><input type="text" class="form-control" name="txtalasan1" placeholder="Masukkan Alasan 1" value="<?php echo $data['bajakan_1_alasan'] ? $data['bajakan_1_alasan'] :'-'; ?>" placeholder="Masukan Aplikasi 1" onkeyup="this.value = this.value.toUpperCase()">
											</td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
											<!-- history -->
											<td>Aplikasi 2</td>
											<td>:</td>
											<td>
												<select style="width:100%" class="form-control apk_bjk" name="txtBajakan2" >
													<option value="-" selected="selected">-</option>
													<?php 
													foreach ($slc as $key => $value) {?>
													<option <?php echo $data['bajakan_2'] == $value ? 'selected' : '' ?> value="<?= $value ?>" ><?= $value ?></option>
													<?php 	}?>
												</select>
											</td>
											<td></td>

											<td><input type="text" class="form-control" name="txtalasan2" placeholder="Masukkan Alasan 2" value="<?php echo $data['bajakan_2_alasan'] ? $data['bajakan_2_alasan'] : '-'; ?>" placeholder="Masukan Aplikasi 2" onkeyup="this.value = this.value.toUpperCase()">
											</td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
											<td>Aplikasi 3</td>
											<td>:</td>
											<td>
												<select style="width:100%" class="form-control apk_bjk" name="txtBajakan3" >
													<option value="-" selected="selected">-</option>
													<?php 
													foreach ($slc as $key => $value) {?>
													<option <?php echo $data['bajakan_3'] == $value ? 'selected' : '' ?> value="<?= $value ?>" ><?= $value ?></option>
													<?php 	}?>
												</select>
											</td>
											<td></td>
											<td><input type="text" class="form-control" name="txtalasan3" placeholder="Masukkan Alasan 3" value="<?php echo $data['bajakan_3_alasan'] ? $data['bajakan_3_alasan'] : '-'; ?>" placeholder="Masukan Aplikasi 3" onkeyup="this.value = this.value.toUpperCase()">
											</td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
											<!-- history -->
											<td>Aplikasi 4</td>
											<td>:</td>
											<td>
												<select style="width:100%" class="form-control apk_bjk" name="txtBajakan4" >
													<option value="-" selected="selected">-</option>
													<?php 
													foreach ($slc as $key => $value) {?>
													<option <?php echo $data['bajakan_4'] == $value ? 'selected' : '' ?> value="<?= $value ?>" ><?= $value ?></option>
													<?php 	}?>
												</select>
											</td>
											<td></td>
											<td><input type="text" class="form-control" name="txtalasan4" placeholder="Masukkan Alasan 4" value="<?php echo $data['bajakan_4_alasan'] ? $data['bajakan_4_alasan'] : '-'; ?>" placeholder="Masukan Aplikasi" onkeyup="this.value = this.value.toUpperCase()">
											</td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
											<!-- <input type="text" class="form-control" name="txtTypeRam" placeholder="Masukan Type RAM" required> -->
											<!-- history -->
											<td>Aplikasi 5</td>
											<td>:</td>
											<td>
												<select style="width:100%" class="form-control apk_bjk" name="txtBajakan5" >
													<option value="-" selected="selected">-</option>
													<?php 
													foreach ($slc as $key => $value) {?>
													<option <?php echo $data['bajakan_5'] == $value ? 'selected' : '' ?> value="<?= $value ?>" ><?= $value ?></option>
													<?php 	}?>
												</select>
											</td>
											<td></td>
											<td><input type="text" class="form-control" name="txtalasan5" placeholder="Masukkan Alasan 5" value="<?php echo $data['bajakan_5_alasan'] ? $data['bajakan_5_alasan'] : '-'; ?>" placeholder="Masukan Aplikasi" onkeyup="this.value = this.value.toUpperCase()">
											</td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
											<!-- history -->
											<td>Aplikasi 6</td>
											<td>:</td>
											<td>
												<select style="width:100%" class="form-control apk_bjk" name="txtBajakan6" >
													<option value="-" selected="selected">-</option>
													<?php 
													foreach ($slc as $key => $value) {?>
													<option <?php echo $data['bajakan_6'] == $value ? 'selected' : '' ?> value="<?= $value ?>" ><?= $value ?></option>
													<?php 	}?>
												</select>
											</td>
											<td></td>
											<td><input type="text" class="form-control" name="txtalasan6" placeholder="Masukkan Alasan 6" value="<?php echo $data['bajakan_6_alasan'] ? $data['bajakan_6_alasan'] : '-'; ?>" placeholder="Masukan Aplikasi" onkeyup="this.value = this.value.toUpperCase()">
											</td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
											<td>Aplikasi 7</td>
											<td>:</td>
											<td>
												<select style="width:100%" class="form-control apk_bjk" name="txtBajakan7" >
													<option value="-" selected="selected">-</option>
													<?php 
													foreach ($slc as $key => $value) {?>
													<option <?php echo $data['bajakan_7'] == $value ? 'selected' : '' ?> value="<?= $value ?>" ><?= $value ?></option>
													<?php 	}?>
												</select>
											</td>
											<td></td>
											<td><input type="text" class="form-control" name="txtalasan7" placeholder="Masukkan Alasan 7" value="<?php echo $data['bajakan_7_alasan'] ? $data['bajakan_7_alasan'] : '-'; ?>" placeholder="Masukan Aplikasi" onkeyup="this.value = this.value.toUpperCase()">
											</td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
											<td>Aplikasi 8</td>
											<td>:</td>
											<td>
												<select style="width:100%" class="form-control apk_bjk" name="txtBajakan8" >
													<option value="-" selected="selected">-</option>
													<?php 
													foreach ($slc as $key => $value) {?>
													<option <?php echo $data['bajakan_8'] == $value ? 'selected' : '' ?> value="<?= $value ?>" ><?= $value ?></option>
													<?php 	}?>
												</select>
											</td>
											<td></td>
											<td><input type="text" class="form-control" name="txtalasan8" placeholder="Masukkan Alasan 8" value="<?php echo $data['bajakan_8_alasan'] ? $data['bajakan_8_alasan'] : '-'; ?>" placeholder="Masukan Aplikasi" onkeyup="this.value = this.value.toUpperCase()">
											</td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
											<td>Aplikasi 9</td>
											<td>:</td>
											<td>
												<select style="width:100%" class="form-control apk_bjk" name="txtBajakan9" >
													<option value="-" selected="selected">-</option>
													<?php 
													foreach ($slc as $key => $value) {?>
													<option <?php echo $data['bajakan_9'] == $value ? 'selected' : '' ?> value="<?= $value ?>" ><?= $value ?></option>
													<?php 	}?>
												</select>
											</td>
											<td></td>
											<td><input type="text" class="form-control" name="txtalasan9" placeholder="Masukkan Alasan 9" value="<?php echo $data['bajakan_9_alasan'] ? $data['bajakan_9_alasan'] : '-'; ?>" placeholder="Masukan Aplikasi" onkeyup="this.value = this.value.toUpperCase()">
											</td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
											<td>Aplikasi 10</td>
											<td>:</td>
											<td>
												<select style="width:100%" class="form-control apk_bjk" name="txtBajakan10" >
													<option value="-" selected="selected">-</option>
													<?php 
													foreach ($slc as $key => $value) {?>
													<option <?php echo $data['bajakan_10'] == $value ? 'selected' : '' ?> value="<?= $value ?>" ><?= $value ?></option>
													<?php 	}?>
												</select>
											</td>
											<td></td>
											<td><input type="text" class="form-control" name="txtalasan10" placeholder="Masukkan Alasan 10" value="<?php echo $data['bajakan_10_alasan'] ? $data['bajakan_10_alasan'] : '-'; ?>" placeholder="Masukan Aplikasi" onkeyup="this.value = this.value.toUpperCase()">
											</td>
										</tr>

									</table>
								</div>
								<div class="col-xs-12 text-right">
									<label>
										<input type="checkbox" <?= ($data['remark'] == 1) ? 'checked':'' ?> name="verifikasi"> Sudah di Verifikasi
									</label>
								</div>
								<div hidden="">
									<input hidden="" type="checkbox" <?= ($data['remark'] == 1) ? 'checked':'' ?> name="verifikasi_state">
								</div>
							<?php endforeach ;?>
							<div class="col-xs-12">
								<button type="submit" id="show_login" class="btn btn-primary pull-right">Update</button>
							</div>
						</div>   
					</div>
				</div>
			</div>
		</form>
	</div>
</section>
