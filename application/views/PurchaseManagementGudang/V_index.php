<section id="content">
	<div class="inner" style="background: url('<?php echo base_url('assets/img/3.jpg');?>');background-size: cover;" >
	
		
			<!-- Content Header (Page header) -->
			<section class="content-header">
					<div class="row">
						<div class="col-lg-5">
							<br />
							<h1>NON CONFORMITY</h1>
						</div>
					</div>
			</section>
			<hr />
			<div class="row">
				<div class="col-lg-12">
				    <div class="col-lg-12 text-right">    
                        <h4><small>You are logged in as : <?php echo $this->session->user;?></small></h4>
					</div>	
						
						<center> 
							
							 <img src="<?=base_url('assets/img/erp.png')?>" style="width:45%;height:45%;"/>
						
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
