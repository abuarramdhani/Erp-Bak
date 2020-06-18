<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>CETAK BARCODE PACKAGING</title>
		<style type="text/css">
		.font {
				font-size:10px;
				font-size-adjust: 0.58;
		}

		.font2 {
				font-size:12px;
		}
		</style>
	</head>
	<body style="font-family:arial;">
		<?php for ($i=1; $i <= $qty; $i++) {?>
		<div style="width: 50%; height: 100%; float: left;" >
			<div style="height:10%;padding-top: 5px" >
				<table style="border-bottom: 2px solid #333;width: 100%;" >
					<tr >
						<td ><img src="<?php echo base_url('assets/img/logo/quicklog.jpg') ?>" style="width: 50px; height: 10px;text-align: right; " ></td>
						<td class="font" ><?php echo $row[0]['TANGGAL']; ?></td>
						<td class="font" align="right" ><p> <?php echo $row[0]['TYPE']; ?> </p> </td>
					</tr>
				</table>
			</div>
			<div style="height: 65%;"  >
					<table style="height: 100%;"   >
						<tr>
							<td colspan="2" style="height: 40px; padding: 5px;font-size: 15px;border: 0px solid black;"  > <b><?php echo $row[0]['DESCRIPTION'];?>  </b></td>
							<td align="right" style="border: 0px solid black;" colspan="2" rowspan="3"  >
							<img style=" float:right; width:100%; padding-right: 2px;  height:auto;" src="<?php echo base_url('assets/upload/wipp/qrcode/'.$row[0]['SEGMENT1']) ?>" />
							<h2>INIQRCODE</h2>
							</td>
						</tr>
						<tr>
							<td align="center" >
								<img alt="TESTING" style="width: 100%; height: auto" src="<?php echo base_url('application/controllers/WorkInProcessPackaging/barcode.php?size=50&text='.$row[0]['SEGMENT1'])
								?>">
							</td>
						</tr>
						<tr>
							<td align="center" style="padding-right: 5px; font-size: 16px " > <b>
								<?PHP
								echo $row[0]['SEGMENT1'] ; ?></b>
							</td>
						</tr>
				</table>
			</div>

			<div style="width: 100%;  height:15% ;" >
		    <table style="border-top: 2px solid #333; position: fixed; width: 100%;">
		      <tr>
		        <td style="border-right: 2px solid #333" >
		          <img src="<?php echo base_url('assets/img/logo/quicklogbig.jpg') ?>" style="width: 21px;height: 24px; margin-right: 10px ; margin-left: 10px " >
		        </td>
		        <td style="font-size: 11px ;text-align: center; vertical-align: top " ><b> CV. KARYA HIDUP SENTOSA <br/> YOGYAKARTA</b> </td>
		      </tr>
		    </table>
		  </div>
		</div>

		<div style="width: 50%; height: 100%; float: left;" >
			<div style="height:10%;padding-top: 5px" >
				<table style="border-bottom: 2px solid #333;width: 100%;" >
					<tr >
						<td ><img src="<?php echo base_url('assets/img/logo/quicklog.jpg') ?>" style="width: 50px; height: 10px;text-align: right; " ></td>
						<td class="font" ><?php echo $row[0]['TANGGAL']; ?></td>
						<td class="font" align="right" ><p> <?php echo $row[0]['TYPE']; ?> </p> </td>
					</tr>
				</table>
			</div>
			<div style="height: 65%;"  >
					<table style="height: 100%;"   >
						<tr>
							<td colspan="2" style="height: 40px; padding: 5px;font-size: 15px;border: 0px solid black;"  > <b><?php echo $row[0]['DESCRIPTION'];?>  </b></td>
							<td align="right" style="border: 0px solid black;" colspan="2" rowspan="3"  >
							<img style=" float:right; width:100%; padding-right: 2px;  height:auto;" src="<?php echo base_url('assets/upload/wipp/'.$row[0]['SEGMENT1']) ?>" />
							<h2>INIQRCODE</h2>
							</td>
						</tr>
						<tr>
							<td align="center" >
								<img alt="TESTING" style="width: 100%; height: auto" src="<?php echo base_url('application/controllers/WorkInProcessPackaging/barcode.php?size=50&text='.$row[0]['SEGMENT1'])
								?>">
							</td>
						</tr>
						<tr>
							<td align="center" style="padding-right: 5px; font-size: 16px " > <b>
								<?PHP
								echo $row[0]['SEGMENT1'] ; ?></b>
							</td>
						</tr>
				</table>
			</div>

			<div style="width: 100%;  height:15% ;" >
				<table style="border-top: 2px solid #333; position: fixed; width: 100%;">
					<tr>
						<td style="border-right: 2px solid #333" >
							<img src="<?php echo base_url('assets/img/logo/quicklogbig.jpg') ?>" style="width: 21px;height: 24px; margin-right: 10px ; margin-left: 10px " >
						</td>
						<td style="font-size: 11px ;text-align: center; vertical-align: top " ><b> CV. KARYA HIDUP SENTOSA <br/> YOGYAKARTA</b> </td>
					</tr>
				</table>
			</div>
		</div>

   <?php } ?>

		<!-- <p>SPACEX TRIAL NASA 9.0012<p>
			<img src="<?php echo base_url('assets/upload/WIPP/QRCODE/'.$get) ?>" alt="">
			<img src="<?php echo base_url('assets/img/logo/quicklog.jpg') ?>" alt=""> -->
	</body>
</html>
