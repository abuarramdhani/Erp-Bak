<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>
<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>INPUT DATA CASTING</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('CastingCost/InputCasting');?>">
                                <i class="icon-dollar icon-2x"></i>
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
						Request List
					</div>
					<div class="box-body">
					<h4>Request Baru</h4>
					<table id="table_casting" class="table panel table-bordered table-responsive  " width="60%">
						<thead  class="bg-blue">
							<tr>
								<td> No.</td>
								<td> Pemesan</td>
								<td> User Input </td>
								<td> Tanggal Input </td>
								<td> Status </td>
								<td> Action  </td>
							</tr>
						</thead>
						<tbody>
							<?php $no = 1 ;foreach ($request as $req) {?>
							 <tr>
								<td> <?php echo $no; ?></td>
								<td> <?php echo $req['orderer'] ;?></td>
								<td> <?php echo $req['user_submitter'];?></td>
								<td> <?php echo $req['date_submition'];?></td>

								<?php $status='<span class="badge bg-red faa-flash faa-slow animated">Unconfirmed</span>';
										if ($req['sign_confirmation'] == '1') {
											 $status='<span class="badge bg-green ">Confirmed</span>';
										}

								?>

								<td><?php echo $status ?></td>
								<td> <a href="<?php echo base_url('CastingCost/EditRequest/'.$req['id']) ?>"><button class="btn btn-xs btn-success"> Edit</button></a></td>
							 </tr>
							<?php $no++; } ?>


						</tbody>
					</table>

					<h4>Telah Dikonfirmasi</h4>
					<table id="table_casting2" class="table panel table-bordered table-responsive  " style="width: 80%">
						<thead style="background-color: #54ca63">
							<tr>
								<td> No.</td>
								<td> Pemesan</td>
								<td> User Input </td>
								<td> Tanggal Input </td>
								<td> Status </td>
								<td> Tangal Konfirmasi </td>
							</tr>
						</thead>
						<tbody>
							<?php $no = 1 ;foreach ($request_done as $req_d) {?>
							 <tr>
								<td> <?php echo $no; ?></td>
								<td> <?php echo $req_d['orderer'] ;?></td>
								<td> <?php echo $req_d['user_submitter'];?></td>
								<td> <?php echo $req_d['date_submition'];?></td>

								<?php $status='<span class="badge bg-red faa-flash faa-slow animated">Unconfirmed</span>';
										if ($req_d['sign_confirmation'] == '1') {
											 $status='<span class="badge bg-green ">Confirmed</span>';
										}

								?>

								<td><?php echo $status ?></td>
								<td><?php  echo $req_d['date_confirmation']?></td>
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
</section>
  