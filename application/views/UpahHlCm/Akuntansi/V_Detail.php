<section class="content">
	<div class="panel panel-primary" >

		<div class="panel-heading"  style="padding-top: 10px;padding-bottom: 10px;">
				<h3> Detail Periode <?php echo date('F Y',strtotime($periode)); ?></h3>
				<div align="right"><a class="btn btn-warning btn-lg" href="<?php echo base_url('UpahHlCm/Akuntansi/'); ?>">Kembali</a></div>
		</div>
	
		<div class="panel-body" >

		<div class="table-responsive">
			
				<table id="tbl_detail" class="table table-striped table-bordered table-hover" style="width:100%">
			<thead>
				<tr style="background-color:#367FA9; color:white ">
						<th rowspan="2" colspan="1" class="text-center" style="width:15px">No</th>
						<th rowspan="2" colspan="1" class="text-center">No Induk</th>
						<th rowspan="2" colspan="1" class="text-center">Nama</th>
						<th rowspan="2" colspan="1" class="text-center">Lokasi Kerja</th>
						<th rowspan="2" colspan="1" class="text-center">Status</th>
						<th rowspan="1" colspan="4" class="text-center" >Gaji</th>
						<th rowspan="1" colspan="3" class="text-center" >Tambahan</th>
						<th rowspan="1" colspan="3" class="text-center" >Potongan</th>
					</tr>
					<tr style="background-color:#367FA9; color:white ">
						<th rowspan="1" colspan="1" class="text-center">Gaji Pokok</th>
						<th rowspan="1" colspan="1" class="text-center">Lembur</th>
						<th rowspan="1" colspan="1" class="text-center">Uang Makan</th>
						<th rowspan="1" colspan="1" class="text-center">Uang Makan Puasa</th>
						<th rowspan="1" colspan="1" class="text-center">Gaji Pokok</th>
						<th rowspan="1" colspan="1" class="text-center">Lembur</th>
						<th rowspan="1" colspan="1" class="text-center">Uang Makan</th>
						<th rowspan="1" colspan="1" class="text-center">Gaji Pokok</th>
						<th rowspan="1" colspan="1" class="text-center">Lembur</th>
						<th rowspan="1" colspan="1" class="text-center">Uang Makan</th>
					</tr>
			</thead>
			<tbody>
			<?php $no=0; foreach($detail_rekap as $data): $no++; ?>
				<tr>
				<td><?= $no; ?></td>
				<td><?= $data->noind; ?></td>
				<td><?= rtrim($data->nama); ?></td>
				<td><?= $data->lokasi_kerja; ?></td>
				<td><?= $data->status; ?></td>
				<td class="text-center"><?= number_format($data->proses_komponen_gaji_pokok,2); ?></td>
				<td class="text-center"><?= number_format($data->proses_komponen_lembur,2); ?></td>
				<td class="text-center"><?= number_format($data->proses_komponen_uang_makan,2); ?></td>
				<td class="text-center"><?= number_format($data->proses_komponen_uang_makan_puasa,2); ?></td>
				<td class="text-center"><?= number_format($data->tambahan_komponen_gaji_pokok,2); ?></td>
				<td class="text-center"><?= number_format($data->tambahan_komponen_lembur,2); ?></td>
				<td class="text-center"><?= number_format($data->tambahan_komponen_uang_makan,2); ?></td>
				<td class="text-center"><?= number_format($data->potongan_komponen_gaji_pokok,2); ?></td>
				<td class="text-center"><?= number_format($data->potongan_komponen_lembur,2); ?></td>
				<td class="text-center"><?= number_format($data->potongan_komponen_uang_makan,2); ?></td>
				</tr>
			<?php endforeach; ?>	
			</tbody>
			
		</table>
		</div>

		</div>
	</div>
</section>
<script type="text/javascript">
	$(document).ready(function(){
		$("#tbl_detail").DataTable();
	})
</script>
