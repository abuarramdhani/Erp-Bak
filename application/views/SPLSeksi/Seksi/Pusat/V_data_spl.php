<style>
	.select2 {
		width: 100% !important;
	}
	.select2-container {
	width: 100% !important;
	padding: 0;
	}
</style>
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
				<form class="form-horizontal" action="<?php echo site_URL('SPLSeksi/C_splseksi/data_spl_cetak'); ?>" method="post" enctype="multipart/form-data" target="_blank">
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
												<input type="text" class="form-control pull-right spl-date" name="dari" id="tgl_mulai" value="<?php echo '01-'.date("m-Y"); ?>">
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
												<option value="21">Approved by Kasie</option>
												<option value="25">Approved by AssKa</option>
												<option value="31">Canceled by Kasie</option>
												<option value="35">Canceled by AssKa</option>
											</select>
										</div>
									</div>

									<!-- <div class="form-group">
										<label class="col-sm-2 control-label">Lokasi</label>
										<div class="col-sm-10">
											<select class="form-control select2" name="lokasi" id="lokasi">
												<option value="">-- silahkan pilih --</option>
												<?php foreach($lokasi as $l){ ?>
													<option value="<?php echo $l['id_']; ?>"><?php echo $l['lokasi_kerja']; ?></option>
												<?php } ?>
											</select>
										</div>
									</div> -->

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
											<img src="<?php echo base_url('assets/img/gif/loading6.gif') ?>" class="pull-right spl-loading hidden" width="33px" height="33px" style="margin-right:3px">
										</div>
									</div>

								</div>
								<div class="col-lg-6">
									<button style="float: right;" onclick="sendReminder()" type="button" name="reminderSPLSeksi" class="btn btn-warning"><i class="fa fa-bullhorn"></i></button>
								</div>
							</div>
						</div>
					</div>
				</form>

				<div class="box box-primary">
					<div class="box-body">
						<table id="example11" class="table table-bordered table-striped spl-table">
							<thead style="background:#3c8dbc; color:#fff;">
								<tr>
								<th width="10%" style="vertical-align: middle;text-align: center">Action</th>
								<th width="20%" style="vertical-align: middle;text-align: center">Status</th>
								<th width="20%" style="vertical-align: middle;text-align: center">Tgl. Lembur</th>
								<th width="2%" style="vertical-align: middle;text-align: center">Noind</th>
								<th width="20%" style="vertical-align: middle;text-align: center">Nama</th>
								<!-- <th width="2%" style="vertical-align: middle;text-align: center">Kodesie</th>
								<th width="30%" style="vertical-align: middle;text-align: center">Seksi/Unit</th> -->
								<th width="20%" style="vertical-align: middle;text-align: center">Pekerjaan</th>
								<th width="20%" style="vertical-align: middle;text-align: center">Jenis Lembur</th>
								<th width="20%" style="vertical-align: middle;text-align: center">Mulai</th>
								<th width="20%" style="vertical-align: middle;text-align: center">Selesai</th>
								<th width="20%" style="vertical-align: middle;text-align: center">Break</th>
								<th width="20%" style="vertical-align: middle;text-align: center">Istirahat</th>
								<th width="20%" style="vertical-align: middle;text-align: center">Estimasi</th>
								<th width="20%" style="vertical-align: middle;text-align: center">Target/Pcs/%</th>
								<th width="20%" style="vertical-align: middle;text-align: center">Realisasi/Pcs/%</th>
								<th width="20%" style="vertical-align: middle;text-align: center">Alasan Lembur</th>
								<th width="20%" style="vertical-align: middle;text-align: center">Tanggal Proses</th>
								</tr>
							</thead>
							<?php if (isset($data) and !empty($data)) { ?>
								<tbody>
									<?php foreach ($data as $key) {
										echo "<tr>";
										foreach ($key as $val) {
											echo "<td>".$val."</td>";
										}
										echo "</tr>";
									} ?>
								</tbody>
							<?php } ?>
						</table>
					</div>
				</div>
			</section>
		</div>
	</div>
	<script type="text/javascript">
		// need some idea
		window.onfocus = function() {
		  console.log('Got focus');
		 // window.location.reload();
		}

		var timeoutInMiliseconds = 120000;
		var timeoutId;

		function startTimer() {
		    // window.setTimeout returns an Id that can be used to start and stop a timer
		    timeoutId = window.setTimeout(doInactive, timeoutInMiliseconds)
		}

		function doInactive() {
		    // does whatever you need it to actually do - probably signs them out or stops polling the server for info
		    //window.location.reload();
		}

		function resetTimer() {
		    window.clearTimeout(timeoutId)
		    startTimer();
		}

		function setupTimers () {
		    document.addEventListener("mousemove", resetTimer(), false);
		    document.addEventListener("mousedown", resetTimer(), false);
		    document.addEventListener("keypress", resetTimer(), false);
		    document.addEventListener("touchmove", resetTimer(), false);

		    startTimer();
		}

		document.addEventListener("DOMContentLoaded",function(e){
			setupTimers();
		});

		//set cache
		let exist = window.localStorage.getItem('alert-SPL')
		const d = new Date()

		let today = d.getFullYear()+'-'+d.getMonth()+'-'+d.getDate()

		let json = JSON.parse(exist)

		if(exist == null || json.today != today){
			let data = {
				count: 0,
				lastTime: null,
				today
			}

			window.localStorage.setItem('alert-SPL', JSON.stringify(data))
			console.log("spl-alert storage has been created")
		}

	</script>
