<section class="content">

<?php if (!empty($this->session->flashdata('msg'))):?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#modalSukses').modal('show');
	});
</script>
<?php endif;?>

	<div class="inner" >
			<div class="box box-header"  style="padding-left:20px">
				<h3 class="pull-left"><strong> Absen Pekerja Entry List </strong></h3>
			</div>
		</div>
		<div class="panel box-body" >
		<table id="ms_barang" class="table table-striped table-bordered table-responsive table-hover dataTable no-footer">
			<thead>
				<tr style="background-color:#367FA9; color:white ">
						<th class="text-center " style="width:15px">No</th>
						<th class="text-center ">Action</th>
						<th class="text-center ">Status</th>
						<th class="text-center ">No Induk</th>
						<th class="text-center ">Nama</th>
						<th class="text-center ">Jenis Absen</th>
						<th class="text-center ">Waktu Absen</th>
						<th class="text-center ">Lokasi</th>						
					</tr>
			</thead>
			<tbody>
			<?php 
			$no=0;
			$no++;

			foreach ($listData as $key => $value)
			 {
			 	if($value['status'] == 0){
					$status = "New Entry";
				}else if($value['status']==1){
					$status = "Approved";
				}else{
					$status = "Rejected";
				}

				$date = date_create($value['waktu']);
			?>
			
			<tr>
			<td><?php echo $no++; ?></td>
			<td><center><a target="_blank" href="<?php echo base_url('AbsenAtasan/List/detail/'.$value['absen_id']); ?>" class="btn btn-success">Detail</a></center></td>
			<td id="textStatus"><?php echo $status; ?></td>
			<td><?php echo $value['noind']; ?></td>
			<td><?php echo $value['nama']; ?></td>
			<td><?php echo $value['jenis_absen']; ?></td>
			<td><?php echo date_format($date,"d-M-Y H:i:s"); ?></td>
			<td><?php echo $value['lokasi']." (". $value['longitude'] .", ". $value['latitude'].")"; ?></td>
			</tr>
			
			</tbody>
			<?php } ?>
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
