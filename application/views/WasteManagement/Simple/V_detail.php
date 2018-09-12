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
							<a href="<?php echo site_url('WasteManagement/Simple'); ?>" class="btn btn-default btn-lg text-right">
								<span class="fa fa-wrench fa-2x"></span>
							</a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<div class="col-lg-11">
									<h4><?php echo $Simple['0']['jenis_limbah']." - ".$Simple['0']['periode']; ?></h4>
								</div>
								<div class="col-lg-1 text-right">
									<a href="<?php echo site_url('WasteManagement/Simple/Add_Detail/'.$SimpleId); ?>" class="btn btn-primary icon-plus icon-2x"></a>
								</div>
							</div>
							<div class="box-body">
								<div class="table-responsive">
									<table class="datatable table table striped table-bordered table-hover text-left dataTable-Simple">
										<thead class="bg-primary">
											<tr>
												<th>No</th>
												<th>Action</th>
												<th>Kode Limbah</th>
												<th>Tanggal Dihasilkan</th>
												<th>Kode Manifest</th>
												<th>Jumlah (Ton)</th>
											</tr>
										</thead>
										<tbody>
											<?php $a=1;
												foreach ($SimpleDetail as $key) {
												$encrypted_text = $this->encrypt->encode($key['id_simple_detail']);
												$encrypted_text = str_replace(array('+','/','='), array('-','_','~'), $encrypted_text);
												$Read = 'WasteManagement/Simple/Edit_Detail/'.$encrypted_text;
												$Delete = 'WasteManagement/Simple/Delete_Detail/'.$encrypted_text;
											?>
											<tr>
												<td><?php echo $a; ?></td>
												<td class="text-center">
													<a href="<?php echo site_url($Read); ?>" data-toggle="tooltip" data-placement="bottom" data-original-title="Edit Data">
														<span class="fa fa-pencil-square-o fa-2x"></span>
													</a>
													<a href="<?php echo site_url($Delete); ?>" data-toggle="tooltip" data-placement="bottom" data-original-title="Delete Data" onclick="return confirm('Apakah Anda yakin Ingin Menghapus Data Ini ?')">
														<span class="fa fa-trash fa-2x"></span>
													</a>
												</td>
												<td><?php echo $key['kode_limbah']; ?></td>
												<td><?php echo $key['tanggal_dihasilkan']; ?></td>
												<td><?php echo $key['kode_manifest']; ?></td>
												<td><?php echo $key['jumlah']; ?></td>
											</tr>
											<?php 
											$a++;	} 
											?>
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