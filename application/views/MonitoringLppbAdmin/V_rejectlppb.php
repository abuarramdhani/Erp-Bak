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
							<span><b>Reject LPPB</b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<table class="table text-center dtTableYa">
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
											<button title="Detail Lppb ..." onclick="ModalRejectAdmin(<?php echo $lb['BATCH_NUMBER']?>)" data-toggle="modal" data-target="mdlRejectAdminGudang" class="btn btn-default btn-sm"><i class="fa fa-file-text-o"></i> Detail</button>
										</td>
										<td><?php echo $lb['GROUP_BATCH']?></td>
										<td><?php echo $lb['CREATE_DATE']?></td>
										<td><?php echo $lb['JUMLAH_LPPB']?></td>
										<td>
											<?php 
											if ($lb['KASIE_GUDANG_REJECT']>0) { ?>
												<span class="label label-danger"><?php echo $lb['KASIE_GUDANG_REJECT']." Kasie Gudang Reject &nbsp;"."<br>"?></span>
											<?php }
											if ($lb['AKUNTANSI_REJECT']>0) { ?>
												<span class="label label-danger"><?php echo $lb['AKUNTANSI_REJECT']."  Akuntansi Reject &nbsp;"."<br>"?></span>
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
<script type="text/javascript">
	var id_gd;
	$(document).ready(function(){
	$('.dtTableYa').DataTable({
		"paging": true,
		"info":     false,
		"language" : {
			"zeroRecords": " "             
		}
	})

	})
</script>

<!-- Modal Baru -->
<div class="modal fade mdlRejectAdminGudang"  id="mdlRejectAdminGudang" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="width: 100%;" >
                <h3 class="box-header with border" id="formModalLabel"><b>Detail LPPB Rejected </b></h3>
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
