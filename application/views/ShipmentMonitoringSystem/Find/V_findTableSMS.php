<style type="text/css">
/*table.dataTable thead tr {
  background-color: #bd3735;
}*/
thead.toscahead tr th {
        background-color: #64b2cd;
       	font-family: sans-serif;
      }
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

<table style="width: 100%" id="unitpunya" class="table table-striped table-bordered table-hover text-center">
	<thead class="toscahead">
										<tr class="bg-primary">
											<th style="width: 3%;" class="text-center">No</th>
											<th style="width: 3%;" class="text-center">No.Shp</th>
											<th style="width: 8%;" class="text-center">Kendaraan</th>
											<th style="width: 8%;" class="text-center">Berangkat</th>
											<th style="width: 8%;" class="text-center">Finish Good</th>
											<th style="width: 15%;" class="text-center">Cabang Tujuan</th>
											<th style="width: 15%;" class="text-center">Muatan</th>
											<th style="width: 5%;" class="text-center">Persentase Full (%)</th>
											<th style="width: 5%;" class="text-center">Full</th>
											<th style="width: 10%;" class="text-center">No DO</th>
											<th style="width: 10%;" class="text-center">No SPB</th>
											<th style="width: 25%;" class="text-center">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php $no=1; foreach($find as $k) { ?>
										<tr>
											<td><?php echo $no ?> </td>
											<td><?php echo  $k['no_shipment'] ?></td>
											<td><?php echo  $k['jenis_kendaraan'] ?></td>
											<td><?php echo  $k['berangkat'] ?></td>
											<td><?php echo  $k['asal_gudang'] ?></td>
											<?php if ($k['cabang'] == 'NON CABANG') { ?>											
											<td><?php echo  $k['tujuan'] ?></td>
											<?php }else if ($k['cabang'] !== 'NON CABANG') { ?>
											<td><?php echo  $k['cabang'] ?></td>
											<?php } ?>
											<td><?php echo  $k['muatan'] ?></td>
											<td><?php echo  $k['persentase']  ?>%</td>
											<?php if ($k['status'] == NULL) { ?>
											<td>UNCONFIRMED</td>
											<?php }else if ($k['status'] == 'N') { ?>
											<td> TIDAK </td>
											<?php }else if ($k['status'] == 'Y') { ?>
											<td> FULL </td>
											<?php }?>
											<td><?php echo  $k['no_do'] ?></td>
											<td><?php echo  $k['no_spb'] ?></td>
											<td>
												<a title="edit ..." class="btn btn-warning btn-sm zoom" data-target="MdlMPM" data-toggle="modal" onclick="ModalDetailSMS(<?php echo $k['no_shipment'] ?>)"><i class="fa fa-hand-pointer-o"></i></a>
												<a title="delete ..." class="btn btn-danger btn-sm zoom" onclick="DeleteShipment(<?php echo $k['no_shipment'] ?>)"><i class="fa fa-trash"></i></a></td>
										</tr>
										<?php $no++; } ?>
									</tbody>
</table>

<div class="modal fade MdlMPM"  id="MdlMPM" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width:1300px;" role="document">
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
