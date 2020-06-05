<div class="box-body">
<div style="overflow:auto;">
<table id="tabel_search_tracking_invoice" style="min-width: 110%"  class="table table-striped table-bordered table-hover text-center dataTable">
	<thead style="vertical-align: middle;"> 
		<tr class="bg-primary">
			<td class="text-center">No</td>
			<td class="text-center">Invoice ID</td>
			<td class="text-center">Action</td>
			<td class="text-center">Vendor name</td>
			<td class="text-center">Invoice Number</td>
			<td class="text-center">Invoice Date</td>
			<td class="text-center">Action Date</td>
			<td class="text-center">Action Status</td>
			<td class="text-center">Tax Invoice Number</td>
			<td class="text-center">Invoice Amount</td>
			<td class="text-center" title="Nomor PO - Line Num - LPPB Num - Status LPPB">PO Detail</td>
			<td class="text-center" title="Status Paid / Unpaid">Status</td>
			<td class="text-center" title="Status Paid / Unpaid">PIC</td>
			<td class="text-center">Jenis Dokumen</td>
		</tr>
	</thead>
	<tbody>
		<?php $no=1; if ($invoice) {
			// echo "<pre>";
			// print_r($status);
			// exit();
			foreach($invoice as $i) { ?>
		<tr>
			<td><?php echo $no?></td>
			<td><b><?php echo $i['INVOICE_ID']?></b></td>
			<td><a class="btn btn-success" data-target="MdlTrackInv" data-toggle="modal" onclick="mdlDetailTI(<?php echo $i['INVOICE_ID']?>)" invoice="<?php echo $i['INVOICE_ID']?>">
				 Detail
				</a>
			</td>
			<td><?php echo $i['VENDOR_NAME']?></td>
			<td><?php echo $i['INVOICE_NUMBER']?></td>
			<td><?php echo $i['INVOICE_DATE']?></td>
			<td><?php echo $i['ACTION_DATE']?></td>
			<td><?php echo $i['STATUS']?></td>
			<td><?php echo $i['TAX_INVOICE_NUMBER']?></td>
			<td><?php echo 'Rp. '. number_format(round($i['INVOICE_AMOUNT']),0,'.','.').',00-';
			?></td>
			<td>
			<?php 
				foreach ($status as $k){ ?>
					<?php echo  $k ."<br>" ?>
				<?php }
			 ?>
				
			</td>
			<td><?php echo $i['STATUS_PAYMENT']?></td>
			<td><?php echo $i['SOURCE']?></td>
			<td></td>
		</tr>
		<?php $no++;}} ?>
		<!-- <?php 
		// echo "<pre>";
		// print_r($invoice);
		// exit();
		?> -->
	</tbody>
</table>
</div>
</div>

<div class="modal fade MdlTrackInv"  id="MdlTrackInv" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width:1150px;" role="document">
        <div class="modal-content">
            <div class="modal-header" style="width: 100%;" >
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
                <div class="modal-body" style="width: 100%;">
                	<div class="modal-tabel" >
					</div>
                   
                    	<div class="modal-footer">
                    		<div class="col-md-2 pull-left">
                    		</div>
                    	</div>
                </div>
            </form>
        </div>
    </div>
</div>
