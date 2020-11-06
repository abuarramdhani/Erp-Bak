<link rel="stylesheet" href="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/dataTables/buttons.dataTables.min.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/dataTables/extensions/FixedColumns/css/dataTables.fixedColumns.min.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css');?>" />
    <script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.min.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
	<script type="text/javascript">
		$('.ch_komp_imo1').on('click',function(){
			var a = 0;
			var jml = 0;
			var val = '';
			$('input[name="ch_komp[]"]').each(function(){``
				if ($(this).is(":checked") === true ) {
					a = 1;
					jml +=1;
					val += $(this).val();
				}
			});
			if (a == 0) {
				$('#btnSelectedIMO').attr("disabled","disabled");
				$('#jmlSlcIMO').text('');
				$('#jmlSlcIMO2').text('');
				$('#btnSelectedIMO2').attr("disabled","disabled");
			}else{
				$('#btnSelectedIMO').removeAttr("disabled");
				$('#jmlSlcIMO').text('('+jml+')');
				$('#jmlSlcIMO2').text('('+jml+')');
				$('input[name="selectedPicklistIMO"]').val(val);
				$('#btnSelectedIMO2').removeAttr("disabled");  
				
			}

		});
		$('.checkedAllIMO1').on('click', function(){
			var check = 0;
			var a = 0;
			var jml = 0;
			var val = '';
			if ($(this).is(":checked")) {
				check = 1;
			}else{
				check = 0;
			}
			$('input[name="ch_komp[]"]').each(function(){
				if (check == 1) {
					$(this).prop('checked', true);
				}else{
					$(this).prop('checked', false);
				}
			});

			$('input[name="ch_komp[]"]').each(function(){
				if ($(this).is(":checked") === true ) {
					a = 1;
					jml +=1;
					val += $(this).val();
				}
			});
			if (a == 0) {
				$('#btnSelectedIMO').attr("disabled","disabled");
				$('#btnSelectedIMO2').attr("disabled","disabled");
				$('#jmlSlcIMO').text('');
				$('#jmlSlcIMO2').text('');
			}else{
				$('#btnSelectedIMO').removeAttr("disabled");
				$('#btnSelectedIMO2').removeAttr("disabled");
				$('#jmlSlcIMO').text('('+jml+')');
				$('#jmlSlcIMO2').text('('+jml+')');
				$('input[name="selectedPicklistIMO"]').val(val);
			}
		});

	</script>
	
 <style type="text/css">
 	.text-bold-cuk{
 		font-weight: bold;
 	}

 	table td{
 		border: 1px solid black;
 	}

 	table th{
 		text-align: center;
 		vertical-align: middle !important;
 	}

 	.hdr {
 		text-align: center;
 		vertical-align: middle;
 	}
 	
 </style>
