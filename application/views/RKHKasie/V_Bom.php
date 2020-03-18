<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1>
									<b>
										<?= $Title ?>
									</b>
								</h1>
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('ReceivePO/History/');?>">
									<i class="fa fa-list fa-2x">
									</i>
									<span>
										<br />
									</span>
								</a>
							</div>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-md-12">
						<div class="box box-warning box-solid">
							<div class="box-body">
								<div class="panel-body">
									<div class="col-md-4" style="text-align: right;" >
										<label>Masukan Kode Barang</label>
									</div>
									<div class="col-md-3" style="text-align: left;">
										<!-- <select class="form-control select2" data-placeholder="Kode Barang" name="kodeitem" id="kodeitem"></select> -->
										<input type="text" class="form-control" name="kodeitem">
									</div>
									<div class="col-md-4" style="text-align: left;">
										<button class="btn btn-warning" onclick="getBom(this)"><i class="fa fa-search"></i> Search All</button>
										<button class="btn btn-success" onclick="getBomada(this)">BOM Ada</button>
										<button class="btn btn-danger" onclick="getBomtdkada(this)">BOM Tidak Ada</button>

									</div>

								</div>
								<div class="panel-body" id="bom_result">

								</div>
								<div class="panel-body" id="bom_ada">

								</div>
								<div class="panel-body" id="bom_tdk">

								</div>
						</div>
					</div>
				</div>
			</div>
		</section>