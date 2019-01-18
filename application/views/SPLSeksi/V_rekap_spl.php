	<section class="content">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-11">
						<div class="text-right">
							<h1><b>Rekap Lembur</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
							<a class="btn btn-default btn-lg" href="<?php echo site_url('SPL/RekapLembur');?>">
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
				<form class="form-horizontal">
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
												<input type="text" class="form-control pull-right spl-date" id="tgl_mulai" value="<?php echo date("d-m-Y"); ?>">
											</div>
										</div>
										<div class="col-sm-5">
											<div class="input-group">
												<div class="input-group-addon">
													<i class="fa fa-calendar"></i>
												</div>
												<input type="text" class="form-control pull-right spl-date" id="tgl_selesai" value="<?php echo date("d-m-Y"); ?>">
											</div>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">Noind</label>
										<div class="col-sm-3">
											<select class="form-control select2" id="noi">
												<option value="">-- pilih --</option>
												<?php foreach($noind as $n){ ?>
													<option value="<?php echo $n['fs_noind']; ?>"><?php echo $n['fs_noind']; ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-sm-7">
											<select class="form-control spl-pkj-select2" id="noind"></select>
										</div>
									</div>
									
									<div class="form-group">
										<div class="col-sm-12">
											<button type="submit" id="spl-rekap" style="margin-right:3px" class="btn btn-primary pull-right"> <i class="fa fa-search"></i> Cari</button>
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
								<th width="5%">No.</th>
								<th width="15%">Tanggal</th>
								<th width="10%">Noind</th>
								<th width="20%">Nama</th>
								<th width="15%">Jenis Lembur</th>
								<th width="15%">Mulai</th>
								<th width="15%">Selesai</th>
								<th width="5%">Total(Jam)</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</section>
		</div>
	</div>