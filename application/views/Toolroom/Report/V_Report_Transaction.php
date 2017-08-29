<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b> <?= strtoupper($Title)?></b></h1>
						
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('Toolroom');?>">
									<i class="icon-calendar icon-2x"></i>
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
								Header
							</div>
							<div class="box-body">
								<div class="row col-lg-12">
									<div class="form-group">
											<label for="norm" class="control-label col-md-1 text-center">Periode</label>
											<div class="col-md-3">
												<input type="text" name="txtPeriode" id="txtPeriode" class="form-control daterangepicker-range" data-date-format="d F Y" placeholder="[Periode]"></input>
											</div>
											<label for="norm" class="control-label col-md-1 text-center">Shift</label>
											<div class="col-md-2">
												<select name="txtShift" id="txtShift" class="form-control">
													<option value=""></option>
													<?php
														foreach($list_shift as $list_shift_item){
															echo "<option value='".$list_shift_item['']."'>".$list_shift_item['']."</option>";
														}
													?>
												</select>
											</div>
											<div class="col-md-1">
												<a class="btn btn-md btn-danger" >Search</a>
											</div>
											<div class="col-md-4">
											</div>
									</div>
								</div>
								<br>
								<br>
									<table class="table table-striped table-bordered table-hover text-left table-item-usable" id="table-item-usable" style="font-size:12px;">
										<thead>
											<tr class="bg-primary">
												<th width="5%"><center>No</center></th>
												<th width="10%"><center>Item Code</center></th>
												<th width="30%"><center>Item</center></th>
												<th width="10%"><center>Merk</center></th>
												<th width="5%"><center>Stok</center></th>
												<th width="5%"><center>Qty used</center></th>
												<th width="10%"><center>Date used</center></th>
												<th width="5%"><center>Shift</center></th>
												<th width="5%"><center>User</center></th>
												<th width="5%"><center>Toolman</center></th>
												<th width="10%"><center>Spesification</center></th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
	</div>
</section>