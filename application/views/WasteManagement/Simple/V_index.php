<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11 text-right">
							<h1><b><?=$Title ?></b></h1>
						</div>
						<div class="col-lg-1">
							<a href="" class="btn btn-default btn-lg">
								<span class="fa fa-wrench fa-2x"></span>
							</a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
							</div>
							<div class="box-body">
								<div class="table-responsive">
									<table class="datatable table table-striped table-bordered table-hover text-left dataTable-limbah">
										<thead class="bg-primary">
											<tr>
												<th class="text-center" style="width: 50px;">No</th>
												<th class="text-center" style="width: 100px;">Action</th>
												<th class="text-center">Jenis Limbah</th>
											</tr>
										</thead>
										<tbody>
											<?php $a=1;foreach ($SimpleData as $key) {
												$encrypted_text = $this->encrypt->encode($key['id_jenis_limbah']);
												$encrypted_text = str_replace(array('+','/','='), array('-','_','~'), $encrypted_text);
												$Read = 'WasteManagement/Simple/Read/'.$encrypted_text;
												$Excel = 'WasteManagement/Simple/ExportAll/'.$encrypted_text;
											 ?>
											<tr>
												<td class="text-center"><?php echo $a ?></td>
												<td class="text-center">
													<a href="<?php echo site_url($Read) ?>" data-toggle="tooltip" data-placement="bottom" data-original-title="Read Data">
														<span class="fa fa-list-alt fa-2x"></span>
													</a>
													<a target="_blank" href="<?php echo site_url($Excel) ?>" data-toggle="tooltip" data-placement="bottom" data-original-title="Backup Data">
														<span class="fa fa-file-excel-o fa-2x"></span>
													</a>
												</td>
												<td><?php echo $key['jenis_limbah'] ?></td>
											</tr>
										<?php $a++;} ?>
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