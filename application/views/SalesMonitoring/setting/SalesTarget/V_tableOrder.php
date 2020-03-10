<br />
<table  class="table table-striped table-bordered table-hover" id="dataTables-customer" style="font-size:12px;">
								<thead>
									<tr class="bg-primary">
										<th width="5%" class="text-center">NO</th>
										<th width="65%%" class="text-center">ORDER TYPE</th>
										<th width="30%" class="text-center">ACTION</th>
									</tr>
								</thead>
								<tbody id="tbodyOrderSM">
									<?php $no = 0; foreach($order as $o) { $no++ ?>
										 <tr class="<?php echo $o['ITEM_ID'] ?>">
											<td class="text-center"><?php echo $no; ?></td>
											<td class="text-center"><?php echo $o['ORDER_TYPE'] ?><input type="hidden" id="<?php echo $o['ITEM_ID'] ?>" value="<?php echo $o['ORDER_TYPE'] ?>"></td>
											<td class="text-center">
												<button onclick="deleteeeOrderType(<?php echo $o['ITEM_ID'] ?>)" type="button" class="btn btn-sm btn-danger" style="width:100px"><i class="fa fa-times"></i> Delete</button>
												<button type="button" data-target="#MdlEditOrderSM" data-toggle="modal" onclick="openDetailOrderSM(<?php echo $o['ITEM_ID'] ?>)" class="btn btn-sm btn-warning" style="width:100px"><i class="fa fa-external-link"></i> Edit</button>
											</td>
										</tr> 
									<?php } ?>
								</tbody>																			
							</table>

<div id="MdlEditOrderSM" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width:800px" role="document">
		<div class="modal-content"  id="content1" >
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		    <h5 class="modal-title"></h5>
		  </div>
		  <div class="modal-body">
		    <div class="row">
		      <div class="col-md-12">
		      	<center>
		      		
		      	</select>
		      	<center>
		      </div>
		    </div>
		  </div>
		  <div class="modal-footer">
		  	<h5 class="modal-title-footer pull-left"></h5>
		  </div>
		</div>
 	</div>
</div>