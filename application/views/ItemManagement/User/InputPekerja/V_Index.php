<section class="content-header">
	<a class="btn btn-primary pull-right" href="<?php echo base_url('ItemManagement/User/InputPekerja/create')?>">
		<span class="fa fa-plus" aria-hidden="true"></span> NEW BON
	</a>
	<h1>
		Input Pekerja
	</h1>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-12">	
			<div class="box box-primary">
				<div class="box-body with-border">
					<div id="table-wrapper">
						<table id="im-data-table" class="table table-hover table-bordered table-striped">
							<thead class="bg-primary">
								<tr>
									<th width="40%"><center>Kode Pekerjaan</center></th>
									<th width="40%"><center>Pekerjaan</center></th>
									<th width="20%"><center>Jumlah Pekerja</center></th>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach ($JumlahPekerja as $JP) {
								?>
								<tr>
									<td><?php echo $JP['kdpekerjaan'] ?></td>
									<td><?php echo $JP['pekerjaan'] ?></td>
									<td align="center"><?php echo $JP['jumlah_pkj'] ?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>