				<table style="width:100%; font-size: 12px" id="table_SA" class="table bg-blue text-left table-responsive table-striped table-hover table-bordered" >
					<thead >
						<tr>
							<th width="3%;" style="vertical-align: middle; text-align:center">No</th>
							<th style="vertical-align: middle; text-align:center">Kode Assembly</th>
							<th style="vertical-align: middle; text-align:center">Nama Assembly</th>
							<th style="vertical-align: middle; text-align:center">Type Assembly</th>
							<th style="vertical-align: middle; text-align:center">Item</th>
							<th style="vertical-align: middle; text-align:center">Description</th>
							<th style="vertical-align: middle; text-align:center">Subinventory</th>
							<th style="vertical-align: middle; text-align:center">Alamat</th>
							<th width="5%" style="vertical-align: middle; text-align:center">LPPB / MO / KIB</th>
							<th width="5%" style="vertical-align: middle; text-align:center">Picklist</th>
						</tr>
					</thead>
					<tbody style="background-color: white; color: black" >
					<?php 
					$num = 1;
					foreach ($Assy as $SA) { 
						if ($SA ['LMK'] == "1"){ $centang ="checked";}
						else { $centang ="";}			
						if ($SA ['PICKLIST'] == "1"){$centang2 ="checked";}
						else {$centang2 ="";}
					?>
						<tr>
							<td> <?php echo $num; ?> </td>
							<td> <?php echo $SA['KODE_ASSEMBLY']; ?> </td>
							<td> <?php echo $SA['NAMA_ASSEMBLY']; ?> </td>
							<td> <?php echo $SA['TYPE_ASSEMBLY']; ?> </td>
							<td> <?php echo $SA['ITEM']; ?> </td>
							<td> <?php echo $SA['DESCRIPTION']; ?> </td>
							<td> <?php echo $SA['SUB_INV']; ?> </td>
							<td align="center">
							<input type="text" name="" class="alamat form-control" onkeypress="entir(event, this)"  value=" <?php echo $SA['ALAMAT']; ?>"> 
							<input style="display: none" type="text" hiden name="" class="item form-control" value="<?php echo $SA['ITEM']; ?>" > 
							<input style="display: none" type="text" hiden name="" class="kode_assy form-control" value="<?php echo $SA['KODE_ASSEMBLY']; ?>"> 
							<input style="display: none" type="text" hiden name="" class="type_assy form-control" value="<?php echo $SA['TYPE_ASSEMBLY']; ?>"> 
							<input style="display: none" type="text" hiden name="" class="sub_inv form-control" value="<?php echo $SA['SUB_INV']; ?>"> 
						</td>
						<td><input type="checkbox" class="lmk"  <?php echo "$centang"; ?> onchange="enter(event,this)" />

						</td>
						<td><input type="checkbox" class="picklist" <?php echo "$centang2"; ?> onchange="enter2(event,this)"  /></td>
						</tr>
					<?php $num++; } ?>
					</tbody>
				</table>

	<!-- Custom.js -->
	<script src="<?php echo base_url('assets/js/custom.js');?>"></script>
	<!-- PAGE LEVEL SCRIPTS FOR DATATABLES-->
    <script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
    <script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.min.js');?>" type="text/javascript"></script>

