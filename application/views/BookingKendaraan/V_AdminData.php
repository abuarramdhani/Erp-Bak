<section id="content">
	<div class="row" style="padding: 40px;padding-bottom: 0px;">
		<div class="col-lg-11 text-right">
			<h1><b>Admin Data Kendaraan</b></h1>
		</div>
		<div class="col-lg-1">
			<a href="<?php echo base_url('BookingKendaraan/DataKendaraan'); ?>" class="btn btn-lg btn-default">
				<i class="icon-wrench icon-2x"></i>
			</a>
		</div>
	</div>
	<div class="panel-group" style="margin: 20px; margin-top: 0px;">
		<div class="panel panel-primary">
			<div class="panel-heading">
				
			</div>
			<div class="panel-body">
				<form method="POST" action="<?php echo base_url('AdminBookingKendaraan/DataKendaraan/simpanData'); ?>">
				<div class="row">
					<div class="col-lg-4"></div>
					<div class="col-lg-4">
						<div class="row">
							<div class="col-lg-8">
								<label>No Induk</label>
							</div>
							<div class="col-lg-12">
								<input class="form-control" name="noind_pic" value="<?php echo $data[0]['noind']; ?>" readonly></input>
							</div>
							<div class="col-lg-8">
								<label>Nama</label>
							</div>
							<div class="col-lg-12">
								<input class="form-control" name="nama_pic" value="<?php echo $data[0]['nama']; ?>" readonly></input>
							</div>
							<div class="col-lg-8">
								<label>Seksi</label>
							</div>
							<div class="col-lg-12">
								<input class="form-control" name="seksi_pic" value="<?php echo $data[0]['seksi']; ?>" readonly></input>
							</div>
							<div class="col-lg-8">
								<label>Voip</label>
							</div>
							<div class="col-lg-12">
								<input class="form-control" name="voip_pic" placeholder="Masukan Nomor Voip" <?php
									if (empty($voip)) {
										
									}else{
										?>
										value="<?php echo $voip[0]['voip_pic']; ?>"
										<?php
									}
								?>></input>
							</div>
							<div class="col-lg-8">
								<label>Nomor MyGroup</label>
							</div>
							<div class="col-lg-12">
								<input class="form-control" name="nomor_mygrp" placeholder="Masukan Nomor MyGroup" <?php
									if (empty($voip)) {
										
									}else{
										?>
										value="<?php echo $voip[0]['mygroup_pic']; ?>"
										<?php
									}
								?>></input>
							</div>
						</div>
							<br>
						<div class="row">
							<div class="col-lg-12 text-center">
								<button type="submit" class="btn btn-primary">SIMPAN</button>
							</div>
						</div>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</section>