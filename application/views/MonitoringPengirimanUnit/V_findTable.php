<style type="text/css">
/*table.dataTable thead tr {
  background-color: #bd3735;
}*/
</style>

<table style="width: 100%" id="unitpunya" class="table table-striped table-bordered table-hover text-center">
	<thead>
										<tr class="bg-primary">
											<th style="width: 3%;" class="text-center">No</th>
											<th style="width: 7%;" class="text-center">No Shipment</th>
											<th style="width: 10%;" class="text-center">Kendaraan</th>
											<th style="width: 10%;" class="text-center">Berangkat</th>
											<th style="width: 10%;" class="text-center">Finish Good</th>
											<th style="width: 10%;" class="text-center">Cabang Tujuan</th>
											<th style="width: 30%;" class="text-center">Muatan</th>
											<th style="width: 5%;" class="text-center">Full</th>
											<th style="width: 15%;" class="text-center">Action</th>
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
											<td><?php echo  $k['cabang'] ?></td>
											<td><?php echo  $k['muatan'] ?></td>
											<?php if ($k['status'] == NULL) { ?>
											<td>UNCONFIRMED</td>
											<?php }else{ ?>
											<td><?php echo $k['status'] ?> </td>
											<?php }?>
											<td>
												<a title="edit ..." class="btn btn-warning btn-sm" data-target="MdlMPM" data-toggle="modal" onclick="ModalDetailUnit(<?php echo $k['no_shipment'] ?>)"><i class="fa fa-hand-pointer-o"></i></a>
												<a title="delete ..." class="btn btn-danger btn-sm" onclick="DeleteShipment(<?php echo $k['no_shipment'] ?>)"><i class="fa fa-trash"></i></a></td>
										</tr>
										<?php $no++; } ?>
									</tbody>
</table>

<div class="modal fade MdlMPM"  id="MdlMPM" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
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
