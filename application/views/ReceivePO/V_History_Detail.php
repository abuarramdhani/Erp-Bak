<div class="col-md-4" >
<?php for ($i=0; $i < 1 ; $i++) { ?>
<table id="detail" class="table table-bordered" style="width: 100%">

<tbody >
  <tr>
    <td><input type="hidden" name="porecipt[]" value="<?=$detail[$i]['PO_NUMBER'] ?>" ><b>PO :</b> <?=$detail[$i]['PO_NUMBER'] ?> <br><input type="hidden" name="sujarecipt[]" value="<?=$detail[$i]['SHIPMENT_NUMBER'] ?>" ><b>Surat Jalan : </b><?=$detail[$i]['SHIPMENT_NUMBER'] ?></td>
  </tr>   
  <tr>
    <td><?php if ($detail[$i]['LPPB_NUMBERS'] == null) {  ?>
      <input type="hidden" name="lppbrecipt[]" value="-" > <b>NO LPPB :</b>  -
    <?php } else if ($detail[$i]['LPPB_NUMBERS'] != null) { ?>
      <input type="hidden" name="lppbrecipt[]" value="<?=$detail[$i]['LPPB_NUMBERS'][0]['RECEIPT_NUM'] ?>" > <b>NO LPPB : </b><?=$detail[$i]['LPPB_NUMBERS'][0]['RECEIPT_NUM'] ?>
      <?php } ?>
    </td>
  </tr>   
  <tr>
    <td><input type="text" class="form-control"  id="keterangandong" placeholder="Masukan keterangan" ></td>
  </tr>        
</tbody>
</table>
<?php }?>
</div>
<div class="col-md-7">
<h2  style="text-align: center"  >RINCIAN PO</h2>
<h3  style="text-align: center"  >Standart Warna Hijau</h3>

</div>

<div class="col-md-12">
<table id="detaillist" class="table table-bordered" style="width: 100%">

    <thead class ="bg-teal">
        <tr>
           <th class="text-center" >No</th> 
           <th class="text-center" >Item</th> 
           <th class="text-center" >Deskripsi</th> 
           <th class="text-center" >Qty</th> 
           <th class="text-center" >Detail</th> 
        </tr>  
    </thead>
	<tbody >
  <?php
  $no=1; 
  foreach ($detail as $det ) {
   ?>
        <tr>
            <td class="text-center" style="width: 20px"><?=$no?></td>
            <td class="text-center"><input type="hidden"  id="itemrecipt<?=$no?>"   name="itemrecipt[]" value="<?=$det['ITEM'] ?>" ><?=$det['ITEM'] ?></td>
            <td class="text-center"><input type="hidden" id="descrecipt<?=$no?>" name="descrecipt[]" value="<?=$det['DESCRIPTION'] ?>" ><?=$det['DESCRIPTION'] ?></td>
            <td class="text-center"><input type="hidden" name="qtyrecipt[]" value="<?=$det['QTY_RECIPT'] ?>" ><?=$det['QTY_RECIPT'] ?></td>
            <?php if ($det['SERIAL_STATUS']=='SERIAL') { ?>
                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="intine(this, <?= $no ?>)" >Serial</i></button></td>
             <?php  } else{   ?>
                 <td class="text-center">-</td>
              <?php  }   ?>

        </tr>
        <?php if ($det['SERIAL_STATUS'] == 'SERIAL'){?>
        <tr>
          <td></td>
          <td colspan="4">
              <div id="detailll<?= $no ?>" style="display:none">  
              <?php echo '<table class="table table-bordered  table-responsive " style="width: 100%;"><tr>';
                  $i=0;
                  foreach ($det['SERIAL_NUMBER'] as $number){
                      if($i%4==0 && $i!=0)
                      {
                       echo '</tr><tr><td> <input type="text" class="form-control"id="serial '.$no.'" name="serial'.$no.'"  value='.$number['SERIAL_NUMBER'].'></td>';
                      }
                     else
                      echo '<td><input type="text" class="form-control" id="serial '.$no.'" name="serial'.$no.'" value='.$number['SERIAL_NUMBER'].'></td>';
                    $i++;
                  }
            echo '</tr></table><br>'; ?>

                <button style="float: right;"  class="btn btn-xs btn-danger" onclick="CetakKartu(<?=$no?>)" ><i class="fa fa-print" ></i> Cetak Kartu</button>
         
    <!--           <a style="float: right;"  href="<?php echo base_url('ReceivePO/History/CetakKartu/'.$det['DESCRIPTION'].'/'.$det['SERIAL_NUMBER'][$i]['SERIAL_NUMBER'])?>" target="_blank" ><i class="fa fa-print"></i> Cetak Kartu </a> -->

            </div>
          </td>
          
        </tr>
        <?php } else{ ?>

        <?php } ?>

   <?php $no++; } ?>
  							
	</tbody>
</table>
</div>
