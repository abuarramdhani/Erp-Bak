<section id="content">
	<?php $base_url = base_url() ?>
	<div class="inner" style="<?= "background: url(${base_url}assets/img/3.jpg); background-size: cover;" ?>">
		<section class="content-header">
			<div class="row">
				<div class="col-lg-12">
					<br />
					<h1> Permintaan Perhitungan Harga Sparepart </h1>
				</div>
			</div>
		</section>
		<hr />
		<div class="row">
			<div class="col-lg-12">
				<div class="col-lg-12 text-right reup">
					<h4><small><?= "You are logged in as : <b>{$this->session->user}</b>" ?></small></h4>
				</div>
				<center>
					<img src="<?= "${base_url}assets/img/logo.png" ?>" style="max-width:20%;" />
				</center>
				<br />
				<br />
				<center>
					<?php $load_time = round(microtime(), 3) ?>
					<p style="font: normal 15px courier"><?= "Halaman ini dimuat dalam {$load_time} detik" ?></p>
				</center>
			</div>
		</div>
	</div>
</section>