<table class="table tblResultIMO table-stripe table-bordered table-hover " width="100%">
	<thead>
		<tr class="bg-primary ">
			<th width="5%"> &nbsp;
				<input type="checkbox" class="checkedAllIMO1">&nbsp;
			</th>
			<th width="10%">WIP NAME</th>
			<th width="13%">KODE ITEM</th>
			<th width="14%">NAMA ITEM </th>
			<th width="5%">QTY</th>
			<th width="5%">QTY SUDAH PICKLIST</th>
			<th width="10%">DEPT CLASS</th>
			<th width="20%">DESCRIPTION</th>
			<th width="15%">KETERANGAN</th>
			<th width="8%"></th>
		</tr>
	</thead>
	<tbody>
		<?php  
			if ($requirement):

			$allInvID = array();
			$allQty = array();
			$allUom = array();
			$allJobID = array();
			$allSubInvTo = array();
			$allSubFrom = array();
			$allLocatorTo = array();
			$allLocatorFrom = array();
			$allLocatorFromId = array();
			$allStartQTY = array();
			$allQTYSudah = array();
			$no = 1; 
			foreach ($requirement as $key => $value) {                                                                                                                                                                                                                                   
			$arrErr = array();
			foreach ($value['body'] as $k => $v) {
				if($v['REQUIRED_QUANTITY'] > $v['ATR'] || $v['REQUIRED_QUANTITY'] > $v['KURANG'] ) { array_push($arrErr, $v['REQUIRED_QUANTITY']); }
			}

			if ($value['header']['DEPT_CLASS'] == 'SUBKT') {
				$divisi = 1;
			} else {
				$divisi = 0;
			}


			if($value['header']['KET'] == 0 || $value['header']['KET'] == 2){
				if(count($arrErr) > 0){
					$penanda = 'bg-danger';
					$penandabutton = 1; //-----------------> harusnya 1
					$text_button = '<b>Create Picklist</b>';
				}else{
					$penanda = $value['header']['KET'] == 0 ? '' : 'bg-warning';
					$penandabutton = 0;
					$text_button = '<b>Create Picklist</b>';
					$text_button2 = '<b>Create PL Header</b>';
				}
			}else{
				$penanda = 'bg-success';
				$penandabutton = 0; //-----------------> harusnya 1
				$text_button = '<b>Print Picklist</b>';
				$text_button2 = '<b>Print PL Header</b>';
			}


		?>
		<tr class="hdr" id="baris<?= $no?>">
			<td rowspan="2"   class="<?= $penanda ?>" style="vertical-align: top;" >
				<center>
				<?php if ($penandabutton == 1) { ?>
					<b style="color: #c1c1c1"> <?= $no++; ?></b> <br>
						<input type="checkbox"  class="ch_komp_imo1" onclick="return false;"
							value="<?= $value['header']['WIP_ENTITY_NAME'].'+'; ?>">
				<?php } else { ?>
						<b <?= ($value['body']) ? '' : 'style="color: #c1c1c1"' ?>><?= $no++; ?></b> <br>
						<input type="checkbox"  class="ch_komp_imo1" <?= ($value['body']) ? ' name="ch_komp[]"' : 'onclick="return false;"' ?>
							value="<?= $value['header']['WIP_ENTITY_NAME'].'+'; ?>">
				<?php } ?>
				</center>
			</td>
			<td class="<?= $penanda ?>" ><b><?= $value['header']['WIP_ENTITY_NAME']; ?></b></td>
			<td class="<?= $penanda ?>" ><?= $value['header']['ITEM_CODE'] ?></td>
			<td class="<?= $penanda ?>" ><?= $value['header']['ITEM_DESC'] ?></td>
			<td class="<?= $penanda ?>" ><?= $value['header']['START_QUANTITY'] ?></td>
			<td class="<?= $penanda ?>" id="sdh_att4"><?= $value['header']['ATTRIBUTE4'] ?></td>
			<td class="<?= $penanda ?>" ><?= $value['header']['DEPT_CLASS'] ?></td>
			<td class="<?= $penanda ?>" ><?= $value['header']['DESCRIPTION'] ?></td>
			<td class="<?= $penanda ?>" ><?= ($value['header']['KET'] == 1) ? '<b>Sudah Dibuat Picklist</b>' : 
																				($value['header']['KET'] == 2 ?  '<b>Sudah Dibuat Picklist Sebagian</b>' : 'Belum Dibuat Picklist') ?>
					<input type="hidden" id="nojob_header<?= $no?>" value="<?= $value['header']['WIP_ENTITY_NAME']; ?>">
					<input type="hidden" id="qty_header<?= $no?>" value="<?= $value['header']['START_QUANTITY'] ?>">
					<input type="hidden" id="qty_sudah_header<?= $no?>" value="<?= $value['header']['ATTRIBUTE4']?>">
			</td>
<!-- YANG INI BENAR -->
			<!--td class="<?= $penanda ?>">
				<?php if ($penandabutton == 1) { ?>
				<button class="btn btn-sm  disabled btn-default " target="_blank" >
						 <?= $text_button; ?> 
				</button>
				<?php } else { ?>
				<button class="btn btn-sm  <?= ($value['body']) ? 'btn-success' : 'disabled btn-default' ?>" target="_blank"
						 <?= ($value['body']) ? "onclick=document.getElementById('form".$value['header']['WIP_ENTITY_NAME']."').submit();" :'' ?>>
						 <?= $text_button; ?> 
				</button>
				<?php } ?>
			</td--> 
			<!-- BENARNYA SAMPAI DISINI -->

<!-- YANG INI EDITAN UNTUK TEST CETAK REPORT -->
			<td class="<?= $penanda ?>">
				<?php if ($penandabutton == 1) { ?>
				<button class="btn btn-sm  disabled btn-default " target="_blank">
						 <?= $text_button; ?> 
				</button><br><br>
				<button type="button" class="btn btn-success" style="font-size:12px;font-weight:bold" onclick="createsebagian(<?= $no?>)">Create Sebagian</button>
				<?php } else { ?>
					<?php if ($divisi == 1) { ?>
						<button data-toggle="modal" data-target="#formModal<?= $value['header']['WIP_ENTITY_NAME']; ?>" class="btn btn-sm  <?= ($value['body']) ? 'btn-success' : 'disabled btn-default' ?>" target="_blank">
								 <?= $text_button; ?> 
						</button>
					<?php } else { ?>
						<button class="btn btn-sm  <?= ($value['body']) ? 'btn-success' : 'disabled btn-default' ?>" target="_blank" 
								 <?= ($value['body']) ? "onclick=document.getElementById('form".$value['header']['WIP_ENTITY_NAME']."').submit();" :'' ?>>
								 <?= $text_button; ?> 
						</button><br><br>
						<button class="btn btn-sm  <?= ($value['body']) ? 'btn-success' : 'disabled btn-default' ?>" target="_blank" 
								 <?= ($value['body']) ? "onclick=document.getElementById('form2".$value['header']['WIP_ENTITY_NAME']."').submit();" :'' ?>>
								 <?= $text_button2; ?> 
						</button>
					<?php } ?>
				<?php } ?>
				<br><br><a href="http://produksi.quick.com/print-qr-sticker-packaging/khs_cetak_barcode_besar.php?org=102&segment1=<?= $value['header']['ITEM_CODE']?>" target="_blank">
						<button type="button" class="btn btn-success" style="font-size:12px;font-weight:bold">Print Sticker Besar</button>
				</a>
				<br><br><a href="http://produksi.quick.com/print-qr-sticker-packaging/khs_cetak_barcode.php?org=102&segment1=<?= $value['header']['ITEM_CODE']?>" target="_blank">
						<button type="button" class="btn btn-success" style="font-size:12px;font-weight:bold">Print Sticker Kecil</button>
				</a>


			</td> 
			<!-- EDITANNYA SAMPAI SINI -->

		</tr>
		<tr >
			<td colspan="9"  class="<?= $penanda ?>" ><span onclick="seeDetailIMO(this,'<?= $key ?>')" class="btn btn-xs btn-primary"> see detail >> </span>
				<div style="margin-top: 5px ; display: none; " id="detail<?= $key ?>" >
				<form method="post" target="_blank" id="form<?= $value['header']['WIP_ENTITY_NAME']; ?>" action="<?php echo base_url('InventoryManagement/CreateMoveOrder/create'); ?>">
				<table class="table table-sm table-bordered table-hover table-striped table-responsive"  style="border: 2px solid #ddd">
					<thead>
						<tr class="text-center">
							<th>NO.</th>
							<th>Kode Komponen</th>
							<th>Nama Komponen</th>
							<th>Gudang Asal</th>
							<th>Locator</th>
							<th>Unit</th>
							<th>Jumlah Dibutuhkan</th>
							<!-- EDIT LUTFI -->
							<th>ATT</th>
							<th>MO</th>
							<th>STOK</th>
							
						</tr>
					</thead>
					<tbody>
						<?php 
						$no2 = 1;
						if ($value['body']):
						foreach ($value['body'] as $kut => $vulue) { ?>
						<tr class="baris<?=$no2?>">
							<td><?= $no2++; ?>
								<input type="hidden" name="no_job" value="<?= $vulue['WIP_ENTITY_NAME'] ?>">
								<input type="hidden" name="invID[]" value="<?= $vulue['INVENTORY_ITEM_ID'] ?>">
								<input type="hidden" name="qty[]" value="<?= $vulue['REQUIRED_QUANTITY'] ?>">
								<input type="hidden" name="uom[]" value="<?= $vulue['PRIMARY_UOM_CODE'] ?>">
								<input type="hidden" name="job_id[]" value="<?= $vulue['JOB_ID'] ?>">
								<input type="hidden" name="subinvto[]" value="<?= $vulue['GUDANG_TUJUAN'] ?>">
								<input type="hidden" name="subinvfrom[]" value="<?= $vulue['GUDANG_ASAL'] ?>">
								<input type="hidden" name="locatorto[]" value="<?= $vulue['LOCATOR_TUJUAN_ID'] ?>">
								<input type="hidden" name="locatorfrom[]" value="<?= $vulue['LOCATOR_ASAL'] ?>">
								<input type="hidden" name="locatorfromid[]" value="<?= $vulue['LOCATOR_ASAL_ID'] ?>">
								<input type="hidden" name="departement" value="NONE">
								<input type="hidden" name="piklis" value="1">
								<input type="hidden" name="start_qty" value="<?= $value['header']['START_QUANTITY'] ?>">
								<input type="hidden" class="qty_sudahpick<?= $no?>" name="qty_sudah" value="<?= $value['header']['ATTRIBUTE4']?>">
								<input type="hidden" class="att_komponen<?= $no?>" name="att[]" value="<?= $vulue['ATR'] ?>">
							</td>
							<td><?= $vulue['KOMPONEN'] ?></td>
							<td><?= $vulue['KOMP_DESC'] ?></td>
							<td><?= $vulue['GUDANG_ASAL'] ?></td>
							<td><?= $vulue['LOCATOR_ASAL'] ?></td>
							<td><?= $vulue['PRIMARY_UOM_CODE'] ?></td>
							<td class="<?= ($vulue['REQUIRED_QUANTITY'] > $vulue['ATR']) ? "bg-danger " : "" ?>"><?= $vulue['REQUIRED_QUANTITY'] ?></td>
							<td class="<?= ($vulue['REQUIRED_QUANTITY'] > $vulue['ATR']) ? "text-danger text-bold-cuk" : "" ?>"><?= $vulue['ATR'] ?></td>
							<td ><?= $vulue['MO']?></td>
							<td class="<?= ($vulue['REQUIRED_QUANTITY'] > $vulue['KURANG']) ? "text-danger text-bold-cuk" : "" ?>"><?= $vulue['KURANG'] ?></td>
						</tr>
						<?php 
							$allNojob[$no][] =  $vulue['WIP_ENTITY_NAME'];
							$allAssy[$no][] =  $value['header']['ITEM_CODE'];
							$allInvID[$no][] =  $vulue['INVENTORY_ITEM_ID'];
							$allQty[$no][] =  $vulue['REQUIRED_QUANTITY'];
							$allUom[$no][] =  $vulue['PRIMARY_UOM_CODE'];
							$allJobID[$no][] =  $vulue['JOB_ID'];
							$allSubInvTo[$no][] =  $vulue['GUDANG_TUJUAN'];
							$allSubFrom[$no][] =  $vulue['GUDANG_ASAL'];
							$allLocatorTo[$no][] =  $vulue['LOCATOR_TUJUAN_ID'];
							$allLocatorFrom[$no][] =  $vulue['LOCATOR_ASAL'];
							$allLocatorFromId[$no][] =  $vulue['LOCATOR_ASAL_ID'];
							$allStartQTY[$no][] =  $value['header']['START_QUANTITY'];
							$allQTYSudah[$no][] =  $value['header']['ATTRIBUTE4'];
						?>
						<?php }
						else:?>
							<tr>
								<td colspan="10">
									Tidak ada komponen..
								</td>
							</tr>
						<?php endif;
						 ?>
					</tbody>
				</table>
			</form>
<!---- FORM KE 2 --------------------------------------------------->
			<form method="post" target="_blank" id="form2<?= $value['header']['WIP_ENTITY_NAME']; ?>" action="<?= base_url('InventoryManagement/CreateMoveOrder/create') ?>" >
						<?php 
						$no2 = 1;
						if ($value['body']):
						foreach ($value['body'] as $kut => $vulue) { ?>
						
							<?php $no2++; ?>
								<input type="hidden" name="no_job" value="<?= $vulue['WIP_ENTITY_NAME'] ?>">
								<input type="hidden" name="invID[]" value="<?= $vulue['INVENTORY_ITEM_ID'] ?>">
								<input type="hidden" name="qty[]" value="<?= $vulue['REQUIRED_QUANTITY'] ?>">
								<input type="hidden" name="uom[]" value="<?= $vulue['PRIMARY_UOM_CODE'] ?>">
								<input type="hidden" name="job_id[]" value="<?= $vulue['JOB_ID'] ?>">
								<input type="hidden" name="subinvto[]" value="<?= $vulue['GUDANG_TUJUAN'] ?>">
								<input type="hidden" name="subinvfrom[]" value="<?= $vulue['GUDANG_ASAL'] ?>">
								<input type="hidden" name="locatorto[]" value="<?= $vulue['LOCATOR_TUJUAN_ID'] ?>">
								<input type="hidden" name="locatorfrom[]" value="<?= $vulue['LOCATOR_ASAL_ID'] ?>">
								<input type="hidden" name="departement" value="NONE">
								<input type="hidden" name="piklis" value="2">
								<input type="hidden" name="start_qty" value="<?= $value['header']['START_QUANTITY'] ?>">
								<input type="hidden" class="qty_sudahpick<?= $no?>" name="qty_sudah" value="<?= $value['header']['ATTRIBUTE4']?>">
								<input type="hidden" class="att_komponen<?= $no?>" name="att[]" value="<?= $vulue['ATR'] ?>">
						<?php 
							$allNojob[$no][] =  $vulue['WIP_ENTITY_NAME'];
							$allAssy[$no][] =  $value['header']['ITEM_CODE'];
							$allInvID[$no][] =  $vulue['INVENTORY_ITEM_ID'];
							$allQty[$no][] =  $vulue['REQUIRED_QUANTITY'];
							$allUom[$no][] =  $vulue['PRIMARY_UOM_CODE'];
							$allJobID[$no][] =  $vulue['JOB_ID'];
							$allSubInvTo[$no][] =  $vulue['GUDANG_TUJUAN'];
							$allSubFrom[$no][] =  $vulue['GUDANG_ASAL'];
							$allLocatorTo[$no][] =  $vulue['LOCATOR_TUJUAN_ID'];
							$allLocatorFrom[$no][] =  $vulue['LOCATOR_ASAL'];
							$allLocatorFromId[$no][] =  $vulue['LOCATOR_ASAL_ID'];
							$allStartQTY[$no][] =  $value['header']['START_QUANTITY'];
							$allQTYSudah[$no][] =  $value['header']['ATTRIBUTE4'];
						?>
						<?php }
						else:?>
							<tr>
								<td colspan="10">
									Tidak ada komponen..
								</td>
							</tr>
						<?php endif;
						 ?>
			</form>
<!---- FORM KE 3 (PICKLIST SEBAGIAN)--------------------------------------------------->
			<form method="post" target="_blank" >
						<?php 
						$no3 = 1;
						if ($value['body']):
						foreach ($value['body'] as $kut => $vulue) { ?>
						
							<?php $no3++; ?>
								<input type="hidden" name="no_job" value="<?= $vulue['WIP_ENTITY_NAME'] ?>">
								<input type="hidden" name="invID[]" value="<?= $vulue['INVENTORY_ITEM_ID'] ?>">
								<input type="hidden" class="qty_komponen<?= $no?>" name="qty[]" value="<?= $vulue['REQUIRED_QUANTITY'] ?>">
								<input type="hidden" name="uom[]" value="<?= $vulue['PRIMARY_UOM_CODE'] ?>">
								<input type="hidden" name="job_id[]" value="<?= $vulue['JOB_ID'] ?>">
								<input type="hidden" name="subinvto[]" value="<?= $vulue['GUDANG_TUJUAN'] ?>">
								<input type="hidden" name="subinvfrom[]" value="<?= $vulue['GUDANG_ASAL'] ?>">
								<input type="hidden" name="locatorto[]" value="<?= $vulue['LOCATOR_TUJUAN_ID'] ?>">
								<input type="hidden" name="locatorfrom[]" value="<?= $vulue['LOCATOR_ASAL'] ?>">
								<input type="hidden" name="locatorfromid[]" value="<?= $vulue['LOCATOR_ASAL_ID'] ?>">
								<input type="hidden" name="departement" value="NONE">
								<input type="hidden" name="piklis" value="1">
								<input type="hidden" class="att_komponen<?= $no?>" name="att[]" value="<?= $vulue['ATR'] ?>">
								<input type="hidden" name="start_qty" value="<?= $value['header']['START_QUANTITY'] ?>">
								<input type="hidden" class="qtyreq<?= $no?>" name="qty_request">
								<input type="hidden" id="qtysudah<?= $no?>" name="qty_sudah" value="<?= $value['header']['ATTRIBUTE4']?>">
						<?php }
						else:?>
						<?php endif;
						 ?>
				<button type="submit" id="form3<?= $value['header']['WIP_ENTITY_NAME']; ?>"  formaction="<?= base_url('InventoryManagement/CreateMoveOrder/createSebagian') ?>" style="display:none" ></button>
				<button type="submit" id="form4<?= $value['header']['WIP_ENTITY_NAME']; ?>"  formaction="<?= base_url('InventoryManagement/CreateMoveOrder/printPicklist') ?>" style="display:none" ></button>
			</form>

				</div>
			</td>
		</tr>
		<?php } else: ?>
		<tr>
			<td colspan="9"> No Data Found .. :(  </td>
		</tr>
		<?php endif; ?>
	</tbody>
</table>
<div>
	<?php 
	if ($requirement) { ?>
	<form method="post" target="_blank" action="<?php echo base_url('InventoryManagement/CreateMoveOrder/createall'); ?>">
		<input type="hidden" name="selectedPicklistIMO" value="">
		<?php foreach ($allInvID as $key => $value) { ?>
		<input type="hidden" name="no_job[]" value="<?= implode('<>', $allNojob[$key]) ?>">
		<input type="hidden" name="invID[]" value="<?= implode('<>', $allInvID[$key]) ?>">
		<input type="hidden" name="qty[]" value="<?= implode('<>', $allQty[$key]) ?>">
		<input type="hidden" name="uom[]" value="<?= implode('<>', $allUom[$key]) ?>">
		<input type="hidden" name="job_id[]" value="<?= implode('<>', $allJobID[$key]) ?>">
		<input type="hidden" name="subinvto[]" value="<?= implode('<>', $allSubInvTo[$key]) ?>">
		<input type="hidden" name="subinvfrom[]" value="<?= implode('<>', $allSubFrom[$key]) ?>">
		<input type="hidden" name="locatorto[]" value="<?= implode('<>', $allLocatorTo[$key]) ?>">
		<input type="hidden" name="locatorfrom[]" value="<?= implode('<>', $allLocatorFrom[$key]) ?>">
		<input type="hidden" name="locatorfromid[]" value="<?= implode('<>', $allLocatorFromId[$key]) ?>">
		<input type="hidden" name="startqty[]" value="<?= implode('<>', $allStartQTY[$key]) ?>">
		<input type="hidden" name="qtysudahpick[]" value="<?= implode('<>', $allQTYSudah[$key]) ?>">
		<input type="hidden" name="departement" value="NONE">
		<input type="hidden" name="piklis" value="1">
		<?php } ?>
	<button type="submit" class="btn btn-success pull-right" disabled="disabled" id="btnSelectedIMO"><b> CREATE PICKLIST SELECTED </b><b id="jmlSlcIMO"></b></button>
	</form>
	<br><br>
	<form method="post" target="_blank" action="<?php echo base_url('InventoryManagement/CreateMoveOrder/createall'); ?>">
		<input type="hidden" name="selectedPicklistIMO" value="">
		<?php foreach ($allInvID as $key => $value) { ?>
		<input type="hidden" name="no_job[]" value="<?= implode('<>', $allNojob[$key]) ?>">
		<input type="hidden" name="invID[]" value="<?= implode('<>', $allInvID[$key]) ?>">
		<input type="hidden" name="qty[]" value="<?= implode('<>', $allQty[$key]) ?>">
		<input type="hidden" name="uom[]" value="<?= implode('<>', $allUom[$key]) ?>">
		<input type="hidden" name="job_id[]" value="<?= implode('<>', $allJobID[$key]) ?>">
		<input type="hidden" name="subinvto[]" value="<?= implode('<>', $allSubInvTo[$key]) ?>">
		<input type="hidden" name="subinvfrom[]" value="<?= implode('<>', $allSubFrom[$key]) ?>">
		<input type="hidden" name="locatorto[]" value="<?= implode('<>', $allLocatorTo[$key]) ?>">
		<input type="hidden" name="locatorfrom[]" value="<?= implode('<>', $allLocatorFrom[$key]) ?>">
		<input type="hidden" name="locatorfromid[]" value="<?= implode('<>', $allLocatorFromId[$key]) ?>">
		<input type="hidden" name="startqty[]" value="<?= implode('<>', $allStartQTY[$key]) ?>">
		<input type="hidden" name="qtysudahpick[]" value="<?= implode('<>', $allQTYSudah[$key]) ?>">
		<input type="hidden" name="departement" value="NONE">
		<input type="hidden" name="piklis" value="2">
		<?php } ?>
	<button type="submit" class="btn btn-success pull-right" disabled="disabled" id="btnSelectedIMO2"><b> CREATE PL HEADER SELECTED </b><b id="jmlSlcIMO2"></b></button>
	</form>

	<form method="post" target="_blank" action="<?php echo base_url('InventoryManagement/Monitoring/exportPending'); ?>">
		<?php foreach ($allInvID as $key => $value) { ?>
		<input type="hidden" name="dept" value="<?= $dept?>">
		<input type="hidden" name="date" value="<?= $date?>">
		<input type="hidden" name="shift" value="<?= $shift?>">
		<input type="hidden" name="no_job[]" value="<?= implode('<>', $allNojob[$key]) ?>">
		<input type="hidden" name="assy[]" value="<?= implode('<>', $allAssy[$key]) ?>">
		<?php } ?>
		<button type="submit" class="btn btn-danger" id="btnpdfMerah"><b> Export Kekurangan </b></button>
	</form>
	<?php } ?>
</div>


<?php foreach ($requirement as $key => $value) : ?>
<!---- MODAL --->
<div class="modal fade" id="formModal<?= $value['header']['WIP_ENTITY_NAME']; ?>" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formModalLabel">Masukan Nama</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        <form action="<?= base_url('InventoryManagement/CreateMoveOrder/create') ?>" id="form-modal<?= $value['header']['WIP_ENTITY_NAME']; ?>"
         method="post" target="_blank">
        	
        	<?php foreach ($value['body'] as $kut => $vulue) : ?>

			<input type="hidden" name="no_job" value="<?= $vulue['WIP_ENTITY_NAME'] ?>">
			<input type="hidden" name="invID[]" value="<?= $vulue['INVENTORY_ITEM_ID'] ?>">
			<input type="hidden" name="qty[]" value="<?= $vulue['REQUIRED_QUANTITY'] ?>">
			<input type="hidden" name="uom[]" value="<?= $vulue['PRIMARY_UOM_CODE'] ?>">
			<input type="hidden" name="job_id[]" value="<?= $vulue['JOB_ID'] ?>">
			<input type="hidden" name="subinvto[]" value="<?= $vulue['GUDANG_TUJUAN'] ?>">
			<input type="hidden" name="subinvfrom[]" value="<?= $vulue['GUDANG_ASAL'] ?>">
			<input type="hidden" name="locatorto[]" value="<?= $vulue['LOCATOR_TUJUAN_ID'] ?>">
			<input type="hidden" name="locatorfrom[]" value="<?= $vulue['LOCATOR_ASAL'] ?>">
			<input type="hidden" name="locatorfromid[]" value="<?= $vulue['LOCATOR_ASAL_ID'] ?>">
			<input type="hidden" name="departement" value="SUBKT">
			<input type="hidden" name="start_qty" value="<?= $value['header']['START_QUANTITY'] ?>">
			<input type="hidden" class="qty_sudahpick<?= $no?>" name="qty_sudah" value="<?= $value['header']['ATTRIBUTE4']?>">
			<input type="hidden" class="att_komponen<?= $no?>" name="att[]" value="<?= $vulue['ATR'] ?>">

			<?php endforeach;?>

            <div class="form-group">
                <label for="namaSatu">Nama Satu</label>
                <input type="text" class="form-control" id="namaSatu" name="namaSatu" placeholder="Masukan Nama Satu">
            </div>
            <div class="form-group">
                <label for="namaDua">Nama Dua</label>
                <input type="text" class="form-control" id="namaDua" name="namaDua" placeholder="Masukan Nama Satu">
            </div>
           
        </div>

      <div class="modal-footer">
        <button class="btn btn-sm  <?= ($value['body']) ? 'btn-success' : 'disabled btn-default' ?>" target="_blank"
				 <?= ($value['body']) ? "onclick=document.getElementById('form-modal".$value['header']['WIP_ENTITY_NAME']."').submit();" :'' ?>>
				 <?= $text_button; ?> 
		</button>
      </div>
    </form>
    </div>
  </div>
</div>
<?php endforeach;?>
<!--- Modal -->