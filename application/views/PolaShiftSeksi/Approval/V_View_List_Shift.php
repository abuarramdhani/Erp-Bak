<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
					<hr />
						<table class="table table-bordered tbl_ips_pr_shift text-center">
							<thead class="bg-primary">
								<tr>
									<td width="5%">No</td>
									<td>Seksi</td>
									<td>Periode</td>
									<td>Action</td>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1; foreach ($getShift as $key): ?>
									<tr>
										<td><?php echo $no; ?></td>
										<td><?php echo $key['seksi'] ?></td>
										<td><?php echo $key['periode'] ?></td>
										<td>
											<a href="<?php echo base_url('PolaShiftSeksi/Approval/detail_shift/'.$key['kodesie'].'/'.$key['periode'].'/'.str_replace(' ', '_', $key['tgl_import'])); ?>" title="Detail" class="btn btn-success">
												<i class="fa fa-file-text-o"></i>
											</a>
										</td>
									</tr>
								<?php $no++; endforeach ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>