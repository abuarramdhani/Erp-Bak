<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b>Master Range Nilai</b></h1>
							</div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
	                            <a class="btn btn-default btn-lg" href="<?php echo site_url('PenilaianKinerja/MasterRangeNilai');?>">
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
								<b data-toogle="tooltip" title="Halaman untuk membuat Master Range Nilai.">Master Range Nilai</b>
							</div>
							<div class="box-body">
								<form method="post" action="<?php echo base_url('PenilaianKinerja/MasterRangeNilai/modification');?>" enctype="multipart/form-data">
									<div class="panel-body">
										<table class="table table-striped table-bordered table-hover" id="JurnalPenilaian-masterRangeNilai" style="font-size:12px;">
											<thead class="bg-primary">
												<tr>
													<th>Golongan Nilai</th>
													<th>Batas Bawah</th>
													<th>Batas Atas</th>
													<th>Kategori</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$indeks	=	0;
													foreach ($GetRange as $gr) 
													{
														$idRangeNilai 	=	str_replace(array('+','/','='), array('-','_','~'), $this->encryption->encrypt($gr['id_range_nilai']));

												?>
												<tr>
													<td style="text-align: center; vertical-align: middle;">
														<b><?php echo $gr['gol_nilai'];?></b>
														<input type="text" class="hidden" value="<?php echo $idRangeNilai;?>" name="idRangeNilai[<?php echo $indeks;?>]" />
													</td>
													<td>
														<input type="number" min="0" step="0.1" name="txtBatasBawah[<?php echo $indeks;?>]" value="<?php echo $gr['bts_bwh'];?>" />
													</td>
													<td>
														<input type="number" min="0" step="0.1" name="txtBatasAtas[<?php echo $indeks;?>]" value="<?php echo $gr['bts_ats'];?>" />
													</td>
													<td>
														<input type="text" name="txtKategori[<?php echo $indeks;?>]" style="text-transform: uppercase;" value="<?php echo $gr['kategori'];?>" />
													</td>
												</tr>
												<?php
														$indeks++;
													}
												?>
											</tbody>
										</table>	
									</div>
									<div class="panel-footer">
										<div class="row text-right">
											<button type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>		
			</div>		
		</div>
	</div>
</section>			
			
				
