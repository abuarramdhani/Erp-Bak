<body class="hold-transition login-page">
<section class="content">
	<div class="panel-group">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3>Rekap</h3>
			</div>
			<div class="panel-body">
				<br>
				<form style="margin-left: 200px" method="POST" action="<?php echo base_url('HitungHlcm/Rekap/cetakpdf');?>">
					<div class="row">
						<div class="form-group">
							<div class="col-lg-1">
								<label class="control-label">Periode</label>
							</div>
							<div class="col-lg-3">
								<input name="periode" class="prosesgaji-daterangepicker form-control"></input>
							</div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-lg-3">
							<button type="submit" class="btn btn-success pull-right">Cetak</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
		
</section>
</body>