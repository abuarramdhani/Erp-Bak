<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b> Detele Uploaded Data</b></h1>
						
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php  echo site_url('EmployeeRecruitment/Delete/index/');?>">
									<i class="icon-trash icon-2x"></i>
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
								<form method="post" action="<?php echo base_url('EmployeeRecruitment/Delete/delete') ?>">  
									<button onclick="confirm('Apakah anda yakin?')" type="submit" class="btn btn-md btn-danger pull-right"><b class="fa fa-trash"></b> DELETE</button>
									<button onclick="slcAllERC(this)" type="button" class="btn btn-md btn-primary pull-right"><b class="fa fa-check"></b> SELECT ALL</button>
									<table class="table table-striped table-bordered table-hover text-left tabledelERC" id="" style="font-size:12px;" width="100%">
										<thead>
											<tr class="bg-primary">
												<th width=""><center>No</center></th>
												<th width=""><center>Batch Upload</center></th>
												<th width=""><center>Tanggal</center></th>
												<th width=""><center>Jenis Soal</center></th>
												<th width=""><center>Delete</center></th>
											</tr>
										</thead>
										<tbody>
										<?php $no=1; if ($result): foreach ($result as $res) { ?>
										<tr>
											
											<td><center><?php echo $no++;?></center></td>
											<td><?php echo  str_pad($res['batch_upload'],4,0 ,STR_PAD_LEFT)  ?></td>
											<td><?php echo date('d-M-Y', strtotime($res['tgl_upload']) ) ?></td>
											<td><?php echo $res['jenis_soal'] ?></td>
											<td><center>
												<input type="checkbox" name="id[]" value="<?php echo $res['batch_upload'] ?>">
												</center>
											</td>
										</tr>
										<?php } endif; ?>
										</tbody>
									</table>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
	</div>
</section>