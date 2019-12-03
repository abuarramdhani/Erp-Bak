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
        background-color: #64b2cd;
       	font-family: sans-serif;
      }

      .itsfun1 {
        border-top-color: #599db5;
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
<head> 
	<meta http-equiv="refresh" content="30"/> 
	<meta name="viewport" content="initial-scale=1"/>
</head>
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left">
							<h1><span style="font-family: sans-serif;"><b><i class="fa fa-calendar"></i></a> Shipment Monitoring Dashboard </b></span></h1>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box itsfun1">
					  		<div class="box-header with-border">
					  			<div class="text-left">
					  				<span style="font-family: sans-serif;font-size:12.5px;"><i class="fa fa-star" style="size:10px; color: #ffc400"></i> Tabel refresh otomatis setiap 30 detik</span> 
					  			</div>
					  			<div class="text-left">
					  				<span style="font-family: sans-serif;font-size:12.5px;"><i class="fa fa-star" style="size:10px; color: #ffc400"></i> Tinjau shipment terdahulu pada menu Shipment History</span> 
					  			</div>
					  		</div>
					  		<div id="tableHolder">
								<div class="box-body">
									<div style="overflow:auto;">
									<table id="tb_sms" style="min-width: 130%;" class="tb_sms table table-striped tb_responsive_sms table-bordered table-hover text-center">
									<thead class="toscahead">
										<tr class="bg-primary">
											<th class="text-center" style="width: 5%;">No</th>
											<th class="text-center" title="No Shipment" style="width: 3%;">No SHP</th>
											<th class="text-center" style="width: 8%;">Kendaraan</th>
											<th class="text-center" style="width: 10%;">Estimasi Berangkat</th>
											<th class="text-center" style="width: 10%;">Time Left</th>
											<th class="text-center" style="width: 4%;">Finish Good</th>
											<th class="text-center" style="width: 12%;">Tujuan</th>
											<th class="text-center" style="width: 30%;">Muatan</th>
											<th class="text-center" style="width: 2%;">Full</th>
											<th class="text-center" style="width: 2%;">Full (%)</th>
											<th class="text-center" style="width: 10%;">Actual Loading </th>
											<th class="text-center" style="width: 10%;">Actual Depart </th>
											<th class="text-center" style="width: 10%;">Actual QTY </th>
											<th class="text-center" style="width: 10%;">Nomor PR</th>
											<th class="text-center" style="width: 5%;">Detail PR</th>
										</tr>
									</thead>
									<tbody>
										<?php $no=1; foreach($kirim as $k) { ?>
											<?php if ($k['actual_berangkat'] == NULL && $k['berangkat'] < date('Y-m-d H:i:s')) { ?>
												<tr class ="danger" data-toggle="tooltip" data-placement="top" title="Shipment melewati batas estimasi!!">
											<?php }else{ ?> 
												<tr data-toggle="tooltip" data-placement="top" title="Disortir berdasarkan waktu keberangkatan">
											<?php }?>

											<td><?php echo $no ?> </td>
											<td><?php echo  $k['no_shipment'] ?></td>
											<td><?php echo  $k['jenis_kendaraan'] ?></td>
											<td><?php echo  $k['berangkat'] ?></td>
											<td id="demo" class="zoom">NOT SET YET<input type="hidden" class="hidTxt" value="<?php echo $k['berangkat'] ?>"></input></td>
											<td><?php echo  $k['asal_gudang'] ?></td>
											<?php if ($k['cabang'] == 'NON CABANG') { ?>											
											<td><?php echo  $k['tujuan'] ?></td>
											<?php }else if ($k['cabang'] !== 'NON CABANG') { ?>
											<td><?php echo  $k['cabang'] ?></td>
											<?php } ?>
											<td><?php echo  $k['muatan'] ?></td>
											<td><?php echo  $k['status'] ?> </td>
											<td><?php echo $k['full_percentage'] ?>% </td>
											<?php if ($k['actual_loading'] == NULL) { ?>
											<td><span class="label label-danger">UNCONFIRMED &nbsp;<br></span></td>
											<?php }else{ ?>
											<td><?php echo $k['actual_loading'] ?> </td>
											<?php }?><?php if ($k['actual_berangkat'] == NULL) { ?>
											<td><span class="label label-danger">UNCONFIRMED &nbsp;<br></span></td>
											<?php }else{ ?>
											<td><?php echo $k['actual_berangkat'] ?> </td>
											<?php }?>
											<?php if ($k['dq'] == NULL) { ?>
											<td> Terkirim : - <br> Dari : <?php echo  $k['q'] ?> </td>
											<?php } else { ?>
											<td> Terkirim : <?php echo $k['dq']; ?> <br> Dari : <?php echo  $k['q'] ?></td>
											<?php }?>
											<td><?php echo  $k['pr'] ?> </td>
											<td><button type="button" data-toggle="modal" data-target="MdlSMS" onclick="detailPR(<?php echo $k['prl'] ?>, <?php echo $k['pr'] ?>)" class="btn btn-warning zoom" class="btn_detail_pr" id="btn_detail_pr"><i class="fa fa-search"></i></button></td>
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

<script>
var estimasiw = $('.hidTxt').val();
console.log(estimasiw)
var countDownDate = new Date(estimasiw).getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
    
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="demo"
  document.getElementById("demo").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "EXPIRED";
  }
}, 1000);

</script>
