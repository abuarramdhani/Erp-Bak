	<section class="content">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-11">
						<div class="text-right">
							<h1><b>Approv Lembur</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
							<a class="btn btn-default btn-lg" href="<?php echo site_url('ALK/ListLembur');?>">
								<i class="icon-wrench icon-2x"></i>
								<span><br/></span>	
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<section class="col-lg-12 connectedSortable">
				<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
					<div class="box box-primary">
						<div class="box-header">
							<div class="row">
								<div class="col-lg-6">

									<div class="form-group">
										<label class="col-sm-2 control-label">Tanggal</label>
										<label class="col-sm-1 control-label">
											<input type="checkbox" id="spl-chk-dt" style="width:20px; height:20px; vertical-align:bottom;" checked>
										</label>
										<div class="col-sm-4">
											<div class="input-group">
												<div class="input-group-addon">
													<i class="fa fa-calendar"></i>
												</div>
												<input type="text" class="form-control pull-right spl-date" name="dari" id="tgl_mulai" value="<?php echo date("d-m-Y"); ?>">
											</div>
										</div>
										<div class="col-sm-5">
											<div class="input-group">
												<div class="input-group-addon">
													<i class="fa fa-calendar"></i>
												</div>
												<input type="text" class="form-control pull-right spl-date" name="sampai" id="tgl_selesai" value="<?php echo date("d-m-Y"); ?>">
											</div>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">Status</label>
										<div class="col-sm-10">
											<select class="form-control select2"  name="status" id="status">
												<option value="">-- silahkan pilih --</option>
												<option value="01" selected>SPL Baru</option>
												<option value="11">SPL Sudah diproses</option>
												<option value="21">Approve by Kasie</option>
												<option value="25">Approve by AssKa</option>
												<option value="31">Cancel by Kasie</option>
												<option value="35">Cancel by AssKa</option>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">Lokasi</label>
										<div class="col-sm-10">
											<select class="form-control select2" name="lokasi" id="lokasi">
												<option value="">-- silahkan pilih --</option>
												<?php foreach($lokasi as $l){ ?>
													<option value="<?php echo $l['id_']; ?>"><?php echo $l['lokasi_kerja']; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">Pekerja</label>
										<div class="col-sm-10">
											<select class="form-control spl-pkj-select2" name="noind" id="noind"></select>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">Lainnya</label>
										<div class="col-sm-3">
											<select class="form-control select2" name="kodel" id="kodel">
												<option value="9">-- pilih --</option>
												<option value="7">Seksi</option>
												<option value="5">Unit</option>
												<option value="3">Bidang</option>
												<option value="1">Dept</option>
											</select>
										</div>
										<div class="col-sm-7">
											<select class="form-control spl-sie-select2" name="kodesie" id="kodesie"></select>
										</div>
									</div>
									
									<div class="form-group">
										<div class="col-sm-12">
											<!-- <button type="submit" class="btn btn-primary pull-right"> <i class="fa fa-save"></i> Proses</button> -->
											<input type="text" id="txt_ses" value="<?php echo $this->session->userid; ?>" hidden>
											<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#ProsesDialog"><i class="fa fa-save"></i> Proses</button>
											<button type="button" id="spl-approval-0" style="margin-right:3px" class="btn btn-primary pull-right"> <i class="fa fa-search"></i> Cari</button>
											<button type="reset" style="margin-right:3px" class="btn btn-primary pull-right" onclick="location.reload()"> <i class="fa fa-refresh"></i> Reset</button>
											<img src="<?php echo base_url('assets/img/gif/loading6.gif') ?>" class="pull-right spl-loading hidden" width="33px" height="33px" style="margin-right:3px">
										</div>
									</div>
								</div>
								
							</div>
						</div>
					</div>
			
					<div class="box box-primary">
						<div class="box-body">
							<table id="example1" class="table table-bordered table-striped spl-table">
								<thead style="background:#3c8dbc; color:#fff">
									<tr>
									<th width="10%">Action</th>
									<th width="2%">Tgl. Lembur</th>
									<th width="2%">Noind</th>
									<th width="2%">Nama</th>
									<th width="2%">Kodesie</th>
									<th width="30%">Seksi/Unit</th>
									<th width="20%">Pekerjaan</th>
									<th width="20%">Jenis Lembur</th>
									<th width="20%">Mulai</th>
									<th width="20%">Selesai</th>
									<th width="20%">Break</th>
									<th width="20%">Istirahat</th>
									<th width="20%">Target(%)</th>
									<th width="20%">Realisasi(%)</th>
									<th width="20%">Alasan Lembur</th>
									<th width="20%">Status</th>
									<th width="20%">Tanggal Proses</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>

					<div id="ProsesDialog" class="modal fade" role="dialog">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Proses SPL</h4>
								</div>
								<div class="modal-body">
									Berikan alasan anda :
									<textarea class="form-control" style="min-width: 75%" id="spl_tex_proses"></textarea>
								</div>
								<div class="modal-footer">
									<a href="finspot:FingerspotVer;<?php echo base64_encode(base_url().'SPL/Fp/fp_proces?userid='.$this->session->userid.'&stat=31&data=&ket='); ?>" type="submit" id="spl_proses_reject" class="btn btn-danger"><i class="fa fa-exclamation-circle"></i> Reject</a>
									<a href="finspot:FingerspotVer;<?php echo base64_encode(base_url().'SPL/Fp/fp_proces?userid='.$this->session->userid.'&stat=21&data=&ket='); ?>" type="submit" id="spl_proses_approve" class="btn btn-success"><i class="fa fa-check-square"></i> Approve</a>
								</div>
							</div>
						</div>							
					</div>

					<script>
						// need some idea
						window.onfocus = function() {
						  console.log('Got focus');
						  window.location.reload();
						}
					</script>

				</form>
			</section>
		</div>
	</div>