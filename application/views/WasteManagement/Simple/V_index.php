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
								<button type="button" data-toggle="modal" data-target="#Simple-Create" class="btn btn-default icon-plus icon-2x" style="float:right;"></button>

								<div class="modal" tabindex="-1" role="dialog" aria-hidden="true" id="Simple-Create">
									<div role="document" class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header bg-primary">
												<label class="modal-title">SIMPLE Tambah Baru</label>
											</div>
											<div class="modal-body">
												<form class="form form-horizontal">
													<div class="panel-body">
														<div class="form-group">
															<label for="txtSimpleLimbahJenis" class="control-label col-lg-4">Jenis Limbah</label>
															<div class="col-lg-6">
																<select name="txtSimpleLimbahJenis" id="txtSimpleLimbahJenis" class="select select2" style="width:100%;" required>
																	<option></option>
																	<?php
																		foreach ($LimbahJenis as $key) {
																		 	echo "<option value='".$key['id_jenis']."'>".$key['kode_limbah']." - ".$key['jenis_limbah']."</option>";
																		 } 
																	?>
																</select>
															</div>
														</div>
														<div class="form-group">
															<label for="txtSimplePeriode" class="control-label col-lg-4">Periode</label>
															<div class="col-lg-6">
																<input type="text" class="form-control" name="txtSimplePeriode" id="txtSimplePeriode" class="date form-control" placeholder="<?php echo date('M Y')?>" data-date-format="yyyy-mm" required>
															</div>
														</div>
														<div class="form-group col-lg-8 text-right">
															<button type="button" class="btn btn-primary" id="btnSubmitSimple">Ok</button>
															<button type="button" class="btn btn-danger" id="btnCloseSimple">Cancel</button>
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="box-body">
								<div class="table-responsive">
									<table class="datatable table table-striped table-bordered table-hover text-left dataTable-limbah">
										<thead class="bg-primary">
											<tr>
												<th>No</th>
												<th>Action</th>
												<th>Jenis Limbah</th>
												<th>periode</th>
											</tr>
										</thead>
										<tbody>
											<?php $a=1;foreach ($SimpleData as $key) {
												$encrypted_text = $this->encrypt->encode($key['id_simple']);
												$encrypted_text = str_replace(array('+','/','='), array('-','_','~'), $encrypted_text);
												$Read = 'WasteManagement/Simple/Read/'.$encrypted_text;
												$delete = 'WasteManagement/Simple/Delete/'.$encrypted_text;
												$export = 'WasteManagement/Simple/Export/'.$encrypted_text;
											 ?>
											<tr>
												<td><?php echo $a ?></td>
												<td>
													<a href="<?php echo site_url($export) ?>" data-toggle="tooltip" data-placement="bottom" data-original-title="Export Excel">
														<span class="fa fa-file-excel-o fa-2x"></span>
													</a>
													<a href="<?php echo site_url($Read) ?>" data-toggle="tooltip" data-placement="bottom" data-original-title="Read Data">
														<span class="fa fa-list-alt fa-2x"></span>
													</a>
													<a href="<?php echo site_url($delete) ?>" data-toggle="tooltip" data-placement="bottom" data-original-title="Hapus Data" onclick="return confirm('Apakah Anda yakin Ingin Menghapus Data Ini ? setelah dihapus detail Data ini juga akan terhapus')">
														<span class="fa fa-trash fa-2x"></span>
													</a>
												</td>
												<td><?php echo $key['jenis_limbah'] ?></td>
												<td><?php echo $key['periode'] ?></td>
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