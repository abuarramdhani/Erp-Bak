<section>
	<div style="width: 100%;padding: 50px;">
		<div class="row">
			<div class="col-lg-11 text-right">
				<h1><b>Log Booking Kendaraan</b></h1>
			</div>
			<div class="col-lg-1">
				<a href="<?php echo base_url('BookingKendaraan/LogPeminjaman'); ?>" class="btn btn-lg btn-default">
					<i class="icon-wrench icon-2x"></i>
				</a>
			</div>
		</div>
		<div style="width: 100%">
			<div class="panel-group">
				 <div class="panel panel-primary">
				 	<div class="panel-heading">
				 		
				 	</div>
				 	<div class="panel-body">
				 		<div style="background-color: white;width: 90%;margin: 0px auto;height: 100%;">
				 			<!-- <div class="row">
			 					<div class="col-lg-3">
			 						<div style="width: 183px;height: 100px;background-color: grey;margin: 30px">
			 							
			 						</div>
			 					</div>
			 					<div class="col-lg-4">
			 						<div style="width: 100%;margin-top: 30px;"> 
			 							<label>ISUZU - Panther</label>
			 							<br>
			 							<label>( AB XXXX BA )</label>
			 						</div>
			 					</div>
			 					<div class="col-lg-4">
			 						<div style="width: 100%;margin-top: 30px;"> 
			 							<label>PIC : Alfian Afief Nurtamsa</label>
			 							<br>
			 							<label style="margin-left: 37px;">B0689</label>
			 							<br>
			 							<label>Information & Communication Technology</label>
			 							<br>
			 							<label>Voip : 12300 (ext 3)</label>
			 						</div>
			 					</div>
				 			</div> -->
				 			<table width="100%" class="table table-stripped">
				 				<thead>
				 					<tr>
				 						<th>No</th>
				 						<th>Tgl</th>
				 						<th>Jam</th>
				 						<th>Mobil</th>
				 						<th>PIC</th>
				 						<th>Seksi</th>
				 						<th>Voip</th>
				 						<th width="8%">Status</th>
				 					</tr>
				 				</thead>
				 				<tbody>
				 					<?php
				 						$no = 1;
				 						foreach ($log as $key) {
				 							
				 						
				 					?>
				 					<tr>
				 						<td><?php echo $no;?></td>
				 						<td><?php
				 								$tgl = explode(" ", $key['dari']);
				 								echo $tgl[0];
				 							 ?>
				 						</td>
				 						<td>
				 							<?php
				 								$tgl = explode(" ", $key['dari']);
				 								echo $tgl[1];
				 							 ?>
				 						</td>
				 						<td><img style="width: 183px;height: 100px;" src="<?php echo "http://erp.quick.com/assets/upload/GA/Kendaraan/".$key['foto_kendaraan']; ?>"><br><?php echo $key['merk_kendaraan']; ?> <br> <?php echo $key['nomor_polisi']; ?></td>
				 						<td><?php echo $key['pic_kendaraan']; ?></td>
				 						<td><?php echo $key['pic_seksi']; ?></td>
				 						<td><?php echo $key['pic_voip']; ?></td>
				 						<td>
				 							<?php if ($key['confirmed'] == 0) {
				 								?>
				 								<button type="button" class="btn btn-xs btn-warning">Waiting...</button>
				 								<?php
				 							}elseif ($key['confirmed'] == 1){
				 								?>
				 								<button type="button" class="btn btn-xs btn-success">Confirmed</button>
				 								<?php
				 								} ?>
				 							
				 							
				 						</td>
				 					</tr>
				 					<?php
				 					$no++;
				 						}
				 					?>
				 				</tbody>
				 			</table>
				 		</div>
				 	</div>
				 </div>
			</div>
			
		</div>
	</div>
	
</section>