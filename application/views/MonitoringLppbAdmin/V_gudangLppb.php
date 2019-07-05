<div class="row">
	<div class="col-lg-12">
		<div class="box box-primary box-solid">
			<div class="box-body">
				<table id="tabel_list_batch" class="table text-center dtTableMl">
					
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
					<?php $no=1; if ($lppb) { foreach($lppb as $lb) { ?>
					<tr>
						<td><?php echo $no?></td>
						<td>
							<input name="batch_number" id="batch_number" value="<?php echo $lb['BATCH_NUMBER']?>" type="hidden">
							<a target="_blank" href="ListBatch/detailLppb/<?php echo $lb['BATCH_NUMBER']?>" title="Detail Lppb ..." class="btn btn-default btn-xs" ><i class="fa fa-file-text-o"></i></a>

						<?php if($lb['NEW_DRAF'] > 0 and $lb['ADMIN_EDIT'] > 0 or $lb['NEW_DRAF'] > 0){ ?>
							<a title="Submit to Kasie Gudang" id="btnSubmitChecking" data-id="<?= $lb['BATCH_NUMBER'] ?>" data-batch="<?php echo $lb['GROUP_BATCH']?>" onclick="getBtch(this)" class="btn btn-primary btn-xs"><i class="fa fa-paper-plane"></i>
							</a>
							<a title="Delete" onclick="del_batch_number($(this))" row_id="<?php echo $no?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>
									<input type="hidden" name="batch_number" class="batch_number_<?php echo $no?>" value="<?php echo $lb['BATCH_NUMBER']?>"></a>
							<?php }
							else{ ?>
								<a title="Submit to Kasie Gudang" id="btnSubmitChecking" data-id="<?= $lb['BATCH_NUMBER'] ?>" data-batch="<?php echo $lb['GROUP_BATCH']?>" onclick="getBtch(this)" class="btn btn-primary btn-xs"><i class="fa fa-paper-plane"></i></a>
								<a title="Delete" onclick="del_batch_number($(this))" row_id="<?php echo $no?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>
									<input type="hidden" name="batch_number" class="batch_number_<?php echo $no?>" value="<?php echo $lb['BATCH_NUMBER']?>"></a>
							<?php } ?>
						</td>
						<td><?php echo $lb['GROUP_BATCH']?></td>
						<td><?php echo $lb['CREATE_DATE']?></td>
						<td><?php echo $lb['JUMLAH_LPPB']?></td>
						<td>
							<?php 
							if ($lb['NEW_DRAF']>0) { ?>
								<span class="label label-default"><?php echo $lb['NEW_DRAF']." New/Draf &nbsp;"."<br>"?></span>
							<?php }
							if ($lb['ADMIN_EDIT']>0) { ?>
								<span class="label label-warning"><?php echo $lb['ADMIN_EDIT']." Admin Edit &nbsp;"."<br>"?></span>
							<?php }
							if ($lb['CHECKING_KASIE_GUDANG']>0) { ?>
								<span class="label label-info"><?php echo $lb['CHECKING_KASIE_GUDANG']." Checking Kasie Gudang(Submit ke Kasie Gudang) &nbsp;"."<br>"?></span>
							<?php }
							if ($lb['KASIE_GUDANG_APPROVED']>0) { ?>
								<span class="label label-primary"><?php echo $lb['KASIE_GUDANG_APPROVED']." Kasie Gudang Approve &nbsp;"."<br>"?></span>
							<?php }
							if ($lb['KASIE_GUDANG_REJECT']>0) { ?>
								<span class="label label-danger"><?php echo $lb['KASIE_GUDANG_REJECT']." Kasie Gudang Reject &nbsp;"."<br>"?></span>
							<?php }
							if ($lb['CHECKING_AKUNTANSI']>0) { ?>
								<span class="label label-info"><?php echo $lb['CHECKING_AKUNTANSI']." Checking Akuntansi (Sumbit ke Akuntansi) &nbsp;"."<br>"?></span>
							<?php }
							if ($lb['AKUNTANSI_APPROVED']>0) { ?>
								<span class="label label-success"><?php echo $lb['AKUNTANSI_APPROVED']." Akuntansi Approve"."<br>"?></span>
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

<!-- Modal Submit For Checking -->
<div id="mdlSubmitToKasieGudang" class="modal fade" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content"  id="content1" >
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		    <h5 class="modal-title">Submit For Checking Confirmation</h5>
		  </div>
		  <div class="modal-body">
		    <div class="row">
		      <div class="col-md-12">Apakah Anda yakin akan melakukan Submit untuk pengecekan Kasie Batch Number : <b id="group_batch"></b> ?
		      </div>
		    </div>
		  </div>
		  <div class="modal-footer">
		    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
		    <button type="button" class="btn btn-primary" data-toggle="modal" id="btnYes">Yes</button>
		  </div>
		</div>
 	</div>
</div>

<!-- Modal Submit For Checking -->
<div id="mdlChecking" class="modal fade" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content"  id="content1" >
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		    <h5 class="modal-title">Submit For Checking Confirmation</h5>
		  </div>
		  <div class="modal-body">
		    <div class="row">
		      <div class="col-md-12">Batch Number : <b id="group_batch2"></b> telah diajukan untuk pengecekan. <br>
		      	Silahkan kirimkan berkas hardcopy ke Kasie terkait.
		      </div>
		    </div>
		  </div>
		  <div class="modal-footer">
		    <button type="submit" class="btn btn-default" data-dismiss="modal" id="btnClose" >Close</button>
		  </div>
		</div>
 	</div>
</div>
<script type="text/javascript">
	var id_gd;
</script>