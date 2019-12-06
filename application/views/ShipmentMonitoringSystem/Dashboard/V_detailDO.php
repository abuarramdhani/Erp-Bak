<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="box-header box-primary">
					<div class="row">
						<div class="col-lg-12">
							<div class="text-left ">
								<span><b></i> Detail DO</b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary">
					  		<div id="tableHolder">
								<div class="box-body">
									<table id="tbpr" class="table table-striped table-bordered table-hover text-center">
									<thead>
										<tr class="bg-primary">
											<th class="text-center">No</th>
											<th class="text-center">Nomor DO</th>
										</tr>
									</thead>
									<tbody>
										<?php $no=1; foreach($no_do as $k) { ?>
										<tr>
											<td><?php echo $no ?> </td>
											<td><?php echo  $k['no_do'] ?></td>
										</tr>
										<?php $no++; } ?>
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
</div>
</section>