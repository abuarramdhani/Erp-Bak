<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right"><h1><b><?=$Title ?></b></h1></div>
						</div>
						<div class="col-lg-1">
							<a href="<?php echo site_url('CateringManagement/DetailUrutanJdwl') ?>" class="btn btn-default btn-lg">
								<span class="icon-wrench icon-2x"></span>
							</a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border text-right">
								<a href="<?php echo site_url('CateringManagement/DetailUrutanJdwl/Create') ?>" class="btn btn-default icon-plus icon-2x" data-toggle='tooltip' data-placement='bottom' data-original-title='Add Data'></a>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="table-responsive">
											<table class="datatable table table-bordered table-striped table-hover text-left dataTable-TmpMakan">
												<thead class="bg-primary">
													<tr>
														<th>No</th>
														<th>Hari</th>
														<th>urutan</th>
														<th>Shift 1</th>
														<th>Shift 2</th>
														<th>Shift 3</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													<?php $a=1;foreach ($DetailUrutanJdwl as $key) { 
														$encrypted_1 = $this->encrypt->encode($key['fs_hari']);
                                                		$encrypted_1 = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_1);
                                                		$encrypted_2 = $this->encrypt->encode($key['fn_urutan_jadwal']);
                                                		$encrypted_2 = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_2);
														
														$hari = array(
															'1' => "Minggu", 
															'2' => "Senin", 
															'3' => "Selasa", 
															'4' => "Rabu", 
															'5' => "Kamis", 
															'6' => "Jumat", 
															'7' => "Sabtu", 
															'L' => "Hari Libur", 
															'P' => "Puasa", 
															'PL' => "Libur Saat Puasa" 
														);
                                                	?>
														<tr>
															<td><?php echo $a; ?></td>
															<td><?php echo $hari[$key['fs_hari']] ?></td>
															<td><?php echo $key['fn_urutan_jadwal'] ?></td>
															<td><?php if ($key['fs_tujuan_shift1'] == '1') {
																			echo "Kirim";
																		}else{ 
																			echo "-";
																		} ?></td>
															<td><?php if ($key['fs_tujuan_shift2'] == '1') {
																			echo "Kirim";
																		}else{ 
																			echo "-";
																		} ?></td>
															<td><?php if ($key['fs_tujuan_shift3'] == '1') {
																			echo "Kirim";
																		}else{ 
																			echo "-";
																		} ?></td>

															<td>
																<a href="<?php echo base_url('CateringManagement/DetailUrutanJdwl/Edit/'.$encrypted_1.'/'.$encrypted_2) ?>" class="fa fa-edit fa-2x" data-toggle='tooltip' data-placement='bottom' data-original-title='Edit Data'></a>
															<a href="<?php echo base_url('CateringManagement/DetailUrutanJdwl/Delete/'.$encrypted_1.'/'.$encrypted_2) ?>" class="fa fa-trash fa-2x" data-toggle='tooltip' data-placement='bottom' data-original-title='Delete Data' onclick='return confirm("Apakah Anda Yakin Ingin Menghapus Data Ini ?")'></a>
															</td>
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
		</div>
	</div>
</section>