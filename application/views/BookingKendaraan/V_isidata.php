<section style="">
	<div class="row" style="padding: 40px;padding-bottom: 0px;">
		<div class="col-lg-11 text-right">
			<h1><b>Booking Kendaraan</b></h1>
		</div>
		<div class="col-lg-1">
			<a href="<?php echo base_url('BookingKendaraan/CariMobil/isidata'); ?>" class="btn btn-lg btn-default">
				<i class="icon-wrench icon-2x"></i>
			</a>
		</div>
	</div>
	<div class="panel-group" style="margin: 30px;margin-top: 0px;">
		<div class="panel panel-primary">
			<div class="panel-heading">
				
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-justified">
				  <li ><a href="<?php echo base_url('BookingKendaraan/CariMobil/index'); ?>">List Mobil</a></li>
				  <li class="active"><a href="<?php echo base_url('BookingKendaraan/CariMobil/isidata'); ?>">Isi Data</a></li>
				  <li class="disabled"><a href="#">Konfirmasi</a></li>
				</ul>
				<div style="width: 100%;">
					<div style="width: 60%;height: 100%; margin: 0px auto;background-color: white;padding-top: 30px;">
						<form method="POST" action="<?php echo base_url('BookingKendaraan/CariMobil/simpanbooking'); ?>">
						<div style="width: 100%;">
							<input name="kendaraan_id" value="<?php echo $id; ?>" hidden></input>
							<div class="row">
								<div class="col-lg-6">
									<div class="row">
										<div class="col-lg-4 text-right">
											<label style="margin-top: 8px;">Pengemudi</label>
										</div>
										<div class="col-lg-8">
											<select name="pengemudi_mobil" id="pengemudi_mobil" class="form-control" required></select>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-lg-4 text-right">
											<label style="margin-top: 8px;">Tanggal</label>
										</div>
										<div class="col-lg-8">
											<label>dari :</label>
											<input name="periode_booking1" id="periode_booking" class="form-control cal_periode_booking" required></input>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-lg-4">
										</div>
										<div class="col-lg-8">
											<label>sampai :</label>
											<input name="periode_booking2" id="periode_booking" class="form-control cal_periode_booking" required></input>
										</div>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="row">
										<div class="col-lg-4 text-right">
											<label style="margin-top: 8px;">Tujuan</label>
										</div>
										<div class="col-lg-8">
											<textarea required name="tujuan_booking" id="periode_booking" class="form-control"></textarea>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-lg-4 text-right">
											<label style="margin-top: 8px;">Keperluan</label>
										</div>
										<div class="col-lg-8">
											<textarea required name="keperluan_booking" id="keperluan_booking" class="form-control"></textarea>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-lg-4 text-right">
											<label style="margin-top: 8px;">Pemohon</label>
										</div>
										<div class="col-lg-8">
											<select name="pemohon_booking" id="pemohon_booking" class="form-control"></select>
											<span style="font-size: 11px;">*jika pemohon sama dengan pengemudi boleh dikosongi</span>
										</div>
									</div>
								</div>
							</div>
							
							<br>
							
							<div class="row">
								<div class="col-lg-12 text-center">
									<button type="submit" class="btn btn-primary">SIMPAN</button>
								</div>
							</div>
							<div style="height: 15px;">
								
							</div>
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</section>