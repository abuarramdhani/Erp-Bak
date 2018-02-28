<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row" >
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Master Trainer</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('ADMPelatihan/MasterTrainer');?>">
                                <i class="icon-wrench icon-2x"></i>
                                <span><br/></span>	
                            </a>
						</div>
					</div>
				</div>
			</div>
			<br/>
			
			<div class="row">
				<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						<b>Form Penambahan Trainer Internal</b>
					</div>
					
					<div class="box-body">
					<form method="post" action="<?php echo base_url('ADMPelatihan/MasterTrainer/AddInternal')?>">
						<div class="row" style="margin: 10px 10px">
							<div class="col-md-2">
								<label class="control-label">Pekerja</label>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<div class="input-group">
										<div class="input-group-addon">
											<i class="glyphicon glyphicon-user"></i>
										</div>
										<select class="form-control js-slcInternalTrainer" name="slcEmployee[]" id="slcInternalTrainer" required>
											<option value=""></option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<hr>
						<div class="row" style="margin: 10px 10px">
							<div class="col-md-10">
								<div class="panel panel-default">
									<div class="panel-heading text-right">
										<a href="javascript:void(0);" class="btn btn-sm btn-primary" id="AddPengalaman" title="Tambah Baris" onclick="AddPengalaman('<?php echo base_url(''); ?>')"><i class="fa fa-plus"></i></a>
										<b style="float:left;">Pengalaman Mengajar di KHS</b>
									</div>
									<div class="panel-body">
										<div class="table-responsive" >
										<table class="table table-sm table-bordered table-hover text-center" style="table-layout: fixed;" name="tblPengalaman" id="tblPengalaman">
											 <form method="post" action="<?php echo base_url('ADMPelatihan/MasterTrainer/Add')?>">
												<thead>
													<tr class="bg-primary">
														<th width="10%">No</th>
														<th >Nama Training</th>
														<th width="30%">Tanggal</th>
														<th width="10%">Action</th>
													</tr>
												</thead>
												<tbody id="tbodyTrainerPengalaman">
														<?php 
															$no=1;
														?>
													<tr class="clone" row-id="<?php echo $no; ?>">
														<td ><?php echo $no; ?></td>
														<td>
															<input id="txtPengalaman[]" name="txtPengalaman[]" class="form-control segment" data-placement="top" placeholder="Pengalaman Trainer">
														</td>
														<td>
															<input name="txtTanggalPengalaman[]" class="form-control singledateADM" placeholder="Tanggal" id="txtTanggalPengalaman[]">
														</td>
														<td>
															<a href="javascript:void(0);" class="btn btn-danger btn-xs" id="DelPengalaman" title="Hapus Baris" onclick=""><i class="fa fa-remove"></i>Delete</a>
														</td>
													</tr>
													<?php  ?>
												</tbody>
											</form>
										</table>
										</div>
									</div> 
									<br>
								</div>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="col-md-10">
								<div class="panel panel-default">
									<div class="panel-heading text-right">
										<a href="javascript:void(0);" class="btn btn-sm btn-primary" id="AddSertifikat" title="Tambah Baris" onclick="AddSertifikat('<?php echo base_url(''); ?>')"><i class="fa fa-plus"></i></a>
										<b style="float:left;">Training Bersertifikat yang Pernah Diikuti</b>
									</div>
									<div class="panel-body">
										<div class="table-responsive" >
										<table class="table table-sm table-bordered table-hover text-center" style="table-layout: fixed;" name="tblSertifikat" id="tblSertifikat">
											<thead>
												<tr class="bg-primary">
													<th width="10%">No</th>
													<th >Nama Training</th>
													<th width="30%">Tanggal</th>
													<th width="10%">Action</th>
												</tr>
											</thead>
											<tbody id="tbodyTrainerSertifikat">
													<?php 
														$no=1;
													?>
												<tr class="clone" row-id="<?php echo $no; ?>">
													<td ><?php echo $no; ?></td>
													<td>
														<input id="txtSertifikat[]" name="txtSertifikat[]" class="form-control segment" data-placement="top" placeholder="Nama Training">
													</td>
													<td>
														<input name="txtTanggalSertifikat[]" class="form-control singledateADM" placeholder="Tanggal" id="txtTanggalSertifikat[]">
													</td>
													<td>
														<a href="javascript:void(0);" class="btn btn-danger btn-xs" id="DelSertifikat" title="Hapus Baris" onclick=""><i class="fa fa-remove"></i>Delete</a>
													</td>
												</tr>
												<?php  ?>
											</tbody>
										</table>
										</div>
									</div> 
									<br>
								</div>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="col-md-10">
								<div class="panel panel-default">
									<div class="panel-heading text-right">
										<a href="javascript:void(0);" class="btn btn-sm btn-primary" id="AddTim" title="Tambah Baris" onclick="AddTim('<?php echo base_url(''); ?>')"><i class="fa fa-plus"></i></a>
										<b style="float:left;">Tim yang Pernah Diikuti</b>
									</div>
									<div class="panel-body">
										<div class="table-responsive" >
										<table class="table table-sm table-bordered table-hover text-center" style="table-layout: fixed;" name="tblTim" id="tblTim">
											<thead>
												<tr class="bg-primary">
													<th width="5%">No</th>
													<th >Nama Kegiatan</th>
													<th width="20%"> Tanggal</th>
													<th width="30%">Jabatan</th>
													<th width="10%">Action</th>
												</tr>
											</thead>
											<tbody id="tbodyTrainerTim">
													<?php 
														$no=1;
													?>
												<tr class="clone" row-id="<?php echo $no; ?>">
													<td ><?php echo $no; ?></td>
													<td>
														<input name="txtKegiatan[]" class="form-control segment" data-placement="top" placeholder="Nama Kegiatan" id="txtKegiatan[]">
													</td>
													<td>
														<input name="txtTanggalkegiatan[]" class="form-control singledateADM" placeholder="Tanggal" id="txtTanggalkegiatan[]">
													</td>
													<td>
														<input id="txtJabatan[]" name="txtJabatan[]" class="form-control segment" data-placement="top" placeholder="Jabatan">
													</td>
													<td>
														<a href="javascript:void(0);" class="btn btn-danger btn-xs" id="DelTrainerTim" title="Hapus Baris" onclick=""><i class="fa fa-remove"></i>Delete</a>
													</td>
												</tr>
												<?php  ?>
											</tbody>
										</table>
										</div>
									</div> 
									<br>
								</div>
							</div>
						</div>
						<hr>
						<div class="form-group">
							<div class="col-lg-8 text-right">
								<a href="<?php echo site_url('ADMPelatihan/MasterTrainer');?>"  class="btn btn-primary btn btn-flat">Back</a>
								<button type="submit" class="btn btn-success btn-flat">Save Data</button>
							</div>
						</div>
					<form>
					</div>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>			
			
				
