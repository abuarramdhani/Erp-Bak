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

						<div style="overflow:hidden;">
							<table class="table table-striped table-bordered table-hover text-left" id="JurnalPenilaian-masterBobot" style="width:100%;">
								<thead class="bg-primary">
									<tr>
										<th width="5%" class="text-center">No.</th>
										<th width="20%" class="text-center">Aspek</th>
										<th width="5%" class="text-center">Bobot</th>
										<th  class="text-center">Deskripsi</th>
										<th width="15%" class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>
								<?php 
									$total = 0;
									$number 	=	1;
									foreach ($GetBobot as $gb) 
									{
										$total = $total + (float)$gb['bobot'];
								?>
									<tr>
										<td align="center"><?php echo $number++ ?>
											<input type="text" name="txtIdBobot" value="<?php echo $gb['id_bobot']; ?>" hidden>
										</td>
										<td align="left"><?php echo $gb['aspek']; ?>
										<td align="center"><?php echo $gb['bobot']; ?></td>
										<td align="left"><?php echo $gb['description']; ?></td>
										<td align="center">
											<!-- <a href="<?php echo site_url('PenilaianKinerja/MasterBobot/view/'.$gb['id_bobot']);?>" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-eye"></span></a> -->
											<a href="<?php echo site_url('PenilaianKinerja/MasterBobot/edit/'.$gb['id_bobot']);?>" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-edit"></span></a>
											<a data-toggle="modal" data-target="<?php echo '#deletealert'.$gb['id_bobot'] ?>" class="btn btn-xs btn-danger" title="Batalkan penilaian"><i class="fa fa-remove"></i></a>
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
								<tfoot>
									<tr>
										<th colspan="2">Total Bobot Nilai</th>
										<th style="text-align: center; vertical-align: middle;"><?php echo $total; ?></th>
										<th colspan="2">&nbsp;</th>
									</tr>
								</tfoot>																		
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
			
				
