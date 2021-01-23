<table id="tabel_search_tracking_lppb" class="table table-striped table-bordered table-hover text-center">
	<thead style="vertical-align: middle;"> 
		<tr class="bg-primary">
			<td class="text-center">No</td>
			<td class="text-center">Action</td>
			<td class="text-center">Gudang</td>
			<td class="text-center">IO</td>
			<td class="text-center">Nomor LPPB</td>
			<td class="text-center">Nama Vendor</td>
			<td class="text-center">Tanggal LPPB</td>
			<td class="text-center">Nomor PO</td>
			<td class="text-center">Batch Number</td>
			<td class="text-center">Gudang Input</td>
			<td class="text-center">Gudang Kirim</td>
			<td class="text-center">Akuntansi Terima</td>
			<td class="text-center">Status Detail</td>
		</tr>
	</thead>
	<tbody>
		<?php $no=1; if ($lppb) {
			foreach($lppb as $i) { ?>
		<tr>
			<td>
				<?php echo $no ?>
			</td> 
			<td>
				<a class="btn btn-primary" data-toggle="modal" data-target="mdlDetailTrackingLppb" onclick="ModalTrackingLppb(<?php echo $i['BATCH_DETAIL_ID']?>, <?php echo $i['SECTION_ID']?> )">
					Detail
				</a>
			</td>
			<td><?php echo $i['SECTION_NAME']?></td>
			<td><?php echo $i['ORGANIZATION_CODE']?></td>
			<td><?php echo $i['LPPB_NUMBER']?></td>
			<td><?php echo $i['VENDOR_NAME']?></td>
			<td><?php echo $i['CREATE_DATE']?></td>
			<td><?php echo $i['PO_NUMBER']?></td>
			<td><?php echo $i['BATCH_NUMBER']?></td>
			<td><?php echo $i['CREATE_DATE']?></td>
			<td><?php echo $i['GUDANG_KIRIM']?></td>
			<td><?php echo $i['AKUNTANSI_TERIMA']?></td>
			<?php if ($i['STATUS'] == 0) {
				$status = "New/Draf";
			}elseif ($i['STATUS'] == 1) {
				$status = "Admin Edit";
			}elseif ($i['STATUS'] == 2) {
				$status = "Submitted to Kasie Gudang";
			}elseif ($i['STATUS'] == 3) {
				$status = "Approved by Kasie Gudang";
			}elseif ($i['STATUS'] == 4) {
				$status = "Rejected by Kasie Gudang";
			}elseif ($i['STATUS'] == 5) {
				$status = "Submitted to Akuntansi";
			}elseif ($i['STATUS'] == 6) {
				$status = "Approved by Akuntansi";
			}elseif ($i['STATUS'] == 7) {
				$status = "Rejected by Akuntansi";
			} ?>
			<td><?php echo $status; ?></td>
		</tr>
		<?php $no++;}} ?>
	</tbody>
</table>

<script type="text/javascript">
	var id_gd;
</script>

<div class="modal fade mdlDetailTrackingLppb"  id="mdlDetailTrackingLppb" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width:1150px;" role="document">
        <div class="modal-content">
            <div class="modal-header" style="width: 100%;" >
                <!-- <h3 class="box-header with border" id="formModalLabel"><b>Detail Draft Lppb</b></h3> -->
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