	<section class="content">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-11">
						<div class="text-right">
							<h1><b>List Lembur</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
							<a class="btn btn-default btn-lg" href="<?php echo site_url('SPL/ListLembur');?>">
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
				<form class="form-horizontal" action="<?php echo site_URL('SPLSeksi/C_SPLSeksi/data_spl_cetak'); ?>" method="post" enctype="multipart/form-data" target="_blank">
					<div class="box box-primary">
						<div class="box-header">
							<div class="row">
								<div class="col-lg-6">

									<div class="form-group">
										<label class="col-sm-2 control-label">Tanggal</label>
										<div class="col-sm-5">
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
												<option value="01">SPL Baru</option>
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
									<div class="col-sm-12">
											<button type="submit" class="btn btn-primary pull-right"> <i class="fa fa-file-pdf-o"></i> Cetak</button>
											<button type="button" id="spl-pencarian" style="margin-right:3px" class="btn btn-primary pull-right"> <i class="fa fa-search"></i> Cari</button>
											<button type="reset" style="margin-right:3px" class="btn btn-primary pull-right" onclick="location.reload()"> <i class="fa fa-refresh"></i> Reset</button>
										</div>
									</div>
									
								</div>
								
							</div>
						</div>
					</div>
				</form>
			
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
			</section>
		</div>
	</div>