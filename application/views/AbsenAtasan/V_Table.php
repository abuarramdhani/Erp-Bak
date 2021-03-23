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