<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<h1><?=$Title ?></h1>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-solid box-primary">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12 text-center">
										<?php 
										if (isset($hasil) && !empty($hasil)) {
											foreach ($hasil as $key => $value) {
												?>
												<a href="<?php echo $value['link'] ?>" class="btn btn-primary"><span class="fa fa-file-o"></span>&nbsp;Kode Induk&nbsp;<?php echo $value['ket'] ?></a>
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