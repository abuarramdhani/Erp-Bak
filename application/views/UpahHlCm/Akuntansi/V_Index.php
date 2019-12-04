<section class="content">
	<div class="panel panel-primary" >

		<div class="panel-heading"  style="padding-top: 10px;padding-bottom: 10px;">
				<h3 style="float: left;"> Import Data Absen Penggajian Harian Lepas </h3>
				<div align="right"><a class="btn btn-success btn-lg" href="<?php echo base_url('UpahHlCm/Akuntansi/ImportData'); ?>">Import Data</a></div>
		</div>
	
		<div class="panel-body" >

		<div class="table-responsive">
			
				<table id="tbl_importhlcm" class="table table-striped table-bordered table-hover" style="width:100%">
			<thead>
				<tr style="background-color:#367FA9; color:white ">
						<th class="text-center " style="width:15px">No</th>
						<th class="text-center ">Action</th>
						<th class="text-center ">Periode</th>
						<th class="text-center ">Jumlah Data</th>						
					</tr>
			</thead>
			<tbody>
			<?php $no=0; foreach ($rekap as $key => $data): $no++ ?>
				<tr>
					<td><?= $no; ?></td>
					<td style="width: 15%" class="text-center"><span>
					<a target="_blank" style="margin-right: 7px;" class="btn btn-info" href="<?php echo base_url('UpahHlCm/Akuntansi/getDetail/'.$data->periode); ?>">Detail</a>
					<button data-periode="<?=$data->periode ?>" class="btn btn-danger btn-delete">Delete</button></span></td>
					<td class="text-center"><?= $data->str_periode.' - '.$data->tahun ?></td>
					<td class="text-center"><?= $data->jumlah_data.' Orang' ?></td>
				</tr>
			<?php endforeach;?>
			</tbody>
			
		</table>
		</div>

		</div>
	</div>
</section>
<script type="text/javascript">
$(document).ready(function(){
	$("#tbl_importhlcm").DataTable();

	$("#tbl_importhlcm").on('click','.btn-delete',function(){
		var periode = $(this).attr('data-periode');
		var status = confirm('Yakin menghapus data?');
		if(status){
			$.ajax({
			url: '<?php echo base_url() ?>UpahHlCm/Akuntansi/deleteRekap',
			type: 'POST',
			data: {periode:periode},
			success: function(){
				Swal.fire('Berhasil','Berhasil menghapus data','success').then((result) =>{
					if(result.value){
						location.reload();
					}
				})

			},
			error: function(){
				Swal.fire('Gagal','Gagal menghapus data','error')
			}
		})
		}
		
	})
})
	
</script>
