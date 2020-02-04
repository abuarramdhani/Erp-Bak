<!-- <form name="Orderform" class="form-horizontal" 
		onsubmit="return validasi();window.location.reload();"
		action="<?php echo base_url('ConsumablePart/Rekap/createLaporan'); ?>" method="post"> -->
    <div class="col-md-4">
     <table id="uwuuwu" class="table table-bordered table-condensed" style="width: 100%">

      <?php
      $angka=1; 
       foreach ($result as $list) { 
    ?>
       <thead style="display:none;">
        <tr>	
          <th></th>
          <tr>	
          </thead>
          <tbody >

           <tr>	
            <td><button onclick="Detail(<?=$angka?>)" id="buttonpo<?=$angka?>" class="btn btn-default btn-flat btn-sm" style ="width:100%; " value="<?=$list['PO_NUMBER'] ?>" ><?=$list['PO_NUMBER'] ?> <br><?=$list['SHIPMENT_NUMBER'] ?></button></td>
          </tr>
        </tbody>
      <?php 
        $angka++; } ?>
    </table>
  </div>
  <div class="col-md-8" id="detail" >

  </div>

  <!-- </form> -->
