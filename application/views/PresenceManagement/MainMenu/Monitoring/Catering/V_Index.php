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
						<table class="table table-striped table-bordered table-hover text-left" style="font-size:14px;">
								<thead class="bg-primary">
									<tr>
										<th style="text-align:center;" width="5%">No</th>
										<th style="text-align:center;" width="7%">Lokasi</th>
										<th style="text-align:center;" width="20%">Keterangan</th>
										<th style="text-align:center;" width="10%">Act</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="text-center" width="10%;">1</td>
										<td width="30%;">List Presensi Finger Pusat</td>
										<td width="50%;">Data Semua Mesin Finger yang ada di Area <strong>Pusat</strong></td>
										<td class="text-center" width="10%;"><a href="<?php echo site_url('PresenceManagement/Monitoring/ListPresensi/01') ?>"><i class="icon-signout"></i></a></td>
									</tr>
									<tr>
										<td class="text-center" width="10%;">2</td>
										<td>List Presensi Finger Tuksono</td>
										<td>Data Semua Mesin Finger yang ada di Area <strong>Tuksono</strong></td>
										<td class="text-center" width="10%;"><a href="<?php echo site_url('PresenceManagement/Monitoring/ListPresensi/02') ?>"><i class="icon-signout"></i></a></td>
									</tr>
									<tr>
										<td class="text-center" width="10%;">3</td>
										<td>List Presensi Finger Mlati</td>
										<td>Data Semua Mesin Finger yang ada di Area <strong>Mlati</strong></td>
										<td class="text-center" width="10%;"><a href="<?php echo site_url('PresenceManagement/Monitoring/ListPresensi/03') ?>"><i class="icon-signout"></i></a></td>
									</tr>
									<tr>
										<td class="text-center" width="10%;">4</td>
										<td>List Presensi Barcode Satpam</td>
										<td>Data Semua Mesin Finger yang ada di <strong>Barcode Satpam</strong></td>
										<td class="text-center" width="10%;"><a href="<?php echo site_url('PresenceManagement/Monitoring/ListPresensi/04') ?>"><i class="icon-signout"></i></a></td>
									</tr>
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
