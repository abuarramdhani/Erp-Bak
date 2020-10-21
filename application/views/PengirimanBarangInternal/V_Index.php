<section id="content">
	<div class="inner" style="background: url('<?php echo base_url('assets/img/3.jpg');?>');background-size: cover;" >


			<!-- Content Header (Page header) -->
			<section class="content-header">
					<div class="row">
						<div class="col-lg-12">
							<br />
							<h2 style="text-align: center;"><b >Pengiriman Barang Internal</b></h2>
							<h3 style="text-align: center;"><b ><?= date('d M Y')?></b></h3>
						</div>
					</div>
			</section>
			<hr />
			<div class="row">
				<div class="col-lg-12">
				    <div class="col-lg-12 text-right reup">
                        <h4><small>You are logged in as : <?php echo $this->session->user;?> (<?php echo $this->session->employee;?>)</small></h4>
					</div>

					<br>
					<br>

					<center>
					  <h2><b>
					  	JADWAL KEBERANGKATAN HIWING KHS
					  </b></h2>
					  <br>
					  <table class="table table-hover text-left" style="font-size: 16px; width: 70%;">
					    <thead>
					      <tr class="bg-success" style="border: 1px solid black;">
					        <th style="border: 1px solid black;"><center>NO</center></th>
					        <th style="border: 1px solid black;"><center>ASAL</center></th>
					        <th style="border: 1px solid black;"><center>TUJUAN</center></th>
					        <th style="border: 1px solid black;"><center>JAM (SENIN - KAMIS)</center></th>
					        <th style="border: 1px solid black;"><center>JAM (JUMAT - SABTU)</center></th>
					      </tr>
					    </thead>
					    <tbody>
					      <?php foreach ($jadwal as $key => $g): ?>
					      <tr>
					        <td style="border: 1px solid black;"><center><?php echo $g['JADWAL_ID'] ?></center></td>
					        <td style="border: 1px solid black;"><center><?php echo $g['ASAL'] ?></center></td>
					        <td style="border: 1px solid black;"><center><?php echo $g['TUJUAN'] ?></center></td>
					        <td style="border: 1px solid black;"><center><?php echo $g['SENIN_KAMIS'] ?></center></td>
					        <td style="border: 1px solid black;"><center><?php echo $g['JUMAT_SABTU'] ?></center></td>
					      </tr>
					      <?php endforeach; ?>
					    </tbody>
					  </table>

					  <h4 style="font-style: italic;">
					  	Jadwal ke Mlati menyesuaikan kebutuhan<br>
						Pengiriman barang yang akan dimuat ke Hwing <b style="color: red;">paling lambat 20 menit</b> sebelum berangkat<br>
						* untuk jam keberangkatan dari Tuksono tidak bisa di paskan	
					  </h4>

						<br>
						<br>

						<?php $load = microtime();
							echo '<p style="font: normal 15px courier">Halaman ini dimuat dalam ';
							echo round($load, 3);
							echo ' detik';
						?>
					</center>

				</div>
			</div>
		</div>

</section>
