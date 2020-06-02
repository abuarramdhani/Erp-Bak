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
						<th class="text-center bg-primary" style="width: 100px;">Action</th>
						<th class="text-center bg-primary" style="width: 100px;">Status</th>
						<th class="text-center bg-primary" style="width: 100px">No Induk</th>
						<th class="text-center bg-primary" style="width: 200px">Nama</th>
						<th class="text-center bg-primary" style="width: 200px">Jenis Selfie</th>
						<th class="text-center bg-primary" style="width: 200px">Waktu Selfie</th>
						<th class="text-center bg-primary" style="width: 300px">Lokasi Selfie</th>						
						<th class="text-center bg-primary" style="width: 200px">Waktu Barcode</th>						
						<th class="text-center bg-primary" style="width: 200px">Jarak Tempuh Kantor - Titik Selfie</th>						
						<th class="text-center bg-primary" style="width: 200px">Durasi Gmaps</th>						
						<th class="text-center bg-primary" style="width: 200px">Durasi riil</th>						
						<th class="text-center bg-primary" style="width: 200px">Lokasi Rumah</th>						
						<th class="text-center bg-primary" style="width: 200px">Jarak Tempuh Rumah - Titik Selfie</th>						
					</tr>
				</thead>
				<tbody>
					
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
