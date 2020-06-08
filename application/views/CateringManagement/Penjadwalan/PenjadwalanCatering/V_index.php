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
								<a href="<?php echo site_url('CateringManagement/PenjadwalanCatering'); ?>" class="btn btn-default btn-lg">
									<i class="icon-wrench icon-2x"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">

							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" method="post" action="<?php echo site_url('CateringManagement/PenjadwalanCatering'); ?>">
											<div class="form-group">
												<label class="control-label col-lg-4">Periode</label>
												<div class="col-lg-4">
													<input type="text" class="date form-control" name="txtperiodePenjadwalanCatering" id="txtperiodePenjadwalanCatering" value="<?php if (isset($select)) {echo $select['periode'];}?>" placeholder="Periode" data-date-format="yyyy-mm-dd" required autocomplete="off">
												</div>
												<div class="col-lg-4">
													<button class="btn fa fa-search fa-2x"></button>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Catering</label>
												<div class="col-lg-4">
													<select class="select select2" name="txtCateringPenjadwalanCatering" data-placeholder="Katering" required style="width: 100%;" autocomplete="off">
														<option></option>
														<?php

															foreach ($katering as $key) { ?>
																<option value="<?php echo $key['fs_kd_katering']; ?>" <?php if (isset($select) and $key['fs_kd_katering'] == $select['kode']) {
																echo "selected";} ?> ><?php echo $key['fs_kd_katering']." - ".$key['fs_nama_katering']; ?></option>
														<?php	}
														?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-12 text-center">
													<?php if (isset($select)) {
														$encrypted_periode = $this->encrypt->encode($select['periode']);
		                                                $encrypted_periode = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_periode);
														$encrypted_kode = $this->encrypt->encode($select['kode']);
		                                                $encrypted_kode = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_kode);
														?>
														<a href="<?php echo site_url('CateringManagement/PenjadwalanCatering/Create/'.$encrypted_periode."/".$encrypted_kode) ?>" class="btn btn-primary">Tambah</a>
														<a href="<?php echo site_url('CateringManagement/PenjadwalanCatering/Distribusi/'.$encrypted_periode."/".$encrypted_kode) ?>" class="btn btn-success" style="margin-left: 50px;">Distribusi</a>
													<?php } ?>
												</div>
											</div>
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12 text-right">
										<div class="table-responsive">
											<table class="datatable table table-hover table-striped table-bordered text-left">
												<thead class="bg-primary">
													<tr>
														<th>No</th>
														<th>Tanggal</th>
														<th>Nama Catering</th>
														<th>Shift 1 dan Umum</th>
														<th>Shift 2</th>
														<th>Shift 3</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													<?php if (isset($table)) {
														echo $table;
													}  ?>
												</tbody>
											</table>
										</div>
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
