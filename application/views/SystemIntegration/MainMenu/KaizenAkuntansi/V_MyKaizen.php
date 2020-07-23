<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<b><h1><?=$Title ?></h1></b>
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
										<table class="table table-striped table-hover table-bordered">
											<thead class="bg-primary">
												<tr>
													<th style="text-align: center;">No.</th>
													<th style="text-align: center;">Judul</th>
													<th style="text-align: center;">Create Ide</th>
													<th style="text-align: center;">Due Date F4</th>
													<th style="text-align: center;">Submit F4</th>
													<th style="text-align: center;">F4 Belum di Upload</th>
													<th style="text-align: center;">F4 Sudah di Upload</th>
													<th style="text-align: center;">Action</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												if (isset($kaizen) && !empty($kaizen)) {
													$nomor = 1;
													foreach ($kaizen as $key => $value) {
														?>
														<tr>
															<td><?php echo $nomor ?></td>
															<td><?php echo $value['judul'] ?></td>
															<td>
																<?php 
																if (isset($value['submit_ide']) && !empty($value['submit_ide'])) {
																	$submit_ide = explode(";",$value['submit_ide']);
																	foreach ($submit_ide as $key2 => $value2) {
																		$a = explode("#", $value2);
																		?>
																		<a href="#" title="<?php echo $a[1] ?>" class="btn btn-sm btn-success"><?php echo $a[0] ?></a>
																		<?php
																	}
																}
																?>	
															</td>
															<td><?php echo $value['due_date_f4'] ?></td>
															<td>
																<?php 
																if (isset($value['submit_f4']) && !empty($value['submit_f4'])) {
																	$submit_ide = explode(";",$value['submit_f4']);
																	foreach ($submit_ide as $key2 => $value2) {
																		$a = explode("#", $value2);
																		?>
																		<a href="#" title="<?php echo $a[1] ?>" class="btn btn-sm btn-success"><?php echo $a[0] ?></a>
																		<?php
																	}
																}
																?>	
															</td>
															<td>
																<?php 
																if (isset($value['belum_upload']) && !empty($value['belum_upload'])) {
																	$submit_ide = explode(";",$value['belum_upload']);
																	foreach ($submit_ide as $key2 => $value2) {
																		$a = explode("#", $value2);
																		?>
																		<a href="#" title="<?php echo $a[1] ?>" class="btn btn-sm btn-success"><?php echo $a[0] ?></a>
																		<?php
																	}
																}
																?>	
															</td>
															<td>
																<?php 
																if (isset($value['sudah_upload']) && !empty($value['sudah_upload'])) {
																	$submit_ide = explode(";",$value['sudah_upload']);
																	foreach ($submit_ide as $key2 => $value2) {
																		$a = explode("#", $value2);
																		?>
																		<a href="#" title="<?php echo $a[1] ?>" class="btn btn-sm btn-success"><?php echo $a[0] ?></a>
																		<?php
																	}
																}
																?>	
															</td>
															<td>
																<a href="<?php echo base_url('SystemIntegration/KaizenAkt/CetakF4/'.$value['kaizen_id']) ?>" target="_blank" title="Cetak F4" class="btn btn-danger btn-sm"><span class="fa fa-file-pdf-o"></span></a>
																<a href="<?php echo base_url('SystemIntegration/KaizenAkt/UploadF4/'.$value['kaizen_id']) ?>" target="_blank" title="Upload F4" class="btn btn-info btn-sm"><span class="fa fa-upload"></span></a>
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