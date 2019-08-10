<section class="content">
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
			<td><center><a target="_blank" href="<?php echo base_url('AbsenAtasan/List/detail/'.$value['absen_id']); ?>" class="btn btn-primary">Detail</a></center></td>
			<td><?php echo $status; ?></td>
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


	<?php foreach ($listData as $key => $value) { ?>
	<div id="detailAbsen<?=$value['absen_id'];?>" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <!-- Modal content-->
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Approval Absen</h4>
		      </div>
		      <?php 
		      	foreach ($employeeInfo as $key => $karyawan) {
		      ?>
		      <div class="modal-body">   
				<center><img style="width: 200px;height: 200px;margin-bottom: 15px;" src="<?php echo $value['gambar']; ?>"/></center>
				<h4><strong>DETAIL PEKERJA</strong></h4>

				<div class="row">
					<div class="col-md-3">No. Induk</div>
					<div class="col-md-1"> : </div>
					<div class="col-md-5"><?php echo $value['noind']; ?></div>
				</div>
				<div class="row">
					<div class="col-md-3">Nama</div>
					<div class="col-md-1"> : </div>
					<div class="col-md-5"><?php echo $value['nama']; ?></div>
				</div>
				<div class="row">
					<div class="col-md-3">Seksi</div>
					<div class="col-md-1"> : </div>
					<div class="col-md-7"><?php echo $karyawan['section_name']; ?></div>
				</div>
				<div class="row">
					<div class="col-md-3">Unit</div>
					<div class="col-md-1"> : </div>
					<div class="col-md-7"><?php echo $bidangUnit[0]['unit_name'] ?></div>
				</div>
				<div class="row">
					<div class="col-md-3">Bidang</div>
					<div class="col-md-1"> : </div>
					<div class="col-md-7"><?php echo $bidangUnit[0]['field_name'] ?></div>
				</div>
				<div class="row">
					<div class="col-md-3">Departemen</div>
					<div class="col-md-1"> : </div>
					<div class="col-md-7"><?php echo $karyawan['department_name'] ?></div>
				</div>
				<br/>
				<h4><strong>DETAIL ABSEN</strong></h4>
		        <div class="row">
					<div class="col-md-3">Waktu </div>
					<div class="col-md-1"> : </div>
					<div class="col-md-5"><?php echo $value['waktu']; ?></div>
				</div>
				<div class="row">
					<div class="col-md-3">Lokasi</div>
					<div class="col-md-1"> : </div>
					<div class="col-md-7"><?php echo $value['lokasi']; ?></div>
				</div>
				<div class="row">
					<div class="col-md-3">Jenis Absen</div>
					<div class="col-md-1"> : </div>
					<div class="col-md-5"><?php echo $value['jenis_absen']; ?></div>
				</div>	
			 </div>
			 <div class="row">
				<center>
			 	<div>
			 		<a target="_blank" class="btn btn-success" href="https://maps.google.com/?q=<?php echo $value['latitude']; ?>,<?php echo $value['longitude']; ?>"><i class="fa fa-map-marker"></i>  Lihat di Google Maps</a>
			 	</div>
			 	</center>
			 
			 </div>
			 <?php } ?>
		      <div class="modal-footer">
		      <button type="button" class="btn btn-danger">Reject</button>
		        <a type="button" class="btn btn-primary">Approve</a>
		      </div>
		    </div>

		  </div>
		</div>
		<?php } ?>
		
</section>