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
							<span><b>List Data Batch LPPB</b></span>
						</div>
					</div>
					<div class="col-md-4" style="margin-bottom: 20px">
					  	<select id="id_gudang" name="id_gudang" onchange="getOptionKasieAkt($(this))" class="form-control select2 select2-hidden-accessible" style="width:100%;">
							<option value="" > Opsi Gudang </option>
							<?php foreach ($gudang as $gd) { ?>
							<option value="<?php echo $gd['SECTION_ID'] ?>" ><?php echo $gd['SECTION_NAME'] ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<br />
				<div id="unprocessakuntansi" class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<table id="tblLPPBUnproses" class="tblLPPBAkt table text-center">
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
											<button title="Detail Lppb" data-toggle="modal" data-target="mdlDetailAkt" onclick="ModalDetailAkt(<?php echo $lb['BATCH_NUMBER']?>)"  class="btn btn-default btn-sm"><i class="fa fa-file-text-o"></i> Detail</button>
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
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	var id_gd;
	$(document).ready(function(){
	$('#tblLPPBRejectList').DataTable({
		"paging": true,
		"info":     true,
		"language" : {
			"zeroRecords": " "             
		}
	})
})
</script>

<div class="modal fade mdlDetailAkt"  id="mdlDetailAkt" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width:1150px;" role="document">
        <div class="modal-content">
            <div class="modal-header" style="width: 100%;" >
                <h3 class="box-header with border" id="formModalLabel"><b>Detail Unproses Lppb</b></h3>
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
