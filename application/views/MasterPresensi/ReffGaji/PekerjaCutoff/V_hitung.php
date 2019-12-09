<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<h3><?=$Title ?></h3>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<h2 style="text-align: center">Pekerja Cutoff bulan <?php echo date('F Y',strtotime($periode)) ?></h2>
										<div class="col-lg-12" style="text-align: center">
											<div class="col-lg-6" style="text-align: right;">STAFF : <?=$jumlah_staff ?></div>
											<div class="col-lg-6" style="text-align: left;">NON STAFF : <?=$jumlah_nonstaff ?></div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12 text-center">
										<?php echo $output ?>
									</div>
								</div><br>
								<div class="row">
									<div class="col-lg-12 text-center">
										<?php echo $output_2 ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>