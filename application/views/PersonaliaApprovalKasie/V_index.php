<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<h1><b><?=$Title ?></b></h1>	
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12 text-center">
									<?php 
									if (isset($dashboard) && !empty($dashboard)) {
										foreach ($dashboard as $key => $value) {
											?>
											<div class="small-box bg-primary" style="width: 300px;float: left;margin: 10px;">
												<div class="inner">
													<h3><?php echo $value['jumlah'] ?></h3>
													<p><?php echo $value['ket'] ?></p>
												</div>
												<div class="icon">
													<i class="fa fa-info-circle"></i>
												</div>
												<a href="<?php echo base_url($value['link']) ?>" class="small-box-footer" <?php echo $value['link'] == "#" ? "disabled" : "" ?>>
												<?php echo $value['link'] == "#" ? "Belum Ada Link <i class=\"fa fa-times-circle\"></i>" : "More info <i class=\"fa fa-arrow-circle-right\"></i>" ?> 
												</a>
											</div>
											<?php
										}
									}
									?>	
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