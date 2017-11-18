<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Record Pelatihan</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('ADMPelatihan/Record');?>">
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
						<b data-toogle="tooltip" title="Halaman yang menampilkan daftar pelatihan yang tanggal penjadwalannya telah berlalu.">Record Pelatihan</b>
					</div>
					<div class="box-body">
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-1 control-label">Tanggal</label>
								<div class="col-lg-2">
									<input name="TxtStartDate" class="form-control singledateADM">
								</div>
								<label class="col-lg-1 control-label" align="center">s/d</label>
								<div class="col-lg-2">
									<input name="TxtEndDate" class="form-control singledateADM">
									<input name="TxtStatus" type="text" value="1" hidden>
								</div>
								<div class="col-lg-2">
									<button class="btn btn-primary btn-flat btn-block" id="FilterRecord">Filter</button>
								</div>
								<div class="col-lg-1" align="center"  id="loading">
								</div>
							</div>
						</div>
						<div id="table-full">