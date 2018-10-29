<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-md-11">
				<div class="text-right">
					<h1><b>JOB HARIAN</b></h1>
				</div>
			</div>
			<div class="col-md-1">
			<a class="btn btn-default btn-lg" href="<?php echo base_url('ProductionEngineering/JobHarian/Input'); ?>">
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
						<a class="btn btn-success submit-datemon">Submit</a>
					</div>
				</div>
		</div>
		<div class="box-body">
					<div id="pdf-buttonArea"></div>
			<!-- </form> -->
			<table style="margin-top:10px" id="credit" class="table table-striped table-bordered table-responsive table-hover" >
				<thead style="background:#22aadd; color:#FFFFFF;">
					<th style="width: 5%;text-align:center">NO</th>
					<th style="width: 10%;text-align:center">TANGGAL</th>
					<th style="width: 10%;text-align:center">NAMA</th>
					<th style="width: 55%;text-align:center">KETERANGAN</th>
					<th style="width: 20%;text-align:center">ACTION</th>
				</thead>
				<tbody class="table-filter">
				<?php	$no=1 ;foreach ($laporan as $cl) { ?>
		 			 <tr row-id="<?php echo $cl['id']?>">
						<td style="text-align:center"><?php echo $no ?></td>
						<td style="text-align:center"><?php echo $cl['tanggal']?></td>
						<td style="text-align:center"><?php echo $cl['nama']?></td>
						<td style="text-align:left"><?php echo $cl['keterangan']?></td>
						<td style="text-align:center" class="col-md-2">
							<div class="btn-group-justified" role="group">
								<a class="btn btn-warning" href="<?php echo base_url(); ?>ProductionEngineering/JobHarian/edit/<?php echo $cl['id']?>">EDIT</a>
								<a class="btn btn-danger hapus" onclick="DeleteJobHarian(<?php echo $cl['id']?>)">DELETE</a>
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