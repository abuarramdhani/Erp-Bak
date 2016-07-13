<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
							<h1><b> Report Rekap Penggunaan Unit </b></h1>
						
						</div>
					</div>
					<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="#">
									<i class="icon-file-text icon-2x"></i>
									<span ><br /></span>
								</a>
								

							</div>
					</div>
				</div>	
			</div>
			<br />
			<div class="row">
				<div class="col-lg-12">
					<div class="box box-primary box-solid">
						<div class="box-header with-border">
							Filter Parameters
						</div>
						<form class="form-horizontal" method="post" action="<?php echo site_url('CustomerRelationship/Report/ExportReportRekapPenggunaanUnit');?>">
						<div class="panel-body">
							<div class="col-lg-11">
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3">Time Period</label>
									<div class="col-lg-9">
										<input type="text" placeholder="Time Period" name="txtPeriod" class="form-control daterange" required/>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3">Buying Type</label>
									<div class="col-lg-9">
										<select class="form-control select4" name="txtBuyingType[]" multiple data-placeholder="All Buying Type" style="width:100%;">
											<option value=""></option>
											<?php
											foreach($buyingtype as $bt){
											?>
											<option value="<?php echo $bt->buying_type_id;?>"><?php echo strtoupper($bt->buying_type_name);?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3" >Province</label>
									<div class="col-lg-9">
										<select class="form-control province-data" multiple name="txtProvince[]" data-placeholder="All Province" style="width:100%;">
											<option value=""></option>
											
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3">Sort By</label>
									<div class="col-lg-9">
										<select class="form-control select4" name="txtSortBy" data-placeholder="Sort" style="width:100%;">
											<option value="Jumlah">Jumlah</option>
											<option value="Belum dipakai">Belum dipakai</option>
											<option value="Belum diketahui">Belum diketahui</option>
											<option value="Sudah dipakai">Sudah dipakai</option>
											<option value="Rusak">Rusak</option>
										</select>
									</div>
								</div>
							</div>	
							
						</div>
						<div class="panel-footer text-right">
							<button class="btn btn-primary btn-rect btn-lg">Search</button>
						</div>
						</form>
					</div>
					
				</div>
			</div>
		</div>
	</div>
	</div>
</section>
