<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>
<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Tarik Data Catering Pekerja</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('CateringManagement/List');?>">
                                <i class="icon-glass icon-2x"></i>
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
						<b>Distribusi Presensi Finger</b>
					</div>
					<div class="box-body">
					<br>
					<!-- DISTRIBUSI DATABASE POSTGRES PERSONALIA DARI 6.20 -->
						<table class="table table-striped table-bordered table-hover text-left" style="font-size:14px;" id='table-finger-per-lokasi'>
								<thead class="bg-primary">
									<tr>
										<th style="text-align:center;" width="5%">No</th>
										<th style="text-align:center;" width="7%">Id Lokasi</th>
										<th style="text-align:center;" width="20%">Lokasi Presensi</th>
										<th style="text-align:center;" width="10%">Jml Data Blm Masuk Catering</th>
										<th style="text-align:center;" width="10%">Lokasi Kerja</th>
										<th style="text-align:center;" width="10%">Eksekusi</th>
									</tr>
								</thead>
								<tbody>
									<?php $no=0;
										foreach($data_finger as $item_data_finger){ $no++; 
											echo "<tr>
													<td>".$no."</td>
													<td><span id='txtloc".$no."'>".$item_data_finger['id_lokasi']."</span></td>
													<td>".$item_data_finger['lokasi']."</td>
													<td><span id='txtnum".$no."'></span></td>
													<td>".$item_data_finger['lokasi_kerja_desc']."</td>
													<td><button class='btn btn-primary btn-sm' href='".site_url('PresenceManagement/Monitoring/TarikDataCatering/'.$id.'')."'>Tarik Data</button></td>
													</tr>";
										 } ?>
								</tbody>															
							</table>
						<div class="form-group">
							<div class="col-lg-12 text-right">
								<a href="<?php echo site_url('PresenceManagement/Monitoring');?>"  class="btn btn-success btn-lg btn-rect">Back</a>
							</div>
						</div>
					</div>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>			
