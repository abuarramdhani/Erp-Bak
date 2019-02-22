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
								<a class="btn btn-default btn-lg" href="<?php echo site_url('CateringManagement/LetakTmpMakan') ?>">
									<span class="icon-wrench icon-2x"></span>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border text-right">
								<a href="<?php echo site_url('CateringManagement/LetakTmpMakan/Create') ?>" class="btn btn-default icon-plus icon-2x" data-toggle='tooltip' data-placement='bottom' data-original-title='Add Data'></a>
							</div>
							<div class="box-body">
								<div class="table-responsive">
									<table class="datatable table table-bordered table-striped table-hover text-left">
										<thead class="bg-primary">
											<tr>
												<th>No</th>
												<th>Kode</th>
												<th>Letak</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php $a=1;
											foreach ($LetakTmpMakan as $value) { 
												$encrypted_string = $this->encrypt->encode($value['fn_kd_letak']);
                                                $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);?>
											 	<tr>
											 		<td><?php echo $a ?></td>
											 		<td><?php echo $value['fn_kd_letak'] ?></td>
											 		<td><?php echo $value['fs_letak'] ?></td>
											 		<td>
														<a href="<?php echo base_url('CateringManagement/LetakTmpMakan/Edit/'.$encrypted_string) ?>" class="fa fa-edit fa-2x" data-toggle='tooltip' data-placement='bottom' data-original-title='Edit Data'></a>
														<a href="<?php echo base_url('CateringManagement/LetakTmpMakan/Delete/'.$encrypted_string) ?>" class="fa fa-trash fa-2x" data-toggle='tooltip' data-placement='bottom' data-original-title='Delete Data' onclick='return confirm("Apakah Anda Yakin Ingin Menghapus Data Ini ?")'></a>

													</td>
											 	</tr>
											<?php $a++; } ?>
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
</section>