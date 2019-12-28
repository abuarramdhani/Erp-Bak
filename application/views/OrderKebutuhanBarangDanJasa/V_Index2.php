<section id="content">
	<div class="inner" style="background: url('<?php echo base_url('assets/img/3.jpg');?>');background-size: cover;" >
		<!-- Content Header (Page header) -->
		<section class="content-header">
				<div class="row">
					<div class="col-lg-6">
						<br />
						<h1>Order Kebutuhan Barang dan Jasa</h1>
					</div>
				</div>
				<?php if ($this->session->user == 'B0661') { ?>
					<div class="row">
						<div class="col-lg-12">
							<h4>Hidden Features :</h4>
							<div class="col-sm-3 col-xl-3" style="margin-bottom:10px;">
								<a href="<?php echo site_url('OrderKebutuhanBarangDanJasa/Requisition/SetupUser') ?>" class="btn btn-warning btn-block"><i class="fa fa-gear" style="opacity: 0.4; font-size:90px; color:#000"></i><br><span style="color: #0000005c;"><strong>SETUP USER</strong></span></a>
							</div>
						</div>
					</div>
				<?php } ?>
		</section>
		<hr />
		<div class="row">
			<div class="col-lg-12">
				<div class="col-lg-12 text-right reup">    
                    <h4><small>You are logged in as : <b><?php echo $this->session->user;?></b></small></h4>
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
	</div>
</section>
