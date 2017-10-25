<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Rekap Report Pelatihan</b></h1>
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
						<b data-toogle="tooltip" title="">Efektivitas Training</b>
					</div>
					<div class="box-body">
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-1 control-label">Tanggal</label>
								<div class="col-lg-2">
									<input name="txtDate1" class="form-control singledate">
								</div>
								<label class="col-lg-1 control-label" align="center">s/d</label>
								<div class="col-lg-2">
									<input name="txtDate2" class="form-control singledate">
								</div>
								<div class="col-lg-2">
									<button class="btn btn-primary btn-flat btn-block" id="SearchReport3">Filter</button>
								</div>
								<div class="col-lg-1" align="center" id="loading">
								</div>
							</div>
						</div>
						<div id="table-full">
							<div class="table-responsive" style="overflow:hidden;">
								<table class="table table-striped table-bordered table-hover text-left" id="tblrecord" style="font-size:14px;table-layout:fixed;width:1080px;">
									<thead class="bg-primary">
										<tr>
											<th width="7%" style="text-align:center;">No</th>
											<th >Jenis Training</th>
											<th width="20%" style="text-align:center;">Presentase Kelulusan</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td style="text-align:center;">1</td>
											<td>Pelatihan Orientasi</td>
											<td></td>
										</tr>
										<tr>
											<td style="text-align:center;">2</td>
											<td>Pelatihan Non Orientasi</td>
											<td></td>
										</tr>
									</tbody>															
								</table>
							</div>	
							<div class="form-group">
								<div class="col-lg-12 text-right">
									<a href="javascript:window.history.go(-1);" class="btn btn-primary btn btn-flat">Back</a>		
								</div>
							</div>
						</div>
					</div>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>			
