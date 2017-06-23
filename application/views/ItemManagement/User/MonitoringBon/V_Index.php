<section class="content-header">
	<a class="btn btn-primary pull-right" href="<?php echo base_url('ItemManagement/User/MonitoringBon/create')?>">
		<span class="fa fa-plus" aria-hidden="true"></span> NEW BON
	</a>
	<h1>
		Monitoring Bon
	</h1>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-12">	
			<div class="box box-primary">
				<div class="box-body with-border">
					<form target="_blank" method="post" action="<?php echo base_url('ItemManagement/User/MonitoringBon/export') ?>">
						<div class="row" style="margin: 10px 10px">
							<label class="col-lg-2 control-label">PERIODE</label>
							<div class="col-lg-4">
								<input id="date-filter" type="text" class="form-control im-datepicker" style="width: 100%" placeholder="PERIODE" name="txt_periode_bon" value="" required></input>
							</div>
							<div class="col-lg-2">
								<button id="export" type="submit" class="btn btn-primary">EXPORT</button>
							</div>
							<div class="col-lg-4" style="text-align: right">
								<div id="loading">
									<img src="<?php echo base_url('assets/img/gif/loading3.gif') ?>" width="32px">
								</div>
							</div>
						</div>
					</form>
					<div id="table-wrapper">
						<table class="table table-hover table-bordered table-striped">
							<thead class="bg-primary">
								<tr>
									<th width="10%"><center>Kode Barang</center></th>
									<th width="40%"><center>Detail</center></th>
									<th width="10%"><center>QTY</center></th>
									<th width="20%"><center>Tanggal</center></th>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach ($KodeBon as $KB) {
								?>
								<tr>
									<td colspan="4" align="center"><b>Kode Blanko (<?php echo $KB['kode_blanko'] ?>)</b></td>
								</tr>
								<?php
									foreach ($MonitoringBon as $MB) {
										if ($MB['kode_blanko'] == $KB['kode_blanko']) {
								?>
								<tr>
									<td><?php echo $MB['kode_barang'] ?></td>
									<td><?php echo $MB['detail'] ?></td>
									<td align="center"><?php echo $MB['jumlah'] ?></td>
									<td><?php echo $MB['periode'] ?></td>
								</tr>
								<?php }} ?>
								<tr>
									<td colspan="4"></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>