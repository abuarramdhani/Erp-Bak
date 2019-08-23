<style>
.modal-content  {
	-webkit-border-radius:10px !important;
	-moz-border-radius: 10px !important;
	border-radius: 10px !important;
}
label{
	left: 15px;
}
.container{
	width: auto;
}
/* .modal{
  position: relative;
  top: 50%;
  transform: translateY(-50%); */
}
</style>
<section class="content">
	<div class="inner">
		<div class="box box-primary box-solid">
			<div class="box-header">
				<div class="box-title">
					<h3><center><i class="fa fa-reorder"> <?= $Menu ?></i></center></h3>
				</div>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-lg-12">
						<div class="table">
							<div class="table-responsive">
								<table class="table table-bordered table-hovered table-striped">
									<thead>
										<tr class="bg-primary">
											<th>No</th>
											<th>Tanggal</th>
											<!-- <th>Id Cuti</th> -->
											<th>No Induk - Nama</th>
											<th>Tipe Cuti</th>
											<th>Jenis Cuti</th>
											<th>Keperluan</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<?php $no = 1 ?>
									<?php foreach ($Draft as $key) {
										$encrypted_string = $this->encrypt->encode($key['lm_pengajuan_cuti']);
										$id = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
										$detail = base_url('PermohonanCuti/DraftCuti/Edit/'.$id);
										?>
									<tr id="row<?=$key['lm_pengajuan_cuti']?>">
										<td class="text-center"><?php echo $no ?></td>
										<td><?php echo date("d-M-Y",strtotime($key['tgl_pengajuan'])) ?></td>
										<!-- <td><?php //echo $key['lm_pengajuan_cuti'] ?></td> -->
										<td><?php echo $key['nama'] ?></td>
										<td><?php echo $key['tipe_cuti'] ?></td>
										<td><?php echo $key['jenis_cuti'] ?></td>
										<td><?php if (empty($key['kp'])){ echo $key['keperluan'];}else{ echo $key['kp'];} ?></td>
										<td><?php if ($key['status'] == '0'){ ?>
												<span class='label label-warning'> Belum request</span>
											<?php }elseif ($key['status'] == '1') {
												echo "<span class='label label-warning'><i class='fa fa-clock-o'> </i>  Menunggu Approval</span>";
											}elseif ($key['status'] == '2') {
												echo "<span class='label label-success'><i class='fa fa-check'> </i>  Approved</span>";
											}elseif ($key['status'] == '3'){
												echo "<span class='label label-danger'><i class='fa fa-close'> </i>  Rejected</span>";
											}elseif ($key['status'] == '4'){
												echo "<span class='label label-danger'><i class='fa fa-ban'> </i>  Dibatalkan</span>";
											}
										 ?>
										</td>
										<td>
											<?php if ($key['status'] == '0'): ?>
												<button onclick="reqCuti('<?=$id?>')" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Request"><span class="fa fa-send-o"> </span></button>
												<a href="<?php echo site_url('PermohonanCuti/DraftCuti/Detail/'.$id) ?>" class="btn btn-success btn-xs" data-toggle="tooltip" title="Edit" ><i class="fa fa-edit"></i> </a>
												<button onclick="delCuti('<?=$key['lm_pengajuan_cuti']?>')" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Hapus"><span class="fa fa-trash"> </span></a>&nbsp
											<?php elseif ($key['status'] == '1'): ?>
												<button onclick="delCuti('<?=$key['lm_pengajuan_cuti']?>')" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Hapus"><span class="fa fa-trash"> </span></button>&nbsp
												<a href="<?php echo site_url('PermohonanCuti/DraftCuti/Detail/'.$id) ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Detail Cuti"><i class="fa fa-info"></i> Detail</a>
											<?php else: ?>
												<a href="<?php echo site_url('PermohonanCuti/DraftCuti/Detail/'.$id) ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Detail Cuti"><i class="fa fa-info"></i> Detail</a>
											<?php endif; ?>
										</td>
									</tr>
									<?php $no++; } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Modal Loading -->
<div class="modal fade" id="loadingRequest" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
  <div style="transform: translateY(50%);" class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">
        <div class="loader"></div>
        <div clas="loader-txt">
          <center><img class="img-loading" style="width:130px; height:auto" src="<?php echo base_url('assets/img/gif/loadingquick.gif') ?>"></center>
					<p><center>Loading...</center></p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->
