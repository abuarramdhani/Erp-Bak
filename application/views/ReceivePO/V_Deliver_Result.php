<div class="col-md-4" >
<?php for ($i=0; $i < 1 ; $i++) { ?>
<table id="detail" class="table table-bordered" style="width: 100%">
<tbody >
  <tr>
    <td style="width: 100px"><b>PO </b> </td> 
    <td><?=$datanya[$i]['PO_NUMBER'] ?> </td>
  </tr>
  <tr>
    <td><b>Surat Jalan </b></td>
    <td><?=$datanya[$i]['SHIPMENT_NUMBER'] ?></td>
  </tr> 
    <input type="hidden" name="podelive[]" value="<?=$datanya[$i]['PO_NUMBER'] ?>" >
    <input type="hidden" name="sujadelive[]" value="<?=$datanya[$i]['SHIPMENT_NUMBER'] ?>" >   
</tbody>
</table>
<?php }?>
</div>

<!-- <form name="Orderform" class="form-horizontal" target="_blank" onsubmit="return validasi();window.location.reload();"  method="post" action="<?php echo site_url('ReceivePO/Deliver/Insertketable');?>"> -->

<div class="col-md-12">
<table id="detaillist" class="table table-bordered" style="width: 100%">

    <thead class ="bg-yellow">
        <tr>
           <th class="text-center" >No</th> 
           <th class="text-center" >Item</th> 
           <th class="text-center" >Deskripsi</th> 
           <th class="text-center" >Qty</th>
           <th class="text-center" >Locator</th>
           <th class="text-center">Comments</th> 
        </tr>  
    </thead>
	<tbody >
           
            <input type="hidden" name="lppbnumber[]" value="<?=$datanya[0]['LPPB'] ?>" >   

  <?php
  $no=1; 
  foreach ($datanya as $dat ) {
   ?>

        <tr>
            <td class="text-center" style="width: 20px"><?=$no?></td>
            <td class="text-center"><input type="hidden"  id="itemdelive<?=$no?>"   name="itemdelive[]" value="<?=$dat['ITEM'] ?>" ><?=$dat['ITEM'] ?></td>
            <td class="text-center"><input type="hidden" id="descdelive<?=$no?>" name="descdelive[]" value="<?=$dat['DESCRIPTION'] ?>" ><?=$dat['DESCRIPTION'] ?></td>
            <td class="text-center"><input type="hidden" name="qtydelive[]" value="<?=$dat['QTY_RECIPT'] ?>" ><?=$dat['QTY_RECIPT'] ?></td>
            <td class="text-center"><?php if ($dat['LOCATOR'] != null) { ?>
                <select name="pilihloc[]" class=" form-control select2-selection">
                        <option></option>
                  <?php foreach ($dat['LOCATOR'] as $value) { ?>
                        <option value="<?=$value['LOCATOR']?>"><?=$value['LOCATOR']?></option>
                <?php } ?>
              </select>
            <?php } else{ ?>
              <label ><input type="hidden" name="pilihloc[]" value=""> No Locator</label>
              <?php } ?></td>
            <td class="text-center" style="width: 200px"><input autocomplete="off" type="text" class="form-control" name="commentsdelive[]"></td>

            <input type="hidden" name="podelive[]" value="<?=$dat['PO_NUMBER'] ?>" >
            <input type="hidden" name="sujadelive[]" value="<?=$dat['SHIPMENT_NUMBER'] ?>" >   
            <input type="hidden" name="serialstatus[]" value="<?=$dat['SERIAL_STATUS'] ?>" >
            <input type="hidden" name="iddelive[]" value="<?=$dat['ID'] ?>" >
<!-- 
            <?php if ($dat['SERIAL_STATUS'] == 'SERIAL') { 
              for ($s=0; $s < sizeof($dat['SERIAL_NUMBER']) ; $s++) {  ?>
                <input type="hidden" name="serialnumdelive[]" value="<?=$dat['SERIAL_NUMBER'][$s]['SERIAL_NUMBER']?>">
            <?php } } else if($dat['SERIAL_STATUS'] == 'NON SERIAL'){ } ?>   -->

        </tr>

   <?php $no++; } ?>
  							
	</tbody>
</table>
</div>
<div class="col-md-12">
    <button onclick ="getdataInsert(this)" style="float: right;" class="btn bg-teal">Deliver</button>
</div>
<!-- </form> -->
</div>
