<style>
	.dataTables_filter {
		float: right;
	}

	.dataTables_length {
		float: left;
	}
</style>
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
						<a class="btn btn-default btn-lg" href="<?php echo site_url('SPL/RekapLembur'); ?>">
							<i class="icon-wrench icon-2x"></i>
							<span><br /></span>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<section class="col-lg-12 connectedSortable">
			<form class="form-horizontal" id="frm_rekap_lembur">
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
											<input name="dari" type="text" class="form-control pull-right spl-date" id="tgl_mulai" value="<?php echo '01-' . date("m-Y"); ?>">
										</div>
									</div>
									<div class="col-sm-5">
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</div>
											<input name="sampai" type="text" class="form-control pull-right spl-date" id="tgl_selesai" value="<?php echo date("d-m-Y"); ?>">
										</div>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label">Noind</label>
									<div class="col-sm-3">
										<select name="noi" data-placeholder="--pilih--" class="form-control select2" id="noi">
											<option value=""></option>
											<?php foreach ($noind as $n) : ?>
												<option value="<?php echo $n['fs_noind']; ?>"><?php echo $n['fs_noind']; ?></option>
											<?php endforeach ?>
										</select>
									</div>
									<div class="col-sm-7">
										<select class="form-control spl-pkj-select2" id="noind" name="noind"></select>
									</div>
								</div>

								<div class="form-group">
									<div class="col-sm-12">
										<button type="button" id="spl-rekap-excel" style="margin-right:3px" class="btn btn-success pull-right"> <i class="fa fa-file-excel-o"></i> Export Excel</button>
										<button type="buttons" id="spl-rekap" style="margin-right:3px" class="btn btn-primary pull-right"> <i class="fa fa-search"></i> Cari</button>
										<button type="reset" style="margin-right:3px" class="btn btn-primary pull-right" onclick="location.reload()"> <i class="fa fa-refresh"></i> Reset</button>
										<img src="<?= base_url('assets/img/gif/loading6.gif') ?>" class="pull-right spl-loading hidden" width="33px" height="33px" style="margin-right:3px">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>

			<div class="box box-primary">
				<div class="box-body">
					<table id="example11" class="table table-bordered table-striped spl-table">
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
</section>
<script type="text/javascript">
	// need some idea
	window.onfocus = function() {
		console.log('Got focus');
		//window.location.reload();
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

	function setupTimers() {
		document.addEventListener("mousemove", resetTimer(), false);
		document.addEventListener("mousedown", resetTimer(), false);
		document.addEventListener("keypress", resetTimer(), false);
		document.addEventListener("touchmove", resetTimer(), false);

		startTimer();
	}

	document.addEventListener("DOMContentLoaded", function(e) {
		setupTimers();
	});
</script>