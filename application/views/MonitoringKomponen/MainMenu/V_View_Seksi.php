<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
							<h1><b>KAPASITAS SIMPAN GUDANG</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('CateringManagement/List');?>">
                                <i class="fa fa-cubes fa-2x"></i>
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
							<b>Setup Parameter Komponen Barang Gudang</b>
						</div>
						<div class="box-body">
							<br>
							<table class="table table-bordered table-horvered table-striped" id="table_view">
								<thead>
									<tr>
										<th rowspan="2">No.</th>
										<th rowspan="2">Kode Komp.</th>
										<th rowspan="2">Nama Komp.</th>
										<th rowspan="2">On Hand</th>
										<th rowspan="2">Qty Max</th>
										<th rowspan="2">Boleh Kirim</th>
										<th rowspan="2">Boleh/Tidak</th>
										<th colspan="2" style="text-align:center;">Handling</th>
										<th rowspan="2">Asal Komp.</th>
										<th rowspan="2">Lokasi</th>
										<th rowspan="2">Gudang</th>
									</tr>
									<tr>
										<th>Qty</th>
										<th>Sarana</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$no: 0; 
										foreach($list_comp as $lc){
											$no++;
										?>
											<td><?php echo $no; ?></td>
											<td><?php echo $lc['SEGMENT1']; ?></td>
										<?php
										}
									?>
								</tbody>
							</table>
						</div>
							<div class="box-footer">
								<table align="left">
									<td width="20%"><a href="javascript:window.history.go(-1);" class="btn btn-primary btn-ls col-md-10" style="background:#2E6DA4;"> BACK </a></td>
									<td width="20%"><button class="btn btn-success btn-ls col-md-10" id="txtBtnSave" type="SUBMIT"> EXPORT </button></td>
								</table>
							</div>
					</div>
				</div>
			</div>		
		</div>		
	</div>
</div>
</section>			