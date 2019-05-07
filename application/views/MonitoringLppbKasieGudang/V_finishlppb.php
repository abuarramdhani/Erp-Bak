<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}

</style>
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span><b>Finish Batch LPPB</b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<table class="table text-center dtTableMl">
									<thead>
										<tr class="bg-primary">
											<th width="5%" class="text-center">No</th>
											<th width="10%" class="text-center">Action</th>
											<th class="text-center">Batch LPPB Number</th>
											<th class="text-center">Create Date</th>
											<th class="text-center">Jumlah LPPB</th>
											<th class="text-center">Status Detail</th>
										</tr>
									</thead>
									<tbody>
									<?php $no=1; if ($lppb) { foreach($lppb as $lb){ ?>
									<tr>
										<td><?php echo $no?></td>
										<td>
											<a title="Detail Lppb" href="<?php echo base_url('MonitoringLppbKasieGudang/Finish/detailFinishKasie/'.$lb['BATCH_NUMBER'])?>" class="btn btn-default btn-xs"><i class="fa fa-file-text-o"></i></a>
										</td>
										<td><?php echo $lb['GROUP_BATCH']?></td>
										<td><?php echo $lb['CREATE_DATE']?></td>
										<td><?php echo $lb['JUMLAH_LPPB']?></td>
										<td>
											<?php 
											if ($lb['KASIE_GUDANG_APPROVED']>0) { ?>
												<span class="label label-primary"><?php echo $lb['KASIE_GUDANG_APPROVED']." Kasie Gudang Approve &nbsp;"."<br>"?></span>
											<?php }
											if ($lb['CHECKING_AKUNTANSI']>0) { ?>
												<span class="label label-default"><?php echo $lb['CHECKING_AKUNTANSI']." Checking Akuntansi &nbsp;"."<br>"?></span>
											<?php }
											if ($lb['AKUNTANSI_APPROVED']>0) { ?>
												<span class="label label-success"><?php echo $lb['AKUNTANSI_APPROVED']." Akuntansi Approve &nbsp;"."<br>"?></span>
											<?php }
											?>
										</td>
									</tr>
									<?php $no++; }}?>
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
<script type="text/javascript">
	var id_gd;
</script>
