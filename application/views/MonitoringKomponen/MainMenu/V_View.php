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
							<table class="table table-bordered table-horvered table-striped" id="table_view_seksi" style="width:100%;font-size:12px;">
								<thead style="background:#2E6DA4; color:#FFFFFF;">
									<tr>
										<th rowspan="2" style="text-align:center;">No.</th>
										<th rowspan="2" style="text-align:center;">Kode Komp.</th>
										<th rowspan="2" style="text-align:center;">Nama Komp.</th>
										<th rowspan="2" style="text-align:center;">On Hand</th>
										<th rowspan="2" style="text-align:center;">Qty Max</th>
										<th rowspan="2" style="text-align:center;">Boleh Kirim</th>
										<th rowspan="2" style="text-align:center;">Boleh/Tidak</th>
										<th colspan="2" style="text-align:center;">Handling</th>
										<th rowspan="2" style="text-align:center;">Asal Komp.</th>
										<th rowspan="2" style="text-align:center;">Lokasi</th>
										<th rowspan="2" style="text-align:center;">Gudang</th>
									</tr>
									<tr>
										<th>Qty</th>
										<th>Sarana</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$no= 0; 
										foreach($data as $lc){
											$no++;
										?>
											<tr>
												<td><?php echo $no; ?></td>
												<td><?php echo $lc['SEGMENT1']; ?></td>
												<td><?php echo $lc['DESCRIPTION']; ?></td>
												<td><?php echo $lc['ONHAND']; ?></td>
												<td><?php echo $lc['MAX_MINMAX_QUANTITY']; ?></td>
												<td><?php echo $lc['BOLEH_KIRIM']; ?></td>
												<td><?php echo $lc['STATUS']; ?></td>
												<td><?php echo $lc['UNIT_VOLUME']; ?></td>
												<td><?php echo $lc['ATTRIBUTE14']; ?></td>
												<td><?php echo $lc['ASAL_ITEM']; ?></td>
												<td><?php echo $lc['LOKASI']; ?></td>
												<td><?php echo $lc['SUBINVENTORY_CODE']; ?></td>
											</tr>
										<?php
										}
									?>
								</tbody>
							</table>
						</div>
							<div class="box-footer">
								<div class="col-md-12">
									<div class="col-md-2">
										<a href="javascript:window.history.go(-1);" class="btn btn-flat btn-primary btn-ls col-md-10" style="width:100%;"> BACK </a>
									</div>
									<div class="col-md-2">
										<a href="<?php echo $export_xls; ?>" target="blank_" class="btn btn-flat btn-success btn-ls col-md-10" style="width:100%;"> XLS </a>
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