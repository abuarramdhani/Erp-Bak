<section class="content-header">
	<h1>
		Rekap TIMS Kebutuhan Promosi Pekerja
	</h1>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-12">	
			<div class="box box-primary">
				<div class="table-responsive">
					<fieldset class="row2">
						<div class="box-body with-border">
							<form id="filter-rekap" method="post" action="<?php echo base_url('RekapTIMSPromosiPekerja/RekapTIMS/show-data')?>">
								<table class="table">
									<tr>
										<td class="col-md-2">
											Periode
										</td>
										<td class="col-md-5">
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</div>
													<input type="text" id="rekapBegin" class="form-control" name="rekapBegin" value="<?php echo $this->session->userdata('periode1Filter') ?>" required>
												</div>
											</div>
										</td>
										<td> s/d </td>
										<td class="col-md-5">
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</div>
													<input type="text" id="rekapEnd" class="form-control" name="rekapEnd" value="<?php echo $this->session->userdata('periode2Filter') ?>" required>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td class="col-md-2">
											Status Hubungan Kerja
										</td>
										<td class="col-md-5">
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-addon">
														<i class="glyphicon glyphicon-briefcase"></i>
													</div>
													<select data-placeholder="Pilih Salah Satu!" class="form-control select2" style="width:100%" name ="statushubker" required>
														<option value=""><option>
														<?php foreach ($status as $status_item){
																$select = '';
																if ($status_item['kd_jabatan'] == $this->session->userdata('statusFilter')) {
																	$select = 'selected';
																}
														?>
															<option <?php echo $select ?> value="<?php echo $status_item['kd_jabatan'];?>"><?php echo $status_item['nama_jabatan'];?></option>
													<?php } ?>
													</select>
												</div>
											</div>
										</td>
										<td></td>
										<td class="col-md-5"></td>
									</tr>
									<tr>
										<td class="col-md-2">
											Departemen
										</td>
										<td class="col-md-5">
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-addon">
														<i class="glyphicon glyphicon-user"></i>
													</div>
													<select id="departemen_select" data-placeholder="Pilih Salah Satu!" class="form-control select2" style="width:100%" name="departemen" required>
														<option value=""></option>
														<?php foreach ($dept as $dept_item){
																$select = '';
																if ($dept_item['Dept'] == $this->session->userdata('departemenFilter')) {
																	$select = 'selected';
																}
														?>
															<option <?php echo $select ?> value="<?php echo $dept_item['Dept'];?>"><?php echo $dept_item['Dept'];?></option>
													<?php } ?>
													</select>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td class="col-md-2">
											Bidang
										</td>
										<td class="col-md-5">
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-addon">
														<i class="glyphicon glyphicon-user"></i>
													</div>
													<select id="bidang_select" data-placeholder="Pilih Salah Satu!" class="form-control select2" style="width:100%" name="bidang" required>
														<option value=""></option>
														<?php 
															if ($this->session->userdata('bidangFilter') == '') {
																echo '<option value="0" disabled>Pilih Departemen terlebih dahulu</option>';
															}
															else{
																foreach ($bidang as $bidang_item){
																	$select = '';
																	if ($bidang_item['Bidang'] == $this->session->userdata('bidangFilter')) {
																		$select = 'selected';
																	}
																	echo "<option ".$select." >".$bidang_item['Bidang']."</option>";
																}
															}
														?>

													</select>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td class="col-md-2">
											Unit
										</td>
										<td class="col-md-5">
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-addon">
														<i class="glyphicon glyphicon-user"></i>
													</div>
													<select id="unit_select" data-placeholder="Pilih Salah Satu!" class="form-control select2" style="width:100%" name="unit" required>
														<option value=""></option>
														<?php 
															if ($this->session->userdata('unitFilter') == '') {
																echo '<option value="0" disabled>Pilih Bidang terlebih dahulu</option>';
															}
															else{
																foreach ($unit as $unit_item){
																	$select = '';
																	if ($unit_item['Unit'] == $this->session->userdata('unitFilter')) {
																		$select = 'selected';
																	}
																	echo "<option ".$select." >".$unit_item['Unit']."</option>";
																}
															}
														?>
													</select>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td class="col-md-2">
											Seksi
										</td>
										<td class="col-md-5">
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-addon">
														<i class="glyphicon glyphicon-user"></i>
													</div>
													<select id="section_select" data-placeholder="Pilih Salah Satu!" class="form-control select2" style="width:100%" name="section" required>
														<option value=""></option>
														<option value="0" disabled>Pilih Unit terlebih dahulu</option>
														<?php 
															if ($this->session->userdata('seksiFilter') == '') {
																echo '<option value="0" disabled>Pilih Unit terlebih dahulu</option>';
															}
															else{
																foreach ($seksi as $seksi_item){
																	$select = '';
																	if ($seksi_item['Seksi'] == $this->session->userdata('seksiFilter')) {
																		$select = 'selected';
																	}
																	echo "<option ".$select." >".$seksi_item['Seksi']."</option>";
																}
															}
														?>
													</select>
												</div>
											</div>
										</td>
										<td></td>
										<td>
											<div class="form-group">
												<div class="checkbox">
													<label>
														<?php
															$check = 'checked';
															if ($this->session->userdata('detailFilter') == NULL) {
																$check = '';
															}

														?>
														<input id="toggle_button" name="detail" type="checkbox" value="1" <?php echo $check ?>>
														Tampilkan Detail Data TIMS
													</label>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td></td>
										<td>
											<div id="loadingAjax"></div>
										</td>
										<td></td>
										<td>
											<span id="submit-filter-rekap" class="btn btn-primary pull-right">
												PROSES
											</span>
										</td>
									</tr>
								</table>
							</form>
							<div id="table-div">
								
							</div>
						</div>
					</fieldset>
				</div>
			</div>
		</div>
	</div>
</section>