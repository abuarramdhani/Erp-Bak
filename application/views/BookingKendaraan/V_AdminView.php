<section id="content">
	<div class="row" style="padding: 40px;padding-bottom: 0px;">
		<div class="col-lg-11 text-right">
			<h1><b>Admin Booking Kendaraan</b></h1>
		</div>
		<div class="col-lg-1">
			<a href="<?php echo base_url('BookingKendaraan/AdminBookingKendaraan'); ?>" class="btn btn-lg btn-default">
				<i class="icon-wrench icon-2x"></i>
			</a>
		</div>
	</div>
	<div class="panel-group" style="margin: 20px; margin-top: 0px;">
		<div class="panel panel-primary">
			<div class="panel-heading">
				
			</div>
			<div class="panel-body">
				<table width="100%">
					<thead>
						<tr>
							<th>No</th>
							<th>Tanggal</th>
							<th>Jam</th>
							<th>Mobil</th>
							<th>Pengemudi</th>
							<th>Pemohon</th>
							<th>Tujuan</th>
							<th>Keperluan</th>
							<th width="8%">Status</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$no=1;
							if (empty($data)) {
								# code...
							}else{
							foreach ($data as $key) {
								
							
						?>
						<tr>
							<td><?php echo $no; ?></td>
							<td><?php echo date('Y-m-d',strtotime($key['tanggal'])); ?></td>
							<td><?php echo date('H:i:s',strtotime($key['dari'])); ?></td>
							<td><img style="width: 183px;height: 100px;" src="<?php echo "http://erp.quick.com/assets/upload/GA/Kendaraan/".$key['foto_kendaraan']; ?>"><br><?php echo $key['merk_kendaraan']; ?> <br> <?php echo $key['nomor_polisi']; ?></td>
							<td><?php foreach ($pengemudi as $pen) {
								if ($pen['noind'] == $key['pengemudi']) {
									echo $pen['nama'];
								}
							} ?></td>
							<td><?php foreach ($pemohon as $pem) {
								if ($pem['noind'] == $key['pemohon']) {
									echo $pem['nama'];
								}
							} ?></td>
							<td><?php echo $key['tujuan']; ?></td>
							<td><?php echo $key['keperluan']; ?></td>
							<td><?php
									if ($key['confirmed'] == 0) {
										?>
										<button type="submit" class="btn btn-sm btn-danger">Confirm</button>
										<?php
									}elseif ($key['confirmed'] == 1){
										?>
										<button type="submit" class="btn btn-sm btn-success">Confirmed</button>
										<?php
									}
							?>
								
								
							</td>
						</tr>
						<?php
						$no++;
							}
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>