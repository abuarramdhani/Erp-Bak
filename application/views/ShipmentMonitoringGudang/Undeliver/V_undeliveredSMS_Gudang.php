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

/*tr:first-child {
  font-weight: bold;
}*/

tr.danger td{
	 background-color: #eb3d34;
}

tr.hidden td{
	display: none;
}
thead.toscahead tr th {
        background-color: #dd4b39;
       	font-family: sans-serif;
      }

      .itsfun1 {
        border-top-color: #dd4b39;
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
<!-- <head> 
	<meta http-equiv="refresh" content="30"/> 
	<meta name="viewport" content="initial-scale=1"/>
</head> -->
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left">
							<h1><span style="font-family: sans-serif;"><b><i class="fa fa-calendar"></i></a> Undelivered Shipment List </b></span></h1>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-danger">
					  		<div class="box-header with-border">
					  			<div class="text-left">
					  				<span style="font-family: sans-serif;font-size:16px;"><i class="fa fa-bookmark" style="color: #ffc400"></i> List Shipment Tidak Terkirim</span> 
					  			</div>
					  		</div>
					  		<div id="tableHolder">
								<div class="box-body">
									<table id="tb_sms" style="width: 100%;" class="tb_sms tb_responsive_sms table table-striped table-bordered table-hover text-center">
									<thead class="toscahead">
										<tr class="bg-primary">
											<th class="text-center" style="width: 2%;">No</th>
											<th title="No Shipment" class="text-center" style="width: 2%;">No SHP</th>
											<th class="text-center" style="width: 3%;">Kendaraan</th>
											<th class="text-center" style="width: 8%;">Creation Date</th>
											<th class="text-center" style="width: 4%;">Finish Good</th>
											<th class="text-center" style="width: 12%;">Tujuan</th>
											<th class="text-center" style="width: 25%;">Muatan</th>
											<th title="Status muatan" class="text-center" style="width: 2%;">Full</th>
											<th title="Persentase Full" class="text-center" style="width: 2%;">Percentage (%)</th>
											<th class="text-center" style="width: 8%;">Actual QTY </th>
											<th class="text-center" style="width: 8%;">No PR</th>
											<th class="text-center" style="width: 8%;">Nomor DO</th>
											<th class="text-center" style="width: 8%;">Nomor SPB</th>
											<th title="Detail Nomor PR" class="text-center" style="width: 5%;">Detail PR</th>
											<th title="Detail Shipment" class="text-center" style="width: 5%;">Detail SHP</th>
										</tr>
									</thead>
									<tbody>
										<?php $no=1; foreach($undeliver as $k) { ?>

											<?php if ($k['dq'] == NULL || $k['q'] > $k['dq']) { ?>
												<tr data-toggle="tooltip" data-placement="top"title="<?php echo $k['q'] - $k['dq']?> SHIPMENT TIDAK TERKIRIM">
											<?php }elseif ($k['q'] = $k['dq']) { ?>
												<tr style ="display:none;">
											<?php }?>

											<td><?php echo $no ?> </td>
											<td><?php echo  $k['no_shipment'] ?></td>
											<td><?php echo  $k['jenis_kendaraan'] ?></td>
											<td><?php echo  $k['creation_date'] ?></td>
											<td><?php echo  $k['asal_gudang'] ?></td>
											<?php if ($k['cabang'] == 'NON CABANG') { ?>											
											<td><?php echo  $k['tujuan'] ?></td>
											<?php }else if ($k['cabang'] !== 'NON CABANG') { ?>
											<td><?php echo  $k['cabang'] ?></td>
											<?php } ?>
											<td><?php echo  $k['muatan'] ?></td>
											<td><?php echo  $k['status'] ?> </td>
											<td><?php echo $k['full_percentage'] ?>% </td>
											<!-- <?php if ($k['actual_loading'] == NULL) { ?>
											<td>UNCONFIRMED</td>
											<?php }else{ ?>
											<td><?php echo $k['actual_loading'] ?> </td>
											<?php }?><?php if ($k['actual_berangkat'] == NULL) { ?>
											<td>UNCONFIRMED</td>
											<?php }else{ ?>
											<td><?php echo $k['actual_berangkat'] ?> </td>
											<?php }?> -->
											<?php if ($k['dq'] == NULL) { ?>
											<td id="blinking_td" style="font-weight: bold;" class="danger blink_me"> Terkirim : - <br> Dari : <?php echo  $k['q'] ?> </td>
											<?php } else { ?>
											<td id="blinking_td" style="font-weight: bold;" class="danger blink_me"> Terkirim : <?php echo $k['dq']; ?> <br> Dari : <?php echo  $k['q'] ?></td>
											<?php }?>
											<td><?php echo  $k['pr'] ?> </td>
											<td><?php echo  $k['no_do'] ?> </td>
											<td><?php echo  $k['no_spb'] ?> </td>
											<td><button title="Detail PR..." type="button" data-toggle="modal" data-target="MdlSMS" onclick="detailPRGdg(<?php echo $k['prl'] ?>, <?php echo $k['pr'] ?>)" class="btn btn-warning zoom" class="btn_detail_pr" id="btn_detail_pr"><i class="fa fa-search"></i></button></td>
											<td><button title="Detail Shipment..." type="button" data-toggle="modal" data-target="MdlDetailShpUndeliver" onclick="detailShpUndeliver(<?php echo $k['no_shipment'] ?>)" class="btn btn-success zoom" class="btn_detail_pr" id="btn_detail_pr"><i class="fa fa-hand-pointer-o"></i></button></td>
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
</section>

<div class="modal fade MdlSMS"  id="MdlSMS" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog modal-sm" style="width:800px;" role="document">
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

<div class="modal fade MdlDetailShpUndeliver"  id="MdlDetailShpUndeliver" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
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
