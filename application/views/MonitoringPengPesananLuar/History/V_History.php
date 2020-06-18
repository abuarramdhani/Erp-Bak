<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px;
tr:first-child {background-color: #ffccf9;}
	}
.blink_me {
  animation: blinker 1.5s linear infinite;
}

@keyframes blinker {
  50% {
    opacity: 0;
  }
}

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
        background-color: #3789a5;
       	font-family: sans-serif;
      }

      .itsfun1 {
        border-top-color: #3789a5;
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
							<!-- <a class="btn btn-lg pull-right zoom" style="background-color: #14868c; color: white" target="_blank" href="<?php echo site_url('MonitoringPengirimanPesananLuar/InputPengiriman');?>">
						<i class="icon-plus icon-2x"></i>
							<span ><br /></span>
							</a> -->
						<div class="text-left">
							<h1><span style="font-family: sans-serif;"><b></i></a> History Pengiriman </b></span></h1>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box itsfun1">
					  		<div class="box-header with-border">
					  			<div class="text-left">
					  				<form action="<?php echo base_url('MonitoringPengirimanPesananLuar/RekapPengiriman/exportExcelPengiriman') ?>" method="post">
					  				<!-- <table>
					  					<tr>
					  						<td>
					  						 <label>Filter</label></span>
					  						</td>
					  						<td> <input type="date" placeholder="From Date" name="txtFilterAwalIp" id="txtFilterAwal" class="form-control" style="margin-left: 5px; margin-right: 10px;">
					  						</td>
					  						<td style="padding-left: 20px"> <input type="date" placeholder="To Date" name="txtFilterAkhirIp" id="txtFilterAkhir" class="form-control" style="margin-right: 10px;">
					  						</td>
					  						<td></td>
					  						<td style="padding-left: 20px"><button style="background-color: #3789a5;border-color: #3789a5;" type="submit" class="btn btn-success zoom" id="btnExportMPPL"><i class="fa fa-search"></i> Export Excel</button></td>
					  					</tr>
					  				</table> -->
					  			</form>
					  			</div>
					  		</div>
					  		<div id="tableHolder">
								<div class="box-body">
									<div style="overflow:auto;">
									<table id="tblPurcOrder" style="width: 100%;" class="tblPurcOrderClass table table-striped table-bordered table-hover text-center">
									<thead class="toscahead">
										<tr class="bg-primary">
											<th class="text-center" style="width: 2%;">No</th>
											<th class="text-center" style="width: 5%;">Customer</th>
											<th class="text-center" style="width: 7%;">No PO</th>
											<th class="text-center" style="width: 6%;">Tgl Issued</th>
											<th class="text-center" style="width: 6%;">Need By Date</th>
											<th class="text-center" style="width: 6%;">Delivery Date</th>
											<th class="text-center" style="width: 8%;">No.SO</th>
											<th class="text-center" style="width: 8%;">No.DOSP</th>
											<th class="text-center" style="width: 10%;">Keterangan</th>
											<th class="text-center" style="width: 8%;">Ekspedisi</th>
											<th class="text-center" style="width: 8%;">Entry</th>
											<th class="text-center" style="width: 8%;">Status</th>
											<th class="text-center" style="width: 5%;">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php $no=1; foreach($send as $k) { ?>
											<td><?php echo $no ?> </td>
											<td><?php echo  $k['nama_customer'] ?></td>
											<td><?php echo  $k['no_po'] ?></td>
											<td><span class="hidden"><?php echo  $k['tanggal_issued_order'] ?></span><?php echo  $k['tanggal_issued'] ?></td>
											<td><span class="hidden"><?php echo  $k['need_by_date_order'] ?></span><?php echo  $k['need_by_date'] ?></td>
											<td><span class="hidden"><?php echo  $k['delivery_date_order'] ?></span><?php echo  $k['delivery_date'] ?></td>
											<td><?php echo  $k['no_so'] ?></td>
											<td><?php echo  $k['no_dosp'] ?></td>
											<td><?php echo  $k['keterangan'] ?> </td>
											<td><?php echo $k['nama_ekspedisi'] ?> </td>
											<td><span class="label label-success"><?php echo $k['count'] ?> Pengiriman &nbsp;<br></span></td>
											<?php if ($k['status'] == 'Open') { ?>
												<td><span class="label label-warning">Status : <?php echo  $k['status'] ?> &nbsp;<br></span></td>
												<?php }else if ($k['status'] == 'Close') { ?>
												<td><span class="label label-success">Status : <?php echo  $k['status'] ?> &nbsp;<br></span></td>
											<?php } ?>
											<td>
											<button type="button" data-toggle="modal" data-target="mdlPengiriman" class="btn btn-default zoom btn-sm zoom" onclick="openHistoryPengiriman(<?php echo $k['id_rekap_pengiriman']?>)" class="btnMdlHis" id="btnMdlHis"><i class="fa fa-clock-o"></i> History</button>
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

<div class="modal fade mdlPengiriman"  id="mdlPengiriman" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
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