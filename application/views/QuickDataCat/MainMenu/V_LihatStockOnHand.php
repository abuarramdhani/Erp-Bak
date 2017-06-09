<!-- Content Header (Page header) -->
<section class="content-header">
<div class="row"> 
	<div class="col-md-10">
		<h3><b><i class="fa fa-tint"></i> DATA CAT ONHAND(OHN) </b></h3>
	</div>
</div>
 </section>
<br>
 <section class="content">
        <div class="row">
            <div class="col-md-12">
				<div class="col-md-13">
					<div class="box box-primary">
						<div class="box-header with-border" style="background:#2E6DA4; color:#FFFFFF;">
						 <h3 class="box-title"><a><li class="fa fa-table"></li></a> Data OHN</h3>
						</div><!-- /.box-header -->
						<div  class="box-body">
						<div class="col-md-9" >

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
						echo '<table id="table_ohn" class="table table-bordered" id="cat-onhand table-responsive " style="font-size:12px; border:5px ">
							<tr class="bg-primary" > 
							  <td rowspan="2"  width="5%"><center><b>NO</center></td>
							  <td rowspan="2"  width="30%"><center><b>KODE CAT</center></td>
							  <td rowspan="2"  width="30%"><center><b>DESCRIPTION</center></td>
							  <td colspan="2"  width="30%"><center><b>ON HAND</center></td>
							</tr>
							<tr class=" bg-primary ">
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
						echo '<table class="table table-bordered" id="cat-onhand table-responsive " style="font-size:12px; border:5px ">
							<tr class="bg-primary" >
							  <td rowspan="2"  width="5%"><center><b>NO</center></td>
							  <td rowspan="2"  width="30%"><center><b>KODE CAT</center></td>
							  <td rowspan="2"  width="30%"><center><b>DESCRIPTION</center></td>
							  <td colspan="2"  width="30%"><center><b>ON HAND</center></td>
							</tr>
							<tr class=" bg-primary ">
					          <td><center><b>TGL EXPIRED</center></td>
					          <td><center><b>QTY</center></td>
							</tr>
							</table>';
					}
						?>
						<br>
							<table align="left">
								<a href="<?php base_url()?>LihatStokOnHand/exportExcelOnHand"  class="btn btn-primary btn-ls col-md-2" style="background:#fff;color:#06f;"> <b>EXCEL</b> </a>
							</table>
						</div>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
				</div><!-- /.box -->
            </div>
        </div>
</section>