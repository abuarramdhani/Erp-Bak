<link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/plugins/datatables/buttons.dataTables.min.css');?>" rel="stylesheet" type="text/css" />

<?php
header("Content-Type:application/vnd.ms-excel");
header('Content-Disposition:attachment; filename="datacatonhand.xls"');
?>

<h3> CV. KARYA HIDUP SENTOSA </h3>
<h4> Laporan Stock OnHand dan Tanggal Expired </h4>
</br></br>
												<?php 
							if (!empty($data_onhand)) {
								
							$i=0; 
							foreach ($data_onhand as $dat){
							  $row[$i]=$dat;
							  $i++;
							}
							foreach($row as $cell){
							  if(isset($total[$cell['paint_code']]['jml'])){ 
							    $total[$cell['paint_code']]['jml']++; 
							  }else{
							    $total[$cell['paint_code']]['jml']=1; 
							  }
							}
						echo '<table border=1 class="table table-bordered" id="cat-onhand table-responsive " style="font-size:12px; border:1 ">
							<tr>
							  <td rowspan="2"  width="5%"><center><b>NO</center></td>
							  <td rowspan="2"  width="30%"><center><b>KODE CAT</center></td>
							  <td rowspan="2"  width="30%"><center><b>DESCRIPTION</center></td>
							  <td colspan="2"  width="30%"><center><b>ON HAND</center></td>
							</tr>
							<tr>
					          <td><center><b>TGL EXPIRED</center></td>
					          <td><center><b>QTY</center></td>
							</tr>';
						$n=count($row);
						$cekinstansi="";
						$num=1;
						for($i=0;$i<$n;$i++){
						  $cell=$row[$i];
						  echo '<tr class="bg-default" > ';
						  if($cekinstansi!=$cell['paint_code']){
						    echo '<td' .($total[$cell['paint_code']]['jml']>1?' rowspan="' .($total[$cell['paint_code']]['jml']).'">':'>') .$num.'</td>'; $num++;
						    echo '<td' .($total[$cell['paint_code']]['jml']>1?' rowspan="' .($total[$cell['paint_code']]['jml']).'">':'>') .$cell['paint_code'].'</td>';
						    echo '<td' .($total[$cell['paint_code']]['jml']>1?' rowspan="' .($total[$cell['paint_code']]['jml']).'">':'>') .$cell['paint_description'].'</td>';
						    $cekinstansi=$cell['paint_code'];

						  }
						  echo "<td>$cell[expired_date]</td><td>$cell[on_hand]</td>";
						  echo "</tr>";

						}
						echo "</table>";
					}
					else{
						echo '<table border=1 class="table table-bordered" id="cat-onhand table-responsive " style="font-size:12px">
							<tr>
							  <td rowspan="2"  width="5%"><center><b>NO</center></td>
							  <td rowspan="2"  width="30%"><center><b>KODE CAT</center></td>
							  <td rowspan="2"  width="30%"><center><b>DESCRIPTION</center></td>
							  <td colspan="2"  width="30%"><center><b>ON HAND</center></td>
							</tr>
							<tr >
					          <td><center><b>TGL EXPIRED</center></td>
					          <td><center><b>QTY</center></td>
							</tr>
							</table>';
					}
						?>