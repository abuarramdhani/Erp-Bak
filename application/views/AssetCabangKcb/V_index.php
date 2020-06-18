<section id="content">
	<div class="inner" style="background: url('<?php echo base_url('assets/img/3.jpg');?>');background-size: cover;" >
	
		
			<!-- Content Header (Page header) -->
			<section class="content-header">
					<div class="row">
						<div class="col-lg-6">
							<br />
							<span style="font-family: sans-serif;"><i><h2>Aplikasi ERP Asset Cabang (Kepala Cabang)</h2></i></span>
						</div>
					</div>
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
		
	
	
	
</section>
