<style type="text/css">
	.zoom {
  transition: transform .2s;
}

.zoom:hover {
  -ms-transform: scale(1.3); /* IE 9 */
  -webkit-transform: scale(1.3); /* Safari 3-8 */
  transform: scale(1.3); 
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}
</style>
<div class="row">
	<div class="col-lg-12">
		<div class="box box-primary box-solid">
			<div class="box-body">
				<!-- <input type="hidden" id="hdnLppb" value="<?php echo $lppb[0]['BATCH_NUMBER'] ?>"> -->
				<table id="tabel_list_batch" class="table text-center dtTableMl">
					
					<thead>
						<tr class="bg-primary">
							<th width="5%" class="text-center">No</th>
							<th width="30%" class="text-center">Action</th>
							<th class="text-center">Batch LPPB Number</th>
							<th class="text-center">Create Date</th>
							<th class="text-center">Jumlah LPPB</th>
							<th class="text-center">Status Detail</th>
						</tr>
					</thead>
					<tbody id="tbodyCoba">
					<?php $no=1; if ($lppb) { foreach($lppb as $lb) { ?>
					<tr>
						<td><?php echo $no?></td>
						<td>
							<input name="batch_number" id="batch_number" value="<?php echo $lb['BATCH_NUMBER']?>" type="hidden">
						
							<button onclick="ModalDetailAdmin(<?php echo $lb['BATCH_NUMBER']?>)" data-toggle="modal" data-target="mdlDetailAdminGudang" title="Detail Lppb ..." class="btn btn-default btn-sm zoom"><i class="fa fa-file-text-o detailIcon"></i> Detail</button>

						<?php if($lb['NEW_DRAF'] > 0 and $lb['ADMIN_EDIT'] > 0 or $lb['NEW_DRAF'] > 0){ ?>
							
							<button title="Submit to Kasie Gudang" id="btnSubmitChecking" data-id="<?= $lb['BATCH_NUMBER'] ?>" data-batch="<?php echo $lb['GROUP_BATCH']?>" onclick="getBtch(this)" class="btn btn-primary btn-sm zoom"><i class="fa fa fa-paper-plane detailIcon"></i> Submit </button>

							<button title="Delete" onclick="del_batch_number($(this))" row_id="<?php echo $no?>" class="btn btn-danger btn-sm zoom"><i class="fa fa-trash detailIcon"></i> Delete </button>

							<input type="hidden" name="batch_number" class="batch_number_<?php echo $no?>" value="<?php echo $lb['BATCH_NUMBER']?>"></a>

							<?php }
							else{ ?>
								
								<button title="Submit to Kasie Gudang" id="btnSubmitChecking" data-id="<?= $lb['BATCH_NUMBER'] ?>" data-batch="<?php echo $lb['GROUP_BATCH']?>" onclick="getBtch(this)" class="btn btn-primary btn-sm zoom"><i class="fa fa fa-paper-plane detailIcon"></i> Submit </button>

								
								<button title="Delete" onclick="del_batch_number($(this))" row_id="<?php echo $no?>" class="btn btn-danger btn-sm zoom"><i class="fa fa-trash detailIcon"></i> Delete </button>

								<input type="hidden" name="batch_number" class="batch_number_<?php echo $no?>" value="<?php echo $lb['BATCH_NUMBER']?>"></a>
							<?php } ?>
						</td>
						<td class="coba"><?php echo $lb['GROUP_BATCH']?></td>
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
								<span class="label label-info"><?php echo $lb['CHECKING_AKUNTANSI']." Checking Akuntansi (submit ke Akuntansi) &nbsp;"."<br>"?></span>
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

<!-- Modal Baru -->
<div class="modal fade mdlDetailAdminGudang"  id="mdlDetailAdminGudang" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width:1150px;" role="document">
        <div class="modal-content">
            <div class="modal-header" style="width: 100%;" >
                <h3 class="box-header with border" id="formModalLabel"><b>Detail Draft Lppb</b></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
                <div class="modal-body" style="width: 100%;">
                	<div class="modal-tabel" >
                	<!-- <div class="text-left ">
							<span><b>Detail Batch </b></span>
							<input type="hidden" name="batch_number" value="<?php echo $result[0]['BATCH_NUMBER']?>">
						<input type="hidden" name="batch_detail_id" value="<?php echo $result[0]['BATCH_DETAIL_ID']?>">
						</div> -->
					</div>
                   
                    	<div class="modal-footer">
                    		<div class="col-md-2 pull-left">
                        	<!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                        <!-- 	<button type="submit" class="btn btn-primary" id="BtnSubmit" onclick="updateData(this)">Ubah Data</button> -->
                    		</div>
                    	</div>
                </div>
            </form>
        </div>
    </div>
</div>