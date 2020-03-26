<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Master TIM</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('PenilaianKinerja/MasterTIM');?>">
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
						<a href="<?php echo site_url('PenilaianKinerja/MasterTIM/create') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
							<button type="button" class="btn btn-default btn-sm">
							  <i class="icon-plus icon-2x"></i>
							</button>
						</a>
						<b data-toogle="tooltip" title="Halaman untuk membuat Master TIM.">Master TIM</b>
					</div>
					<div class="box-body">

						<divstyle="overflow:hidden;">
							<table class="table table-striped table-bordered table-hover text-left" id="JurnalPenilaian-masterTIM" style="width:100%;">
								<thead class="bg-primary">
									<tr>
										<th width="5%" class="text-center">NO</th>
										<th width="15%" class="text-center">Batas Atas</th>
										<th width="15%" class="text-center">Batas Bawah</th>
										<th width="20%" class="text-center">Nilai</th>
										<th width="10%" class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>
								<?php foreach ($GetTIM as $gt) {?>
									<tr>
										<td align="center"><?php echo $number++ ?></td>
										<td align="center"><?php echo $gt['bts_ats']; ?></td>
										<input type="text" name="txtIdTIM" value="<?php echo $gt['id_tim_dtl']; ?>" hidden>
										<td align="center"><?php echo $gt['bts_bwh']; ?></td>
										<td align="center"><?php echo $gt['nilai']; ?></td>
										<td align="center">
											<a href="<?php echo site_url('PenilaianKinerja/MasterTIM/edit/'.$gt['id_tim_dtl']);?>" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-edit"></span></a>
											<a data-toggle="modal" data-target="<?php echo '#deletealert'.$gt['id_tim_dtl'] ?>" class="btn btn-xs btn-danger" title="Batalkan penilaian"><i class="fa fa-remove"></i></a>
										</td>
									</tr>
									<div class="modal fade modal-danger" id="<?php echo 'deletealert'.$gt['id_tim_dtl'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<div class="col-sm-2"></div>
													<div class="col-sm-8" align="center"><h5><b>PERHATIAN !</b></h5></div>
													<div class="col-sm-2"><h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></h5></div>
													</br>
												</div>
												<div class="modal-body" align="center">
													Apakah anda yakin ingin menghapus master TIM ini ? <br>
													<small>*) Data yang sudah dihapus tidak dapat dikembalikan lagi.</small>
													<div class="row">
														<br>
														<a href="<?php echo base_url('PenilaianKinerja/MasterTIM/delete/'.$gt['id_tim_dtl']);?>" class="btn btn-default"><i class="fa fa-remove"></i> DELETE</a>
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
			
				
