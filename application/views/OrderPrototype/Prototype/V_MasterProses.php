<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1>
									<b>
										<?= $Title ?>
									</b>
								</h1>
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('OrderPro/monorderpro');?>">
									<i class="fa fa-cog fa-2x">
									</i>
									<span>
										<br />
									</span>
								</a>
							</div>
						</div>
					</div>
				</div>
				<br />
				<!-- <form name="Orderform" action="<?php echo base_url('OrderPro/neworderpro/Insert'); ?>" class="form-horizontal" target="_blank" onsubmit="return validasi();window.location.reload();" method="post"> -->
				<div class="row">
					<div class="col-md-12">
						<div class="box box-info">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="col-md-4" style="text-align: right;"><label>Proses</label></div>
								<div class="col-md-4" style="text-align: left"><input type="text" id="nama_proses" class="form-control" name="nama_proses" placeholder="Nama Proses"></div>
								<br><br><br>
								<div class="col-md-12" style="text-align: center;"><button onclick="saveproses()" class="btn btn-success">Save</button></div>
								<br><br><br>
								<div class="col-md-12">
									<div id="hilanginaja">
										<table class="table table-bordered" id="master_proses" style="float: none;margin: 0 auto;width: 70%">
											<thead class="bg-yellow">
												<tr>
													<th class="text-center">No</th>
													<th class="text-center">Nama Proses</th>
													<th class="text-center">Action</th>
												
												</tr>
											</thead>
											<tbody>
												<?php $n=1; foreach ($proses as $pros) {?>
												<tr>
													<td class="text-center"><?=$n?></td>
													<td class="text-center"><input type="hidden" id="namapros<?=$n?>" value="<?=$pros['nama_proses']?>"><?=$pros['nama_proses']?></td>
													<td class="text-center"><button onclick="deleteproses(<?=$n?>)" class="btn btn-danger btn-xs">Delete</button></td>
												</tr>
												<?php $n++; } ?>
											</tbody>
										</table>
									</div>
									<div id="tabel_proses">
										<!-- tabel prosesnya disini -->
									</div>
							</div>
						
							</div>
						</div>
						<div class="row">
							
						</div>
					</div>
				</div>
			<!-- </form> -->
			</div>
		</section>