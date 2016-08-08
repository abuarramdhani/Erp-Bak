<section class="content">
	<div class="inner" >
	<div class="box box-info">
	<div style="padding-top: 10px">
		<div class="box-header with-border">
			<h4 class="pull-left">Rekap TIMS Kebutuhan Promosi Pekerja</h4>
		</div>
		<div class="box-body">
			<form method="post" action="<?php echo base_url('RekapTIMSPromosiPekerja/RekapTIMS/ShowData')?>">
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
									<input type="text" id="rekapBegin" class="form-control" name="rekapBegin" required>
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
									<input type="text" id="rekapEnd" class="form-control" name="rekapEnd" required>
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
									<select data-placeholder="Status Hubungan Kerja" class="form-control select2" style="width:100%" name ="statushubker" required>
										<option value="" disabled selected>-- PILIH SALAH SATU --</option>
										<option value="muach" disabled >-- PILIH SALAH SATU --</option>
										<?php foreach ($status as $status_item){ ?>
											<option value="<?php echo $status_item['kd_jabatan'];?>"><?php echo $status_item['nama_jabatan'];?></option>
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
									<select id="departemen_select" data-placeholder="Departemen" class="form-control select2" style="width:100%" name="departemen" required>
										<option value=""></option>
										<option value="muach" disabled >-- PILIH SALAH SATU --</option>
										<?php foreach ($dept as $dept_item){ ?>
											<option value="<?php echo $dept_item['Dept'];?>"><?php echo $dept_item['Dept'];?></option>
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
									<select id="bidang_select" data-placeholder="Bidang" class="form-control select2" style="width:100%" name="bidang" required>
										<option value=""></option>
										<option value="muach" disabled >-- PILIH DEPARTEMEN TERLEBIH DAHULU --</option>
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
									<select id="unit_select" data-placeholder="Unit" class="form-control select2" style="width:100%" name="unit" required>
										<option value=""></option>
										<option value="muach" disabled >-- PILIH BIDANG TERLEBIH DAHULU --</option>
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
									<select id="section_select" data-placeholder="Seksi" class="form-control select2" style="width:100%" name="section" required>
										<option value=""></option>
										<option value="muach" disabled >-- PILIH UNIT TERLEBIH DAHULU --</option>
									</select>
								</div>
							</div>
						</td>
						<td></td>
						<td>
							<div class="input-group">
							    <span class="input-group-addon">
							    	<input type="checkbox" name="detail" value="1">
							    </span>
							    <input class="form-control" type="text" placeholder="Tampilkan Detail Data TIMS" disabled>
							</div>
						</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td>
							<button class="btn btn-primary pull-right" type="submit">
								PROSES
							</button>
						</td>
					</tr>
				</table>
			</form>
		</div>
		<div class="box box-info"></div>
	</div>
	</div>
	</div>
</section>