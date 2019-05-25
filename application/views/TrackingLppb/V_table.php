<table id="tabel_search_tracking_lppb" class="table table-striped table-bordered table-hover text-center">
	<thead style="vertical-align: middle;"> 
		<tr class="bg-primary">
			<td class="text-center">No</td>
			<td class="text-center">Action</td>
			<td class="text-center">IO</td>
			<td class="text-center">Nomor LPPB</td>
			<td class="text-center">Nama Vendor</td>
			<td class="text-center">Tanggal LPPB</td>
			<td class="text-center">Nomor PO</td>
			<td class="text-center">Gudang</td>
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
				<a class="btn btn-primary btn-xs" href="<?php echo base_url('TrackingLppb/Tracking/detail/'.$i['BATCH_DETAIL_ID'])?>">
					Detail
				</a>
			</td>
			<td><?php echo $i['ORGANIZATION_CODE']?></td>
			<td><?php echo $i['LPPB_NUMBER']?></td>
			<td><?php echo $i['VENDOR_NAME']?></td>
			<td><?php echo $i['CREATE_DATE']?></td>
			<td><?php echo $i['PO_NUMBER']?></td>
			<td><?php echo $i['SOURCE']?></td>
			<td><?php echo $i['CREATE_DATE']?></td>
			<td><?php echo $i['GUDANG_KIRIM']?></td>
			<td><?php echo $i['AKUNTANSI_TERIMA']?></td>
			<?php if ($i['STATUS'] == 0) {
				$status = "New/Draf";
			}elseif ($i['STATUS'] == 1) {
				$status = "Admin Edit";
			}elseif ($i['STATUS'] == 2) {
				$status = "Submit by Kasie Gudang";
			}elseif ($i['STATUS'] == 3) {
				$status = "Kasie Gudang Approve";
			}elseif ($i['STATUS'] == 4) {
				$status = "Kasie Gudang Reject";
			}elseif ($i['STATUS'] == 5) {
				$status = "Submit by Akuntansi";
			}elseif ($i['STATUS'] == 6) {
				$status = "Akuntansi Approve";
			}elseif ($i['STATUS'] == 7) {
				$status = "Akuntansi Reject";
			} ?>
			<td><?php echo $status; ?></td>
		</tr>
		<?php $no++;}} ?>
	</tbody>
</table>

<script type="text/javascript">
	var id_gd;
</script>