<section id="content">
	<div class="inner" style="background: url('<?php echo base_url('assets/img/3.jpg');?>');background-size: cover;" >


			<!-- Content Header (Page header) -->
			<section class="content-header">
					<div class="row">
						<div class="col-lg-12">
							<br />
							<h2 style="text-align: center;"><b >Kalibrasi Abu Metal Sheet</b></h2>
							<h3 style="text-align: center;"><b ><?= date('d M Y')?></b></h3>
						</div>
					</div>
			</section>
			<hr />
			<div class="row">
				<div class="col-lg-12">
				    <div class="col-lg-12 text-right reup">
              <h4><small>You are logged in as : <?php echo $this->session->employee;?></small></h4>
					</div>

						<center>

							<img  src="<?php echo base_url('assets/img/logo.png');?>" style="max-width:20%;" />

						</center>
						<br /><br />
						<center>
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
