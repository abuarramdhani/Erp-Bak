<section style="">
	<div class="row" style="padding: 40px;padding-bottom: 0px;">
		<div class="col-lg-11 text-right">
			<h1><b>Booking Kendaraan</b></h1>
		</div>
		<div class="col-lg-1">
			<a href="<?php echo base_url('BookingKendaraan/CariMobil/konfirmasi'); ?>" class="btn btn-lg btn-default">
				<i class="icon-wrench icon-2x"></i>
			</a>
		</div>
	</div>
	<div class="panel-group" style="margin: 30px; margin-top: 0px;">
		<div class="panel panel-primary">
			<div class="panel-heading">
				
			</div>
			<div class="panel-body" >
				<ul class="nav nav-pills nav-justified">
					  <li ><a href="<?php echo base_url('BookingKendaraan/CariMobil/index'); ?>">List Mobil</a></li>
					  <li class="disabled"><a href="#">Isi Data</a></li>
					  <li class="active"><a href="<?php echo base_url('BookingKendaraan/CariMobil/konfirmasi'); ?>">Konfirmasi</a></li>
					</ul>
					<div style="width: 100%;height: 100%; background-color: white;float: right">
						<div class="100%" style="text-align: center;margin-top: 40px;">
							<label>Silahkan menghubungi PIC yang bersangkutan !</label>
						</div>
						<br>
						<div class="row">
							<div class="col-lg-3">
								<div style="width: 183px;height: 100px;background-color: grey;margin: 30px">
									<img style="width: 183px;height: 100px;" src="<?php echo "http://erp.quick.com/assets/upload/GA/Kendaraan/".$kendaraan[0]['foto_kendaraan']; ?>">
								</div>
							</div>
							<div class="col-lg-4">
								<div style="width: 100%;margin-top: 30px;"> 
									<label><?php echo $kendaraan[0]['merk_kendaraan']; ?></label>
									<br>
									<label><?php echo $kendaraan[0]['nomor_polisi']; ?></label>
								</div>
							</div>
							<div class="col-lg-4">
								<div style="width: 100%;margin-top: 30px;"> 
									<label>PIC : <?php if ($pic != "") {
										 echo $pic[0]['nama'];
									}else{
										echo "-";
										} ?></label>
									<br>
									<label style="margin-left: 37px;"><?php if ($pic != "") {
										 echo $pic[0]['noind'];
									}else{
										echo "-";
										} ?></label>
									<br>
									<label><?php if ($pic != "") {
										 echo $pic[0]['seksi'];
									}else{
										echo "-";
										} ?></label>
									<br>
									<label>Voip : </label>
								</div>
							</div>
						</div>
						<br>
						<div style="width: 100%;text-align: center;">
							<label style="background-color: #ffb84d;padding: 10px; border-radius: 5px 5px;color: white">Menunggu Konfirmasi</label>
						</div>
						<br>
						<br>
					</div>
			</div>
		</div>
	</div>
</section>