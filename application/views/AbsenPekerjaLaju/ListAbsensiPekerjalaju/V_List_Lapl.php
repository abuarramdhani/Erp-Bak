<section class="content">
<?php if (!empty($this->session->flashdata('msg'))):?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#modalSukses').modal('show');
	});
</script>
<?php endif;?>
<style type="text/css">
	.Approved{
		color: green;
	}
</style>
	<div class="inner" >
		<div class="box box-header"  style="padding-left:20px">
			<h3 class="pull-left"><strong> Absen Pekerja Entry List </strong></h3>
		</div>
	</div>
	<div class="panel box-body" >

		<div class="table-responsive">
			
			<table id="tblListPekerjaLaju" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center bg-primary" style="width:15px">No</th>
						<!-- <th class="text-center ">Action</th> -->
						<th class="text-center bg-primary" style="width: 100px;">Status</th>
						<th class="text-center bg-primary" style="width: 100px">No Induk</th>
						<th class="text-center bg-primary" style="width: 200px">Nama</th>
						<th class="text-center bg-primary" style="width: 200px">Jenis Selfi</th>
						<th class="text-center bg-primary" style="width: 200px">Waktu Selfi</th>
						<th class="text-center bg-primary" style="width: 300px">Lokasi</th>						
						<th class="text-center bg-primary" style="width: 200px">Waktu Barcode</th>						
						<th class="text-center bg-primary" style="width: 200px">Jarak Tempuh</th>						
						<th class="text-center bg-primary" style="width: 200px">Durasi Gmaps</th>						
						<th class="text-center bg-primary" style="width: 200px">Durasi riil</th>						
					</tr>
				</thead>
				<tbody>
					<?php 
					$no=0;
					$no++;

					foreach ($listData as $key => $value)
					 {
					 	/*if($value['status'] == 0){
							$status = "New Entry";
							$classLabel = "label label-default";
						}else if($value['status']==1){
							$status = "Approved";
							$classLabel = "label label-success";
						}else{
							$status = "Rejected";
							$classLabel = "label label-danger";
						}*/

						$date = date_create($value['waktu']);

						$batas = round($value['waktu_normal_value']/60);
						$wkt_riil = round(abs(strtotime($value['waktu']) - strtotime($value['waktu_barcode']))/60);
						if ($wkt_riil > $batas) {
							$style = ' style="color: red"';
						}else{
							$style = "";
						}
						?>
					
					<tr <?php echo $style ?>>
						<td class="text-center"><?php echo $no++; ?></td>
						<td><center><a target="_blank" href="<?php echo base_url('AbsenPekerjaLaju/list_absen_pkj_laju/list/detail/'.$value['absen_id']); ?>" class="btn btn-primary">Detail</a></center></td>
						<!-- <td id="dataStatus"><span id="textStatus" class="<?php  //echo $classLabel;?>"><?php //echo $status; ?></span></td> -->
						<td><?php echo $value['noind']; ?></td>
						<td><?php echo $value['nama']; ?></td>
						<td><?php echo $value['jenis_absen']; ?></td>
						<td><?php echo date_format($date,"d-M-Y H:i:s"); ?></td>
						<td><?php echo $value['lokasi']." (". $value['longitude'] .", ". $value['latitude'].")"; ?></td>
						<td><?php echo $value['waktu_barcode']; ?></td>
						<td><?php echo $value['jarak_normal_text'].' ( '.$value['jarak_normal_value'].' m ) '; ?></td>
						<td><?php echo 'normal : '.round($value['waktu_normal_value']/60).' Menit<br>cepat :'.round($value['waktu_optimis_value']/60).' Menit<br>lambat : '.round($value['waktu_normal_value']/60).' Menit'; ?></td>
						<td><?php echo $wkt_riil.' Menit'; ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>

	</div>

	<div id="modalSukses" class="modal fade" role="dialog">
		<div class="modal-dialog">

		<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Informasi</h4>
				</div>
				<div class="modal-body">
					<center>
					<h4><strong>ABSEN BERHASIL DIAPPROVE</strong></h4><br/>
					<img style="width: 200px;height: 200px;" src="<?php echo base_url('assets/img/checked.gif'); ?>"><br/>
					<h5>Silahkan Melanjutkan Pekerjaan / Kegiatan Anda</h5>
					</center>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Kembali</button>
				</div>
			</div>
		</div>
	</div>	
</section>
<script type="text/javascript">
	$(document).ready(function(){
	$("#absenAtasanTable").DataTable();
});
</script>
