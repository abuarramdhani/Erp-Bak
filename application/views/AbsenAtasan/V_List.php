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

	#rowT{
	color: white;
	background: #667db6;  /* fallback for old browsers */
	background: -webkit-linear-gradient(to right, #667db6, #0082c8, #0082c8, #667db6);  /* Chrome 10-25, Safari 5.1-6 */
	background: linear-gradient(to right, #667db6, #0082c8, #0082c8, #667db6); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
	}
</style>
	<div class="inner" >
			<div class="box box-header"  style="padding-left:20px">
				<h3 class="pull-left"><strong> Absen Pekerja Entry List </strong></h3>
			</div>
	</div>
	<div class="panel box-body" >
		<div class="table-responsive" id="asa_divasatable">
			<table id="absenAtasanTable" class="table table-striped table-bordered table-hover" style="width:100%">
				<thead>
					<tr id="rowT">
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
							$classLabel = "label label-default";
						}else if($value['status']==1){
							$status = "Approved";
							$classLabel = "label label-success";
						}else{
							$status = "Rejected";
							$classLabel = "label label-danger";
						}

						$date = date_create($value['waktu']);

						?>

					<tr>
						<td class="text-center"><?php echo $no++; ?></td>
						<td><center><a target="_blank" href="<?php echo base_url('AbsenAtasan/List/detail/'.$value['absen_id']); ?>" class="btn btn-primary">Detail</a></center></td>
						<td id="dataStatus"><span id="textStatus" class="<?php  echo $classLabel;?>"><?php echo $status; ?></span></td>
						<td><?php echo $value['noind']; ?></td>
						<td><?php echo $value['nama']; ?></td>
						<td><?php echo $value['jenis_absen']; ?></td>
						<td data-order="<?=date_format($date,'Y-m-d H:i:s')?>"><?php echo date_format($date,"d-M-Y H:i:s"); ?></td>
						<td><?php echo $value['lokasi']." (". $value['longitude'] .", ". $value['latitude'].")"; ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<div class="col-md-12 text-center">
			<?php if (count($listData2) > 20): ?>
				<button class="btn btn-info" id="aba_btnshowall">
					Tampilkan Semua Data
				</button>
			<?php endif ?>
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
<script src="<?= base_url('assets/plugins/fakeLoading/fakeLoading.js') ?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#absenAtasanTable").DataTable();

		$('#aba_btnshowall').click(function(){
			fakeLoading(0);
			$.ajax({
				data: null,
				method: 'GET',
				url: baseurl + 'AbsenAtasan/List/getListAbsenAll',
				error: function(xhr,status,error){
					swal.fire({
						title: xhr['status'] + "(" + xhr['statusText'] + ")",
						html: xhr['responseText'],
						type: "error",
						confirmButtonText: 'OK',
						confirmButtonColor: '#d63031',
					})
				},
				success: function(data){
					fakeLoading(1);
					$('#asa_divasatable').html(data);
					$("#absenAtasanTable").DataTable();
				}
			});
		});
	});
</script>
