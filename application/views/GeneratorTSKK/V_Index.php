<section id="content">
	<div class="inner" style="background: url('<?php echo base_url('assets/img/3.jpg');?>');background-size: cover;" >

			<!-- Content Header (Page header) -->
			<section class="content-header">
					<div class="row">
						<div class="box-header">
							<br/>
							<h1><b><center>Dashboard Generator TSKK Versi 2.5</center></b></h1>
							<br>
							<center>Terakhir Diperbarui Pada 2021-05-05 11:25:56</center>
						</div>
					</div>
			</section>
			<hr />
			<div class="row">
				<div class="col-lg-12">
				    <div class="col-lg-12 text-right reup">
              <h4><small>You are logged in as : <?php echo $this->session->user;?></small></h4>
					</div>

						<center>

							<img  src="<?php echo base_url('assets/img/logo.png');?>" style="max-width:17%;" />
							<input type="hidden" id="gtskk_app" value="1">
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

<!-- <script type="text/javascript">
	alert('Aplikasi Terakhir Diperbarui Pada 2021-04-21 16:30:23. Reload halaman ini dengan menekan ctrl+shift+r secara berurutan jika telah melewati tanggal pembaruan..')
</script> -->

<script type="text/javascript">

</script>
