<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b><?=$Title ?></b></h1>
							</div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a href="" class="btn btn-default btn-lg">
									<i class="icon-wrench icon-2x"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header">
								
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form method="POST" class="form-horizontal" enctype="Multipart/form-data" action="<?php echo base_url('CateringManagement/Puasa/Setup/SaveUpload') ?>">
											<div class="form-group">
												<label class="control-label col-lg-4">File</label>
												<div class="col-lg-4">
													<input type="file" name="flPuasaPekerja" class="form-group" required>
												</div>
												<div class="col-lg-4">
													<button type="submit" class="btn btn-primary">Upload</button>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-12 text-center">
													<?php 
													if (isset($ket) && !empty($ket)) {
														if ($ket == "sukses") {
															echo "<h1 style='color: green'>Upload Sukses</h1>";
														}elseif ($ket == "empty") {
															echo "<h1 style='color: red'>Upload Gagal</h1>";
														}
													}
													?>
												</div>
											</div>
										</form>
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