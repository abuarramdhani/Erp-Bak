<!-- FINISHED -->
<div class="modal fade modal-default" id="rincian_paket_finished" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="col-sm-2"></div>
				<div class="col-sm-8" align="center">
					<h5><b>Pelatihan Paket</b> <br>
					<b> 
					<?php foreach ($paketdetailfinish as $pkd) {
						echo $pkd['package_scheduling_name']; 
					} ?>
					</b>
					</h5></div>
				<div class="col-sm-2"><h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></h5></div>
				<br>
			</div>
			<div class="modal-body" align="center">
				<table class="table table-stripped table-hover">
					<thead>
						<th width="5%" >No</th>
						<th width="15%">Action</th>
						<th width="15%">Trainer</th>
						<th width="20%">Nama Pelatihan</th>
						<th width="10%">Tanggal</th>
						<th width="5%" style="text-align:center;">Jumlah Peserta</th>
					</thead>
					<tbody>
					<?php $number=0;  foreach ($recPackage as $rp) {
							$strainer = explode(',', $rp['trainer']);
							$number++;?>
						<tr>
							<td><?php echo $number ?></td>
							<td>
								<a href="<?php echo site_url('ADMPelatihan/Record/Detail/'.$rp['scheduling_id']);?>" class="btn btn-flat btn-sm btn-warning" data-toggle="tooltip1" title="View" ><i class="fa fa-search"></i></a>
								<a href="<?php echo site_url('ADMPelatihan/Record/Confirm/'.$rp['scheduling_id']);?>" class="btn btn-flat btn-sm btn-success" data-toggle="tooltip1" title="Input Kehadiran & Nilai"><i class="fa fa-check"></i></a>
								<a href="<?php echo site_url('ADMPelatihan/InputQuestionnaire/ToCreate/'.$rp['scheduling_id']);?>" class="btn btn-flat btn-sm btn-primary" data-toggle="tooltip1" title="Input Kuesioner"><i class="fa fa-file-text-o"></i></a>
								<a data-toggle="modal" onclick="showModalDel('<?php echo $rp['scheduling_id'] ?>','<?php echo $rp['scheduling_name'] ?>')" class="btn btn-flat btn-danger btn-sm" title="Hapus Pelatihan"><i class="fa fa-remove"></i></a>
							</td>
							<td>
								<?php 
								foreach ($strainer as $st){
									foreach ($trainer as $tr){
										if ($st == $tr['trainer_id']){
											echo '<i class="fa fa-angle-right"></i> '.$tr['trainer_name'].'<br>';
										}
									}
								};
							?>
							</td>
							<td><?php echo $rp['scheduling_name'] ?></td>
							<td><?php echo $rp['date_format'] ?></td>
							<td align="center"><?php echo $rp['participant_number'] ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>		
			</div>
		</div>
	</div>
</div>
<!-- MODAL  DELETE-->
	<div class="modal fade modal-danger" id="showModalDel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<!-- <div class="modal fade modal-danger" id="<?php echo 'deletealert'.$rp['scheduling_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> -->
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<div class="col-sm-2"></div>
					<div class="col-sm-8" align="center"><h5><b>PERHATIAN !</b></h5></div>
					<div class="col-sm-2"><h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></h5></div>
					<br>
				</div>
				<div class="modal-body" align="center">
					Apakah anda yakin ingin menghapus <b id="data-id">
						<?php //echo $rp['scheduling_name'] ?>
					</b> dari jadwal pelatihan ? <br>
					<small>*) Data yang sudah dihapus tidak dapat dikembalikan lagi.</small>
					<div class="row">
						<br>
						<a href="" class="btn btn-default"><i class="fa fa-remove"></i> DELETE</a>
						<!-- <a href="<?php echo base_url('ADMPelatihan/Record/Delete/'.$rp['scheduling_id'])?>" class="btn btn-default"><i class="fa fa-remove"></i> DELETE</a> -->
					</div>
				</div>
			</div>
		</div>
	</div>