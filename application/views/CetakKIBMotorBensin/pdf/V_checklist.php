<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title></title>
	</head>
	<body>
  <div style="width:100%">
  	<?php foreach ($count as $key => $value): ?>
  		<div style="width:29%;float: left;margin-left:23.5px;">
  			<table style="border-collapse: collapse;width: 100%;page-break-inside:avoid;margin-top:15px;" >
  				<thead>
  					<tr>
  						<td style="border-left:1px solid black;border-top:1px solid black;border-bottom:1px solid black;padding:5px;font-weight:bold;text-align:center" colspan="3">PALET</td>
  						<td style="border-left:1px solid black;border-top:1px solid black;border-bottom:1px solid black;border-right:1px solid black;padding:5px;text-align:center;font-weight:bold"><?php echo $value ?></td>
  					</tr>
  					<tr>
  						<td style="border-left:1px solid black;border-bottom:1px solid black;padding:5px;font-weight:bold;text-align:center;width:15%">NO</td>
  						<td style="border-left:1px solid black;border-bottom:1px solid black;border-right:1px solid black;padding:5px;text-align:center;font-weight:bold" colspan="3">NOMOR ENGINE</td>
  					</tr>
  				</thead>
  				<tbody>
  					<?php foreach ($get[$value] as $k => $v): ?>
  						<?php if ($k <= 30){ ?>
  							<tr>
  								<td style="border-left:1px solid black;border-bottom:1px solid black;padding:5px;text-align:center"><?php echo $k+1 ?></td>
  								<td style="width:35%;border-left:1px solid black;border-bottom:1px solid black;padding:5px;"><?php echo $v['TYPE'] ?></td>
  								<td style="width:20%;border-left:1px solid black;border-bottom:1px solid black;padding:5px;"><?php echo $v['KODE_1'] ?></td>
  								<td style="width:30%;border-left:1px solid black;border-bottom:1px solid black;border-right:1px solid black;padding:5px;"><?php echo $v['KODE_2'] ?></td>
  							</tr>
  						<?php } ?>
  					<?php endforeach; ?>
  				</tbody>
  			</table>
  		</div>
      <?php if (($value) % 3 == 0): ?>
        <?php echo "<pagebreak>" ?>
      <?php endif; ?>
  	<?php endforeach; ?>
  </div>

	</body>
</html>
