<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-md-11">
				<div class="text-right">
					<h1><b>LAPORAN</b></h1>
				</div>
			</div>
			<div class="col-md-1">
			<a class="btn btn-default btn-lg" href="<?php echo base_url('ProductionEngineering/Input'); ?>">
					<i class="icon-plus icon-2x"></i>
					<span ><br /></span>
				</a>
			</div>
		</div>
	<div class="box box-info">
		<div class="box-header bg-info">
			<!-- <form method="post" action="<?php echo base_url('/MonitoringPEIA/C_AccountReceivables/buatPDF/') ?>" target="_blank"> -->
				<div class="form-inline">
					<div class="form-group">
						<label>Tanggal awal :</label>
						<input class="form-control" id="tanggalan1" type="date" name="daterawal"/>	
					</div>
					<div class="form-group">
						<label>Tanggal Akhir :</label>
						<input class="form-control" id="tanggalan2" type="date" name="daterakhir"/>	
					</div>
					<div class="form-group">
						<a class="btn btn-success submit-date">Submit</a>
					</div>
				</div>
		</div>
		<div class="box-body">
					<div id="pdf-buttonArea"></div>
			<!-- </form> -->
			<table style="margin-top:10px" id="credit" class="table table-striped table-bordered table-responsive table-hover" >
				<thead style="background:#22aadd; color:#FFFFFF;">
					<th style="text-align:center">NO</th>
					<th width="10%" style="text-align:center">TANGGAL ORDER</th>
					<th style="text-align:center">SEKSI</th>
					<th style="text-align:center">NAMA</th>
					<th style="text-align:center">ORDER</th>
					<th style="text-align:center">JENIS ORDER</th>
					<th style="text-align:center">KETERANGAN</th>
					<th style="text-align:center">ACTION</th>
				</thead>
				<tbody class="table-filter">
				<?php	$no=1 ;foreach ($laporan as $cl) { ?>
		 			 <tr row-id="<?php echo $cl['id']?>">
						<td style="text-align:center"><?php echo $no ?></td>
						<td style="text-align:center"><?php echo $cl['tanggal']?></td>
						<td style="text-align:center"><?php echo $cl['seksi']?></td>
						<td style="text-align:center"><?php echo $cl['nama']?></td>
						<td style="text-align:center"><?php echo $cl['order_']?></td>
						<td style="text-align:center"><?php echo $cl['jenis_order']?></td>
						<td style="text-align:left"><?php echo $cl['keterangan']?></td>
						<td style="text-align:center" class="col-md-2">
							<div class="btn-group-justified" role="group">
								<a class="btn btn-warning" href="<?php echo base_url(); ?>ProductionEngineering/Laporan/edit/<?php echo $cl['id']?>">EDIT</a>
								<a class="btn btn-danger hapus" onclick="DeleteLaporan(<?php echo $cl['id']?>)">DELETE</a>
							</div>
						</td>
					</tr>
				<?php $no++;} ?>
				</tbody>
			</table>
			
		</div>
		</form>
		<div class="box box-info"></div>
	</div>
	</div>
</section>