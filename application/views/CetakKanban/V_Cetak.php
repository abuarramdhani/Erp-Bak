<section class="content">
		<div class="col-lg-11">
			<div class="text-right">
				<h1>
					<b>
						Cetak Kanban
					</b>
				</h1>
			</div>
		</div>
		<div class="col-lg-1 ">
			<div class="text-right hidden-md hidden-sm hidden-xs">
				<a class="btn btn-default btn-lg" href="">
					<i aria-hidden="true" class="fa fa-refresh fa-2x">
					</i>
				</a>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="box box-danger">
					<div class="box-header with-border">
						<h3><b><center>SELECT DATA CETAK KANBAN</center></b></h3>
					</div>
					<br>
					<div class="box-body">
	                <div class="col-lg-12">
	                	<div class="form-group col-lg-12">
	                		<div class="col-md-4" style="text-align: right;">
	                			<label >Date</label>
	                		</div>
	                		<div class="col-md-6">
	                			<div class="input-group date">
	                				<input type="text" class="form-control pull-right tuanggal" id="tuanggal" class="tuanggal" name="tuanggal" placeholder="DD/MM/YYYY" autocomplete="off">
	                				<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
	                			</div>
	                		</div>

	                	</div>
	                	<div class="form-group col-lg-12">

	                		<div class="col-md-4" style="text-align: right;">
	                			<label >Shift</label>
	                		</div>
	                		<div class="col-md-6">
								<select class="select4 form-control inputShiftCKM" name="shift" id="shift" disabled="disabled" data-placeholder="Pilih Shift" style="width: 100%">
									<option></option>
			                </select>
			            </div>
			        </div>
			        <div class="form-group col-lg-12">

			        	<div class="col-md-4" style="text-align: right;">
			        		<label >Department Class</label>
			        	</div>
			        	<div class="col-md-6">
								<select class="select4 form-control" style="width: 100%" name="deptclass" id="selectDept" data-placeholder="Pilih Department Class">
									<option></option>
									<?php foreach ($deptclass as $key => $value) { ?>
									<option value="<?= $value['DEPT'] ?>"><?= $value['DEPT'].' - '.$value['DESCRIPTION'] ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group col-lg-12">
							
							<div class="col-md-4" style="text-align: right;">
								<label >Job From</label>
							</div>
							<div class="col-md-2">
								<select  class="select4 form-control" name="jobfrom" id="jobfrom" data-placeholder="Pilih Job">
									<option></option>
								</select>
							</div>
							<div class="col-md-2" style="text-align: right;">
								<label >Job To</label>
							</div>
							<div class="col-md-2">
								<select id="jobto" name="jobto" class="select4 form-control" data-placeholder="Pilih Job">
									<option></option>
								</select>
							</div>
						</div>
						<div class="form-group col-lg-12">
							
							<div class="col-md-4" style="text-align: right;">
								<label >Status</label>
							</div>
							<div class="col-md-6">
								<select class="select4 form-control" style="width: 100%" name="status" id="status" data-placeholder="Pilih Status">
									<option></option>
									<?php foreach ($status as $key => $value) { ?>
									<option value="<?= $value['LOOKUP_CODE'] ?>"><?= $value['MEANING'] ?></option>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="panel-body">
							<div class="col-md-12">
								<center><button class="btn btn-lg btn-primary btncari" onclick="getCKM(this)" disabled="disabled"><i class="fa fa-search"></i><b> select</b></button></center>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12" id="ResultCKM"></div>
			</div>
		</div>
	</div>
</section>
