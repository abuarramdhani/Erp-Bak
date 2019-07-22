<div class="row">
	<div class="col-lg-12">
		<div class="box box-primary box-solid">
			<div class="box-body">
				<table id="tabel_list_batch" class="table text-center">
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
							<a title="Detail Lppb" target="_blank" onclick = "bukaMdl(<?php echo $lb['BATCH_NUMBER']?>)" class="btn btn-default btn-xs" data-toggle="modal" data-target="mdlSubmitToKasieGudang"><i class="fa fa-file-text-o"></i></a>
							<?php if ($lb['KASIE_GUDANG_APPROVED'] >= 0 and $lb['KASIE_GUDANG_REJECT'] >= 0 AND $lb['CHECKING_KASIE_GUDANG'] >= 0 and $lb['CHECKING_AKUNTANSI'] >= 0) { ?>
							<a title="Submit to Kasie Akuntansi" id="btnSubmitCheckingToAkuntansi" onclick="submitToKasie(this)" data-id="<?php echo $lb['BATCH_NUMBER']?>" data-batch="<?php echo $lb['GROUP_BATCH']?>" class="btn btn-primary btn-xs"><i class="fa fa-paper-plane"></i></a>
							<?php } ?>
							<!-- <?php { ?>
								<a title="Submit to Kasie Akuntansi" id="btnSubmitCheckingToAkuntansi" onclick="submitToKasie(this)" data-id="<?php echo $lb['BATCH_NUMBER']?>" data-batch="<?php echo $lb['GROUP_BATCH']?>" class="btn btn-primary btn-xs"><i class="fa fa-paper-plane"></i></a>
							<?php } ?> -->
						</td>
						<td><?php echo $lb['GROUP_BATCH']?></td>
						<td><?php echo $lb['CREATE_DATE']?></td>
						<td><?php echo $lb['JUMLAH_LPPB']?></td>
						<td>
							<?php 
							if ($lb['CHECKING_KASIE_GUDANG']>0) { ?>
								<span class="label label-default"><?php echo $lb['CHECKING_KASIE_GUDANG']." Checking Kasie Gudang &nbsp;"."<br>"?></span>
							<?php }
							if ($lb['KASIE_GUDANG_APPROVED']>0) { ?>
								<span class="label label-primary"><?php echo $lb['KASIE_GUDANG_APPROVED']." Kasie Gudang Approve &nbsp;"."<br>"?></span>
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
<div id="mdlSubmitToKasieAkuntansi" class="modal fade" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content"  id="content1" >
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		    <h5 class="modal-title">Submit For Checking Confirmation</h5>
		  </div>
		  <div class="modal-body">
		    <div class="row">
		      <div class="col-md-12">Apakah Anda yakin akan melakukan Submit ke Kasie Batch Number Akuntansi : <b id="group_batch"></b> ?</div>
		    </div>
		  </div>
		  <div class="modal-footer">
		    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
		    <button type="button" class="btn btn-primary" id="mdlYesAkt" >Yes</button>
		  </div>
		</div>
 	</div>
</div>
<script type="text/javascript">
	var id_gd;
</script>



<!-- Modal Baru -->
<div class="modal fade mdlSubmitToKasieGudang"  id="mdlSubmitToKasieGudang" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="width: 100%;" >
                <h3 class="box-header with border" id="formModalLabel"><b> Unproses Lppb</b></h3>
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
