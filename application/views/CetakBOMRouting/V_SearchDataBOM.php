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
								<a class="btn btn-default btn-lg" href="<?php echo site_url('ProductionPlan/Item');?>">
									<i class="fa fa-wrench fa-2x">
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
				<form name="Orderform" action="<?php echo base_url('CetakBOMResources/Cetak/CetakBOM'); ?>" class="form-horizontal" target="_blank" onsubmit="return validasi();window.location.reload();" method="post">
				<div class="row">
					<div class="col-md-12">
						<div class="box box-success">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="panel-body">
									<div class="col-md-4" style="text-align: right;">
										<label>Produk</label>
									</div>
									<div class="col-md-3" style="text-align: center;">
										<select style="text-align: center" id="prodd" class="select2 form-control" name="prodd" data-placeholder="Produk" required="required"> </select>

									</div>
                                    
								</div>
									<div class="panel-body">
									<div class="col-md-4" style="text-align: right;">
										<label>Kode Komponen</label>
									</div>
									<div class="col-md-3" style="text-align: center;">
										<select class="form-control select2 comp" disabled data-placeholder="Kode Komponen" id="comp" name="comp" required="required">
											
										</select>
									</div>
                                    
								</div>
									<div class="panel-body">
									<div class="col-md-4" style="text-align: right;">
										<label>Organization</label>
									</div>
									<div class="col-md-3" style="text-align: center;">
										<select class="form-control select2 org" id="org" data-placeholder="Organization Code" name="org">
											<option value="ODM">ODM</option>
											<option value="OPM">OPM</option>
										</select>
										<!-- <input style="text-align: center" type="text" class="form-control org" id="org" value ="ODM" name="org" readonly="readonly"> -->
									</div>
                                    
								</div>
									<div class="panel-body">
									<div class="col-md-4" style="text-align: right;">
										<label>Seksi </label>
									</div>
									<div class="col-md-3" style="text-align: center;">
										<select class="form-control select2 seksii" data-placeholder="Seksi" name="seksi" id="seksii">
											
										</select>
									</div>
                                    
								</div>
								</div>
									<div class="panel-body">
									<div class="col-md-4" style="text-align: right;">
										<label>Tipe Cetak</label>
									</div>
									<div class="col-md-3" style="text-align: center;">
										<select class="form-control select2 typeCetak" id="typeCetak" name="typeCetak">
											<option value="N">Default</option>
											<option value="Y">Detail Proses</option>
										</select>
									</div>
                                    
								</div>
								<div class="panel-body">
									<div  class="col-md-4" ></div>
									<div class="col-md-3" style="text-align: center;">
										<button class="btn btn-success"><i class="fa fa-print"></i> Cetak </button>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							
						</div>
					</div>
				</div>
			</form>
			</div>
		</section>