<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b><?php echo $Title;?></b></h1>
							</div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('OnJobTraining/CetakMemoJadwalTraining');?>">
									<i class="icon-wrench icon-2x"></i>
								</a>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<h3 class="box-title">Daftar Cetak Memo Jadwal Training</h3>
								<a href="<?php echo site_url('OnJobTraining/CetakMemoJadwalTraining/create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
							</div>
							<div class="box-body">
								<table class="table table-bordered" id="MonitoringOJT-daftarCetakUndangan">
									<thead>
										<tr>
											<th class="text-center">No.</th>
											<th class="text-center">Periode</th>
											<th class="text-center">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$no 	=	1;
											foreach ($daftar_cetak_memo_jadwal_training as $cetak_memo_jadwal_training) 
											{
												$encrypted_string 	=	$this->general->enkripsi($cetak_memo_jadwal_training['id_proses_memo_jadwal_training']);
										?>
										<tr>
											<td class="text-center"><?php echo $no;?></td>
											<td class="text-center"><?php echo $cetak_memo_jadwal_training['tanggal_periode_awal'].' - '.$cetak_memo_jadwal_training['tanggal_periode_akhir'];?></td>
											<td class="text-center">
												<a target="_blank" style="margin-right:4px" href="<?php echo base_url('OnJobTraining/CetakMemoJadwalTraining/export_memo_pdf/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Ekspor Memo PDF"><span class="fa fa-file-pdf-o fa-2x"></span></a>
												<a target="_blank" style="margin-right:4px" href="<?php echo base_url('OnJobTraining/CetakMemoJadwalTraining/export_lampiran_pdf/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Ekspor Lampiran PDF"><span class="fa fa-file-pdf-o fa-2x"></span></a>
                                                <a style="margin-right:4px" href="<?php echo base_url('OnJobTraining/CetakMemoJadwalTraining/update/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Memo"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                <a href="<?php echo base_url('OnJobTraining/CetakMemoJadwalTraining/delete/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Memo" onclick="return confirm('Apakah Anda ingin menghapus format ini?');"><span class="fa fa-trash fa-2x"></span></a>
											</td>
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
				</div>
			</div>
		</div>
	</div>
</section>