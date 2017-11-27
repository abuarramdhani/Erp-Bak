<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Master Bobot Nilai</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('PenilaianKinerja/MasterBobot');?>">
                                <i class="icon-wrench icon-2x"></i>
                                <span><br/></span>	
                            </a>
						</div>
					</div>
				</div>
			</div>
			<br/>
			
			<div class="row">
				<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						<a href="<?php echo site_url('PenilaianKinerja/MasterBobot/create') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
							<button type="button" class="btn btn-default btn-sm">
							  <i class="icon-plus icon-2x"></i>
							</button>
						</a>
						<b data-toogle="tooltip" title="Halaman untuk membuat Master Bobot Nilai.">Master Bobot Nilai</b>
					</div>
					<div class="box-body">

						<div class="table-responsive" style="overflow:hidden;">
							<table class="table table-striped table-bordered table-hover text-left" id="master-index" style="font-size:14px;">
								<thead class="bg-primary">
									<tr>
										<th width="5%">NO</th>
										<th width="20%">Aspek</th>
										<th width="5%">Bobot Nilai</th>
										<th >Deskripsi</th>
										<th width="15%">Tanggal Berlaku</th>
										<th width="15%">Tanggal Tidak Berlaku</th>
										<th width="15%">Action</th>
									</tr>
								</thead>
								<tbody>
								<?php foreach ($GetBobot as $gb) {
									$number;
								?>
									<tr>
										<td><?php echo $number++ ?></td>
											<input type="text" name="txtIdBobot" value="<?php echo $gb['id_bobot']; ?>" hidden>
										<td><?php echo $gb['aspek']; ?>
										<td><?php echo $gb['bobot']; ?></td>
										<td><?php echo $gb['description']; ?></td>
										<td><?php echo $gb['tberlaku']; ?></td>
										<td style="color: red"><?php echo $gb['ttberlaku']; ?></td>
										<td>
											<a href="<?php echo site_url('PenilaianKinerja/MasterBobot/view/'.$gb['id_bobot']);?>" class="btn btn-flat btn-sm btn-success" title="Lihat Data"><i class="fa fa-search"></i></a>
											&nbsp;&nbsp;
											<a href="<?php echo site_url('PenilaianKinerja/MasterBobot/edit/'.$gb['id_bobot']);?>" class="btn btn-flat btn-sm  btn-warning" title="Edit data"><i class="fa fa-edit"></i></a>
											&nbsp;&nbsp;
											<a data-toggle="modal" data-target="<?php echo '#deletealert'.$gb['id_bobot'] ?>" class="btn btn-flat btn-sm  btn-danger" title="Batalkan penilaian"><i class="fa fa-remove"></i></a>
											&nbsp;&nbsp;
										</td>
									</tr>
									<div class="modal fade modal-danger" id="<?php echo 'deletealert'.$gb['id_bobot'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<div class="col-sm-2"></div>
													<div class="col-sm-8" align="center"><h5><b>PERHATIAN !</b></h5></div>
													<div class="col-sm-2"><h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></h5></div>
													</br>
												</div>
												<div class="modal-body" align="center">
													Apakah anda yakin ingin menghapus master bobot ini ? <br>
													<small>*) Data yang sudah dihapus tidak dapat dikembalikan lagi.</small>
													<div class="row">
														<br>
														<a href="<?php echo base_url('PenilaianKinerja/MasterBobot/delete/'.$gb['id_bobot']);?>" class="btn btn-default"><i class="fa fa-remove"></i> DELETE</a>
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php } ?>
								</tbody>																			
							</table>
						</div>
					</div>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>			
			
				
