<body class="hold-transition login-page">
<section class="content">
	<div class="panel-group">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3>Setup Approval</h3>
			</div>
			<div class="panel-body">
				<br>
				<table id="tabel_approval" class="table table-hover table-bordered">
					<thead>
						<tr>
							<th style="text-align: center;">No</th>
							<th style="text-align: center;">Posisi</th>
							<th style="text-align: center;">Nama</th>
							<th style="text-align: center;">No Induk</th>
							<th style="text-align: center;">Lokasi Kerja</th>
							<th style="text-align: center;">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no=1;
						foreach ($data as $key) {
							$id= $key['id_approval'];
							?>
							<tr>
								<td style="text-align: center;"><?php echo $no;?></td>
								<td><?php echo $key['posisi'];?></td>
								<td><?php echo $key['nama'];?></td>
								<td style="text-align: center;"><?php echo $key['noind'];?></td>
								<td style="text-align: center;">
									<?php if ($key['lokasi_kerja'] == '01') {
										echo "Jogja";
									}elseif ($key['lokasi_kerja'] == '02') {
										echo "Tuksono";
									};?>
								</td>
								<td><a href="<?php echo base_url('HitungHlcm/Approval/editData'.'/'.$id);?>"><span class="glyphicon glyphicon-edit"></span></a></td>
							</tr>
							<?php
							$no++;
						}

						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
		
</section>
</body>