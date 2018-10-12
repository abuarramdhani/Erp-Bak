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
							<a href="<?php echo site_url('CateringManagement/JamPesananDatang') ?>" class="btn btn-default btn-lg">
								<span class="icon-wrench icon-2x"></span>
							</a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border text-right">
								<a href="<?php echo site_url('CateringManagement/JamPesananDatang/Create') ?>" class="btn btn-default icon-plus icon-2x" data-toggle='tooltip' data-placement='bottom' data-original-title='Add Data'></a>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="row">
											<form class="form-horizontal" method="post" action="<?php echo site_url('CateringManagement/JamPesananDatang') ?>">
												<label class="control-label col-lg-1">Shift</label>
												<div class="col-lg-2">
													<select class="select select2" name="txtShiftPesan" data-placeholder="Shift" style="width: 100%;">
														<?php if (isset($ShiftNow)) { ?>
															<option value="<?php echo $ShiftNow['0']['kd_shift'] ?>"><?php echo $ShiftNow['0']['shift'] ?><option>
														<?php }else{ ?>
															<option></option>
														<?php } ?>
														<?php foreach ($Shift as $key) { ?>
															<option value="<?php echo $key['kd_shift'] ?>"><?php echo $key['shift'] ?></option>
														<?php } ?>
													</select>
												</div>
												<button type="submit" class="btn btn-primary">Cari</button>
											</form>
										</div>
										<br>
										<div class="table-responsive">
											<table class="datatable table table-bordered table-striped table-hover text-left dataTable-TmpMakan">
												<thead class="bg-primary">
													<tr>
														<th>No</th>
														<th>Hari</th>
														<th>Nama Shift</th>
														<th>Jam Pesan</th>
														<th>jam Datang</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													<?php if (isset($JamPesananDatang)) {
														$a=1;foreach ($JamPesananDatang as $key) { 
														$encrypted_1 = $this->encrypt->encode($key['fs_hari']);
                                                		$encrypted_1 = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_1);
                                                		$encrypted_2 = $this->encrypt->encode($key['fs_kd_shift']);
                                                		$encrypted_2 = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_2);
														
														$hari = array(
															'1' => "Minggu", 
															'2' => "Senin", 
															'3' => "Selasa", 
															'4' => "Rabu", 
															'5' => "Kamis", 
															'6' => "Jumat", 
															'7' => "Sabtu"
														);
                                                	?>
														<tr>
															<td><?php echo $a; ?></td>
															<td><?php echo $hari[$key['fs_hari']] ?></td>
															<td><?php echo $key['shift'] ?></td>
															<td><?php echo $key['fs_jam_pesan'] ?></td>
															<td><?php echo $key['fs_jam_datang'] ?></td>
															<td>
																<a href="<?php echo base_url('CateringManagement/JamPesananDatang/Edit/'.$encrypted_1.'/'.$encrypted_2) ?>" class="fa fa-edit fa-2x" data-toggle='tooltip' data-placement='bottom' data-original-title='Edit Data'></a>
															<a href="<?php echo base_url('CateringManagement/JamPesananDatang/Delete/'.$encrypted_1.'/'.$encrypted_2) ?>" class="fa fa-trash fa-2x" data-toggle='tooltip' data-placement='bottom' data-original-title='Delete Data' onclick='return confirm("Apakah Anda Yakin Ingin Menghapus Data Ini ?")'></a>
															</td>
														</tr>
													<?php $a++;} }  ?>
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