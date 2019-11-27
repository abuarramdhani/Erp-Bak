<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px;
tr:first-child {background-color: #ffccf9;}
	}
/*.blink_me {
  animation: blinker 1.5s linear infinite;
}

@keyframes blinker {
  50% {
    opacity: 0;
  }
}*/

table.tb_sms tr:first-child {
  font-weight: bold;
}

tr.danger td{
	 background-color: #eb3d34;
}

tr.hidden td{
	display: none;
}
thead.toscahead tr th {
        background-color: #5eb7b7;
       	font-family: sans-serif;
      }

      .itsfun1 {
        border-top-color: #5eb7b7;
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
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
							<a class="btn btn-lg pull-right zoom" style="background-color: #5eb7b7; color: white" href="<?php echo site_url('MonitoringPengirimanPesananLuar/InputPurchaseOrder');?>">
						<i class="icon-plus icon-2x"></i>
							<span ><br /></span>
							</a>
						<div class="text-left">
							<h1><span style="font-family: sans-serif;"><b></i></a> Rekap Purchase Order </b></span></h1>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box itsfun1">
					  		<div class="box-header with-border">
					  			<div class="text-left">
					  				<table>
					  					<form action="<?php echo base_url('MonitoringPengirimanPesananLuar/RekapPurchaseOrder/exportExcel') ?>" method="post">
					  					<tr>
					  						<td>
					  						 <label>Filter Tanggal Issued</label></span>
					  						</td>
					  						<td> <input type="text" placeholder="From Date" name="txtFilterAwalTIS" id="txtFilterAwalTIS" class="form-control datefilterrr" style="margin-left: 5px; margin-right: 10px;">
					  						</td>
					  						<td style="padding-left: 20px"> <input type="text" placeholder="To Date" name="txtFilterAkhirTIS" id="txtFilterAkhir" class="form-control datefilterrr" style="margin-right: 10px;">
					  						</td>
					  						<td></td>
					  						<td style="padding-left: 20px"><button style="background-color: #5eb7b7;border-color: #5eb7b7;" type="submit" class="btn btn-success zoom" id="btnExportMPPL"><i class="fa fa-search"></i> Export Excel</button></td>
					  					</tr>
					  				</form>
					  				</table>
					  			</div>
					  		</div>
					  		<div id="tableHolder">
								<div class="box-body">
									<div style="overflow:auto;">
									<table id="tblPurcOrder" style="min-width:110%;" class="tblPurcOrder tb_responsive_sms table table-striped table-bordered table-hover text-center">
									<thead class="toscahead">
										<tr class="bg-primary">
											<th class="text-center" style="width: 2%;">No</th>
											<th class="text-center" style="width: 5%;">Customer</th>
											<th class="text-center" style="width: 8%;">No PO</th>
											<th class="text-center" style="width: 10%;">Tgl Issued</th>
											<th class="text-center" style="width: 10%;">Need By Date</th>
											<th class="text-center" style="width: 15%;">Lampiran</th>
											<th class="text-center" style="width: 5%;">Status</th>
											<th class="text-center" style="width: 30%;">Action</th>
											<th style="display: none" class="text-center" style="width: 20%;">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php $no=1; foreach($dsh as $k) { ?>
											<td><?php echo $no ?> </td>
											<td><?php echo  $k['nama_customer'] ?></td>
											<td><?php echo  $k['no_po'] ?></td>
											<td><?php echo  $k['tanggal_issued'] ?></td>
											<td><?php echo  $k['need_by_date'] ?></td>
											<td> <a href="<?php echo base_url("MonitoringPengirimanPesananLuar/RekapPurchaseOrder/download/".$k['lampiran']) ?>"> <button class="btn btn-info btn-sm zoom"><i class="fa fa-download"></i> Download</button> </a>
												<a target="_blank" href="<?= base_url('assets/upload/MonitoringPengirimanPesananLuar/').'/'.$k['lampiran'] ?>">
												<button class="btn btn-default btn-sm zoom"><i class="fa fa-external-link"></i>  View</button></a>
											</td>
												<?php if ($k['status'] == 'Open') { ?>
											<td><span class="label label-primary">Status : <?php echo  $k['status'] ?> &nbsp;<br></span></td>
												<?php }else if ($k['status'] == 'Close') { ?>
											<td><span class="label label-danger">Status : <?php echo  $k['status'] ?> &nbsp;<br></span></td>
												<?php } ?>
										
											<td>
												<button type="button" data-toggle="modal" data-target="mdlDetailPo" class="btn btn-success zoom btn-sm zoom" onclick="openModalPO(<?php echo $k['id_rekap_po']?>)" class="btnMdlPO" id="btnMdlPO"><i class="fa fa-search"></i> Detail</button>
											
											
												<?php if ($k['no_so'] == NULL) { ?>
												<a target="_blank" href="<?php echo base_url('MonitoringPengirimanPesananLuar/RekapPurchaseOrder/edit/'.$k['id_rekap_po'])?>" >
													<button type="button" class="btn btn-warning zoom btn-sm zoom" id="btn_detail_pr"><i class="fa fa-pencil"></i> Edit</button>

													<!-- data-target="mdlDetailPo" data-toggle="modal" onclick="MdlEditPo(<?php echo $k['id_rekap_po']?>)"  -->
												</a>
												<?php } ?>

											
												<button type="button" class="btn btn-danger zoom btn-sm zoom" onclick="onDeletePO(this)" id="btnDeletePO"><i class="fa fa-trash"></i> Delete</button>
											</td>
										

											<td class="test" style="display: none"><input type="hidden" name="hdnPo" id="hdnPO" value="<?php echo $k['id_rekap_po']?>"><input type="hidden" name="hdnPo2" id="hdnPO2" value="<?php echo  $k['no_po'] ?>">
											</td>
										</tr>
										<?php $no++; } ?>
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
	</div>
</section>

<div class="modal fade mdlDetailPo"  id="mdlDetailPo" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog modal-sm" style="width:1200px;" role="document">
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

<script type="text/javascript">
	$('.datefilterrr').datepicker({
		format: 'mm/dd/yy',
		autoclose: true,
	});
</script>