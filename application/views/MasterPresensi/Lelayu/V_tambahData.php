<style media="screen">
	.swal-wide{
	 width:250px !important;
	}
</style>
<?php if($spsi != 'alert'): ?>
<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
								<div class="text-right"><h1><b><?= $Title ?></b></h1></div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
									<a class="btn btn-default btn-lg" href="<?php echo site_url('CateringTambahan');?>">
											<i class="icon-wrench icon-2x"></i>
									</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
				<div class="col-lg-12">
					<div class="box box-primary box-solid">
						<div class="box-header with-border"></div>
							<div class="box-body box-primary">
								<div class="row" style="margin-top: 50px;">
									<div class="col-lg-12">
											<div class="col-lg-5 text-right">
												<label>Pilih Pekerja</label>
											</div>
											<label class="col-lg-1" style="width: 10px;">: </label>
											<div class="col-lg-4 text-left">
												<select type="select select2" class="form-control" id="selectPekerja" name="nama_lelayu">
													<option></option>
													<?php foreach ($pekerja as $key) { ?>
														<option value="<?php echo $key['noind'] ?>"><?php echo $key['noind']." - ".$key['nama'] ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-lg-12">
											<div class="col-lg-5 text-right">
												<label>Tanggal Lelayu</label>
											</div>
											<label class="col-lg-1" style="width:10px">:</label>
											<div class="col-lg-4 text-left">
												<input type="text" class="form-control" id="waktu" name="tanggal_lelayu" value="<?php echo $today ?>" readonly>
											</div>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-lg-12">
											<div class="col-lg-5 text-right">
												<label>Keterangan</label>
											</div>
											<label class="col-lg-1" style="width: 10px;">:</label>
											<div class="col-lg-4">
												<textarea class="form-control" name="keterangan_Lelayu" id="keterangan_Lelayu"></textarea>
											</div>
										</div>
									</div>
									<br><hr><br>
									<div class="row" style="padding-left: 100px; padding-right: 100px;">
										<div class="col-lg-12">
											<div class="row">
												<div class="col-lg-12">
													<label><b>Uang Duka Perusahaan</b></label>
												</div>
												<div class="col-lg-9" style="padding-left: 70px;">
													<h5>Kain Kafan</h5>
												</div>
												<h5 class="col-lg-1 text-right">Rp</h5>
												<div class="col-lg-2 text-right">
													<h5 name="nomKafan" id="id_kafan" value="<?php echo $data['0']['kain_kafan'] ?>"><?php echo number_format($data['0']['kain_kafan'],2,',','.') ?></h5>
												</div>
												<div class="col-lg-9" style="padding-left: 70px;">
													<h5>Uang Duka</h5>
												</div>
												<h5 class="col-lg-1 text-right">Rp</h5>
												<div class="col-lg-2 text-right">
													<h5 name="nomDuka" id="uang_Duka" value="<?php echo $data['0']['uang_duka'] ?>"><?php echo number_format($data['0']['uang_duka'],2,',','.') ?></h5>
												</div>
											</div>
										</div>
									</div>
									<br>
									<div class="row" style="padding-left: 100px; padding-right: 100px;">
										<div class="col-lg-12">
											<div class="row">
												<div class="col-lg-12">
													<label><b>Uang Duka SPSI</b></label>
												</div>
												<div class="col-lg-6" style="padding-left: 70px;">
													<h5>Askanit ke-Atas</h5>
												</div>
												<div class="col-lg-2 text-right">
													<h5 name="askanit" id="askanit" value="<?php echo $spsi."	x " ?>"><?php echo $spsi."	x "." Rp " ?></h5>
												</div>
												<div class="col-lg-1 text-right">
													<h5 name="nomAskanit" id="nomAskanit" value="<?php echo $nominal ?>"><?php echo number_format($nominal,2,',','.'); ?></h5>
												</div>
												<h5 class="col-lg-1 text-right">Rp</h5>
												<div class="col-lg-2 text-right">
													<h5 name="totalAskanit" id="totalAskanit" value="<?php $total1 = $spsi*$nominal; echo $total1 ?>"><?php
															echo number_format($total1,2,',','.'); ?></h5>
												</div>

												<div class="col-lg-6" style="padding-left: 70px;">
													<h5>Kasie Madya - Kasie Utama</h5>
												</div>
												<div class="col-lg-2 text-right">
													<h5 name="madya" id="madya" value="<?php echo $spsi1." x " ?>"><?php echo $spsi1." x "." Rp " ?></h5>
												</div>
												<div class="col-lg-1 text-right">
													<h5 name="nomMadya" id="nomMadya" value="<?php echo $nominal1 ?>"><?php echo number_format($nominal1,2,',','.'); ?></h5>
												</div>
												<h5 class="col-lg-1 text-right">Rp</h5>
												<div class="col-lg-2 text-right">
													<h5 name="totMadya" id="totMadya" value="<?php $total2 = $spsi1*$nominal1; echo $total2 ?>"><?php
															echo number_format($total2,2,',','.'); ?></h5>
												</div>

												<div class="col-lg-6" style="padding-left: 70px;">
													<h5>Supervisor - Kasie Pratama</h5>
												</div>
												<div class="col-lg-2 text-right">
													<h5 name="supervisor" id="supervisor" value="<?php echo $spsi2." x " ?>"><?php echo $spsi2." x "." Rp " ?></h5>
												</div>
												<div class="col-lg-1 text-right">
													<h5 name="nomSuper" id="nomSuper" value="<?php echo $nominal2 ?>"><?php echo number_format($nominal2,2,',','.'); ?></h5>
												</div>
												<h5 class="col-lg-1 text-right">Rp</h5>
												<div class="col-lg-2 text-right">
													<h5 name="totSuper" id="totSuper" value="<?php $total3 = $spsi2*$nominal2; echo $total3 ?>"><?php
															echo number_format($total3,2,',','.'); ?></h5>
												</div>

												<div class="col-lg-6" style="padding-left: 70px;">
													<h5>Non Staff dan Staff Non Manajerial</h5>
												</div>
												<div class="col-lg-2 text-right">
													<h5 name="nonStaff" id="nonStaff" value="<?php echo $spsi3." x " ?>"><?php echo $spsi3." x "." Rp " ?></h5>
												</div>
												<div class="col-lg-1 text-right">
													<h5 name="nomNon" id="nomNon" value="<?php echo $nominal3 ?>"><?php echo number_format($nominal3,2,',','.'); ?></h5>
												</div>
												<h5 class="col-lg-1 text-right">Rp</h5>
												<div class="col-lg-2 text-right">
													<h5 name="totNon" id="totNon" value="<?php $total4 = $spsi3*$nominal3; echo $total4 ?>"><?php
															echo number_format($total4,2,',','.'); ?></h5>
												</div>
											</div>
										</div>
									</div>
									<br>
									<div class="row" style="padding-left: 100px; padding-right: 100px;">
										<div class="col-lg-12">
											<div class="row">
												<div class="col-lg-9">
													<label><b>Total</b></label>
												</div>
												<h5 class="col-lg-1 text-right">Rp</h5>
												<div class="col-lg-2 text-right">
													<h5><?php
															$totalall = $data['0']['kain_kafan']+$data['0']['uang_duka']+$total1+$total2+$total3+$total4;
															echo number_format($totalall,2,',','.'); ?></h5>
												</div>
											</div>
										</div>
									</div>
									<br>
									<div class="row">
									<div class="col-lg-12 text-center">
										<button class="btn btn-primary" onclick="MP_simpan_lelayu()">Simpan</button>
									</div>
								</div>
								<br>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>
<script type="text/javascript">
	$(document).ready(function(){
		let spsi 	= '<?= $spsi ?>'
		let spsi1 = '<?= $spsi1 ?>'
		let spsi2 = '<?= $spsi2 ?>'
		let spsi3 = '<?= $spsi3 ?>'
		console.log(spsi, spsi1, spsi2, spsi3)
		if(spsi == 'alert' || spsi1 == 'alert' ||spsi2 == 'alert' ||spsi3 == 'alert'){
			swal.fire({
				title:'Peringatan',
				text:'Periode Cutoff tidak ditemukan',
				type:'warning',
				showConfirmButton:true
			})
			window.location.href = baseurl+"MasterPresensi";
		}
	})
</script>
