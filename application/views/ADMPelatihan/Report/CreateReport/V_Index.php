<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Create Report</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
							<a class="btn btn-default btn-lg" href="<?php echo site_url('ADMPelatihan/Report/CreateReport');?>">
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
						<a href="<?php echo site_url('ADMPelatihan/Report/createReport_fill') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
							<button type="button" class="btn btn-default btn-sm">
							  <i class="icon-plus icon-2x"></i>
							</button>
						</a>
						<b data-toogle="tooltip" title="Halaman membuat report">Create Report</b>
					</div>
					<div class="box-body">
						<div class="table-responsive" style="overflow:hidden;">
							<table class="table table-striped table-bordered table-hover text-left" id="master-index" style="font-size:14px; min-width: 1500px">
								<thead class="bg-primary">
									<tr>
										<th width="5%">NO</th>
										<th width="8%" style="text-align: center;">Action</th>
										<th width="10%">Tanggal Dibuat</th>
										<th width="30%">Nama Training/ Paket Training</th>
										<th width="10%">Tanggal Training</th>
										<th width="10%">Jenis Training</th>
										<th width="30%">Pelaksana</th>
									</tr>
								</thead>
								<tbody>
									<?php $no=1;
										foreach ($report as $rpt) {
									 ?>
									<tr>
										<td><?php echo $no++; ?></td>
										<td style="padding-left: 15px">
											<a style="margin-right:4px" href="<?php echo site_url('ADMPelatihan/Report/cetakPDF/'.$rpt['id_report']);?>" target="_blank" data-placement="bottom" title="Cetak Data" >
												<span class="fa fa-print fa-2x"></span>
											</a>
                                        	<a style="margin-right:4px" href="<?php echo site_url('ADMPelatihan/Report/editReport/'.$rpt['id_report']);?>" data-placement="bottom" title="Edit Data">
                                        		<span class="fa fa-pencil-square-o fa-2x"></span>
                                        	</a>
                                        	<a style="margin-right:4px" href="<?php echo site_url('ADMPelatihan/Report/deleteReport/'.$rpt['id_report']);?>" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');">
                                        		<span class="fa fa-trash fa-2x"></span>
                                        	</a>
										</td>
										<td>
											<?php 
												$date= $rpt['tgldoc']; 
												$newDate=date("d F Y", strtotime($date));
												echo $newDate;
											?>
										</td>
										<td>
											<?php 
												echo $rpt['scheduling_or_package_name'];
											?>
										</td>
										<td>
											<?php 
												echo $rpt['tanggal'];
											?>
										</td>
										<td>
											<?php 
												if ($rpt['jenis']==0) {echo "Softskill";} 
												if ($rpt['jenis']==1) {echo "Hardskill";} 
												if ($rpt['jenis']==2) {echo "Softskill & Hardskill";} 
											?>
										</td>
										<td>
											<?php 
												$strainer=explode(',', $rpt['pelaksana']);					
												foreach ($strainer as $st) {
													foreach ($trainer as $tr) {
														if ($st==$tr['trainer_id']) {
															echo $tr['trainer_name']."<br>";
														} 
													} 
												}?>
										</td>
									</tr>
									<?php }?>
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
			
				
