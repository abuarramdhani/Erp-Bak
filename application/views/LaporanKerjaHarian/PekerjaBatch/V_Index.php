<section id="content">
	<div class="inner" style="background: url('<?= base_url('assets/img/3.jpg');?>'); background-size: cover;" >
    	<section class="content-header">
				<div class="row">
					<div class="col-lg-11">
						<h1><?= $Title ?></h1>
					</div>
				</div>
		</section>
		<hr />
		<div class="row">
			<div class="col-lg-12">
				<div class="col-lg-12 text-right reup">    
					<h4><small>You are logged in as : <?php echo $this->session->user;?></small></h4>
				</div>
				<div style="text-align: center;">
					<img  src="<?php echo base_url('assets/img/logo.png');?>" style="max-width:20%;" />
					<br/><br/>
					<?= '<p style="font: normal 15px courier">Halaman ini dimuat dalam '.round(microtime(), 3).' detik'; ?>
				</div>
			</div>
		</div>
	</div>
</section>