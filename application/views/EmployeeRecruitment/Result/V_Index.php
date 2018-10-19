<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b> Correction Result</b></h1>
						
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php  echo site_url('EmployeeRecruitment/Result/index/');?>">
									<i class="icon-file icon-2x"></i>
									<span ><br /></span>
								</a>
								

							</div>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								Uploaded List
							</div>
							<div class="box-body">
								<div class="table-responsive">
									
									<table class="table table-striped table-bordered table-hover text-left" id="tblUser" style="font-size:12px;">
										<thead>
											<tr class="bg-primary">
												<th width=""><center>No</center></th>
												<th width=""><center>Batch Upload</center></th>
												<th width=""><center>Tanggal</center></th>
												<th width=""><center>Jenis Soal</center></th>
												<th width=""><center></center></th>
											</tr>
										</thead>
										<tbody>
										<?php $no=1; foreach ($result as $res) { ?>
										<tr>
											
											<td><center><?php echo $no++;?></center></td>
											<td><?php echo  str_pad($res['batch_upload'],4,0 ,STR_PAD_LEFT)  ?></td>
											<td><?php echo date('d-M-Y', strtotime($res['tgl_upload']) ) ?></td>
											<td><?php echo $res['jenis_soal'] ?></td>
											<td><center>
												<form method="post" action="<?php echo  base_url('EmployeeRecruitment/Upload/export') ?>">
													<input type="hidden" name="batchnum" value="<?php echo $res['batch_upload']; ?>">
	                                                <input type="hidden" name="jenis" value="<?php echo $res['jenis_soal']; ?>">
														<button type="submit" class="btn btn-xs btn-success"> Export</button>
												</form>
												</center>
											</td>
										</tr>
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