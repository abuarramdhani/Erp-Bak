<style>
/* Block out what is behind the fixed column's header and footer */
table.DTFC_Cloned thead,
table.DTFC_Cloned tfoot {
background-color: #337ab7;
}

/* Block out the gap above the scrollbar on the right, when there is a fixed
* right column
*/
div.DTFC_Blocker {
background-color: #337ab7;
}
</style>
<div class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11 text-right"><h3><b><?=$Title ?></b></h3></div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a href="" class="btn btn-default btn-lg"><span class="icon-wrench icon-2x"></span></a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" method="POST" action="<?php echo site_url('MasterPresensi/ReffGaji/PekerjaKeluar/Proses') ?>">
											<div class="form-group">
												<label class="control-label col-lg-2">Periode Keluar</label>
												<div class="col-lg-3">
													<input type="text" class="date form-control" name="txtPeriodeGaji" id="txtPeriodeGajiPKJKeluar" required value="<?php if(isset($_POST['txtPeriodeGaji'])){echo $_POST['txtPeriodeGaji'];} ?>">
												</div>
												<label class="control-label col-lg-2">Puasa</label>
												<div class="col-lg-1">
													<input type="checkbox" class="form-control" name="txtPuasa" name="txtPuasaPKJKeluar" id="txtPuasaPKJKeluar" value="puasa" <?php if(isset($_POST['txtPuasa'])){echo "checked";} ?>>
												</div>
												<div class="col-lg-3">
													<input type="text" class="date form-control" name="txtPeriodePuasa" id="txtPeriodePuasaPKJKeluar" <?php if(!isset($_POST['txtPeriodePuasa'])){echo "disabled";}else{echo "value='".$_POST['txtPeriodePuasa']."'";} ?> required>
												</div>												
											</div>
											<div class="form-group">
												<label class="control-label col-lg-2">Status Pekerja</label>
												<div class="col-lg-3">
													<select class="select select2" name="slcStatusPekerja" id="slcStatusPekerja" data-placeholder="Pilih Status Pekerja" style="width: 100%" required>
														<option></option>
														<option value="A" <?php if(isset($_POST['slcStatusPekerja']) && $_POST['slcStatusPekerja'] == "A"){echo "selected";} ?>>A - Pekerja Non Staf / Operator</option>
														<option value="B" <?php if(isset($_POST['slcStatusPekerja']) && $_POST['slcStatusPekerja'] == "B"){echo "selected";} ?>>B - Pekerja Staf</option>
														<option value="D" <?php if(isset($_POST['slcStatusPekerja']) && $_POST['slcStatusPekerja'] == "D"){echo "selected";} ?>>D - Trainee Staf</option>
														<option value="E" <?php if(isset($_POST['slcStatusPekerja']) && $_POST['slcStatusPekerja'] == "E"){echo "selected";} ?>>E - Trainee Non Staf</option>
														<option value="H" <?php if(isset($_POST['slcStatusPekerja']) && $_POST['slcStatusPekerja'] == "H"){echo "selected";} ?>>H - Kontrak Non Staf</option>
														<option value="J" <?php if(isset($_POST['slcStatusPekerja']) && $_POST['slcStatusPekerja'] == "J"){echo "selected";} ?>>J - Kontrak Staf</option>
														<option value="T" <?php if(isset($_POST['slcStatusPekerja']) && $_POST['slcStatusPekerja'] == "T"){echo "selected";} ?>>T - Kontrak Non Staff Khusus</option>
													</select>
												</div>
												<label class="control-label col-lg-2">Khusus Ganti Tahun</label>
												<div class="col-lg-1">
													<input type="checkbox" class="form-control" name="txtKhususPKJKeluarCheckList" id="txtKhususPKJKeluarCheckList" value="khusus" <?php if(isset($_POST['txtKhususPKJKeluarCheckList'])){echo "checked";} ?>>
												</div>
												<div class="col-lg-3">
													<div class="col-lg-6">
														<input type="radio" class="form-control" name="txtKhususPKJKeluar" id="txtKhususPKJKeluarSebelum" <?php if(!isset($_POST['txtKhususPKJKeluar'])){echo "disabled";} ?> value="sebelum" <?php if(isset($_POST['txtKhususPKJKeluar']) && $_POST['txtKhususPKJKeluar'] == "sebelum"){echo "checked";} ?>>Sebelum														
													</div>
													<div class="col-lg-6">
														<input type="radio" class="form-control" name="txtKhususPKJKeluar" id="txtKhususPKJKeluarSesudah" <?php if(!isset($_POST['txtKhususPKJKeluar'])){echo "disabled";} ?> value="sesudah" <?php if(isset($_POST['txtKhususPKJKeluar']) && $_POST['txtKhususPKJKeluar'] == "sesudah"){echo "checked";} ?>>Sesudah														
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-2">Nomor Induk</label>
												<div class="col-lg-3">
													<select class="slcPekerjaGajiPKJKeluar" multiple="multiple" name="slcPekerja[]" data-placeholder = "Pilih Nomor Induk" style="width: 100%">
														<option></option>
													</select>
												</div>
												<label class="control-label col-lg-2">Pot. Seragam</label>
												<div class="col-lg-4">
													<input type="number" placeholder="Pot. Seragam Kode H" class="form-control" name="txtPotSeragam" id="txtPotSeragamPKJKeluar" value="<?php if(isset($_POST['txtPotSeragam'])){echo $_POST['txtPotSeragam'];} ?>">
												</div>
											</div>
											<div class="form-group">												
												<div class="col-lg-6 text-right">
													<button type="submit" class="btn btn-primary">Proses</button>
												</div>
											</div>
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12 text-right">
										<?php if(isset($_POST['txtPeriodeGaji'])){
											?>
											<form target="_blank" method="POST" style="float: right;margin-right: 20px;margin-bottom: 20px" action="<?php echo site_url('MasterPresensi/ReffGaji/PekerjaKeluar/Export') ?>">
												<input type="hidden" name="txtPuasa2" value="<?php if(isset($_POST['txtPuasa'])){echo $_POST['txtPuasa'];} ?>">
												<input type="hidden" name="txtPeriodePuasa2" value="<?php if(isset($_POST['txtPeriodePuasa'])){echo $_POST['txtPeriodePuasa'];} ?>">
												<input type="hidden" name="txtPeriodeGaji2" value="<?php if(isset($_POST['txtPeriodeGaji'])){echo $_POST['txtPeriodeGaji'];} ?>">
												<input type="hidden" name="slcStatusPekerja2" value="<?php if(isset($_POST['slcStatusPekerja'])){echo $_POST['slcStatusPekerja'];} ?>">
												<?php
													if (isset($_POST['slcPekerja'])){
														foreach ($_POST['slcPekerja'] as $key) { ?>
															<input type="hidden" name="slcPekerja2[]" value="<?php echo $key; ?>">
												<?php 		}
													}else{ ?>
														<input type="hidden" name="slcPekerja2[]" value="">
												<?php } ?>
												<input type="hidden" name="txtPotSeragam2" value="<?php if(isset($_POST['txtPotSeragam'])){echo $_POST['txtPotSeragam'];} ?>">
												<input type="hidden" name="txtKhususPKJKeluarCheckList2" value="<?php if(isset($_POST['txtKhususPKJKeluarCheckList'])){echo $_POST['txtKhususPKJKeluarCheckList'];} ?>">
												<input type="hidden" name="txtKhususPKJKeluar2" value="<?php if(isset($_POST['txtKhususPKJKeluar'])){echo $_POST['txtKhususPKJKeluar'];} ?>">
												<button class="btn btn-info" type="submit">DBF</button>
											</form>
											<form target="_blank" method="POST" style="float: right;margin-right: 20px;margin-bottom: 20px" action="<?php echo site_url('MasterPresensi/ReffGaji/PekerjaKeluar/ExportExcel') ?>">
												<input type="hidden" name="txtPuasa2" value="<?php if(isset($_POST['txtPuasa'])){echo $_POST['txtPuasa'];} ?>">
												<input type="hidden" name="txtPeriodePuasa2" value="<?php if(isset($_POST['txtPeriodePuasa'])){echo $_POST['txtPeriodePuasa'];} ?>">
												<input type="hidden" name="txtPeriodeGaji2" value="<?php if(isset($_POST['txtPeriodeGaji'])){echo $_POST['txtPeriodeGaji'];} ?>">
												<input type="hidden" name="slcStatusPekerja2" value="<?php if(isset($_POST['slcStatusPekerja'])){echo $_POST['slcStatusPekerja'];} ?>">
												<?php
													if (isset($_POST['slcPekerja'])){
														foreach ($_POST['slcPekerja'] as $key) { ?>
															<input type="hidden" name="slcPekerja2[]" value="<?php echo $key; ?>">
												<?php 		}
													}else{ ?>
														<input type="hidden" name="slcPekerja2[]" value="">
												<?php } ?>
												<input type="hidden" name="txtPotSeragam2" value="<?php if(isset($_POST['txtPotSeragam'])){echo $_POST['txtPotSeragam'];} ?>">
												<input type="hidden" name="txtKhususPKJKeluarCheckList2" value="<?php if(isset($_POST['txtKhususPKJKeluarCheckList'])){echo $_POST['txtKhususPKJKeluarCheckList'];} ?>">
												<input type="hidden" name="txtKhususPKJKeluar2" value="<?php if(isset($_POST['txtKhususPKJKeluar'])){echo $_POST['txtKhususPKJKeluar'];} ?>">
												<button class="btn btn-success" type="submit">Excel</button>
											</form>
											<?php
										} ?>
										<?php
											$text = "get=1";
											if(isset($_POST['txtPuasa'])){
												$text .= "&txtPuasa2=".$_POST['txtPuasa'];
											}
											if(isset($_POST['txtPeriodePuasa'])){
												$text .= "&txtPeriodePuasa2=".$_POST['txtPeriodePuasa'];
											}
											if(isset($_POST['txtPeriodeGaji'])){
												$text .= "&txtPeriodeGaji2=".$_POST['txtPeriodeGaji'];
											}
											if(isset($_POST['slcStatusPekerja'])){
												$text .= "&slcStatusPekerja2=".$_POST['slcStatusPekerja'];
											}
											if(isset($_POST['slcPekerja'])){
												foreach ($_POST['slcPekerja'] as $key) {
													$text .= "&slcPekerja2[]=".$key;
												}
											}
											if(isset($_POST['txtPotSeragam'])){
												$text .= "&txtPotSeragam2=".$_POST['txtPotSeragam'];
											}
											if(isset($_POST['txtKhususPKJKeluar'])){
												$text .= "&txtKhususPKJKeluar2=".$_POST['txtKhususPKJKeluar'];
											}
											if(isset($_POST['txtKhususPKJKeluarCheckList'])){
												$text .= "&txtKhususPKJKeluarCheckList2=".$_POST['txtKhususPKJKeluarCheckList'];
											}
										?>
										<?php if(isset($_POST['txtPeriodeGaji'])){ ?>
											<a target="_blank" style="float: right;margin-right: 20px;margin-bottom: 20px" href="<?php echo base_url('MasterPresensi/ReffGaji/PekerjaKeluar/print_pdf?'.$text) ?>" class="btn btn-danger">Print</a>
										<?php } ?>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<table class="table table-bordered table-hover table-striped" id="table-gaji-pekerja-keluar" style="width: 100%">
											<thead>
												<tr>
													<th>No</th>
													<th>Noind</th>
													<th>Nama</th>
													<th>Kodesie</th>
													<th>Seksi</th>
													<th>Tanggal Keluar</th>
													<th>IP</th>
													<th>IK</th>
													<th>UBT</th>
													<th>UPAMK</th>
													<th>IF</th>
													<th>LEMBUR</th>
													<th>HTM</th>
													<th>ABS</th>
													<th>Ijin</th>
													<th>Sisa Cuti</th>
													<th>Keterangan</th>
													<th>UM Puasa</th>
													<th>IMS</th>
													<th>IMM</th>
													<th>IPT</th>
													<th>UM Cabang</th>
													<th>Uang DL</th>
													<th>Pot. Seragam</th>
													<th>Pot. Lain</th>
													<th>Tambahan</th>
													<th>Potongan</th>
													<th>Jumlah JKN</th>
													<th>Jumlah JHT</th>
													<th>Jumlah JP</th>
													<th>Jumlah Duka</th>
													<th>Total Duka</th>
												</tr>
											</thead>
											<tbody>
												<?php if (isset($data) && !empty($data)) {
													$angka = 1;
													foreach ($data as $key) { ?>
														<tr>
															<td><?=$angka ?></td>
															<td><a target="_blank" href="<?php echo base_url('MasterPresensi/ReffGaji/PekerjaKeluar/detail_absensi/'.$key['noind']) ; ?>"><?=$key['noind'] ?></a></td>
															<td><?=$key['nama'] ?></td>
															<td><?=$key['kodesie'] ?></td>
															<td><?=$key['seksi'] ?></td>
															<td><?=$key['tgl_keluar'] ?></td>
															<td><?=$key['ip'] ?></td>
															<td><?=$key['ik'] ?></td>
															<td><?=$key['ubt'] ?></td>
															<td><?=$key['upamk'] ?></td>
															<td><?=$key['if'] ?></td>
															<td><?=$key['lembur'] ?></td>
															<td><?=$key['htm'] ?></td>
															<td><?=$key['tm'] ?></td>
															<td><?=$key['tik'] ?></td>
															<td><?=$key['sisa_cuti'] ?></td>
															<td><?=$key['sk_susulan']+$key['cuti_susulan'] ?></td>
															<td><?=$key['um_puasa'] ?></td>
															<td><?=$key['ims'] ?></td>
															<td><?=$key['imm'] ?></td>
															<td><?=$key['ipt'] ?></td>
															<td><?=$key['um_cabang'] ?></td>
															<td><?=$key['um_dl'] ?></td>
															<td><?=$key['pot_seragam'] ?></td>
															<td><?=$key['pot_lain'] ?></td>
															<td><?=$key['tam_susulan'] ?></td>
															<td><?=$key['pot_susulan'] ?></td>
															<td><?=$key['jml_jkn'] ?></td>
															<td><?=$key['jml_jht'] ?></td>
															<td><?=$key['jml_jp'] ?></td>
															<td><?=$key['jml_duka'] ?></td>
															<td><?=$key['nom_duka'] ?></td>
														</tr>
													<?php $angka++;
													}
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
</div>
