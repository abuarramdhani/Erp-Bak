<div class="row">
	<div class="col-lg-12">
		<div class="box box-primary box-solid">
			<div class="box-body">
				<table id="lppbgudangakt" class="table text-center">
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
					<tbody class="coba">
					<?php $no=1; if ($lppb) { foreach($lppb as $lb){ ?>
					<tr>
						<td><?php echo $no?></td>
						<td>
							<button title="Detail Lppb" href="<?php echo base_url('MonitoringLppbAkuntansi/Unprocess/detailLppbAkuntansi/'.$lb['BATCH_NUMBER'])?>" class="btn btn-default btn-sm"><i class="fa fa-file-text-o"></i> Detail</button>
						</td>
						<td class="coba"><?php echo $lb['GROUP_BATCH']?></td>
						<td><?php echo $lb['CREATE_DATE']?></td>
						<td><?php echo $lb['JUMLAH_LPPB']?></td>
						<td>
							<?php
							if ($lb['CHECKING_AKUNTANSI']>0) { ?>
								<span class="label label-default"><?php echo $lb['CHECKING_AKUNTANSI']." Checking Akuntansi &nbsp;"."<br>"?></span>
							<?php }
							if ($lb['AKUNTANSI_APPROVED']>0) { ?>
								<span class="label label-success"><?php echo $lb['AKUNTANSI_APPROVED']." Akuntansi Approve &nbsp;"."<br>"?></span>
							<?php }
							if ($lb['AKUNTANSI_REJECT']>0) { ?>
								<span class="label label-danger"><?php echo $lb['AKUNTANSI_REJECT']." Akuntansi Reject &nbsp;"."<br>"?></span>
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
<script type="text/javascript">
	var id_gd;
</script>