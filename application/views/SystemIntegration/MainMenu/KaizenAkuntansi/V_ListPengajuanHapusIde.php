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
									<div class="col-lg-12">
											<style type="text/css">
												.dt-buttons, .dataTables_info {
													float: left;
												}
												.dataTables_filter, .dataTables_paginate {
													float: right;
												}
											</style>
										<table class="table table-bordered table-hover table-striped" id="tbl-SI-KaizenAkt-PengajuanHapusIde">
											<thead class="bg-primary">
												<tr>
													<th style="text-align: center;">No.</th>
													<th style="text-align: center;">No. Induk</th>
													<th style="text-align: center;">Nama</th>
													<th style="text-align: center;">Ide</th>
													<th style="text-align: center;">Create Ide</th>
													<th style="text-align: center;">Due Date F4</th>
													<th style="text-align: center;">Action</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												if (isset($kaizen) && !empty($kaizen)) {
													$nomor = 1;
													foreach ($kaizen as $key => $value) {
														$encrypted_string = $this->encrypt->encode($value['kaizen_id']);
														$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
														?>
														<tr>
															<td style="text-align: center;"><?php echo $nomor ?></td>
															<td style="text-align: center;"><?php echo $value['pencetus_noind'] ?></td>
															<td><?php echo $value['pencetus_nama'] ?></td>
															<td><?php echo $value['ide'] ?></td>
															<td><?php echo date('Y-m-d H:i:s',strtotime($value['created_timestamp'])) ?></td>
															<td><?php echo $value['due_date_f4'] ?></td>
															<td style="text-align: center;">
																<a href="<?php echo base_url('SystemIntegration/KaizenAkt/HapusIde/'.$encrypted_string) ?>" class="btn btn-danger btn-sm" title="Hapus Ide" onclick="return confirm('Apakah Anda yakin ingin menghapus ide ini ?')"><span class="fa fa-trash"></span></a>
															</td>
														</tr>
														<?php
														$nomor++;
													}
												}
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
	</div>
</section>